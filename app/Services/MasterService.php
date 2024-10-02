<?php

namespace App\Services;

use App\Constants\Parameters;
use App\Models\Master;
use App\Models\MasterProfession;
use App\Models\MasterVerificationRequestFile;
use App\Notifications\SendResetPasswordSMS;
use App\Notifications\SendVerifySMS;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class MasterService
{
    /**
     * @param $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(array $request): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $request['password'] = Hash::make($request['password']);
            $master = Master::query()->create(
                array_merge(Arr::except($request, 'profession_ids'), [
                    'mobile_verify_code' => random_int(1000, 9999),
                    'mobile_verify_code_expires_at' => Carbon::now()->addMinutes(10)
                ])
            );
            $profession_ids = $request['profession_ids'];
            if (in_array(Parameters::COURIER_PROFESSION_ID,$profession_ids)){
                $master->update(['is_courier' => 1]);
            }
            $master->professions()->attach($profession_ids);

            return Response::json(['master_id' => $master->id]);
        });
    }

    public function verify(Master $master, array $request): JsonResponse|array
    {
        if (empty($request['code'])) {
            return Response::json(['error' => [
                'en' => 'Code is required',
                'ru' => 'Пожалуйста введите код',
                'hy' => 'Մուտքագրեք կոդը']
            ], 422);
        }

        if ($master->mobile_verify_code_expires_at < Carbon::now()) {
            return Response::json(['error' => [
                'en' => 'Code is expired',
                'ru' => 'Срок кода истек',
                'hy' => 'Կոդը վավերականության ժամկետն անցել է']
            ], 422);
        }

        if ($request['code'] === intval($master->mobile_verify_code)) {
            $master->update([
                'is_verified' => true,
                'mobile_verify_code' => null,
                'mobile_verify_code_expires_at' => null
            ]);

            return ['token' => $master->createToken($master->phone)->plainTextToken];
        } else {
            return Response::json(['error' => [
                'en' => 'Wrong code',
                'ru' => 'Неправилъный код',
                'hy' => 'Մուտքագրված կոդը սխալ է']
            ], 422);
        }
    }

    /**
     * @param array $request
     * @return JsonResponse
     */
    public function login(array $request): JsonResponse
    {
        $master = Master::query()->where(['phone' => $request['phone']])->first();

        if (!empty($master) && Hash::check($request['password'], $master->password)) {
            if ($master->isNotVerified()) {
                return Response::json([
                    'error' => [
                        'en' => 'You are not verified,please process verification',
                        'ru' => 'Пожалуйста пройдите верификацию',
                        'hy' => 'Խնդրում ենք անցնել վերիֆիկացիա'
                    ]
                ]);
            }
            $response = ['token' => $master->createToken($request['phone'])->plainTextToken];
            $master->load('verificationRequest');
            if (empty($master->verificationRequest)){
                $response['verified_by_admin'] = false;
                $response['verification_request'] = null;
            }else if (!$master->isVerifiedByAdmin() && ($master->hasNewAdminVerificationRequest() || $master->hasRejectedAdminVerificationRequest())){
                $response['verified_by_admin'] = false;
                $response['verification_request'] = $master->verificationRequest->load('files');
                $response['verification_request']['passport'] = $master->passport;
                $response['verification_request']['driver_license'] = $master->driver_license;

                if (!empty($master->verificationRequest->files)){
                    foreach ($master->verificationRequest->files as $file){
                        if (!empty($file->car_texpassport_number)){
                            $response['verification_request']['car_texpassport_number'] = $file->car_texpassport_number;
                            break;
                        }
                    }
                }
            }elseif($master->isVerifiedByAdmin()){
                $response['verified_by_admin'] = true;
            }
            $master->update(['fcm_token' => $request['fcm_token']]);
            return Response::json($response);
        }

        return Response::json(['error' => [
            'en' => 'Wrong phone or password',
            'ru' => 'Неправилъный номер телефона или паролъ',
            'hy' => 'Համարը կամ գաղտնաբառը սխալ է'
        ]], 422);
    }

    public function sendVerificationRequest(array $request, Master $master)
    {

        try {
            DB::beginTransaction();

            $master_update_data = ['passport' => $request['passport']];
            if (!empty($request['driver_license'])){
                $master_update_data['driver_license'] = $request['driver_license'];
            }

            $master->update($master_update_data);
            $current_verification_request = $master->verificationRequest()->create();

            $passport_image_files = [];
            $driver_license_image_files = [];
            $car_texpassport_image_files = [];
            $car_images = [];

            if (!empty($request['passport_images'])){
                foreach ($request['passport_images'] as $passport_image){
                    $passport_image_files[] = [
                        'master_verification_request_id' => $current_verification_request->id,
                      'type' => 'passport',
                      'image_url' => $passport_image,
                      'created_at' => Carbon::now(),
                      'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['driver_license_images'])){
                foreach ($request['driver_license_images'] as $driver_license_image){
                    $driver_license_image_files[] = [
                        'master_verification_request_id' => $current_verification_request->id,
                        'type' => 'driver_license',
                        'image_url' => $driver_license_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['car_texpassport_number']) && !empty($request['car_texpassport_images'])){
                foreach ($request['car_texpassport_images'] as $car_texpassport_image){
                    $car_texpassport_image_files[] = [
                        'master_verification_request_id' => $current_verification_request->id,
                        'car_texpassport_number' => $request['car_texpassport_number'],
                        'type' => 'car_texpassport_image',
                        'image_url' => $car_texpassport_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['car_images']) && !empty($request['car_images'])){
                foreach ($request['car_images'] as $car_image){
                    $car_images[] = [
                        'master_verification_request_id' => $current_verification_request->id,
                        'type' => 'car',
                        'image_url' => $car_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($passport_image_files)){
                MasterVerificationRequestFile::query()->insert($passport_image_files);
            }
            if (!empty($driver_license_image_files)){
                MasterVerificationRequestFile::query()->insert($driver_license_image_files);
            }
            if (!empty($car_texpassport_image_files)){
                MasterVerificationRequestFile::query()->insert($car_texpassport_image_files);
            }

            if (!empty($car_images)){
                MasterVerificationRequestFile::query()->insert($car_images);
            }

            DB::commit();
            return Response::json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return Response::json(['error' => [
                'en' => 'Something went wrong,Please try later!',
                'ru' => 'Неправилъный адрес эл. почты или паролъ',
                'hy' => 'Խնդրում ենք փորձել մի փոքր ուշ․'
            ]]);
        }
    }

    public function updateExistingVerificationRequest(array $request, Master $master){

        try {
            DB::beginTransaction();

            $master->load('verificationRequest');
            $master_update_data = [];
            if (!empty($request['passport'])){
                $master_update_data['passport'] = $request['passport'];
            }

            if (!empty($request['driver_license'])){
                $master_update_data['driver_license'] = $request['driver_license'];
            }
            $master->update($master_update_data);
            $master->verificationRequest->update([
                'admin_decision_provided' => 0,
                'reason' => null,
            ]);

            $master->verificationRequest->files()->delete();
            $passport_image_files = [];
            $driver_license_image_files = [];
            $car_texpassport_image_files = [];
            $car_images = [];

            if (!empty($request['passport_images'])){
                foreach ($request['passport_images'] as $passport_image){
                    $passport_image_files[] = [
                        'master_verification_request_id' => $master->verificationRequest->id,
                        'type' => 'passport',
                        'image_url' => $passport_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['driver_license_images'])){
                foreach ($request['driver_license_images'] as $driver_license_image){
                    $driver_license_image_files[] = [
                        'master_verification_request_id' => $master->verificationRequest->id,
                        'type' => 'driver_license',
                        'image_url' => $driver_license_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['car_texpassport_number']) && !empty($request['car_texpassport_images'])){
                foreach ($request['car_texpassport_images'] as $car_texpassport_image){
                    $car_texpassport_image_files[] = [
                        'master_verification_request_id' => $master->verificationRequest->id,
                        'car_texpassport_number' => $request['car_texpassport_number'],
                        'type' => 'car_texpassport_image',
                        'image_url' => $car_texpassport_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($request['car_images']) && !empty($request['car_images'])){
                foreach ($request['car_images'] as $car_image){
                    $car_images[] = [
                        'master_verification_request_id' => $master->verificationRequest->id,
                        'type' => 'car',
                        'image_url' => $car_image,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }

            if (!empty($passport_image_files)){
                MasterVerificationRequestFile::query()->insert($passport_image_files);
            }
            if (!empty($driver_license_image_files)){
                MasterVerificationRequestFile::query()->insert($driver_license_image_files);
            }
            if (!empty($car_texpassport_image_files)){
                MasterVerificationRequestFile::query()->insert($car_texpassport_image_files);
            }

            if (!empty($car_images)){
                MasterVerificationRequestFile::query()->insert($car_images);
            }

            DB::commit();
            return Response::json(['status' => true], 200);

        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return Response::json(['error' => [
                'en' => 'Something went wrong,Please try later!',
                'ru' => 'Неправилъный адрес эл. почты или паролъ',
                'hy' => 'Խնդրում ենք փորձել մի փոքր ուշ․'
            ]]);
        }
    }

    /**
     * @param Master $master
     * @param array $request
     * @return Master|null
     */
    public function editAccount(Master $master, array $request): ?Master
    {
        $professions = $request['professions'];
        unset($request['professions']);

        if (in_array(Parameters::COURIER_PROFESSION_ID, $professions)){
            $master->update(['is_courier' => 1]);
        }else{
            $master->update(['is_courier' => 0]);
        }
        MasterProfession::query()->where('master_id', $master->id)->delete();
        foreach ($professions as $profession){
            MasterProfession::query()->create(['master_id' => $master->id, 'profession_id' => $profession]);
        }
////        $master->professions()->delete();
////        $master->professions()->attach($professions);
//        dd(Master::query()->where('id', $master->id)->with('professions')->first());
        $master->update($request);
        return $master->fresh()->load('professions');
    }


    public function verifyResetPassword(array $request)
    {
        $master = $this->findByPhone($request['phone']);
        $master_current_code = $master->passwordResetCodes()->where('is_used', '=', 0)->first(['code']);

        if ($master_current_code->code === $request['code']) {
            return Response::json([
                'token' => $master->createToken($request['phone'])->plainTextToken
            ]);
        }

        return Response::json([
            'error' => [
                'en' => 'Wrong code',
                'ru' => 'Неверный код',
                'hy' => 'Մուտքագրված կոդը սխալ է'
            ]
        ],422);
    }

    public function findByPhone(string $phone)
    {
        $master = Master::query()->where(['phone' => $phone])->first();
        if (!$master) {
            return Response::json([
                'success' => false,
                'error' => [
                    'am' => 'Նշված համարով օգտատեր չկա․',
                    'ru' => 'У нас пользователя с таким номером телефона.',
                    'en' => 'There is not a user with such phone number'
                ]
            ], 400);
        }

        return $master;
    }

    public function sendResetPasswordSms(array $request)
    {
        $master = $this->findByPhone($request['phone']);

        return DB::transaction(function () use ($master) {
            $code = random_int(1000, 9999);
            $master->passwordResetCodes()->where(['is_used' => 0])->delete();
            $master->passwordResetCodes()->create([
                'code' => $code
            ]);
            if ($master->phone != '+37400000000'){
                $master->notify(new SendResetPasswordSMS($code));
            }
        });
    }

    public function resendSms(Master $master): mixed
    {
        if ($master->isNotVerified()) {
            return DB::transaction(function () use ($master) {
                $master->update([
                    'mobile_verify_code' => random_int(1000, 9999),
                    'mobile_verify_code_expires_at' => Carbon::now()->addMinutes(10)
                ]);
                if ($master->phone != '+37400000000'){
                    $master->notify(new SendVerifySMS());
                }
            });
        }
        return Response::json([
            'error' => [
                'en' => 'User is already verified',
                'ru' => 'Полъзожателъ уже верифицирован',
                'hy' => 'Օգտատերն արդեն վերիֆիկացված է'
            ]
        ], 400);
    }

    public function updatePassword(Master $master, array $request): bool
    {
        return $master->update([
            'password' => Hash::make($request['password'])]);
    }
}

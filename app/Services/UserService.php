<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SendResetPasswordSMS;
use App\Notifications\SendVerifySMS;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class UserService
{

    /**
     * @param $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(array $request): \Illuminate\Http\JsonResponse
    {
        $request['password'] = Hash::make($request['password']);
        $user = User::query()->create(
            array_merge($request, [
                'mobile_verify_code' => random_int(1000, 9999),
                'mobile_verify_code_expires_at' => Carbon::now()->addMinutes(10)
            ])
        );

        return Response::json(['user_id' => $user->id]);
    }


    /**
     * @param User $user
     * @param array $request
     * @return JsonResponse|array
     */
    public function verify(User $user, array $request): JsonResponse|array
    {
        if (empty($request['code'])) {
            return Response::json(['error' => [
                'en' => 'Code is required',
                'ru' => 'Пожалуйста введите код',
                'hy' => 'Մուտքագրեք կոդը']
            ], 422);
        }

        if ($user->mobile_verify_code_expires_at < Carbon::now()) {
            return Response::json(['error' => [
                'en' => 'Code is expired',
                'ru' => 'Срок кода истек',
                'hy' => 'Կոդը վավերականության ժամկետն անցել է']
            ], 422);
        }

        if ($request['code'] === intval($user->mobile_verify_code)) {
            $user->update([
                'is_verified' => true,
                'mobile_verify_code' => null,
                'mobile_verify_code_expires_at' => null
            ]);

            return ['token' => $user->createToken($user->phone)->plainTextToken];
        } else {
            return Response::json(['error' => [
                'en' => 'Wrong code',
                'ru' => 'Неправилъный код',
                'hy' => 'Մուտքագրված կոդը սխալ է']
            ], 422);
        }
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function resendSms(User $user): mixed
    {
        if ($user->isNotVerified()) {
            return DB::transaction(function () use ($user) {
                $user->update([
                    'mobile_verify_code' => random_int(1000, 9999),
                    'mobile_verify_code_expires_at' => Carbon::now()->addMinutes(10)
                ]);
                if ($user->phone != '+37400000000'){
                    $user->notify(new SendVerifySMS());
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

    /**
     * @param array $request
     * @return JsonResponse
     */
    public function login(array $request): JsonResponse
    {
        if (Auth::attempt([
            'phone' => $request['phone'],
            'password' => $request['password']
        ])) {
            if (Auth::user()->isNotVerified()) {
                return Response::json([
                    'error' => [
                        'en' => 'You are not verified,please process verification',
                        'ru' => 'Пожалуйста пройдите верификацию',
                        'hy' => 'Խնդրում ենք անցնել վերիֆիկացիա'
                    ]
                ]);
            }

            Auth::user()->update(['fcm_token' => $request['fcm_token']]);
            return Response::json([
                'token' => Auth::user()->createToken($request['phone'])->plainTextToken
            ]);
        }

        return Response::json(['error' => [
            'en' => 'Wrong phone or password',
            'ru' => 'Неправилъный номер телефона или паролъ',
            'hy' => 'Համարը կամ գաղտնաբառը սխալ է'
        ]], 422);
    }

    /**
     * @param User $user
     * @param array $request
     * @return User|null
     */
    public function editAccount(User $user, array $request): ?User
    {
        $user->update($request);
        return $user->fresh();
    }

    public function sendResetPasswordSms(array $request)
    {
        $user = $this->findByPhone($request['phone']);

        return DB::transaction(function () use ($user) {
            $code = random_int(1000, 9999);
            $user->passwordResetCodes()->where(['is_used' => 0])->delete();
            $user->passwordResetCodes()->create([
                'code' => $code
            ]);
            if ($user->phone != '+37400000000'){
                $user->notify(new SendResetPasswordSMS($code));
            }
        });
    }

    public function verifyResetPassword(array $request)
    {
        $user = $this->findByPhone($request['phone']);
        $user_current_code = $user->passwordResetCodes()->where('is_used', '=', 0)->first(['code']);

        if ($user_current_code->code === $request['code']) {
            return Response::json([
                'token' => $user->createToken($request['phone'])->plainTextToken
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

    /**
     * @param string $phone
     * @return Builder|Model|JsonResponse
     */
    public function findByPhone(string $phone): Model|Builder|JsonResponse
    {
        $user = User::query()->where(['phone' => $phone])->first();
        if (!$user) {
            return Response::json([
                'success' => false,
                'error' => [
                    'am' => 'Նշված համարով օգտատեր չկա․',
                    'ru' => 'У нас пользователя с таким номером телефона.',
                    'en' => 'There is not a user with such phone number'
                ]
            ], 400);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param array $request
     * @return bool
     */
    public function updatePassword(User $user, array $request): bool
    {
        return $user->update([
            'password' => Hash::make($request['password'])]);
    }
}

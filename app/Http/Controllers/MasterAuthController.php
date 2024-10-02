<?php

namespace App\Http\Controllers;

use App\Events\SendLocation;
use App\Http\Requests\MasterEditAccountRequest;
use App\Http\Requests\MasterLocationUpdateRequest;
use App\Http\Requests\MasterLoginRequest;
use App\Http\Requests\MasterPhoneVerifyRequest;
use App\Http\Requests\MasterRegistrationRequest;
use App\Http\Requests\MasterResetPasswordRequest;
use App\Http\Requests\MasterResetPasswordVerifyRequest;
use App\Http\Requests\MasterUpdatePasswordRequest;
use App\Http\Requests\MasterVerifyRequest;
use App\Models\Master;
use App\Models\SentNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\MasterService;
use Illuminate\Http\Response;

class MasterAuthController extends Controller
{
    private $service;

    /**
     * @param MasterService $masterService
     */
    public function __construct(MasterService $masterService)
    {
        $this->service = $masterService;
    }

    /**
     * @param MasterRegistrationRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(MasterRegistrationRequest $request): JsonResponse
    {
        return $this->service->register($request->validated());
    }

    public function verify(Master $master, MasterPhoneVerifyRequest $request): JsonResponse|array
    {
        return $this->service->verify($master, $request->validated());
    }

    /**
     * @param MasterLoginRequest $request
     * @return JsonResponse
     */
    public function login(MasterLoginRequest $request): JsonResponse
    {
        return $this->service->login($request->validated());
    }

    public function resendSms(Master $master): mixed
    {
        return $this->service->resendSms($master);
    }

    public function logout(Request $request)
    {
        return $request->user('masters')->tokens()
            ->where('id','=',$request->user('masters')->currentAccessToken()->id)->delete();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function account(Request $request): mixed
    {
        return $request->user('masters')->load('professions');
    }

    /**
     * @param MasterEditAccountRequest $request
     * @return Master|null
     */
    public function editAccount(MasterEditAccountRequest $request): ?Master
    {
        return $this->service->editAccount($request->user('masters'), $request->validated());
    }

    public function sendVerifyRequest(MasterVerifyRequest $request){

        if ($request->user('masters')->isNotVerifiedByAdmin()){
            if ($request->user('masters')->hasNewAdminVerificationRequest()){
                return \response()->json([
                    'error' => [
                        'en' => 'Master already has a submited verification request, which is not reviewed by admin',
                        'ru' => 'U Mastera uje est zapros na verifikaciyu.',
                        'hy' => 'Օգտատերն արդեն ունի վերֆիկացման հայտ'
                    ]
                ], 400);
            }elseif ($request->user('masters')->hasRejectedAdminVerificationRequest()){
                return $this->service->updateExistingVerificationRequest($request->validated(),$request->user('masters'));
            } else {
                return $this->service->sendVerificationRequest($request->validated(),$request->user('masters'));
            }
        }else {
            return \response()->json([
                'error' => [
                    'en' => 'Master is already verified',
                    'ru' => 'master uje verificirovan',
                    'hy' => 'Օգտատերն արդեն վերիֆիկացված է․'
                ]
            ], 400);
        }
    }

    /**
     * @param MasterLocationUpdateRequest $request
     * @return JsonResponse
     */
    public function locationUpdate(MasterLocationUpdateRequest $request): JsonResponse
    {
        $master_current_order = $request->user('masters')->load('inProcessOrder');
        if (!empty($master_current_order->inProcessOrder)) {
            event(new SendLocation($master_current_order->inProcessOrder,
                ['latitude' => $request->latitude, 'longitude' => $request->longitude]));
        }else{
            return \response()->json([
                'success' => false,
                'error' => [
                    'hy' => 'Առաքիչը պատվերի մեջ չէ',
                    'en' => 'Courier is not in order',
                    'ru' => 'Kurier ne v zakaze'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }

    public function resetPasswordSendSms(MasterResetPasswordRequest $request): mixed
    {
        return $this->service->sendResetPasswordSms($request->validated());
    }

    public function resetPasswordVerify(MasterResetPasswordVerifyRequest $request): JsonResponse
    {
        return $this->service->verifyResetPassword($request->validated());
    }

    public function updatePassword(MasterUpdatePasswordRequest $request): bool
    {
        return $this->service->updatePassword($request->user('masters'), $request->validated());
    }

    public function becomeFree(Request $request){

        if($request->get('busy')){
            return $request->user('masters')->update([
                'busy' => 1,
            ]);
        }

        if (empty($request->latitude) || empty($request->longitude)){
            return \response()->json([
               'error' => [
                   'en' => 'Latitude and longitude are required',
                   'ru' => 'latitud i longitude obyazatelni',
                   'hy' => 'Լատիտուդն ու լոնգիտուդը պարտադիր են․'
               ]
            ],400);
        }

        return $request->user('masters')->update([
           'busy' => 0,
           'current_lat' =>  $request->latitude,
           'current_long' =>  $request->longitude,
        ]);
    }

    public function isVerified(Request $request){
        $master = $request->user('masters');
        $master->load('verificationRequest');
        $response = [];
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
        return \Illuminate\Support\Facades\Response::json($response);
    }

    public function getNotifications(Request $request){

        $request->user('masters')->load(['sentNotifications' => function ($query){
            return $query->with(['order.user', 'order.products.product.mainImage', 'order.cartService.service'])->where('is_new','=',true);
        }]);
        $result = [];
        $updating_ids = [];
        if (!empty($request->user('masters')->sentNotifications)){
            $result = $request->user('masters')->sentNotifications;
            foreach ($request->user('masters')->sentNotifications as $notification){
                $updating_ids[] = $notification->id;
            }
        }

        if (!empty($updating_ids)){
//            SentNotification::query()->whereIn('id',$updating_ids)->update([
//               'is_new' => false
//            ]);
        }

        return \response()->json([
           'success' => true,
           'data' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Master $master
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Master $master)
    {
        $master->delete();

        return response()->json([
            'success' => true,
            'message' => 'Վարպետը ջնջված է'
        ]);

    }
}

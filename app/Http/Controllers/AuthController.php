<?php

namespace App\Http\Controllers;

use App\Constants\Parameters;
use App\Http\Requests\EditAccountRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordVerifyRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\VerifyRequest;
use App\Models\Master;
use App\Models\SentNotification;
use App\Models\User;
use App\Models\UserBonus;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $service;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }


    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        return $this->service->register($request->validated());
    }


    /**
     * @param User $user
     * @param VerifyRequest $request
     * @return JsonResponse|array
     */
    public function verify(User $user, VerifyRequest $request): JsonResponse|array
    {
        return $this->service->verify($user, $request->validated());
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->service->login($request->validated());
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function resendSms(User $user): mixed
    {
        return $this->service->resendSms($user);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $request->user('api-user')->tokens()
            ->where('id','=',$request->user('api-user')->currentAccessToken()->id)->delete();
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function account(Request $request): mixed
    {
        return $request->user('api-user');
    }

    /**
     * @param EditAccountRequest $request
     * @return User|null
     */
    public function editAccount(EditAccountRequest $request): ?User
    {
        return $this->service->editAccount($request->user('api-user'), $request->validated());
    }

    /**
     * @param ResetPasswordRequest $request
     * @return mixed
     */
    public function resetPasswordSendSms(ResetPasswordRequest $request): mixed
    {
        return $this->service->sendResetPasswordSms($request->validated());
    }

    /**
     * @param ResetPasswordVerifyRequest $request
     * @return JsonResponse
     */
    public function resetPasswordVerify(ResetPasswordVerifyRequest $request): JsonResponse
    {
        return $this->service->verifyResetPassword($request->validated());
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return bool
     */
    public function updatePassword(UpdatePasswordRequest $request): bool
    {
        return $this->service->updatePassword($request->user('api-user'), $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Վարպետը ջնջված է'
        ]);

    }

}

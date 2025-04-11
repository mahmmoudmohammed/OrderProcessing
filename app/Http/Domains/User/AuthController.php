<?php

namespace App\Http\Domains\User;

use App\Http\Controllers\Controller;
use App\Http\Domains\User\Repository\UserAuthRepository;
use App\Http\Domains\User\Request\CreateUserRequest;
use App\Http\Domains\User\Request\UserLoginRequest;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private UserAuthRepository $repository)
    {
    }

    public function register(CreateUserRequest $request)
    {
        $user = $this->repository->register($request->validated());

        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->ip())->plainTextToken,
        ]);
    }

    public function login(UserLoginRequest $request): UserResource|JsonResponse
    {
        $admin = $this->repository->login($request->validated());
        if (!$admin) {
            return $this->ApiResponse(401, 'auth.failed');
        }
        return (new UserResource($admin))->additional([
            'token' => $admin->createToken($request->ip())->accessToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success();
    }
}

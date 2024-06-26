<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;
use App\Exceptions\{LoginException};
use App\Models\User;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{DB, Hash};

class AuthService
{
    /**
     * @throws LoginException
     */
    public function login(LoginRequest $request): string
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new LoginException('Invalid credentials');
        }

        return $user->createToken('user')->accessToken;
    }

    public function register(RegisterRequest $request): string
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
            ]);

            $user->cart()->create();

            $token = $user->createToken('access')->accessToken;

            DB::commit();

            return $token;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function logout(Request $request): void
    {
        $request->user()->token()->revoke();
    }

    public function update(UpdateUserRequest $request): void
    {
        $user = $request->user();

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
    }
}

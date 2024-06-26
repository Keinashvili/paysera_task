<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\{LoginException, UnauthorizedUserException};
use App\Models\User;
use Illuminate\Http\{JsonResponse, Response};
use Illuminate\Support\Facades\{DB, Hash};

class AuthService
{
    /**
     * @throws LoginException
     */
    public function login($request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user &&
            auth()->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]) &&
            Hash::check($request->password, $user->password)) {

            auth()->login($user);

            return response()->json([
                'token' => $user->createToken('user')->accessToken,
            ]);
        }

        throw new LoginException();
    }

    public function register($request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
            ]);

            $user->cart()->create();

            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            return response()->json([
                'token' => $token,
            ]);
        });
    }

    /**
     * @throws UnauthorizedUserException
     */
    public function logout($request): Response
    {
        $user = $request->user();

        if ($user) {
            $accessToken = $user->token();

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);

            $accessToken->revoke();

            session()->regenerateToken();
            session()->flush();

            $user->update([
                'remember_token' => null,
            ]);

            return response()->noContent(200);
        }

        throw new UnauthorizedUserException();
    }

    public function update($request): Response
    {
        $user = $request->user();

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return response()->noContent();
    }
}

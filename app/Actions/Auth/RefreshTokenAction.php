<?php

namespace App\Actions\Auth;

use App\Models\RefreshToken;
use App\Services\RefreshTokenService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RefreshTokenAction
{
    public function handle(Request $request)
    {
        $token = RefreshToken::where('token', $request->refresh_token)->first();

        if (!$token || $token->isExpired()) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired refresh token.'],
            ]);
        }

        $user = $token->user;
        $token->delete(); // optional: revoke old refresh token

        $accessToken = $user->createToken('access_token')->plainTextToken;
        $newRefreshToken = RefreshTokenService::generateRefreshToken($user);

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
        ]);
    }
}

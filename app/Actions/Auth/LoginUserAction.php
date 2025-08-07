<?php
namespace App\Actions\Auth;

use App\Models\RefreshToken;
use App\Services\RefreshTokenService;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    public function handle(array $credentials): array|bool
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        $refreshToken = RefreshTokenService::generateRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }
}

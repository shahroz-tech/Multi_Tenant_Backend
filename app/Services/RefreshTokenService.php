<?php
namespace App\Services;

use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Support\Str;

class RefreshTokenService
{
    public static function generateRefreshToken(User $user): string
    {
        $token = Str::random(64);

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addDays(30),
        ]);

        return $token;
    }
}

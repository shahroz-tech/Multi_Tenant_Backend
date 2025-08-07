<?php
namespace App\Actions\Auth;

use Illuminate\Http\Request;

class LogoutUserAction
{
    public function handle(Request $request): void
    {

        $request->user()->currentAccessToken()->delete();
    }
}

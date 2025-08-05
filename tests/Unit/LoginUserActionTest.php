<?php

namespace Tests\Unit;

use App\Actions\Auth\LoginUserAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_succeeds_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginAction = new LoginUserAction();

        $result = $loginAction->handle([
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('token', $result);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginAction = new LoginUserAction();

        $result = $loginAction->handle([
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertFalse($result);
    }
}

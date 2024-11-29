<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\{postJson};

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'user@example.com',
    ]);
});

describe('login', function () {
    it("can user to login", function () {
        postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ])
            ->assertOk()
            ->assertJsonStructure([
                'authorization' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                ],
            ]);
    });

    it("can't user to login with invalid credentials", function () {
        postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'wrongpassword',
        ])
            ->assertUnauthorized();
    });
});

describe('logout', function () {
    it("can user to logout", function () {
        $token = Auth::login($this->user);

        postJson('/api/auth/logout', [], ['Authorization' => "Bearer $token"])
            ->assertOk()
            ->assertJson([
                'message' => 'You successfully logged out.',
            ]);
    });

    it("can't user to logout without a token", function () {
        postJson('/api/auth/logout')->assertUnauthorized();
    });
});

describe('refresh', function () {
    it("can user to refresh token", function () {
        $token = Auth::login($this->user);

        postJson('/api/auth/refresh', [], ['Authorization' => "Bearer $token"])
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'authorization' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                ],
            ]);
    });

    it("can't user to refresh tokens without a token", function () {
        postJson('/api/auth/refresh')->assertUnauthorized();
    });
});

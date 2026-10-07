<?php

namespace Tests\Feature;

use App\Exceptions\GoogleEmailNotVerifiedException;
use App\Exceptions\GoogleTokenException;
use App\Services\GoogleIdTokenVerifier;
use Mockery;
use Tests\TestCase;
use Throwable;

class ApiGoogleAuthTest extends TestCase
{
    public function test_google_login_requires_an_id_token(): void
    {
        $response = $this->postJson('/api/v1/auth/google', [
            'device_name' => 'bankir-app',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['id_token']);
    }

    public function test_google_login_returns_a_safe_error_for_an_invalid_token(): void
    {
        $this->mockVerifier(new GoogleTokenException('Token Google tidak valid atau sudah kedaluwarsa.'));

        $this->postJson('/api/v1/auth/google', [
            'id_token' => 'invalid-token',
        ])
            ->assertUnauthorized()
            ->assertJson([
                'success' => false,
                'message' => 'Token Google tidak valid atau sudah kedaluwarsa.',
            ]);
    }

    public function test_google_login_explains_that_the_email_must_be_verified(): void
    {
        $this->mockVerifier(new GoogleEmailNotVerifiedException('Email Google belum terverifikasi.'));

        $this->postJson('/api/v1/auth/google', [
            'id_token' => 'signed-token',
        ])
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Email Google belum terverifikasi.',
            ]);
    }

    private function mockVerifier(Throwable $exception): void
    {
        $verifier = Mockery::mock(GoogleIdTokenVerifier::class);
        $verifier->shouldReceive('verify')->once()->andThrow($exception);

        $this->app->instance(GoogleIdTokenVerifier::class, $verifier);
    }
}

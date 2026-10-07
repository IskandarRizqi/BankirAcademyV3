<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiEmailVerificationTest extends TestCase
{
    public function test_email_verification_notification_requires_an_email(): void
    {
        $this->postJson('/api/v1/auth/email/verification-notification')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_email_verification_rejects_an_unsigned_link(): void
    {
        $this->getJson('/api/v1/auth/email/verify/1/'.str_repeat('a', 40))
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'code' => 'invalid_verification_link',
            ]);
    }

    public function test_email_verification_notification_is_disabled_for_mobile(): void
    {
        $this->postJson('/api/v1/auth/email/verification-notification', [
            'email' => 'student@example.com',
        ])
            ->assertAccepted()
            ->assertJson([
                'success' => true,
                'code' => 'email_verification_disabled',
            ]);
    }
}

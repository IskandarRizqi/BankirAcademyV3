<?php

namespace App\Contracts;

interface WhatsAppGateway
{
    public function sendText(
        string $recipient,
        string $message,
        string $idempotencyKey,
    ): string;
}

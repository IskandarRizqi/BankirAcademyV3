<?php

return [
    'expiration_minutes' => env('ACTIVATION_EXPIRATION_MINUTES', 60),

    'allowed_email_keys' => [
        'email',
        'email_address',
        'email_kantor',
        'work_email',
    ],

    'allowed_whatsapp_keys' => [
        'phone',
        'mobile_phone',
        'no_wa',
        'nomor_whatsapp',
    ],
];

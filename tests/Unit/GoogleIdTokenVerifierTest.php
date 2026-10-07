<?php

namespace Tests\Unit;

use App\Services\GoogleIdTokenVerifier;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleIdTokenVerifierTest extends TestCase
{
    public function test_it_verifies_google_signature_and_required_claims(): void
    {
        [$privateKey, $publicKey] = $this->keyPair();
        config(['services.google.client_id' => 'web-client.apps.googleusercontent.com']);
        Cache::forget('google.oauth2.jwks');
        Http::fake([
            'https://www.googleapis.com/oauth2/v3/certs' => Http::response([
                'keys' => [[
                    'kty' => 'RSA',
                    'alg' => 'RS256',
                    'use' => 'sig',
                    'kid' => 'test-key',
                    'n' => $this->base64Url($publicKey['rsa']['n']),
                    'e' => $this->base64Url($publicKey['rsa']['e']),
                ]],
            ]),
        ]);

        $token = JWT::encode([
            'iss' => 'https://accounts.google.com',
            'aud' => 'web-client.apps.googleusercontent.com',
            'sub' => 'google-sub-123',
            'email' => 'user@gmail.com',
            'email_verified' => true,
            'name' => 'Google User',
            'exp' => time() + 300,
        ], $privateKey, 'RS256', 'test-key');

        $identity = app(GoogleIdTokenVerifier::class)->verify($token);

        $this->assertSame([
            'sub' => 'google-sub-123',
            'email' => 'user@gmail.com',
            'name' => 'Google User',
        ], $identity);
    }

    /**
     * @return array{0: string, 1: array<string, mixed>}
     */
    private function keyPair(): array
    {
        $privateKey = <<<'PEM'
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAwet4jWQtnZF0745Ya42nebCTZ7MXYkS445o3Lq2XI6KCKFJt
AWdJVpiLstwlJp9mdIypNAMsWVKqJsV5r4BT2IkZp0n8RLTNSrQNUtUNYHl+zF0b
OFwmNNj6JK1tC0E6dT9uO0wfeoZ/W9VeaRKGJNxV0g9XcAj5tQM5vOo5Dn04k55P
3z0wprP5y4cAjmUZKRK3gdHYfTa2dV0B2wlOcLqWXgXm7US7BG+5Mvwlm28NWCTW
ma5hPfGAMPOJqSHFhrs1ZT6yw74SVH6v3jxZNDRVf1LlXUqgJrJfxp6o4J7gkGIO
KwE5KoHKbJ6UkV6RAs1BlNM/vCBYfeAch0YcFQIDAQABAoIBAGZXOhEMrJI6wMbo
jbt9T8SGLtUMjCu9bwIXUkYdMOWKjzxue77A3tCHwzpKuoSOnUinL2kWv6IIYWoC
z/ySMi3V9Sb3gd5UuP9S1LFBZUTj+coq3QG6iCNd223d5O2KqCpWpns+6mIEd1Rk
3+V99DOh4NzyYcfrxLUGFcOgrSn6eKquYpQYunc0ILqoer2tZJFDeI7cq3GWrqeg
EWFbbNzXMIbPnCq9qo5ipZaELQXe1v74M2s4LS+yw4gOWI2RxUMcTRnp5pZwlKt+
h8j65AEQ60pWna6qTtCyQOnXQyVPUo+CohGzaNp3fc2Hyd9AMFal0bmVTCb2hXIh
cKzJeGUCgYEA/5owqCbyNmP7llNtF3WKbwg72r75RDWTRK+5aTuvrM4ZP+P8czhJ
mJVLTvzfLEj0/AwwlR+fvpEA1a1z8geZfoXmpZtTyoS4RgkjB3t+DQMi/zvyhnZk
EUkk2kMEVhsrjDUkUuRwnTJVhY3++nEWtBsdeffQnedz7lkx78gUmE8CgYEAwji2
O8sRi1Fz17SyX6e4JiM8tcRTHGEGbK9RW0/IumgTWYazOSSIONpxLWX+/Gah6VgZ
RpxDWMk6v0qWlauRCOPCjUzaMrJU0SRSBM5X2hLghyvVI3rI//RwKYTBlOaMDy6b
n9AqOdMlvwaf9jWcm250SkVvIItt7zohkUvWiFsCgYAgZffy6HTdJhE2vb5fMdvp
NP75PCm2VqAjHa7/wrwCyGD08z4FkMXrXEkeavkS0PCUniruTALgkdqsOv8uV35C
RlC0/xpA2k/NOM1C3olctuARwBR+rLUEZ+QO8l2zWGBNtlKzWxdXJZEni5cdQYZi
L+mtkxbTXQoZ1R56ST8rCwKBgQCZmOodjXIZgNghTgkG9wf+OT3I7jNgLSc8isXH
dehj6uzqj0lrtoV4mOCKq7AlAjGn7YFHw0rLi5DHOYCvaxhvNFhnENE66KeFIrku
jdUSZH1myPZtcaxGJ5UQcKn7TPyVASIYGDNcuayPTvjwaOOqVIbpOdIxpbLST2G+
m4BVIwKBgQD4rW0P/QmL6qmTMoUeqYeguyLHcVJtjoPcM9ohnwlmPApUdCYRpnmX
gRhy4iKrkB69aSlNA4wzdyHnqAJWc2BCHBjEAgamVIXxMUzLKnd815+vr8FzOvNW
1aB3r85ksu/uICBNQULRaUlyls77ZGObXpxYC78vI0fBhpUxAA7MCA==
-----END RSA PRIVATE KEY-----
PEM;

        $key = openssl_pkey_get_private($privateKey);

        if ($key === false) {
            self::markTestSkipped('OpenSSL cannot read the RSA fixture in this environment.');
        }

        return [$privateKey, openssl_pkey_get_details($key)];
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}

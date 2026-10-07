<?php

namespace App\Services;

use App\Exceptions\GoogleEmailNotVerifiedException;
use App\Exceptions\GoogleProviderException;
use App\Exceptions\GoogleTokenException;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use OutOfBoundsException;
use Throwable;

class GoogleIdTokenVerifier
{
    private const JWKS_CACHE_KEY = 'google.oauth2.jwks';

    private const JWKS_URL = 'https://www.googleapis.com/oauth2/v3/certs';

    /**
     * @return array{sub: string, email: string, name: string}
     */
    public function verify(string $idToken): array
    {
        $clientId = config('services.google.client_id');

        if (! is_string($clientId) || $clientId === '') {
            throw new GoogleProviderException('Login Google sedang tidak tersedia.');
        }

        try {
            $claims = $this->decode($idToken);
        } catch (GoogleProviderException $exception) {
            throw $exception;
        } catch (Throwable) {

            throw new GoogleTokenException('Token Google tidak valid atau sudah kedaluwarsa.');
        }

        if (! in_array($claims->iss ?? null, ['accounts.google.com', 'https://accounts.google.com'], true)) {
            throw new GoogleTokenException('Token Google tidak valid atau sudah kedaluwarsa.');
        }

        $audience = $claims->aud ?? null;
        $validAudience = is_string($audience)
            ? hash_equals($clientId, $audience)
            : is_array($audience) && in_array($clientId, $audience, true);

        if (! $validAudience) {
            throw new GoogleTokenException('Token Google tidak ditujukan untuk aplikasi ini.');
        }

        if (! isset($claims->exp) || ! is_numeric($claims->exp) || (int) $claims->exp <= time()) {
            throw new GoogleTokenException('Token Google tidak valid atau sudah kedaluwarsa.');
        }

        if (($claims->email_verified ?? null) !== true) {
            throw new GoogleEmailNotVerifiedException('Email Google belum terverifikasi.');
        }

        $sub = $claims->sub ?? null;
        $email = $claims->email ?? null;

        if (! is_string($sub) || $sub === '' || ! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new GoogleTokenException('Token Google tidak menyediakan identitas yang valid.');
        }

        $name = $claims->name ?? $email;

        return [
            'sub' => $sub,
            'email' => $email,
            'name' => is_string($name) && $name !== '' ? $name : $email,
        ];
    }

    private function decode(string $idToken): object
    {
        $headers = new \stdClass;

        try {
            $claims = JWT::decode($idToken, JWK::parseKeySet($this->keySet()), $headers);
        } catch (OutOfBoundsException) {
            // Google rotates signing keys. Retry once with a fresh key set.
            Cache::forget(self::JWKS_CACHE_KEY);
            $claims = JWT::decode($idToken, JWK::parseKeySet($this->keySet()), $headers);
        }

        if (($headers->alg ?? null) !== 'RS256' || ! isset($headers->kid)) {
            throw new GoogleTokenException('Token Google tidak valid atau sudah kedaluwarsa.');
        }

        return $claims;
    }

    /**
     * @return array<string, mixed>
     */
    private function keySet(): array
    {
        return Cache::remember(self::JWKS_CACHE_KEY, now()->addHour(), function (): array {
            $response = Http::acceptJson()
                ->timeout(5)
                ->get(self::JWKS_URL);

            if ($response->failed() || ! is_array($keys = $response->json('keys'))) {
                throw new GoogleProviderException('Kunci verifikasi Google tidak tersedia.');
            }

            return ['keys' => $keys];
        });
    }
}

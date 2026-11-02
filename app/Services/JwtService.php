<?php

namespace App\Services;

use App\Models\User;
use Exception;

class JwtService
{
    private string $secret;
    private int $ttl; // in minutes
    private int $refreshTtl;

    public function __construct()
    {
        $this->secret = config('jwt.secret') ?? env('JWT_SECRET', 'mon_orientation_ci_jwt_secret_key_orange_blanc_vert_2026');
        $this->ttl = (int) (config('jwt.ttl') ?? env('JWT_TTL', 1440)); // 24 hours
        $this->refreshTtl = (int) (config('jwt.refresh_ttl') ?? env('JWT_REFRESH_TTL', 20160)); // 14 days
    }

    /**
     * Generate an access token for a given user.
     */
    public function generateToken(User $user): string
    {
        $now = time();
        $payload = [
            'iss' => config('app.url', 'http://localhost:8000'),
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'name' => $user->name,
            'serie_id' => $user->bac_serie_id,
            'iat' => $now,
            'exp' => $now + ($this->ttl * 60),
            'type' => 'access',
        ];

        return $this->encode($payload);
    }

    /**
     * Generate a refresh token.
     */
    public function generateRefreshToken(User $user): string
    {
        $now = time();
        $payload = [
            'iss' => config('app.url', 'http://localhost:8000'),
            'sub' => $user->id,
            'iat' => $now,
            'exp' => $now + ($this->refreshTtl * 60),
            'type' => 'refresh',
        ];

        return $this->encode($payload);
    }

    /**
     * Validate a token and return its payload if valid, or null if invalid/expired.
     */
    public function validateToken(string $token): ?array
    {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return null;
            }

            [$headerB64, $payloadB64, $signatureB64] = $parts;

            $header = json_decode($this->base64UrlDecode($headerB64), true);
            $payload = json_decode($this->base64UrlDecode($payloadB64), true);

            if (!$header || !$payload) {
                return null;
            }

            // Verify signature
            $expectedSignature = hash_hmac('sha256', "$headerB64.$payloadB64", $this->secret, true);
            $actualSignature = $this->base64UrlDecode($signatureB64);

            if (!hash_equals($expectedSignature, $actualSignature)) {
                return null;
            }

            // Check expiration
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                return null;
            }

            return $payload;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieve the User instance from an access token.
     */
    public function getUserFromToken(string $token): ?User
    {
        $payload = $this->validateToken($token);
        if (!$payload || !isset($payload['sub'])) {
            return null;
        }

        return User::with(['city', 'bacSerie'])->find($payload['sub']);
    }

    private function encode(array $payload): string
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];

        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $this->secret, true);
        $signatureEncoded = $this->base64UrlEncode($signature);

        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

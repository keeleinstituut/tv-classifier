<?php

namespace Tests;

use Firebase\JWT\JWT;

trait AuthHelpers
{
    protected static function createJwt(array $payload): string
    {
        $privateKeyPem = static::getPrivateKey();

        return JWT::encode($payload, $privateKeyPem, 'RS256');
    }

    private static function getPrivateKey(): string
    {
        $key = env('KEYCLOAK_REALM_PRIVATE_KEY');

        return "-----BEGIN PRIVATE KEY-----\n".
            wordwrap($key, 64, "\n", true).
            "\n-----END PRIVATE KEY-----";
    }
}

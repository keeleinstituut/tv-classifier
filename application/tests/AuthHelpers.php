<?php

namespace Tests;

use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class AuthHelpers
{
    public static function generateServiceAccountAccessToken(?string $role = null): string
    {
        return self::createJwt([
            'iss' => config('keycloak.base_url').'/realms/'.config('keycloak.realm'),
            'realm_access' => [
                'roles' => filled($role) ? [$role] : [config('keycloak.service_account_sync_role')],
            ],
        ]);
    }

    public static function generateAccessToken(array $tolkevaravPayload = [], string $azp = null): string
    {
        $payload = collect([
            'azp' => $azp ?? Str::of(config('keycloak.accepted_authorized_parties'))
                ->explode(',')
                ->first(),
            'iss' => config('keycloak.base_url').'/realms/'.config('keycloak.realm'),
            'tolkevarav' => collect([
                'userId' => 1,
                'personalIdentificationCode' => '11111111111',
                'privileges' => [],
            ])->merge($tolkevaravPayload)->toArray(),
        ]);

        return static::createJwt($payload->toArray());
    }

    public static function createJwt(array $payload): string
    {
        $privateKeyPem = static::getPrivateKey();

        return JWT::encode($payload, $privateKeyPem, 'RS256');
    }

    public static function getPrivateKey(): string
    {
        $key = env('KEYCLOAK_REALM_PRIVATE_KEY');

        return "-----BEGIN PRIVATE KEY-----\n".
            wordwrap($key, 64, "\n", true).
            "\n-----END PRIVATE KEY-----";
    }
}

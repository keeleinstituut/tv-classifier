<?php

namespace App\DataTransferObjects\Meta;

use OpenApi\Attributes as OA;

#[OA\Schema(
    required: ['iso3_code'],
    properties: [
        new OA\Property(property: 'iso3_code', type: 'string'),
    ],
    type: 'object'
)]
readonly class LanguageMetaData
{
    public string $iso3Code;

    public function __construct(array $meta = null)
    {
        $this->iso3Code = $meta['iso3_code'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'iso3_code' => $this->iso3Code,
        ];
    }
}

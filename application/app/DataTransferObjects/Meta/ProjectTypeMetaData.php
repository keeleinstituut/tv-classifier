<?php

namespace App\DataTransferObjects\Meta;

use OpenApi\Attributes as OA;

#[OA\Schema(
    required: ['code'],
    properties: [
        new OA\Property(property: 'code', type: 'string'),
    ],
    type: 'object'
)]
readonly class ProjectTypeMetaData
{
    public string $code;

    public function __construct(array $meta = null)
    {
        $this->code = $meta['code'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\DataTransferObjects\Meta\LanguageMetaData;
use App\DataTransferObjects\Meta\ProjectTypeMetaData;
use App\Enums\ClassifierValueType;
use App\Models\ClassifierValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin ClassifierValue
 */
#[OA\Schema(
    title: 'Classifier Value',
    required: ['id', 'name', 'value', 'type', 'meta'],
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'value', type: 'string'),
        new OA\Property(property: 'type', enum: ClassifierValueType::class),
        new OA\Property(
            property: 'meta',
            nullable: true,
            anyOf: [
                new OA\Schema(ref: LanguageMetaData::class),
                new OA\Schema(ref: ProjectTypeMetaData::class),
            ]
        ),
    ],
    type: 'object'
)]
class ClassifierValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            ...$this->only([
                'id',
                'name',
                'value',
                'type',
            ]),
            'meta' => $this->getMetaData(),
        ];
    }

    protected function getMetaData(): array
    {
        return match ($this->type) {
            ClassifierValueType::Language => (new LanguageMetaData($this->meta))->toArray(),
            ClassifierValueType::ProjectType => (new ProjectTypeMetaData($this->meta))->toArray(),
            default => []
        };
    }
}

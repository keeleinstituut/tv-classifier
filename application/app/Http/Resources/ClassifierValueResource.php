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
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
            'meta' => $this->getMetaData($this),
        ];
    }

    private function getMetaData(ClassifierValueResource $classifierValue): array
    {
        return match ($classifierValue->type) {
            ClassifierValueType::Language => (new LanguageMetaData($classifierValue->meta))->toArray(),
            ClassifierValueType::ProjectType => (new ProjectTypeMetaData($classifierValue->meta))->toArray(),
            default => []
        };
    }
}

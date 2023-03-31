<?php

namespace App\Http\Resources;

use App\DataTransferObjects\Meta\LanguageMetaData;
use App\DataTransferObjects\Meta\ProjectTypeMetaData;
use App\Enums\ClassifierValueType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => $this->type->value,
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

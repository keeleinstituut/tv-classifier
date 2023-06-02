<?php

namespace App\Http\Resources;

use App\DataTransferObjects\Meta\LanguageMetaData;
use App\DataTransferObjects\Meta\ProjectTypeMetaData;
use App\Enums\ClassifierValueType;
use App\Models\ClassifierValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClassifierValue
 */
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

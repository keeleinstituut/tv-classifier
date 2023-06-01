<?php

namespace App\Http\Resources;

use App\Models\ClassifierValue;
use Illuminate\Http\Request;

/**
 * @mixin ClassifierValue
 */
class ClassifierValueSyncResource extends ClassifierValueResource
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
            'deleted_at' => $this->deleted_at,
        ];
    }
}
<?php

namespace Tests\Feature;

use App\Models\ClassifierValue;

class RepresentationHelpers
{
    public static function createClassifierValueSyncRepresentation(ClassifierValue $classifierValue): array
    {
        return [
            'id' => $classifierValue->id,
            'name' => $classifierValue->name,
            'value' => $classifierValue->value,
            'type' => $classifierValue->type->value,
            'meta' => $classifierValue->meta ?: [],
            'deleted_at' => $classifierValue->deleted_at?->toISOString(),
        ];
    }

    public static function createClassifierValueRepresentation(ClassifierValue $classifierValue): array
    {
        return [
            'id' => $classifierValue->id,
            'name' => $classifierValue->name,
            'value' => $classifierValue->value,
            'type' => $classifierValue->type->value,
            'meta' => $classifierValue->meta ?: [],
        ];
    }
}

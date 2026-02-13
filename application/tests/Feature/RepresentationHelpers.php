<?php

namespace Tests\Feature;

use App\DataTransferObjects\Meta\LanguageMetaData;
use App\DataTransferObjects\Meta\ProjectTypeMetaData;
use App\Enums\ClassifierValueType;
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
            'meta' => self::getMetaData($classifierValue),
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
            'meta' => self::getMetaData($classifierValue),
        ];
    }

    protected static function getMetaData(ClassifierValue $classifierValue): array
    {
        return match ($classifierValue->type) {
            ClassifierValueType::Language => (new LanguageMetaData($classifierValue->meta))->toArray(),
            ClassifierValueType::ProjectType => (new ProjectTypeMetaData($classifierValue->meta))->toArray(),
            default => []
        };
    }
}

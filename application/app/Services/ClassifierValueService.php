<?php

namespace App\Services;

use App\DataTransferObjects\ClassifierValueSearchData;
use App\Models\ClassifierValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ClassifierValueService
{
    public function search(ClassifierValueSearchData $searchData): Collection
    {
        return ClassifierValue::when(
            $searchData->type,
            fn(Builder $query) => $query->where('type', '=', $searchData->type->value)
        )->orderBy('type')->orderBy('name')->get();
    }
}

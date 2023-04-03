<?php

namespace App\DataTransferObjects;

use App\Enums\ClassifierValueType;

readonly class ClassifierValueSearchData
{
    public function __construct(public ?ClassifierValueType $type) {}
}

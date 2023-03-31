<?php

namespace App\DataTransferObjects;

use App\Enums\ClassifierValueType;

class ClassifierValueSearchData
{
    public function __construct(public ?ClassifierValueType $type) {}
}

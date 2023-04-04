<?php

namespace App\Http\Requests;

use App\Enums\ClassifierValueType;

class GetClassifierValuesRequest extends ApiFormRequest
{
    public function getType(): ?ClassifierValueType
    {
        return ClassifierValueType::tryFrom($this->input('type'));
    }

    public function rules(): array
    {
        return [
            'type' => ['string', 'in:'.implode(',', ClassifierValueType::values())],
        ];
    }
}

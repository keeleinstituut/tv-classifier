<?php

namespace App\Http\Requests;

use App\Enums\ClassifierValueType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ClassifierValueListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', new Enum(ClassifierValueType::class)],
        ];
    }
}

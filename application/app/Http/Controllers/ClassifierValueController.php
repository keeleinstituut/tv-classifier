<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassifierValueListRequest;
use App\Http\Resources\ClassifierValueResource;
use App\Models\ClassifierValue;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassifierValueController extends Controller
{
    public function index(ClassifierValueListRequest $request): ResourceCollection
    {
        $classifierValuesQuery = ClassifierValue::query()
            ->orderBy('type')
            ->orderBy('name');

        if ($type = $request->validated('type')) {
            $classifierValuesQuery->where('type', $type);
        }

        return ClassifierValueResource::collection(
            $classifierValuesQuery->get()
        );
    }

    public function show(string $id): ClassifierValueResource
    {
        return new ClassifierValueResource(
            ClassifierValue::query()->findOrFail($id)
        );
    }
}

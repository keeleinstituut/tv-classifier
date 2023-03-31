<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ClassifierValueSearchData;
use App\Http\Requests\GetClassifierValuesRequest;
use App\Http\Resources\ClassifierValueResource;
use App\Models\ClassifierValue;
use App\Services\ClassifierValueService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClassifierValueController extends Controller
{
    public function __construct(private readonly ClassifierValueService $classifierValueService) {}

    public function index(GetClassifierValuesRequest $request): AnonymousResourceCollection
    {
        $classifierValues = $this->classifierValueService->search(
            new ClassifierValueSearchData(
                $request->getType()
            )
        );

        return ClassifierValueResource::collection($classifierValues);
    }

    public function get(string $id): ClassifierValueResource
    {
        return new ClassifierValueResource(ClassifierValue::findOrFail($id));
    }
}

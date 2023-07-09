<?php

namespace App\Http\Controllers;

use App\Enums\ClassifierValueType;
use App\Http\Requests\ClassifierValueListRequest;
use App\Http\Resources\ClassifierValueResource;
use App\Models\ClassifierValue;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class ClassifierValueController extends Controller
{
    #[OA\Get(
        path: '/classifier-values',
        summary: 'List classifier values, optionally filtering by type',
        parameters: [
            new OA\QueryParameter(name: 'type', schema: new OA\Schema(enum: ClassifierValueType::class, nullable: true)),
        ],
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Filtered classifier values',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: ClassifierValueResource::class)
                ),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation errors')]
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

    #[OA\Get(
        path: '/classifier-values/{id}',
        summary: 'Get the classifier value with the given UUID',
        parameters: [
            new OA\PathParameter(name: 'id', schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Classifier value with given UUID',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    ref: ClassifierValueResource::class
                ),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found')]
    public function show(string $id): ClassifierValueResource
    {
        return new ClassifierValueResource(
            ClassifierValue::query()->findOrFail($id)
        );
    }
}

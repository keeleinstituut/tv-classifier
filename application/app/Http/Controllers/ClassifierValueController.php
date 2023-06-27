<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ClassifierValueSearchData;
use App\Enums\ClassifierValueType;
use App\Http\Requests\GetClassifierValuesRequest;
use App\Http\Resources\ClassifierValueResource;
use App\Models\ClassifierValue;
use App\Services\ClassifierValueService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class ClassifierValueController extends Controller
{
    public function __construct(private readonly ClassifierValueService $classifierValueService)
    {
    }

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
    public function index(GetClassifierValuesRequest $request): AnonymousResourceCollection
    {
        $classifierValues = $this->classifierValueService->search(
            new ClassifierValueSearchData(
                $request->getType()
            )
        );

        return ClassifierValueResource::collection($classifierValues);
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
    public function get(string $id): ClassifierValueResource
    {
        return new ClassifierValueResource(ClassifierValue::findOrFail($id));
    }
}

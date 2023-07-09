<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassifierValueSyncResource;
use App\Models\ClassifierValue;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use KeycloakAuthGuard\Middleware\EnsureJwtBelongsToServiceAccountWithSyncRole;

class ClassifierValueSyncController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureJwtBelongsToServiceAccountWithSyncRole::class);
    }

    public function index(): AnonymousResourceCollection
    {
        return ClassifierValueSyncResource::collection(
            ClassifierValue::withTrashed()->get()
        );
    }

    public function show(string $id): ClassifierValueSyncResource
    {
        return new ClassifierValueSyncResource(
            ClassifierValue::withTrashed()->findOrFail($id)
        );
    }
}

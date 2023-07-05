<?php

namespace Tests\Feature\Http;

use App\Http\Controllers\ClassifierValueSyncController;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthHelpers;
use Tests\Feature\RepresentationHelpers;
use Tests\TestCase;

class ClassifierValueSyncControllerShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_classifier_value_returned(): void
    {
        $classifierValue = ClassifierValue::factory()->create();
        $this->queryClassifierValueForSync($classifierValue->id, $this->generateServiceAccountAccessToken())
            ->assertOk()
            ->assertJson([
                'data' => RepresentationHelpers::createClassifierValueSyncRepresentation($classifierValue),
            ]);
    }

    public function test_single_deleted_classifier_value_returned(): void
    {
        $classifierValue = ClassifierValue::factory()->trashed()->create();
        $this->queryClassifierValueForSync($classifierValue->id, $this->generateServiceAccountAccessToken())
            ->assertOk()
            ->assertJson([
                'data' => RepresentationHelpers::createClassifierValueSyncRepresentation($classifierValue),
            ]);
    }

    public function test_receiving_single_classifier_value_with_wrong_uuid_value_returned_404(): void
    {
        $this->queryClassifierValueForSync('some-string', $this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_receiving_single_classifier_value_with_not_existing_uuid_value_returned_404(): void
    {
        $this->queryClassifierValueForSync(Str::orderedUuid(), $this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    private function queryClassifierValueForSync(string $id, ?string $token = null): TestResponse
    {
        if (filled($token)) {
            $this->withHeaders([
                'Authorization' => 'Bearer '.$token,
            ]);
        }

        return $this->getJson(action([ClassifierValueSyncController::class, 'show'], ['id' => $id]));
    }

    public function generateServiceAccountAccessToken(?string $role = null): string
    {
        return AuthHelpers::createJwt([
            'iss' => config('keycloak.base_url').'/realms/'.config('keycloak.realm'),
            'realm_access' => [
                'roles' => filled($role) ? [$role] : [config('keycloak.service_account_sync_role')],
            ],
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Http\Controllers\ClassifierValueSyncController;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthHelpers;
use Tests\TestCase;

class ClassifierValueSyncControllerTest extends TestCase
{
    use AuthHelpers, RefreshDatabase;

    public function test_list_of_classifier_values_returned(): void
    {
        $classifierValues = ClassifierValue::factory(5)->create();
        $response = $this->queryClassifierValuesForSync($this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_OK);

        $classifierValues->map(
            fn (ClassifierValue $classifierValue) => $response->assertJsonFragment(
                $this->createClassifierValueRepresentation($classifierValue)
            )
        );
    }

    public function test_list_of_classifier_values_with_deleted_returned(): void
    {
        $classifierValues = ClassifierValue::factory(5)->trashed()->create();
        $response = $this->queryClassifierValuesForSync($this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_OK);

        $classifierValues->map(
            fn (ClassifierValue $classifierValue) => $response->assertJsonFragment(
                $this->createClassifierValueRepresentation($classifierValue)
            )
        );
    }

    public function test_unauthorized_access_to_list_of_classifier_values_returned_401(): void
    {
        $this->queryClassifierValuesForSync()
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_access_with_incorrect_role_to_list_of_classifier_values_returned_403(): void
    {
        $this->queryClassifierValuesForSync($this->generateServiceAccountAccessToken('wrong-role'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_single_classifier_value_returned(): void
    {
        $classifierValue = ClassifierValue::factory()->create();
        $this->queryClassifierValueForSync($classifierValue->id, $this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => $this->createClassifierValueRepresentation($classifierValue)]);
    }

    public function test_single_deleted_classifier_value_returned(): void
    {
        $classifierValue = ClassifierValue::factory()->trashed()->create();
        $this->queryClassifierValueForSync($classifierValue->id, $this->generateServiceAccountAccessToken())
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => $this->createClassifierValueRepresentation($classifierValue)]);
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

    private function createClassifierValueRepresentation(ClassifierValue $classifierValue): array
    {
        return [
            'id' => $classifierValue->id,
            'name' => $classifierValue->name,
            'value' => $classifierValue->value,
            'type' => $classifierValue->type->value,
            'meta' => $classifierValue->meta ?: [],
            'deleted_at' => $classifierValue->deleted_at?->toISOString(),
        ];
    }

    private function queryClassifierValuesForSync(?string $token = null): TestResponse
    {
        if (filled($token)) {
            $this->withHeaders([
                'Authorization' => 'Bearer '.$token,
            ]);
        }

        return $this->getJson(action([ClassifierValueSyncController::class, 'index']));
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
        $azp = explode(',', config('keycloak.service_accounts_accepted_authorized_parties'))[0];

        return $this->createJwt([
            'iss' => config('keycloak.base_url').'/realms/'.config('keycloak.realm'),
            'azp' => $azp,
            'realm_access' => [
                'roles' => filled($role) ? [$role] : [config('keycloak.service_account_sync_role')],
            ],
        ]);
    }
}

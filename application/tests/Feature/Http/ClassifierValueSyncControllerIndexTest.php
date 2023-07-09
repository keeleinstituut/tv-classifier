<?php

namespace Tests\Feature\Http;

use App\Http\Controllers\ClassifierValueSyncController;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\AuthHelpers;
use Tests\Feature\RepresentationHelpers;
use Tests\TestCase;

class ClassifierValueSyncControllerIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_classifier_values_returned(): void
    {
        $classifierValues = ClassifierValue::factory(5)->create();
        $response = $this->queryClassifierValuesForSync(
            AuthHelpers::generateServiceAccountAccessToken()
        )->assertOk();

        $classifierValues->map(
            fn (ClassifierValue $classifierValue) => $response->assertJsonFragment(
                RepresentationHelpers::createClassifierValueSyncRepresentation($classifierValue)
            )
        );
    }

    public function test_list_of_classifier_values_with_deleted_returned(): void
    {
        $classifierValues = ClassifierValue::factory(5)->trashed()->create();
        $response = $this->queryClassifierValuesForSync(
            AuthHelpers::generateServiceAccountAccessToken()
        )->assertOk();

        $classifierValues->map(
            fn (ClassifierValue $classifierValue) => $response->assertJsonFragment(
                RepresentationHelpers::createClassifierValueSyncRepresentation($classifierValue)
            )
        );
    }

    public function test_unauthorized_access_to_list_of_classifier_values_returned_401(): void
    {
        $this->queryClassifierValuesForSync()
            ->assertUnauthorized();
    }

    public function test_access_with_incorrect_role_to_list_of_classifier_values_returned_403(): void
    {
        $this->queryClassifierValuesForSync(
            AuthHelpers::generateServiceAccountAccessToken('wrong-role')
        )->assertForbidden();
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
}

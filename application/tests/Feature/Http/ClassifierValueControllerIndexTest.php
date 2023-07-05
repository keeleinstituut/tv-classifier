<?php

namespace Tests\Feature\Http;

use App\Enums\ClassifierValueType;
use App\Http\Controllers\ClassifierValueController;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\AuthHelpers;
use Tests\Feature\RepresentationHelpers;
use Tests\TestCase;

class ClassifierValueControllerIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_receiving_list_of_classifier_values(): void
    {
        $classifierValues = ClassifierValue::factory(100)->create();
        $trashedClassifierValue = ClassifierValue::factory()->trashed()->createOne();

        $response = $this->sendGetRequestWithGivenToken(
            AuthHelpers::generateAccessToken()
        )->assertOk();

        $classifierValues->each(
            fn (ClassifierValue $classifierValue) => $response->assertJsonFragment(
                RepresentationHelpers::createClassifierValueRepresentation($classifierValue)
            )
        );

        $response->assertJsonMissing(['id' => $trashedClassifierValue->id]);
    }

    public function test_receiving_list_of_classifier_values_with_specific_type()
    {
        foreach (ClassifierValueType::cases() as $classifierValueType) {
            ClassifierValue::factory(10)->withType($classifierValueType)->create();
        }

        $token = AuthHelpers::generateAccessToken();
        foreach (ClassifierValueType::cases() as $classifierValueType) {
            $response = $this->sendGetRequestWithGivenToken(
                $token,
                ['type' => $classifierValueType->value]
            )->assertOk();

            foreach (ClassifierValueType::cases() as $anotherClassifierValueType) {
                if ($anotherClassifierValueType === $classifierValueType) {
                    continue;
                }

                $response->assertJsonMissing(['type' => $anotherClassifierValueType->value]);
            }
        }
    }

    public function test_receiving_list_of_classifier_values_with_wrong_type()
    {
        $this->sendGetRequestWithGivenToken(
            AuthHelpers::generateAccessToken(),
            ['type' => 'wrong_type']
        )->assertUnprocessable();
    }

    public function test_unauthorized_receiving_list_of_classifier_values_returned_401()
    {
        $this->sendGetRequestWithGivenToken('')->assertUnauthorized();
    }

    private function sendGetRequestWithGivenToken(string $token, array $queryParams = []): TestResponse
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->getJson(action([ClassifierValueController::class, 'index'], $queryParams));
    }
}

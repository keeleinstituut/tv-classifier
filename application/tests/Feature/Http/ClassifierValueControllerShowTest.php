<?php

namespace Tests\Feature\Http;

use App\Http\Controllers\ClassifierValueController;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\AuthHelpers;
use Tests\TestCase;

class ClassifierValueControllerShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_receiving_classifier_value(): void
    {
        $classifierValue = ClassifierValue::factory()->create();
        $this->sendGetRequestWithGivenToken(
            $classifierValue->id,
            AuthHelpers::generateAccessToken()
        )->assertOk()->assertJsonFragment([
            'id' => $classifierValue->id,
            'name' => $classifierValue->name,
            'value' => $classifierValue->value,
            'type' => $classifierValue->type->value,
            'meta' => $classifierValue->meta ?: [],
        ]);
    }

    public function test_receiving_trashed_classifier_value(): void
    {
        $classifierValue = ClassifierValue::factory()->trashed()->create();
        $this->sendGetRequestWithGivenToken(
            $classifierValue->id,
            AuthHelpers::generateAccessToken()
        )->assertNotFound();
    }

    public function test_unauthorized_receiving_classifier_value_returned_401(): void
    {
        $classifierValue = ClassifierValue::factory()->trashed()->create();
        $this->sendGetRequestWithGivenToken(
            $classifierValue->id,
            ''
        )->assertUnauthorized();
    }

    private function sendGetRequestWithGivenToken(string $id, string $token): TestResponse
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->getJson(action([ClassifierValueController::class, 'show'], ['id' => $id]));
    }
}

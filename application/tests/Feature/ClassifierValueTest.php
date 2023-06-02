<?php

namespace Tests\Feature;

use App\Enums\ClassifierValueType;
use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Throwable;

class ClassifierValueTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_saving(): void
    {
        $createdModel = ClassifierValue::factory()->create();
        $this->assertModelExists($createdModel);

        $retrievedModel = ClassifierValue::findOrFail($createdModel->id);
        $this->assertEquals($createdModel->name, $retrievedModel->name);
    }

    public function test_soft_delete(): void
    {
        $createdModel = ClassifierValue::factory()->create();
        $this->assertModelExists($createdModel);

        $createdModel->delete();
        $this->assertModelExists($createdModel);
        $this->assertNotEmpty($createdModel->deleted_at);
    }

    /**
     * @throws Throwable
     */
    public function test_receiving_list_of_classifier_values(): void
    {
        $classifierValues = ClassifierValue::factory(100)->create();
        $trashedClassifierValue = ClassifierValue::factory()->trashed()->createOne();
        $response = $this->json('GET', '/api/classifier-values');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(ClassifierValue::query()->count(), 'data');

        $responseContentParts = $classifierValues->map(
            fn(ClassifierValue $classifierValue) => [
                'id' => $classifierValue->id,
                'name' => $classifierValue->name,
                'value' => $classifierValue->value,
                'type' => $classifierValue->type->value,
                'meta' => $classifierValue->meta ?: [],
            ]
        )->toArray();

        foreach ($responseContentParts as $responseContentPart) {
            $response->assertJsonFragment($responseContentPart);
        }

        $response->assertJsonMissing(['id' => $trashedClassifierValue->id]);
    }

    public function test_receiving_list_of_classifier_values_with_specific_type()
    {
        foreach (ClassifierValueType::cases() as $classifierValueType) {
            ClassifierValue::factory(10)->withType($classifierValueType)->create();
        }

        foreach (ClassifierValueType::cases() as $classifierValueType) {
            $classifierValuesCount = ClassifierValue::query()->where('type', '=', $classifierValueType->value)
                ->count();

            $response = $this->json('GET', "/api/classifier-values?type=$classifierValueType->value")
                ->assertStatus(Response::HTTP_OK)
                ->assertJsonCount($classifierValuesCount, 'data');

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
        $this->json('GET', '/api/classifier-values?type=somerandomstring')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_receiving_classifier_value(): void
    {
        $classifierValue = ClassifierValue::factory()->create();
        $this->json('GET', "/api/classifier-values/$classifierValue->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
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
        $this->json('GET', "/api/classifier-values/$classifierValue->id")
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

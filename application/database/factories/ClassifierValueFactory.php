<?php

namespace Database\Factories;

use App\Enums\ClassifierValueType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassifierValue>
 */
class ClassifierValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(ClassifierValueType::cases());

        return [
            'name' => Str::random(10),
            'value' => Str::random(10),
            'type' => $type,
            'meta' => $this->getMetaByType($type),
        ];
    }

    public function withType(ClassifierValueType $type): Factory
    {
        return $this->state(fn() => [
            'type' => $type,
            'meta' => $this->getMetaByType($type),
        ]);
    }

    private function getMetaByType(ClassifierValueType $type): ?array
    {
        return match ($type) {
            ClassifierValueType::Language => [
                'iso3_code' => Str::random(3),
            ],
            ClassifierValueType::ProjectType => [
                'display_start_time' => fake()->boolean,
                'workflow_id' => Str::random(),
            ],
            default => null,
        };
    }
}

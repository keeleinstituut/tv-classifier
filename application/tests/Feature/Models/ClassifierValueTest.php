<?php

namespace Tests\Feature\Models;

use App\Models\ClassifierValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}

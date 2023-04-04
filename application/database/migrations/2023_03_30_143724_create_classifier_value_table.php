<?php

use App\Enums\ClassifierValueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classifier_values', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->enum('type', ClassifierValueType::values());
            $table->string('value');
            $table->string('name');
            $table->json('meta')->nullable();
            $table->unique(['type', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifier_values');
    }
};

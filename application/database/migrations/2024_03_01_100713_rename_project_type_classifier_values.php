<?php

use App\Enums\ClassifierValueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->getData() as $classifierValueData) {
            $this->updateClassifierName(
                $classifierValueData[1],
                $classifierValueData[0]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->getRevertData() as $classifierValueData) {
            $this->updateClassifierName(
                $classifierValueData[1],
                $classifierValueData[0]
            );
        }
    }

    private function updateClassifierName(string $value, string $name): void
    {
        DB::table('classifier_values')
            ->where('type', ClassifierValueType::ProjectType->value)
            ->where('value', $value)
            ->update([
                'name' => $name,
                'updated_at' => DB::raw('NOW()'),
            ]);
    }

    private function getData(): array
    {
        return [
            ['Toimetatud tõlge (CAT)', 'EDITED_TRANSLATION'],
            ['Toimetatud tõlge (CAT), Ülevaatus', 'EDITED_TRANSLATION_REVIEW'],
        ];
    }

    private function getRevertData(): array
    {
        return [
            ['Toimetatud tõlge', 'EDITED_TRANSLATION'],
            ['Toimetatud tõlge, Ülevaatus', 'EDITED_TRANSLATION_REVIEW'],
        ];
    }
};

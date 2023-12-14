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
        DB::table('classifier_values')->insert(
            array_map(function (array $classifierValueItem) {
                return [
                    'name' => $classifierValueItem[0],
                    'value' => $classifierValueItem[1],
                    'meta' => json_encode(['iso3_code' => $classifierValueItem[2]]),
                    'type' => ClassifierValueType::Language->value,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ];
            }, $this->getData())
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('classifier_values')
            ->whereIn('value', array_column($this->getData(), 1))
            ->where('type', '=', ClassifierValueType::Language->value)
            ->delete();
    }

    private function getData(): array
    {
        return [
            ['kurdi-badini [ku-SDH]', 'ku-SDH', 'kur'],
            ['pärsia (farsi) [pes-IR]', 'pes-IR', 'pes'],
            ['pärsia (dari) [fa-AF]', 'fa-AF', 'prs'],
        ];
    }
};

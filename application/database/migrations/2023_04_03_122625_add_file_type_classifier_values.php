<?php

use App\Enums\ClassifierValueType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('classifier_values')->insert(
            array_map(function (array $classifierValueData) {
                return [
                    ...$classifierValueData,
                    'type' => ClassifierValueType::FileType->value,
                    'meta' => '[]',
                    'created_at' => DB::raw('NOW()'),
                ];
            }, $this->getData())
        );
    }

    public function down(): void
    {
        DB::table('classifier_values')
            ->whereIn('value', array_column($this->getData(), 'value'))
            ->where('type', '=', ClassifierValueType::FileType->value)
            ->delete();
    }

    private function getData(): array
    {
        return [
            [
                'name' => 'Stiilijuhis',
                'value' => 'SJ',
            ],
            [
                'name' => 'Terminibaas',
                'value' => 'TB',
            ],
            [
                'name' => 'Abifail',
                'value' => 'AF',
            ],
            [
                'name' => 'Tõlkemälu',
                'value' => 'TM',
            ],
        ];
    }
};

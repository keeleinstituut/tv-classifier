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
                    'type' => ClassifierValueType::ProjectType->value,
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
            ->whereIn('name', array_column($this->getData(), 0))
            ->where('type', '=', ClassifierValueType::ProjectType->value)
            ->delete();
    }

    private function getData(): array
    {
        return [
            'Suuline tõlge', 'S',
            'Järeltõlge', 'JÄ',
            'Sünkroontõlge', 'SÜ',
            'Viipekeel', 'VK',
            'Tõlkimine (CAT), Ülevaatus', 'T',
            'Tõlkimine (CAT)', 'T',
            'Tõlkimine, Ülevaatus', 'T',
            'Tõlkimine', 'T',
            'Toimetamine, Ülevaatus', 'TO',
            'Toimetamine', 'TO',
            'Toimetatud tõlge, Ülevaatus', 'TO',
            'Toimetatud tõlge', 'TT',
            'Tõlkimine (CAT), Toimetamine, Ülevaatus', 'TT',
            'Tõlkimine (CAT), Toimetamine', 'TT',
            'Tõlkimine, Toimetamine, Ülevaatus', 'TT',
            'Tõlkimine, Toimetamine', 'TT',
            'Käsikirjaline tõlge, Ülevaatus', 'KT',
            'Käsikirjaline tõlge', 'KT',
            'Terminoloogia töö', 'TR',
            'Vandetõlge (CAT), ülevaatus', 'VT',
            'Vandetõlge (CAT)', 'VT',
            'Vandetõlge, Ülevaatus', 'VT',
            'Vandetõlge', 'VT',
        ];
    }
};

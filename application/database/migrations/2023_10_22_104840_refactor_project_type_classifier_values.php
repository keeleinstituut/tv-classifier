<?php

use App\Enums\ClassifierValueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->getData() as $classifierValueData) {
            DB::table('classifier_values')->where('type', ClassifierValueType::ProjectType->value)
                ->updateOrInsert([
                    'name' => $classifierValueData[0],
                    'type' => ClassifierValueType::ProjectType->value
                ], [
                    'value' => $classifierValueData[1],
                    'meta' => json_encode($classifierValueData[2]),
                    'updated_at' => DB::raw('NOW()'),
                ]);
        }

        Schema::table('classifier_values', function (Blueprint $table) {
            $table->unique(['type', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classifier_values', function (Blueprint $table) {
            $table->dropUnique(['type', 'value']);
        });

        foreach ($this->getRevertData() as $classifierValueItem) {
            DB::table('classifier_values')->where('name', $classifierValueItem[0])
                ->where('type', ClassifierValueType::ProjectType->value)
                ->update([
                    'name' => $classifierValueItem[0],
                    'value' => $classifierValueItem[1],
                    'meta' => null,
                    'updated_at' => DB::raw('NOW()'),
                ]);
        }

        DB::table('classifier_values')->where('value', 'TERMINOLOGY_WORK_REVIEW')
            ->where('type', ClassifierValueType::ProjectType->value)
            ->delete();
    }

    private function getData(): array
    {
        return [
            ['Suuline tõlge', 'ORAL_TRANSLATION', ['code' => 'S']],
            ['Sünkroontõlge', 'SYNCHRONOUS_TRANSLATION', ['code' => 'SÜ']],
            ['Järeltõlge', 'POST_TRANSLATION', ['code' => 'JÄ']],
            ['Viipekeel', 'SIGN_LANGUAGE', ['code' => 'VK']],
            ['Tõlkimine (CAT), Ülevaatus', 'CAT_TRANSLATION_REVIEW', ['code' => 'T']],
            ['Tõlkimine (CAT), Toimetamine, Ülevaatus', 'CAT_TRANSLATION_EDITING_REVIEW', ['code' => 'TT']],
            ['Tõlkimine (CAT), Toimetamine', 'CAT_TRANSLATION_EDITING', ['code' => 'TT']],
            ['Tõlkimine (CAT)', 'CAT_TRANSLATION', ['code' => 'T']],
            ['Toimetatud tõlge', 'EDITED_TRANSLATION', ['code' => 'TT']],
            ['Toimetatud tõlge, Ülevaatus', 'EDITED_TRANSLATION_REVIEW', ['code' => 'TO']],
            ['Tõlkimine, Ülevaatus', 'TRANSLATION_REVIEW', ['code' => 'T']],
            ['Tõlkimine', 'TRANSLATION', ['code' => 'T']],
            ['Tõlkimine, Toimetamine, Ülevaatus', 'TRANSLATION_EDITING_REVIEW', ['code' => 'TT']],
            ['Tõlkimine, Toimetamine', 'TRANSLATION_EDITING', ['code' => 'TT']],
            ['Käsikirjaline tõlge', 'MANUSCRIPT_TRANSLATION', ['code' => 'KT']],
            ['Käsikirjaline tõlge, Ülevaatus', 'MANUSCRIPT_TRANSLATION_REVIEW', ['code' => 'KT']],
            ['Terminoloogia töö', 'TERMINOLOGY_WORK', ['code' => 'TR']],
            ['Terminoloogia töö, Ülevaatus', 'TERMINOLOGY_WORK_REVIEW', ['code' => 'TR']],
            ['Vandetõlge (CAT), ülevaatus', 'SWORN_CAT_TRANSLATION_REVIEW', ['code' => 'VT']],
            ['Vandetõlge (CAT)', 'SWORN_CAT_TRANSLATION', ['code' => 'VT']],
            ['Vandetõlge, Ülevaatus', 'SWORN_TRANSLATION_REVIEW', ['code' => 'VT']],
            ['Vandetõlge', 'SWORN_TRANSLATION', ['code' => 'VT']],
            ['Toimetamine, Ülevaatus', 'EDITING_REVIEW', ['code' => 'TO']],
            ['Toimetamine', 'EDITING', ['code' => 'TO']],
        ];
    }

    private function getRevertData(): array
    {
        return [
            ['Suuline tõlge', 'S'],
            ['Järeltõlge', 'JÄ'],
            ['Sünkroontõlge', 'SÜ'],
            ['Viipekeel', 'VK'],
            ['Tõlkimine (CAT), Ülevaatus', 'T'],
            ['Tõlkimine (CAT)', 'T'],
            ['Tõlkimine, Ülevaatus', 'T'],
            ['Tõlkimine', 'T'],
            ['Toimetamine, Ülevaatus', 'TO'],
            ['Toimetamine', 'TO'],
            ['Toimetatud tõlge, Ülevaatus', 'TO'],
            ['Toimetatud tõlge', 'TT'],
            ['Tõlkimine (CAT), Toimetamine, Ülevaatus', 'TT'],
            ['Tõlkimine (CAT), Toimetamine', 'TT'],
            ['Tõlkimine, Toimetamine, Ülevaatus', 'TT'],
            ['Tõlkimine, Toimetamine', 'TT'],
            ['Käsikirjaline tõlge, Ülevaatus', 'KT'],
            ['Käsikirjaline tõlge', 'KT'],
            ['Terminoloogia töö', 'TR'],
            ['Vandetõlge (CAT), ülevaatus', 'VT'],
            ['Vandetõlge (CAT)', 'VT'],
            ['Vandetõlge, Ülevaatus', 'VT'],
            ['Vandetõlge', 'VT'],
        ];
    }
};

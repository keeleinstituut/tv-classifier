<?php

use App\Enums\ClassifierValueType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('classifier_values')->insert(
            array_map(function (array $classifierValueData) {
                return [
                    ...$classifierValueData,
                    'type' => ClassifierValueType::TranslationDomain->value,
                    'meta' => '[]',
                    'created_at' => DB::raw('NOW()'),
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
            ->whereIn('value', array_column($this->getData(), 'value'))
            ->where('type', '=', ClassifierValueType::TranslationDomain->value)
            ->delete();
    }

    private function getData(): array
    {
        return [
            [
                'name' => 'Haridus',
                'value' => 'HAR',
            ],
            [
                'name' => 'Teadus',
                'value' => 'TEA',
            ],
            [
                'name' => 'Arhiivindus',
                'value' => 'ARH',
            ],
            [
                'name' => 'Noorte- ja keelepoliitika',
                'value' => 'NKP',
            ],
            [
                'name' => 'Õiguspoliitika',
                'value' => 'ÕIP',
            ],
            [
                'name' => 'Kriminaalpoliitika',
                'value' => 'KRP',
            ],
            [
                'name' => 'Seadusetõlked',
                'value' => 'SET',
            ],
            [
                'name' => 'Justiitshalduspoliitika',
                'value' => 'JHP',
            ],
            [
                'name' => 'Eelarvepoliitika',
                'value' => 'EAP',
            ],
            [
                'name' => 'Maksu- ja tollipoliitika',
                'value' => 'MTP',
            ],
            [
                'name' => 'Riiklik statistika',
                'value' => 'RST',
            ],
            [
                'name' => 'Riigiraamatupidamine',
                'value' => 'RRP',
            ],
            [
                'name' => 'Finants- ja kindlustuspoliitika',
                'value' => 'FKP',
            ],
            [
                'name' => 'Kinnisvara- ja osaluspoliitika',
                'value' => 'KOP',
            ],
            [
                'name' => 'Avalik kord ja sisejulgeolek',
                'value' => 'ASP',
            ],
            [
                'name' => 'Kriisireguleerimine ja pästetööd',
                'value' => 'KPT',
            ],
            [
                'name' => 'Piirivalve',
                'value' => 'PRV',
            ],
            [
                'name' => 'Kodakondsuse, rände ja identiteedihaldus',
                'value' => 'KRI',
            ],
            [
                'name' => 'Rahvastiku- ja perepoliitika',
                'value' => 'RPP',
            ],
        ];
    }
};

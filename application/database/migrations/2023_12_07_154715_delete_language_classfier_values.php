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
        DB::table('classifier_values')
            ->whereIn('value', array_column($this->getData(), 1))
            ->where('type', '=', ClassifierValueType::Language->value)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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

    private function getData(): array
    {
        return [
            ['araabia [ar-SA]', 'ar-SA', 'ara'],
            ['araabia [ar-MA]', 'ar-MA', 'ara'],
            ['hiina [zh-HK]', 'zh-HK', 'zho'],
            ['hiina [zh-MO]', 'zh-MO', 'zho'],
            ['hispaania [es-419]', 'es-419', 'spa'],
            ['hispaania [es-AR]', 'es-AR', 'spa'],
            ['hispaania [es-CO]', 'es-CO', 'spa'],
            ['hispaania [es-MX]', 'es-MX', 'spa'],
            ['hispaania [es-US]', 'es-US', 'spa'],
            ['hollandi [nl-BE]', 'nl-BE', 'nld'],
            ['inglise [en-AU]', 'en-AU', 'eng'],
            ['inglise [en-CA]', 'en-CA', 'eng'],
            ['inglise [en-IE]', 'en-IE', 'eng'],
            ['inglise [en-IN]', 'en-IN', 'eng'],
            ['inglise [en-NZ]', 'en-NZ', 'eng'],
            ['inglise [en-SG]', 'en-SG', 'eng'],
            ['inglise [en-ZA]', 'en-ZA', 'eng'],
            ['itaalia [it-CH]', 'it-CH', 'ita'],
            ['kannada [kr-KAU]', 'kr-KAU', 'kan'],
            ['norra [nn-NO]', 'nn-NO', 'nno'],
            ['pandžabi [pnb-PK]', 'pnb-PK', 'pan'],
            ['portugali [pt-BR]', 'pt-BR', 'por'],
            ['prantsuse [fr-BE]', 'fr-BE', 'fra'],
            ['prantsuse [fr-CA]', 'fr-CA', 'fra'],
            ['prantsuse [fr-CH]', 'fr-CH', 'fra'],
            ['romanši [roh-CH]', 'roh-CH', 'roh'],
            ['saksa [de-AT]', 'de-AT', 'deu'],
            ['saksa [de-CH]', 'de-CH', 'deu'],
            ['tamili [ta-LK]', 'ta-LK', 'tam'],
            ['tsvana [tn-ZA]', 'tn-ZA', 'tsn'],
            ['vanasüüria [syc-TR]', 'syc-TR', 'syc'],
            ['vandala [mfi-NG]', 'mfi-NG', 'mfi'],
            ['pärsia [fa-AF]', 'fa-AF', 'fas'],
        ];
    }
};

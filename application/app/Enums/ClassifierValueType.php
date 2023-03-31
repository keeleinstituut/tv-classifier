<?php

namespace App\Enums;

enum ClassifierValueType: string
{
    case Language = 'LANGUAGE';
    case FileType = 'FILE_TYPE';
    case TranslationDomain = 'TRANSLATION_DOMAIN';
    case ProjectType = 'PROJECT_TYPE';
}

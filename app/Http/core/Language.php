<?php

namespace App\Http\core;


use App\Models\TranslateModel;
use App\Models\LanguageModel;

class Language
{

    public function l($translation_string, $lg = null)
    {
        if ($translation_string != "") {
            if ($lg == null) {
                $lg = session('language') != null ? session('language') : 'en';
            }

            $languages = LanguageModel::all();
            foreach ($languages as $key => $value) {
                $check = TranslateModel::istranslationexist($translation_string, $value['language_id']);
                if ($check == '') {
                    TranslateModel::insertString($translation_string, $value['language_id']);
                } else {
                    $language_id = LanguageModel::get_language_id($lg);
                    $translation_trad = TranslateModel::getTranslationValue($translation_string, $language_id);
                    if ($translation_trad != "") {
                        return $translation_trad;
                    }
                }
            }
            return $translation_string;
            //}
        }
    }
}

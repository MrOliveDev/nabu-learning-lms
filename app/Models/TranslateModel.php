<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LanguageModel;

class TranslateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation_id', 'language_id', 'translation_string', 'translation_value'
    ];

    protected $table = 'tb_translations';

    public $timestamps = false;

    protected $primaryKey = 'translation_id';

    public function scopeIstranslationexist($query, $translation_string, $language_id)
    {

        $data = $query->where('translation_string', $translation_string)
            ->where('language_id', $language_id)
            ->first();
        return $data == null ? $translation_string : $data['translation_value'];
    }

    public function scopeGetTranslationValue($query, $translation_string, $language_id)
    {
        $data = $query->where('translation_string', $translation_string)
            ->where('language_id', $language_id)
            ->first();
        return $data == null ? $translation_string : $data['translation_value'];
    }

    public function scopeUpdateTranslation($query, $translation_id, $translation_value)
    {

        $query->where('translation_id', $translation_id)
            ->update(['translation_value' => $translation_value]);
    }

    public function scopeRemovebylang($query, $language_id)
    {

        $query->where('language_id', $language_id)
            ->delete();
    }

    public function scopeGettranslation($query, $translation_string, $Translation_id)
    {

        $prepare_data = $query->where('traslation_string', $translation_string)
            ->where('Translation_id', $Translation_id);
        $data = $prepare_data->get();
        $data['doesitexist'] = $prepare_data->count();
        return $data;
    }

    public function scopeGet_translation_string($query, $translation_id)
    {

        $data = $query->where('translation_id', $translation_id)->first();
        return $data['translation_string'];
    }

    public function scopeInsertString($query, $translation_string, $language_id)
    {

        $query->create(['translation_string' => $translation_string, 'language_id' => $language_id]);
    }

    public function scopeGetTranslations($query, $language_id)
    {

        $dataf = $query->where('language_id', $language_id)->get();
        return $dataf;
    }

    public function scopeGet_list_of_string($query)
    {
        $data = $query->groupby('translation_string')->distinct()->select('translation_string');
        return $data == null ? $data : array();
    }
}

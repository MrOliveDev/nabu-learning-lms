<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'language_name', 'language_iso', 'language_active'
    ];

    protected $table = 'tb_languages';

    public $timestamps = false;

    public function scopeGetLanguage($query, $language_id){

        $data=$query->where('language_id', $language_id)->get();
		return $data;
	}

	public function scopeGet_language_id($query, $language_iso = 'en'){

        $data = $query->where('language_iso', $language_iso)->first();
        return $data['language_id'];
	}

	public function scopeGet_language_iso($query, $language_id){

        $data=$query->where('language_id', $language_id)->get();
        return $data['language_iso'];
	}

	public function scopeGet_language_name($query, $language_iso){

        $data=$query->where('language_iso', $language_iso)->get();
        return $data['language_name'];
	}

	public function scopeGetLanguages($query, ){

        $dataf=$query->all();
        return $dataf;
	}

	public function scopeUpdateLanguage($query, $language_id, $language_name, $language_iso, $language_active){

        $query->where('language_id', $language_id)
        ->update(['language_name'=>$language_name,
        'language_iso'=>$language_iso,
        'language_active'=>$language_active]);
    }

	public function scopeInsertLanguage($query, $language_name, $language_iso, $language_active){

        $data=$query->create(['language_name'=>$language_name, 'language_iso'=>$language_iso, 'language_active'=>$language_active]);
        return $data->id;
    }

	public function scopeDeleteLanguage($query, $language_id){
        $query->where('language_id', $language_id)->delete();
	}

	public function scopeGetIdByIso($query, $language_iso){

        $data=$query->where('language_iso', $language_iso)->get();
		return $data['language_id'];
	}
}

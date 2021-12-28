<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "id", "filename", "user", "created_date"
    ];
    protected $table = 'tb_document';

    public $timestamps = false;

    public function scopeGetDocumentsBySession($query, $session_id) {
        $result = $query->select(
            'tb_document.*',
            // 'tb_languages.language_iso as language_iso'
            // 'tb_position.name as position',
            // 'tb_companies.name as companies'
        )
            // ->leftjoin('tb_languages', 'tb_session.language_iso', '=', 'tb_languages.language_id')
            ->where('tb_document.session_id', $session_id)
            ->get();
        return $result;
    }
}

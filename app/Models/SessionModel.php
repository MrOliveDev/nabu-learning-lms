<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'session_code',
        'name',
        'begin_date',
        'linked_item',
        'create_date',
        'templateformation',
        'language_iso',
        'description',
        'participants',
        'contents',
        'end_date',
    ];

    protected $table = 'tb_session';

    public $timestamps = false;

    public function scopeGetSessionPageInfoFromId($query, $id)
    {
        $result = $query->select(
            'tb_users.*',
            'tb_languages.language_iso as language_iso'
            // 'tb_position.name as position',
            // 'tb_companies.name as companies'
        )
            ->leftjoin('tb_languages', 'session.language_iso', '=', 'tb_languages.language_id')
            ->where('tb_session.id', $id)
            ->first();
        return $result;
    }

    public function scopeGetSessionPageInfo($query)
    {
        $result = $query->select(
            'tb_session.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_session.language_iso', 'tb_languages.language_id')
            ->get();
        return $result;
    }
}

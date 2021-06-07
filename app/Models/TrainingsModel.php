<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'id_creator',
        'date_begin',
        'date_end',
        'status',
        'creation_date',
        'templateformation',
        'lesson_content',
        'type'
    ];

    protected $table = 'tb_trainings';
    use HasFactory;

    public function scopeGetAllTrainings($query)
    {
        return $query->select(
            'tb_trainings.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_trainings.lang', '=', 'tb_languages.language_id')
            ->get();
    }

    public function scopeGetTrainingForTrainingpage($query, $id)
    {
        $result = $query->select(
            'tb_trainings.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_trainings.lang', '=', 'tb_languages.language_id')
            ->where('tb_trainings.id', $id)
            ->first();
        return $result;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'publicoAlvo',
        'dataCriacao',
        'status',
        'idFabrica',
        'idCriador',
        'threshold_score',
        'template_player_id'
    ];

    protected $table = 'tb_lesson';
    use HasFactory;

    public function scopeGetLessonsContainedTraining($query)
    {
        $trainings = TrainingsModel::select('id', 'lesson_content')->get();
        $lessons = $query->select(
            'tb_lesson.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_lesson.lang', '=', 'tb_languages.language_id')
            ->get();
        $test = array(array());
        foreach ($lessons as $key => $lesson) {
            $test[$key] = $lesson->toArray();
            $test[$key]['training'] = [];
        }
        foreach ($lessons as $key => $lesson) {
            foreach ($trainings as $training) {
                $lessonList = json_decode($training->lesson_content, true);
                foreach ($lessonList as $lessonItem) {
                    if ($lessonItem['item'] == $lesson->id) {
                        array_push($test[$key]['training'], $training->id);
                    }
                }
            }
        }
        return $test;
    }
    public function scopeGetLessonContainedTraining($query, $id)
    {
        $trainings = TrainingsModel::select('id', 'lesson_content')->get();
        $lesson = $query->select(
            'tb_lesson.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_lesson.lang', '=', 'tb_languages.language_id')
            ->where('id', $id)
            ->first();

        $test = $lesson->toArray();
        $test['training'] = array();
        foreach ($trainings as $training) {
            $lessonList = json_decode($training->lesson_content, true);
            foreach ($lessonList as $lessonItem) {
                if ($lessonItem['item'] == $lesson->id) {
                    array_push($test['training'], $training->id);
                }
            }
        }
        return $test;
    }
}

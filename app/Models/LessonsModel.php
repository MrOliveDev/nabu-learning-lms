<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonsModel extends Model
{
    use HasFactory;

    protected $fillable = [
'id',
'name',
'description',
'publicAudio',
'creation_date',
'status',
'idFabrica',
'idCreator',
'threshold_score',
'template_player_id',
'lang',
'date_end',
'duration'
    ];

    protected $table = 'tb_lesson';
    public $timestamps = false;

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
                // var_dump($training->lesson_content."<br>");
                if ($lessonList != NULL) {
                    foreach ($lessonList as $lessonItem) {
                        if ($lessonItem['item'] == $lesson->id) {
                            array_push($test[$key]['training'], $training->id);
                        }
                    }
                }
            }
            // exit();
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
            ->where('tb_lesson.id', $id)
            ->first();

        $test = $lesson->toArray();
        $test['training'] = array();
        foreach ($trainings as $training) {
            $lessonList = json_decode($training->lesson_content, true);
            if ($lessonList != NULL) {
                foreach ($lessonList as $lessonItem) {
                    if ($lessonItem['item'] == $lesson->id) {
                        array_push($test['training'], $training->id);
                    }
                }
            }
        }
        return $test;
    }

    public function scopeGetLessonForTrainingpage($query, $id)
    {
        $result = $query->select(
            'tb_lesson.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_lesson.lang', '=', 'tb_languages.language_id')
            ->where('tb_lesson.id', $id)
            ->first();
        return $result;
    }

    public function scopeGetLessonByClient($scope) {
        $client = session("client");
        $lessons = $query->leftjoin("tb_users", 'tb_lesson.idCreator', "=", 'tb_users.id')->where("tb_lesson.idCreator", $client)->orWhere('tb_user.creator', $client)->get();
        return $lesson;
    }
}

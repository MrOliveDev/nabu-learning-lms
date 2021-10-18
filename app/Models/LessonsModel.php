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
            ->leftjoin('tb_languages', 'tb_lesson.lang', '=', 'tb_languages.language_id');
            
            if(isset(session("permission")->limited)) {
                $lessons = $lessons
                ->where("tb_lesson.idCreator", auth()->user()->id);
            } else {
                if(auth()->user()->type < 2) {
                    $lessons = $lessons
                    ->whereIn("tb_lesson.idCreator", User::get_members());
                } else {
                    $lessons = $lessons
                    ->where("tb_lesson.idCreator", session("client"))
                    ->orWhere("tb_lesson.idCreator", auth()->user()->id);
                }
            }   
    
            $lessons = $lessons
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
            ->where(function($query){
                if(isset(session("permission")->limited)) {
                    return $query
                    ->where("tb_lesson.idCreator", auth()->user()->id);
                } else {
                    if(auth()->user()->type < 2) {
                        return $query
                        ->whereIn("tb_lesson.idCreator", User::get_members());
                    } else {
                        return $query
                        ->where("tb_lesson.idCreator", session("client"))
                        ->orWhere("tb_lesson.idCreator", auth()->user()->id);
                    }
                }   
            })
            ->first();
            if(isset($lesson)){
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
            } else {
                return [];
            }
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

    public function scopeGetLessonByClient($query) {
        $client = session("client");
        if(isset(session("permission")->limited)) {
            $lessons = $query->leftjoin("tb_users", 'tb_lesson.idCreator', "=", 'tb_users.id')
                ->where("tb_lesson.idCreator", auth()->user()->id)
                ->orWhere('tb_users.id_creator', auth()->user()->id)
                ->get();
        } else {
            if(auth()->user()->type < 2) {
                $lessons = $query->leftjoin("tb_users", 'tb_lesson.idCreator', "=", 'tb_users.id')
                    ->whereIn("tb_lesson.idCreator", User::get_members())
                    ->orWhere('tb_users.id_creator', $client)
                    ->get();
            } else {
                $lessons = $query->leftjoin("tb_users", 'tb_lesson.idCreator', "=", 'tb_users.id')
                    ->where("tb_lesson.idCreator", $client)
                    ->orWhere('tb_users.id_creator', $client)
                    ->orWhere('tb_users.id_creator', auth()->user()->id)
                    ->orWhere('tb_lesson.idCreator', auth()->user()->id)
                    ->get();
            }
        }   
        return $lessons;
    }
}

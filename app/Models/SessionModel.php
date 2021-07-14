<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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
            'tb_session.*',
            'tb_languages.language_iso as language_iso'
            // 'tb_position.name as position',
            // 'tb_companies.name as companies'
        )
            ->leftjoin('tb_languages', 'tb_session.language_iso', '=', 'tb_languages.language_id')
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

    public function scopeGetContentDataFromSession($query, $content_data)
    {
        // $array = [];
        // if (isset($content_data) || $content_data != "{}") {
        //     $content = json_decode($content_data);
        //     if (isset($content)) {
        //         if (count($content) != 0) {
        //             foreach ($content as $contentItem) {
        //                 if (isset($contentItem)) {
        //                     $training = TrainingsModel::find($contentItem);
        //                     $training = $training != NULL ? $training->toArray() : $training;
        //                     array_push($array, $training);
        //                 }
        //             }
        //         }
        //     }
        // }
        // return $array;
        if (isset($content_data) || $content_data != "") {
            $training = TrainingsModel::where('id', $content_data)->get();
            if ($training->count() != 0) {
                return $training;
            } else {
                return null;
            }
        }
        return null;
    }
    public function scopeGetParticipantDataFromSession($query, $participant_data)
    {
        $groupData = array();
        $studentData = array();
        $teacherData = array();
        if (isset($participant_data) || $participant_data != "") {
            $participant = json_decode($participant_data);
            $groupList = isset($participant->g) ? $participant->g : array();
            $studentList = isset($participant->s) ? $participant->s : array();
            $teacherList = isset($participant->t) ? $participant->t : array();
            if (isset($groupList) || $groupList != "") {
                // var_dump($groupList);
                // var_dump($studentList);
                // var_dump($teacherList);
                if (count($groupList) != 0) {
                    foreach ($groupList as $groupValue) {
                        $groupSubData = array();
                        $groupTopData = NULL;
                        $groupSubData = User::getUserFromGroup($groupValue->value);
                        $groupTopData = GroupModel::find($groupValue->value);
                        $groupTopData = $groupTopData != NULL ? $groupTopData->toArray() : NULL;
                        array_push($groupData, array("value" => $groupTopData, "items" => $groupSubData));
                    }
                }
            }
            if (isset($studentList) || $studentList != "") {
                if (count($studentList) != 0) {
                    foreach ($studentList as $studentValue) {
                        // print_r($studentValue);
                        $studentItem = User::find($studentValue);
                        $studentItem = $studentItem != NULL ? $studentItem->toArray() : $studentItem;
                        array_push($studentData, $studentItem);
                    }
                }
            }
            if (isset($teacherList) || $teacherList != "") {
                if (count($teacherList) != 0) {
                    foreach ($teacherList as $teacherValue) {
                        // var_dump($teacherValue);
                        // exit;
                        $teacherItem = User::find($teacherValue);
                        $teacherItem = $teacherItem != NULL ? $teacherItem->toArray() : $teacherItem;
                        array_push($teacherData, $teacherItem);
                    }
                }
            }
        }
        // var_dump(array('group' => $groupData, 'student' => $studentData, 'teacher' => $teacherData));
        // exit;
        return array('group' => $groupData, 'student' => $studentData, 'teacher' => $teacherData);
    }

    public function scopeGetTrainingsForStudent($query, $id)
    {

                $user_id = Session::get('user_id');
        
        // $sessions = $query->where('content', $id)->get();
        $user = User::find($id);
        $sessionList = $query->get();
        $sessions = array();
        foreach ($sessionList as $sessionItem) {
            if ($sessionItem->participants != NULL) {
                $participant = json_decode($sessionItem->participants);
                // var_dump($participant);
                if ($user->type == 3) {
                    $teachers = $participant->t;
                    var_dump($teachers);
                    if ($teachers != NULL && count($teachers) != 0) {
                        foreach ($teachers as $teacher) {
                            if ($teacher == $id) {
                                array_push($sessions, $sessionItem);
                            }
                        }
                    }
                } else if ($user->type == 4) {
                    $students = $participant->s;
                    $groups = $participant->g;
                    // var_dump($students);
                    // var_dump($groups);
                    if ($students != NULL && count($students) != 0) {
                        foreach ($students as $student) {
                            if ($student == $id) {
                                array_push($sessions, $sessionItem);
                            }
                        }
                    }
                    if ($groups != NULL && count($groups) != 0) {
                        foreach ($groups as $group) {
                            if (isset($group->value)) {
                                $users = User::getUserIDFromGroup($group->value);
                                if ($users != NULL && $users->count() != 0) {
                                    foreach ($user as $userItem) {
                                        if ($userItem == $id) {
                                            array_push($sessions, $sessionItem);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $sessions = array_unique($sessions);
        $trainings = array();
        $temp_trainings = array();
        foreach ($sessions as $session) {
            DB::connection('mysql_reports')->unprepared('CREATE TABLE IF NOT EXISTS `tb_screen_optim_'.$session->id.'` (
            `id_screen_optim` int(11) NOT NULL,
            `id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `id_curso_screen_optim` int(11) NOT NULL,
            `id_user_screen_optim` int(11) NOT NULL,
            `progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,
            `progress_screen_optim` float(5,2) NOT NULL,
            `last_date_screen_optim` datetime NOT NULL,
            `first_eval_id_screen_optim` int(11) NOT NULL,
            `last_eval_id_screen_optim` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ');
            if ($session->contents != NULL && $session->contents != '') {
                $new_training = TrainingsModel::find(intval($session->contents));
                if($new_training->lesson_content!=NULL&&$new_training->lesson_content!=''&&$new_training->lesson_content!='[]'){
                    $lessonList = json_decode($new_training->lesson_content, true);
                    if ($lessonList != NULL) {
                        foreach ($lessonList as $value) {
                            $repeat = false;
                            if (LessonsModel::find($value['item'])) {
                                $lesson = LessonsModel::find($value['item']);
                                if($lesson->status==5){
                                    foreach ($temp_trainings as $training_item) {
//                                         print_r($training_item);
//                                         print_r($new_triaining);

                                        if($training_item==$new_training){
                                            $repeat=true;
                                        }
                                        // if($training_item['training']!=$new_training)
                                    }
                                   
                                    array_push($temp_trainings, $new_training);
                                    if(!$repeat){
                                        $score_data = DB::connection('mysql_reports')->select('select AVG(progress_screen_optim) as progress_screen_optim, AVG(last_eval_id_screen_optim) as last_eval_id_screen_optim from tb_screen_optim_'.$session->id.' where  id_user_screen_optim="'.$user_id.'"');
                                        $progress = $score_data[0]->progress_screen_optim?$score_data[0]->progress_screen_optim:0;
                                        $eval = $score_data[0]->last_eval_id_screen_optim?$score_data[0]->last_eval_id_screen_optim:0;
                                        array_push($trainings, ["training"=>$new_training->toArray(), "session_id"=>$session->id, "progress"=>$progress, "eval"=>$eval]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // $trainings = array_unique($trainings);
//         print_r($trainings);exit;
        return $trainings;
    }
}

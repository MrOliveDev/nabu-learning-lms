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
        'creator_id'
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

        $client = session("client");

        $result = $query->select(
            'tb_session.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_session.language_iso', 'tb_languages.language_id')
            ->where("tb_session.id_creator", $client)
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
            $training = TrainingsModel::where('id', $content_data)->where("id_creator", session("client"))->get();
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
        $user = User::find($id);
        $sessionList = $query->get();
        $sessions = array();
        foreach ($sessionList as $sessionItem) {
            if ($sessionItem->participants != NULL) {
                $participant = json_decode($sessionItem->participants);
                // var_dump($participant);
                if ($user->type == 3) {
                    $teachers = $participant->t;
                    // var_dump($teachers);
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
                `id_screen_optim` int(11) NOT NULL AUTO_INCREMENT,
                `id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
                `id_curso_screen_optim` int(11) NOT NULL,
                `id_user_screen_optim` int(11) NOT NULL,
                `progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,
                `progress_screen_optim` float(5,2) NOT NULL,
                `last_date_screen_optim` datetime NOT NULL,
                `first_eval_id_screen_optim` int(11) NOT NULL,
                `last_eval_id_screen_optim` int(11) NOT NULL,
                PRIMARY KEY (id_screen_optim) 
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
                                        $score_data = DB::connection('mysql_reports')->select('select AVG(progress_screen_optim) as progress_screen_optim, AVG(last_eval_id_screen_optim) as last_eval_id_screen_optim from tb_screen_optim_'.$session->id.' where  id_user_screen_optim="'.session("user_id").'"');
                                        $progress = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->progress_screen_optim?$score_data[0]->progress_screen_optim:0));
                                        $eval = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->last_eval_id_screen_optim?$score_data[0]->last_eval_id_screen_optim:0));
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

    public function scopeGetParticipantListFromSessionForDash($query, $participant_data, $session_id)
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
                        $groupUserData = array();
                        $groupTopData = NULL;
                        $groupSubData = User::getUserFromGroup($groupValue->value);
                        if(isset($groupSubData)) {
                            foreach ($groupSubData as $std => $student) {
                                $score_data = DB::connection('mysql_reports')->select('select AVG(progress_screen_optim) as progress_screen_optim, AVG(last_eval_id_screen_optim) as last_eval_id_screen_optim from tb_screen_optim_'.$session_id.' where  id_user_screen_optim="'.$student['id'].'"');
                                $progress = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->progress_screen_optim?$score_data[0]->progress_screen_optim:0));
                                $eval = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->last_eval_id_screen_optim?$score_data[0]->last_eval_id_screen_optim:0));
                                $student["progress"] = $progress ;
                                $student["eval"] = $eval ;
                                array_push($groupUserData, $student);
                            }
                        }
                        $groupTopData = GroupModel::find($groupValue->value);
                        $groupTopData = $groupTopData != NULL ? $groupTopData->toArray() : NULL;
                        array_push($groupData, array("value" => $groupTopData, "items" => $groupUserData));
                    }
                }
            }
            if (isset($studentList) || $studentList != "") {
                if (count($studentList) != 0) {
                    foreach ($studentList as $studentValue) {
                        $studentItem = User::find($studentValue);
                        if($studentItem != NULL) {
                            $studentItem =  $studentItem->toArray();
                            $score_data = DB::connection('mysql_reports')->select('select AVG(progress_screen_optim) as progress_screen_optim, AVG(last_eval_id_screen_optim) as last_eval_id_screen_optim from tb_screen_optim_'.$session_id.' where  id_user_screen_optim="'.$studentItem["id"].'"');
                            $progress = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->progress_screen_optim?$score_data[0]->progress_screen_optim:0));
                            $eval = $score_data==NULL?0:(count($score_data)==0?0:($score_data[0]->last_eval_id_screen_optim?$score_data[0]->last_eval_id_screen_optim:0));
                            $studentItem["progress"] = $progress ;
                            $studentItem["eval"] = $eval ;
                            array_push($studentData, $studentItem);
                        }
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

    public function scopeGetStudentsFromSession($query, $participant_data)
    {
        $studentData = array();
        if (isset($participant_data) || $participant_data != "") {
            $participant = json_decode($participant_data);
            $studentList = isset($participant->s) ? $participant->s : array();

            if (isset($studentList) || $studentList != "") {
                if (count($studentList) != 0) {
                    foreach ($studentList as $studentValue) {
                        // print_r($studentValue);
                        $studentItem = User::find($studentValue);
                        if($studentItem)
                            array_push($studentData, $studentItem->toArray());
                    }
                }
            }

        }
        return $studentData;
    }

    public function scopeGetSessionFromUser($query, $user_id){
        $sessions = SessionModel::all();
        $result = array();
        foreach ($sessions as $session) {
            $participant_data = $session->participants;
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
                            $groupSubData = User::getUserFromGroup($groupValue->value);
                            if(isset($groupSubData))
                            if(in_array($user_id, $groupSubData))
                            array_push($result, $session);
                        }
                    }
                }
                if (isset($studentList) || $studentList != "") {
                    if (count($studentList) != 0) {
                        foreach ($studentList as $studentValue) {
                            // print_r($studentValue);
                            $studentItem = User::find($studentValue);
                            if($studentItem != NULL && $studentItem->id == $user_id) {
                                array_push($result, $session);
                            }
                        }
                    }
                }
                if (isset($teacherList) || $teacherList != "") {
                    if (count($teacherList) != 0) {
                        foreach ($teacherList as $teacherValue) {
                            // var_dump($teacherValue);
                            // exit;
                            $teacherItem = User::find($teacherValue);
                           if($teacherItem != NULL && $teacherItem->id == $user_id)
                            if(in_array($user_id, $teacherItem))
                            array_push($result, $session);
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function scopeGetTeachersFromSession($query, $session_id) {
        $teacherData = array();
        if (isset($participant_data) || $participant_data != "") {
            $participant = json_decode($participant_data);
            $teacherList = isset($participant->t) ? $participant->t : array();

            if (isset($teacherList) || $teacherList != "") {
                if (count($teacherList) != 0) {
                    foreach ($teacherList as $teacherValue) {
                        // print_r($studentValue);
                        $studentItem = User::find($teacherValue);
                        if($studentItem)
                            array_push($teacherData, $studentItem->toArray());
                    }
                }
            }

        }
        return $teacherData;
    }

    public function scopeGetStudentFromOwnedTeacher($query, $teacher_id) {
        $sessions = SessionModel::getSessionFromUser($teacher_id);
        $result = array();
        foreach ($sessions as $session) {
            array_push($result, ...SessionModel::getStudentsFromSession($session->participants));
        }
        return $result;
    }

    public function scopeGetUserFromSessionByType($query, $type) {
        $sessions = SessionModel::getSessionFromUser($teacher_id);
        $result = array();
        foreach($sessions as $session) {
            if($type==4){
                array_push($result, ...SessionModel::getStudentsFromSession($session->participants));
            } else {
                array_push($result, ...SessionModel::getTeachersFromSession($session->participants));
            }
        }
        return $result;
    }
}

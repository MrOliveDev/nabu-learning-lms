<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\SessionModel;


/**
 * Model that concentrated with session table
 */
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
        'max_attempts_eval',
        'consider_eval',
        'creator_id'
    ];

    protected $table = 'tb_session';

    public $timestamps = false;

    /**
     * get detailed session info by session id
     * @param int $id: session id
     * @return model item
     */
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

    /**
     * get the whole session info for session manage page.
     */
    public function scopeGetSessionPageInfo($query)
    {

        $client = session("client");

        $result = $query->select(
            'tb_session.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_session.language_iso', 'tb_languages.language_id');
            if(isset(session("permission")->limited)) {
                $result = $result
                ->where("tb_session.id_creator", auth()->user()->id);
            } else {
                if(auth()->user()->type < 2) {
                    $result = $result
                    ->whereIn("tb_session.id_creator", User::get_members());
                } else {
                    $result = $result
                    ->where("tb_session.id_creator", session("client"))
                    ->orWhere("tb_session.id_creator", auth()->user()->id);
                }
            }   
            $result = $result
            ->get();
        return $result;
    }

    /**
     * get training data for session item
     * @param encoded_json $content_data: training info that contained to session
     */
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
            $training = TrainingsModel::where('id', $content_data);
            if(isset(session("permission")->limited)) {
                $training = $training
                ->where("id_creator", auth()->user()->id)->get();
            } else {
                if(auth()->user()->type < 2) {
                    $training = $training
                    ->whereIn("id_creator", User::get_members())->get();
                } else {
                    $training = $training
                    ->where("id_creator", session("client"))
                    ->where("id_creator", auth()->user()->id)->get();
                }
            }   

            if ($training->count() != 0) {
                return $training;
            } else {
                return null;
            }
        }
        return null;
    }

    /**
     * get participant data from session
     * @param encoded_json $participant_data 
     * @return array list 
     */
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

    /**
     * get the session info that contains the student.
     * @param int $id:student id
     * @return training array list
     */
    public function scopeGetTrainingsForStudent($query, $id)
    {
        // $user = User::find($id);
        // $sessionList = $query->get();
        // $sessions = array();
        // foreach ($sessionList as $sessionItem) {
        //     if ($sessionItem->participants != NULL) {
        //         $participant = json_decode($sessionItem->participants);
        //         // var_dump($participant);
        //         if ($user->type == 3) {
        //             $teachers = $participant->t;
        //             // var_dump($teachers);
        //             if ($teachers != NULL && count($teachers) != 0) {
        //                 foreach ($teachers as $teacher) {
        //                     if ($teacher == $id) {
        //                         array_push($sessions, $sessionItem);
        //                     }
        //                 }
        //             }
        //         } else if ($user->type == 4) {
        //             $students = $participant->s;
        //             $groups = $participant->g;
        //             // var_dump($students);
        //             // var_dump($groups);
        //             if ($students != NULL && count($students) != 0) {
        //                 foreach ($students as $student) {
        //                     if ($student == $id) {
        //                         array_push($sessions, $sessionItem);
        //                     }
        //                 }
        //             }
        //             if ($groups != NULL && count($groups) != 0) {
        //                 foreach ($groups as $group) {
        //                     if (isset($group->value)) {
        //                         $users = User::getUserIDFromGroup($group->value);
        //                         if ($users != NULL && $users->count() != 0) {
        //                             foreach ($user as $userItem) {
        //                                 if ($userItem == $id) {
        //                                     array_push($sessions, $sessionItem);
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        $sessions = array_unique($this->getSessionFromUser($id));
        $trainings = array();
        $temp_trainings = array();
        $user_id = Session::get('user_id');
        // print_r(array_unique($this->getSessionFromUser($id))); exit;
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
                `best_eval_id_screen_optim` int(11) NOT NULL,
                PRIMARY KEY (id_screen_optim) 
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                ');  
            DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_".$session->id."` ("
                . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                . "`date_start` datetime DEFAULT NULL,"
                . "`date_end` datetime DEFAULT NULL,"
                . "`is_presential` int(1) DEFAULT '0',"
                . "`user_keypad` int(11) DEFAULT '0',"
                . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                . "`date_hour` datetime DEFAULT '00-00-0000 00:00:00',"
                . "`number_eval` int(11) DEFAULT NULL,"
                . "`progression` int(11) NOT NULL DEFAULT '0',"
                . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
                . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                . "`id_creator` int(11) NOT NULL DEFAULT '1',"
                . "PRIMARY KEY (id) "
                . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
                );  
                
            if ($session->contents != NULL && $session->contents != '') {
                // print_r('here');
                // print_r(intval($session->contents)); exit;
                $count = 0;
                $eval_count = 0;
                $eval = 0;
                $status = 0;
                $progress_screen_optim = 0;
                $new_training = TrainingsModel::find(intval($session->contents));
                if($new_training->lesson_content!=NULL&&$new_training->lesson_content!=''&&$new_training->lesson_content!='[]'){
                    $lessonList = json_decode($new_training->lesson_content, true);
                    if ($lessonList != NULL) {
                        foreach ($lessonList as $value) {
                            if (LessonsModel::find($value['item'])) {
                                $count = $count + 1;
                                $lesson = LessonsModel::find($value['item']);
                                if($lesson->status==5){
                                    $score_data = DB::connection('mysql_reports')->select('select progress_screen_optim from tb_screen_optim_'.$session->id.' where id_fabrique_screen_optim="'.$lesson->idFabrica.'" and id_user_screen_optim="'.$user_id.'"');
                                    if($score_data) {
                                        $progress_screen_optim += $score_data[0]->progress_screen_optim;
                                    }
                                    // $score_data2 = DB::connection('mysql_historic')->select('select * from tb_evaluation_'.$session->id.' where id_lesson="'.$lesson->idFabrica.'" and user_id="'.$user_id.'"');
                                    if($session->consider_eval == 1) {
                                        $score_data2 = DB::connection('mysql_historic')->select('select * from tb_evaluation_'.$session->id.' where id="'.$score_data[0]->best_eval_id_screen_optim.'"');
                                    } else if ($session->consider_eval == 2) {
                                        $score_data2 = DB::connection('mysql_historic')->select('select * from tb_evaluation_'.$session->id.' where id="'.$score_data[0]->first_eval_id_screen_optim.'"');
                                    } else if ($session->consider_eval == 3) {
                                        $score_data2 = DB::connection('mysql_historic')->select('select * from tb_evaluation_'.$session->id.' where id="'.$score_data[0]->last_eval_id_screen_optim.'"');
                                    }
                                    if($score_data2) {
                                        $eval_count = $eval_count + 1;
                                        // $eval = $score_data2==NULL?0:(count($score_data2)==0?0:($score_data2[0]->note?$score_data2[0]->note:0));
                                        $eval += $score_data2[0]->note;
                                        $threshold_score = $lesson->threshold_score;
                                        if($threshold_score == $score_data2[0]->note || $threshold_score < $score_data2[0]->note){
                                            $status = $status + 1;
                                        }
                                    }
                                    }
                                }
                            }
                        }
                        if($eval_count != 0){
                        $eval = $eval / $eval_count; 
                        } else {
                            $success = "";
                        }
                        if($eval != 0){
                        if($status == $eval_count) {
                            $success = "true";
                        } else if($status == 0) {
                            $success = "false";
                        } else {
                            $success = "NULL";
                        }
                    } else {
                        $success = "";
                    }
                        $progress = $progress_screen_optim / $count;
                        $teacherInfo = array();
                        if ($session->participants != NULL && $session->participants != '') {
                            $participant = json_decode($session->participants);
                            $teacher = $participant->t;
                            $contact_info = null;
                            if($teacher){
                            $contact_info = User::find($teacher[0])->contact_info;
                            $first_name = User::find($teacher[0])->first_name;
                            $last_name = User::find($teacher[0])->last_name;
                            $teacherInfo = ["contact_info"=>json_decode($contact_info), "first_name"=>$first_name, "last_name"=>$last_name];
                            }
                        }
                        $reports = DB::connection('mysql_reports')->select('select * from tb_reports where sessionId="'.$session->id.'" and studentId="'.$user_id.'"');
                        $training_pdf = array();
                        foreach ($reports as $report) {
                            array_push($training_pdf, ["model"=>$report->model, "filename"=>$report->filename, "date"=>$report->created_time]);
                        }
                        array_push($trainings, ["training"=>$new_training->toArray(), "session_id"=>$session->id, "progress"=>$progress, "eval"=>$eval, "success"=>$success, "session_endDate"=>$session->end_date ,"teacher"=>$teacherInfo, "training_pdf"=>$training_pdf, "session_consider"=>$session->consider_eval]);
                    }
                }
            }
        return $trainings;
    }

    /**
     * get participant list from session item for admindash page.
     * @param encoded_json $participant_data
     * @param int $session_id
     * @return item_list
     */
    public function scopeGetParticipantListFromSessionForDash($query, $participant_data, $session_id)
    {
        DB::connection('mysql_reports')->unprepared('CREATE TABLE IF NOT EXISTS `tb_screen_optim_'.$session_id.'` (
            `id_screen_optim` int(11) NOT NULL AUTO_INCREMENT,
            `id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `id_curso_screen_optim` int(11) NOT NULL,
            `id_user_screen_optim` int(11) NOT NULL,
            `progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,
            `progress_screen_optim` float(5,2) NOT NULL,
            `last_date_screen_optim` datetime NOT NULL,
            `first_eval_id_screen_optim` int(11) NOT NULL,
            `last_eval_id_screen_optim` int(11) NOT NULL,
            `best_eval_id_screen_optim` int(11) NOT NULL,
            PRIMARY KEY (id_screen_optim) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ');   
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

    /**
     * get students from session 
     * @param encoded_json $participant_data
     * @return item list
     */
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
                            array_push($studentData, $studentItem);
                    }
                }
            }

        }
        return $studentData;
    }

    /**
     * get session from user id
     * @param int $user_id
     * @return session item list
     */
    public function getSessionFromUser($user_id){
        $sessions = $this->getSessionByClient();
        $result = array();
        if(isset($sessions))
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
                            $groupSubData = User::getUserFromGroup(intval($groupValue->value));
                            foreach($groupSubData as $groupSubItem){
                                if($groupSubItem['id']==$user_id){
                                    array_push($result, $session);
                                }
                            }
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
                            if($studentItem != null && strval($studentItem->id) == $user_id) {
                                array_push($result, $session);
                            }
                        }
                    }
                }
                if (isset($teacherList) || $teacherList != "") {
                    if (count($teacherList) != 0) {
                        foreach ($teacherList as $teacherValue) {
                            // exit;
                            // var_dump($user_id);
                            $teacherItem = User::find($teacherValue);
                            if($teacherItem != null && strval($teacherItem->id) == $user_id){
                                if(in_array($user_id, $teacherItem->toArray())) {
                                    array_push($result, $session);
                                }
                            }
                        }
                    }
                }
            }
        }
        // var_dump($result);
        // exit;
        $result = array_unique($result);
        return $result;
    }

    /**
     * get teacher data from session
     * @param int $session_id
     * @return teacher array list
     */
    public function scopeGetTeachersFromSession($query, $session_id) {
        $participant_data = SessionModel::find("session_id")!=null?SessionModel::find('session_id')->participants:null;
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

    /**
     * get student from teacher who is joined same session.
     * @param int $teacher_id
     */
    public function scopeGetStudentFromOwnedTeacher($query, $teacher_id) {
        $sessions = $this->getSessionFromUser($teacher_id);
        $result = array();
        foreach ($sessions as $session) {
            array_push($result, ...SessionModel::getStudentsFromSession($session->participants));
        }
        return $result;
    }

    /**
     * get user from session by user type
     * @param int $type
     * @return item list
     */
    public function scopeGetUserFromSessionByType($query, $type) {
        if(isset(session("permission")->limited)) {
            $sessions = SessionModel::where("id_creator", auth()->user()->id)->get();
        } else {
            if(auth()->user()->type < 2) {
                $sessions = SessionModel::whereIn("id_creator", User::get_members())->get();
            } else {
                $sessions = SessionModel::where("id_creator", session("client"))
                ->orWhere("id_creator", auth()->user()->id)->get();
            }
        }

        $result = array();
        foreach($sessions as $session) {
            if($type==4){
                $studentInSession = SessionModel::getStudentsFromSession($session->participants);
                foreach ($studentInSession as $studentSession) {
                    if(!in_array($studentSession, $result)){
                        array_push($result, $studentSession);
                    }
                }
                //students:created by teacher
                $students = User::where("type", $type);
                if(isset(session("permission")->limited)) {
                    $students = $students
                    ->where("id_creator", session("user_id"))->get();
                } else {
                    if(auth()->user()->type < 2) {
                        $students = $students
                        ->whereIn("id_creator", User::get_members())->get();
                    } else {
                        $students = $students
                        ->where("id_creator", session("client"))
                        ->where("id_creator", session("user_id"))->get();
                    }
                }   
                foreach ($students as $student) {
                    if(!in_array($student, $result)){
                        array_push($result, $student);
                    }
                }
            } else {
                $teachers = SessionModel::getTeachersFromSession($session->participants);
                foreach($teachers as $teacher){
                    if(!in_array($teacher, $result)){
                        array_push($result, $teacher);
                    }
                }
            }
        }
        // foreach($result as $r){
        //     var_dump($r->id);
        // }
        // exit;
        return $result;
    }

    public function getSessionByClient() {
        if(isset(session("permission")->limited)) {
            $session = $this
            ->where('id_creator', auth()->user()->id)->get();
        } else {
            if(auth()->user()->type < 2) {
                $session = $this
                ->whereIn('id_creator', User::get_members())->get();
            } else if (auth()->user()->type == 4){
                $sessionList = $this->all();
                $sessions = [];
                foreach($sessionList as $sessionItem) {
                    $participants = json_decode($sessionItem->participants, true);
                    
                    if($participants != NULL) {
                        foreach ($participants['s'] as $participant){
                            if($participant == auth()->user()->id){
                                if (!in_array($sessionItem, $sessions)) {
                                    array_push($sessions, $sessionItem);
                                }
                            }
                        }
                        foreach ($participants['g'] as $participant){
                            $users = User::getUserFromGroup($participant);
                            foreach($users as $user){
                                if($user['id'] == auth()->user()->id){
                                    if (!in_array($sessionItem, $sessions)) {
                                        array_push($sessions, $sessionItem);
                                    }
                                }
                            }
                        }
                    }
                }
                return $sessions;
            } else { 
                $session = $this
                ->where('id_creator', session("client"))
                ->orWhere('id_creator', auth()->user()->id)->get();
                return $session;
            }
        }   
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GroupModel;
use App\Models\PositionModel;
use App\Models\CompanyModel;
use App\Models\LanguageModel;
use App\Models\SessionModel;
use App\Models\TrainingsModel;
use App\Models\LessonsModel;
use App\Models\LessonCourses;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session("user_type") == 3){
            $students = SessionModel::getUserFromSessionByType(4);
            $teachers = SessionModel::getUserFromSessionByType(3);
        } else {
            $students = User::getUserPageInfo(4);
            $teachers = User::getUserPageInfo(3);
        }

        $groups = GroupModel::getGroupByClient();
        $trainings = TrainingsModel::getTrainingByClient();
        $companies = CompanyModel::getCompanyByClient();
        $sessions = SessionModel::getSessionPageInfo();
        $positions = PositionModel::getPositionByClient();
        $languages = LanguageModel::all();
        return view('session', compact([/* 'authors',  */'teachers', 'students', 'groups', 'positions', 'companies', 'languages', 'sessions', 'trainings']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session = new SessionModel();
        if ($request->post("name") != NULL) {
            $session->name = $request->post('name');
        }
        if ($request->post("description") != NULL) {
            $session->description = $request->post('description');
        }
        if ($request->post("session_name") != NULL) {
            $session->name = $request->post('session_name');
        }
        if ($request->post("session_description") != NULL) {
            $session->description = $request->post('session_description');
        }
        if ($request->post("session-status-icon") != NULL) {
            $session->status = $request->post('session-status-icon');
        }
        if ($request->post("begin_date") != NULL) {
            $session->begin_date = $request->post('begin_date');
        }
        if ($request->post("end_date") != NULL) {
            $session->end_date = $request->post('end_date');
        }
        if ($request->post("language") != NULL) {
            $session->language_iso = $request->post('language');
        }
        if ($request->post("attempts") != NULL) {
            $session->max_attempts_eval = $request->post('attempts');
        }
        $session->id_creator = session("client");
        // if(){

        // }
        $session->save();
        return response()->json(SessionModel::getSessionPageInfoFromId($session->id)->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SessionModel  $sessionModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $session = SessionModel::find($id);
        $participant = SessionModel::getParticipantDataFromSession($session->participants);
        $contentData = SessionModel::getContentDataFromSession($session->contents);
        // dd(array('contents'=>$content, 'participants'=>$participant, "session_info"=>$session->toArray()));
        // dd(User::getUserIDFromGroup(2));
        if ($contentData == null) {
            // print_r('abc');
            // exit;
            return;
        }
        return response()->json(['contents' => $contentData, 'participants' => $participant, "session_info" => $session->toArray()]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SessionModel  $sessionModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $session = SessionModel::find($id);
        if ($request->post("name") != NULL) {
            $session->name = $request->post('name');
        }
        if ($request->post("description") != NULL) {
            $session->description = $request->post('description');
        }
        if ($request->post("session_name") != NULL) {
            $session->name = $request->post('session_name');
        }
        if ($request->post("session_description") != NULL) {
            $session->description = $request->post('session_description');
        }
        if ($request->post("session-status-icon") != NULL) {
            $session->status = $request->post('session-status-icon');
        }
        if ($request->post("begin_date") != NULL) {
            $session->begin_date = $request->post('begin_date');
        }
        if ($request->post("end_date") != NULL) {
            $session->end_date = $request->post('end_date');
        }
        if ($request->post("language") != NULL) {
            $session->language_iso = $request->post('language');
        }
        if ($request->post("attempts") != NULL) {
            $session->max_attempts_eval = $request->post('attempts');
        }
        $session->id_creator = session("client");
        if (session("user_type") !== 0) {
            $session->id_creator = session("user_id");
        } else {
            $session->id_creator = session("client");
        }
        $session->update();
        return response()->json(SessionModel::getSessionPageInfoFromId($session->id)->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SessionModel  $sessionModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session = SessionModel::find($id);
        $session->delete();
        DB::connection('mysql_reports')->unprepared('DROP TABLE IF EXISTS `tb_screen_optim_'.$id.'`');
        DB::connection('mysql_reports')->unprepared('DROP TABLE IF EXISTS `tb_lesson_course_'.$id.'`');
        DB::connection('mysql_historic')->unprepared('DROP TABLE IF EXISTS `tb_evaluation_'.$id.'`');
        DB::connection('mysql_historic')->unprepared('DROP TABLE IF EXISTS `tb_evaluation_question_'.$id.'`');
        DB::connection('mysql_historic')->unprepared('DROP TABLE IF EXISTS `tb_screen_stats_'.$id.'`');

        return response()->json(["success" => true]);
    }

    /**
     * Join session to participant(user | group) | content(training)
     * 
     * @param Request $request
     * @return Response Json data | false(fail)
     */
    public function sessionJoinTo(Request $request)
    {
        $participantData = $request->post("participant");
        $contentData = $request->post("content");
        $id = $request->post("id");
        $cate = $request->post("cate");
        $session = SessionModel::find($id);

        DB::connection('mysql_reports')->unprepared('CREATE TABLE IF NOT EXISTS `tb_lesson_course_'.$id.'` (
            `id` int(11) NOT NULL,
            `curso_id` int(11) NOT NULL,
            `course_id` int(11) NOT NULL,
            `product_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `profile` int(11) NOT NULL,
            `lang` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT "30",
            `module_structure` text COLLATE utf8_unicode_ci NOT NULL,
            `screens_total` int(11) NOT NULL,
            `screens_titles` text COLLATE utf8_unicode_ci NOT NULL,
            `xml_src` text COLLATE utf8_unicode_ci NOT NULL,
            `creation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ');
        DB::connection('mysql_reports')->delete("DELETE FROM `tb_lesson_course_".$id."`");
        $training = TrainingsModel::find($contentData);
        if($contentData){
        if($training-> lesson_content) {
            $lessonList = json_decode($training->lesson_content, true);
            if($lessonList != NULL) {
                foreach($lessonList as $value) {
                    if(LessonCourses::getLessonCourseByCourseId($value['item']) != "") {
                        $lesson_course = LessonCourses::getLessonCourseByCourseId($value['item']);
                        DB::connection('mysql_reports')->unprepared("INSERT INTO `tb_lesson_course_".$id."` (`id`,`curso_id`, `course_id`, `product_id`, `profile`, `lang`, `module_structure`, `screens_total`, `screens_titles`, `xml_src`, `creation_date`) VALUES(".$lesson_course['id'].",".$lesson_course['curso_id'].",".$lesson_course['course_id'].",'".$lesson_course['product_id']."',".$lesson_course['profile'].",'".$lesson_course['lang']."','".$lesson_course['module_structure']."',".$lesson_course['screens_total'].",'".$lesson_course['screens_titles']."','".$lesson_course['xml_src']."','".$lesson_course['creation_date']."')"
                        );
                        }
                    }
                }
            }
        }
        if ($session != NULL) {
            if ($cate == 'participant') {
                if ($participantData != NULL) {
                    $session->participants = $participantData;
                    $session->update();
                    return response()->json(["success" => true]);
                }
            } else if ($cate == 'content') {
                if ($contentData != NULL) {
                    $session->contents = $contentData;
                    $session->update();
                    return response()->json(["success" => true]);
                } else {
                    $session->contents = "";
                    $session->update();
                    return response()->json(["success" => true]);
                }
            }
        }
        return false;
    }
}

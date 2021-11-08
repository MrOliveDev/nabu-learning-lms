<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InterfaceCfgModel;
use App\Models\LessonsModel;
use App\Models\TranslateModel;
use App\Models\SessionModel;
use Illuminate\Support\Facades\Session;
use App\Models\TrainingsModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

$environment = App::environment();
class DashController extends Controller
{

    public function __construct()
    {
        // InterfaceCfgModel::where('tag_name', '=', '')
        $this->sidebarData = TranslateModel::where('page_category_id', 'sidebar');
    }
    public function index()
    {

        $user_name = auth()->user()->login;
        $user_id = auth()->user()->id;
        // var_dump($id);exit;
        $sidebardata = $this->sidebarData;
        $trainings = SessionModel::getTrainingsForStudent($user_id);
        // $training = TrainingsModel::getTrainingForTrainingpage($trainings[0]->id);
        $lessons = [];
        // if ($training->lesson_content) {
        //     $lessonList = json_decode($training->lesson_content, true);
        //     if ($lessonList != NULL) {
        //         foreach ($lessonList as $value) {
        //             if (LessonsModel::find($value['item'])) {
        //                 if (!in_array(LessonsModel::getLessonContainedTraining($value['item']), $lessons)) {
        //                     array_push($lessons, LessonsModel::getLessonContainedTraining($value['item']));
        //                 }
        //             }
        //         }
        //     }
        // }
        // $lessons = array_unique($lessons);
        // var_dump($lessons[0]['id']);

        // // var_dump($training);
        // exit;
        return view('commondash', compact('sidebardata', 'trainings', 'lessons'));
    }

    public function getLessonsForStudent($id, $session_id){
        // $sql = "";
        // $db = new PDO("mysql:host=localhost;dbname=lms", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        // $stmt = $db->prepare($sql);
        // $stmt->execute();
        // if ($stmt->errorCode() == 0) {
        //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //     return $row;
        // }
        $user_id = Session::get('user_id');
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
            PRIMARY KEY (id_screen_optim) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ');
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_{$session_id}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_start` datetime DEFAULT NULL,"
        . "`date_end` datetime DEFAULT NULL,"
        . "`is_presential` int(1) DEFAULT '0',"
        . "`user_keypad` int(11) DEFAULT '0',"
        . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
        . "`number_eval` int(11) DEFAULT NULL,"
        . "`progression` int(11) NOT NULL DEFAULT '0',"
        . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
        . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_creator` int(11) NOT NULL DEFAULT '1',"
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
            // var_dump($data);exit;
            $training = TrainingsModel::getTrainingForTrainingpage($id);
            $lessons = [];
            if ($training->lesson_content) {
                $lessonList = json_decode($training->lesson_content, true);
            if ($lessonList != NULL) {
                foreach ($lessonList as $value) {
                    if (LessonsModel::find($value['item'])) {
                        if (!in_array(LessonsModel::getLessonContainedTraining($value['item']), $lessons)) {
                            $score_data = DB::connection('mysql_reports')->select('select * from tb_screen_optim_'.$session_id.' where id_fabrique_screen_optim="'.LessonsModel::getLessonContainedTraining($value['item'])["idFabrica"].'" and id_user_screen_optim="'.$user_id.'"');
                            $score_data2 = DB::connection('mysql_historic')->select('select * from tb_evaluation_'.$session_id.' where id_lesson="'.LessonsModel::getLessonContainedTraining($value['item'])["idFabrica"].'" and user_id="'.$user_id.'"');
                            if($score_data && $score_data2){
                                array_push($lessons, ["lesson"=>LessonsModel::getLessonContainedTraining($value['item']), "progress"=>$score_data[0]->progress_screen_optim?$score_data[0]->progress_screen_optim:0, "eval"=>$score_data2[0]->note?$score_data2[0]->note:0]);
                            } else {   
                                array_push($lessons, ["lesson"=>LessonsModel::getLessonContainedTraining($value['item']), "progress"=>0, "eval"=>0]);
                            }
                        }
                    }
                }
            }
        }
        return response()->json($lessons);
    }
}

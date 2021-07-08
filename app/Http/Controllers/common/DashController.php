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

class DashController extends Controller
{

    public function __construct()
    {
        // InterfaceCfgModel::where('tag_name', '=', '')
        $this->sidebarData = TranslateModel::where('page_category_id', 'sidebar');
    }
    public function index()
    {

        $user_name = Session::get('user_name');
        $user_id = Session::get('user_id');
        // var_dump($id);exit;
        $sidebardata = $this->sidebarData;
        $trainings = SessionModel::getTrainingsForStudent($user_id);
        $training = TrainingsModel::getTrainingForTrainingpage($trainings[0]->id);
        $lessons = [];
        if ($training->lesson_content) {
            $lessonList = json_decode($training->lesson_content, true);
            if ($lessonList != NULL) {
                foreach ($lessonList as $value) {
                    if (LessonsModel::find($value['item'])) {
                        if (!in_array(LessonsModel::getLessonContainedTraining($value['item']), $lessons)) {
                            array_push($lessons, LessonsModel::getLessonContainedTraining($value['item']));
                        }
                    }
                }
            }
        }
        // $lessons = array_unique($lessons);
        // var_dump($lessons[0]['id']);

        // // var_dump($training);
        // exit;
        return view('commondash', compact('sidebardata', 'trainings', 'lessons'));
    }

    public function getLessonsForStudent($id){
        $training = TrainingsModel::getTrainingForTrainingpage($id);
        $lessons = [];
        if ($training->lesson_content) {
            $lessonList = json_decode($training->lesson_content, true);
            if ($lessonList != NULL) {
                foreach ($lessonList as $value) {
                    if (LessonsModel::find($value['item'])) {
                        if (!in_array(LessonsModel::getLessonContainedTraining($value['item']), $lessons)) {
                            array_push($lessons, LessonsModel::getLessonContainedTraining($value['item']));
                        }
                    }
                }
            }
        }
        return response()->json($lessons);
    }
}

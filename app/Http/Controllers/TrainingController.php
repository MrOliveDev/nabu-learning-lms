<?php

namespace App\Http\Controllers;

use App\Models\LessonsModel;
use Illuminate\Http\Request;
use App\Models\TrainingsModel;
use App\Models\LanguageModel;

define("PRODUCTS_FABRIQUE_PATH", "/home/sites/default/www/export_fabrique/products/");
define("PRODUCTS_ONLINE_PATH", "/home/sites/default/www/export_online/");

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = TrainingsModel::getAllTrainings();
        $lessons = LessonsModel::getLessonsContainedTraining();
        $languages = LanguageModel::all();
        return view('training')->with(compact('trainings', 'lessons', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $training = new TrainingsModel();
        if ($request->post('training_name') != NULL) {
            $training->name = $request->post('training_name');
        }
        if ($request->post('training_description') != NULL) {
            $training->description = $request->post('training_description');
        }
        if ($request->post('training_enddate') != NULL) {
            $training->date_end = $request->post('training_enddate');
        }
        if ($request->post('training_language') != NULL) {
            $training->lang = $request->post('training_language');
        }
        if ($request->post('training-status-icon') != NULL) {
            $training->status = $request->post('training-status-icon');
        }
        if ($request->post('training_type') != NULL) {
            $training->type = $request->post('training_type');
        }
        if ($request->post('base64_img_data') != NULL) {
            $training->training_icon = $request->post('base64_img_data');
        }
        if ($request->post('name') != NULL) {
            $training->name = $request->post('name');
        }
        if ($request->post('description') != NULL) {
            $training->description = $request->post('description');
        }
        if ($request->post('cate-status-icon') != NULL) {
            $training->status = $request->post('cate-status-icon');
        }
        $training->save();
        return response()->json(TrainingsModel::getTrainingForTrainingpage($training->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = TrainingsModel::find($id);

        return response()->json($training);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $training = TrainingsModel::find($id);
        if ($request->post('training_name')) {
            $training->name = $request->post('training_name');
        }
        if ($request->post('training_description')) {
            $training->description = $request->post('training_description');
        }
        if ($request->post('training_enddate')) {
            $training->date_end = $request->post('training_enddate');
        }
        if ($request->post('training_language')) {
            $training->lang = $request->post('training_language');
        }
        if ($request->post('training-status-icon')) {
            $training->status = $request->post('training-status-icon');
        }
        if ($request->post('training_type')) {
            $training->type = $request->post('training_type');
        }
        if ($request->post('base64_img_data')) {
            $training->training_icon = $request->post('base64_img_data');
        }
        if ($request->post('name')) {
            $training->name = $request->post('name');
        }
        if ($request->post('description')) {
            $training->description = $request->post('description');
        }
        if ($request->post('cate-status-icon') != NULL) {
            $training->status = $request->post('cate-status-icon');
        }
        $training->update();

        return response()->json($training);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = TrainingsModel::find($id);

        $training->delete();

        return response()->json($id);
        //
    }

    public function trainingLinkFromLesson(Request $request)
    {
        $training = TrainingsModel::find($request->post('id'));
        $training->lesson_content = $request->post('target');
        $training->update();
        return response()->json($training);
    }

    public function trainingUpdateType(Request $request)
    {
        $training = TrainingsModel::find($request->post('id'));
        $training->type = $request->post('type');
        $training->update();
        return response()->json($training);
    }

    public function getLessonFromTraining($id)
    {
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

        return json_encode([
            'isSuccess' => true,
            'data'  => $lessons
        ]);
    }

    private function getListCourses($list)
    {

        $courses_list = array();
        foreach ($list as $item) {
            $new_item               = $item;
            $new_item['fabrique']   = $this->courseCheckFolders($item['idFabrica'], "fabrique");
            $new_item['online']     = $this->courseCheckFolders($item['idFabrica'], "online");
            $new_item['routeId']    = $this->getRouteId($item['idFabrica']);

            $courses_list[]         = $new_item;
        }
        return $courses_list;
    }

    private function courseCheckFolders($product_id, $type)
    {
        $path       = $type == "fabrique" ? $type . '/products' : $type;
        $folder = "/home/sites/default/www/export_$path/$product_id/";
        $exist  = file_exists($folder);
        return $exist;
    }

    public function getRouteId($datas)
    {
        $languageModel = new LanguageModel;
        $paths = array("fabrique" => PRODUCTS_FABRIQUE_PATH, "online" => PRODUCTS_ONLINE_PATH);
        $fabrique = false;
        $online = false;
        $types = array();
        foreach ($paths as $key => $path) {

            $dir = $path . $datas['productid'] . '/courses/';
            $files = scandir($dir);
            $langs = array();
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $file_arr = explode('_', $file);
                    $iso = $file_arr[2];
                    $course = $file_arr[1];
                    $langs[] = array("id" => $languageModel->get_language_id($iso), "iso" => $iso, "course" => $course, "name" => $languageModel->get_language_name($iso));
                    if ($key == "fabrique") {
                        $fabrique = true;
                    }
                    if ($key == "online") {
                        $online = true;
                    }
                }
            }
            if (count($langs) > 0) {
                $types[] = $langs;
            }
        }
        $types["fabrique"]  = $fabrique;
        $types["online"]    = $online;
        return $types;
    }
}

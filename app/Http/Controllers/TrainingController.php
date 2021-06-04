<?php

namespace App\Http\Controllers;

use App\Models\LessonsModel;
use Illuminate\Http\Request;
use App\Models\TrainingsModel;
use App\Models\LanguageModel;

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
        $training = TrainingsModel::create([
            'name' => $request->post('training_name'),
            'description' => $request->post('training_description'),
            'date_begin' => $request->post('training_enddate'),
            'status' => $request->post('training'),
        ]);
        $training->lang = $request->post('training_language');
        $training->update();
        return response()->json($training);
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

        $training->name = $request->post('training_name');
        $training->description = $request->post('training_description');
        $training->date_begin = $request->post('training_enddate');
        $training->lang = $request->post('training_language');
        $training->status = $request->post('training_status');
        $training->lesson_content = $request->post('lesson_content');
        $training->type = $request->post('training_type');

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
        $training = TrainingsModel::find($request->post('lesson_content'));

        $training->lesson_content = $request->post('lesson_content');
    }

    public function getLessonFromTraining($id)
    {
        $training = TrainingsModel::find($id);
        $lessons = [];
        if ($training->lesson_content) {
            $lessonList = json_decode($training->lesson_content, true);
            foreach ($lessonList as $value) {
                if (LessonsModel::find($value['item'])) {
                    array_push($lessons, LessonsModel::getLessonContainedTraining($value['item']));
                }
            }
        }

        return json_encode ( [
            'isSuccess' => true,
            'data'  => $lessons
        ] );
    }


}

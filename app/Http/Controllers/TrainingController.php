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
        $trainings = TrainingsModel::all();
        $lessons = LessonsModel::all();
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
            'name'=>$request->post('name'),
            'description'=>$request->post('description'),
            'date_begin'=>$request->post('date_begin'),
            'date_end'=>$request->post('date_end'),
            'template'=>$request->post('template'),
            'lesson_content'=>$request->post('lesson_content'),
            'status'=>$request->post('status')
        ]);

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

        $training->name = $request->post('name');
        $training->description = $request->post('description');
        $training->date_begin = $request->post('date_begin');
        $training->date_end = $request->post('date_end');
        $training->template = $request->post('template');
        $training->status = $request->post('status');
        $training->lesson_content = $request->post('lesson_content');

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
        $training = TrainingsModel::find($request->post(''));
        
        $training->lesson_content = $request->post('');
    }
}

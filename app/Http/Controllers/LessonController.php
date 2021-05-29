<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonsModel;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = LessonsModel::all();

        return response()->json($lessons);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lesson = LessonsModel::create([
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'date_begin' => $request->post('date_begin'),
            'date_end' => $request->post('date_end'),
            'template' => $request->post('template')
        ]);

        return response()->json($lesson);
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
        $lesson = LessonsModel::find($id);

        return response()->json($lesson);
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
        $lesson = LessonsModel::find($id);

        $lesson->name = $request->post('name');
        $lesson->description = $request->post('description');
        $lesson->date_begin = $request->post('date_begin');
        $lesson->date_end = $request->post('date_end');
        $lesson->template_player_id = $request->post('template_player_id');
        $lesson->status = $request->post('status');
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
        $lesson = LessonsModel::find($id);

        $lesson->delete();

        return response()->json($id);
        //
    }
}

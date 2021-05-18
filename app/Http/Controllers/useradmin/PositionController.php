<?php

namespace App\Http\Controllers\useradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PositionModel;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $position = PositionModel::create([
            'name'=>$request->input('category_name'),
            'description'=>$request->input('category_description'),
        ]);

        return redirect('/student');
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
        //
        $position = PositionModel::find($id);

        return response()->json($position);
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
        $position = PositionModel::find($id);
        // print_r($request->input());exit;
        $position->name = $request->input('category_name');
        $position->description = $request->input('category_description');

        $position->update();

        return redirect('/student');
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
        $position = PositionModel::find($id);


        $position->delete();

        return response('successfully deleted', 204);
        //
    }
}

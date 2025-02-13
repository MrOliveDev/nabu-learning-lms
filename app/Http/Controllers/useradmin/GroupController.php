<?php

namespace App\Http\Controllers\useradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupModel;

class GroupController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $group = new GroupModel();
        $group->name = $request->input('category_name');
        $group->description= $request->post('category_description');
        $group->status= $request->input('cate-status-icon');
        if(auth()->user()->type != 0) {
            $group->id_creator = auth()->user()->id;
        } else {
            $group->id_creator = session("client");
        }
        $group->creation_date = date("Y-m-d H:i:s");
        $group->save();
        return response()->json($group);
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
        //TODO:DB::show
        $group = GroupModel::find($id);

        return response()->json($group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = GroupModel::find($id);

        return response('ok', 200)->json($group);
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
        $group = GroupModel::find($id);
        $group->name = $request->input('category_name');
        $group->description = $request->input('category_description');
        // print_r($request->input('cate-status'));exit;
        $group->status = $request->input('cate-status-icon');

        $group->update();
        //
        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = GroupModel::find($id);

        $group->status = 0;

        $group->delete();

        return response('successfully deleted!', 200);
        //
    }
}

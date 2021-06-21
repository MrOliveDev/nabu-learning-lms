<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use App\Models\GroupModel;
use App\Models\PositionModel;
use App\Models\CompanyModel;
use App\Models\ConfigModel;
use App\Models\LanguageModel;
use App\Models\SessionModel;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::all();
        $authors = User::all();
        $teachers = User::all();
        $groups = GroupModel::all();
        $positions = PositionModel::all();
        $companies = CompanyModel::all();
        $languages = LanguageModel::all();
        $sessions = SessionModel::all();
        return view('session', compact(['authors', 'teachers', 'students', 'groups', 'positions', 'companies', 'languages', 'sessions']));
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
        if($request->post("name")!=NULL){
        $session->name=$request->post('name');
        }
        if($request->post("description")!=NULL){
        $session->description=$request->post('description');
        }
        $session->save();
        return response()->json($session);
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
        // print_r($session);
        return response()->json($session);
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
        if($request->post("name")!=NULL){
        $session->name=$request->post('name');
        }
        if($request->post("description")!=NULL){
        $session->description=$request->post('description');
        }
        $session->update();
        return response()->json($session);
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
        return response()->json(["success"=>true]);
    }
}

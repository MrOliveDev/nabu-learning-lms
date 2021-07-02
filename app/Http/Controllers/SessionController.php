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

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::getUserPageInfo(4);
        $teachers = User::getUserPageInfo(3);
        $groups = GroupModel::all();
        $trainings = TrainingsModel::all();
        $positions = PositionModel::all();
        $companies = CompanyModel::all();
        $languages = LanguageModel::all();
        $sessions = SessionModel::getSessionPageInfo();
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
        $content = SessionModel::getContentDataFromSession($session->contents);
        // dd(array('contents'=>$content, 'participants'=>$participant, "session_info"=>$session->toArray()));
        // dd(User::getUserIDFromGroup(2));
        return response()->json(['contents' => $content, 'participants' => $participant, "session_info" => $session->toArray()]);
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
        return response()->json(["success" => true]);
    }

    public function sessionJoinTo(Request $request)
    {
        $participantData = $request->participant;
        $contentData = $request->content;
        $id = $request->id;
        $cate = $request->cate;
        if (($session = SessionModel::find($id)) != NULL) {
            if ($cate == 'participant') {
                if ($participantData != NULL) {
                    $session->participants = $participantData;
                    $session->update();
                    return response()->json(["success" => true]);
                }
            } else if ($cate == 'content') {
                if ($contentData != NULL) {
                    $tempSession = SessionModel::where('contents', $contentData)->first();

                    if ($tempSession) {
                        return response()->json(['success' => false, 'message' => "This content is already exist."]);
                    }
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

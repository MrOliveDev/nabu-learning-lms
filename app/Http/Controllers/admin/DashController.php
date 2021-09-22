<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionModel;
use App\Models\User;
use App\Models\ReportsModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\LessonsModel;

class DashController extends Controller
{
    public function index()
    {
        if (auth()->user()->type == 0 || auth()->user()->type == 1 || auth()->user()->type == 3) {
        
            // PAUSED = a session in progress that is set OFFLINE
            // FINISHED = end date passed
            // CANCELED = a session that was set OFFLINE and END DATE passed
            // IN PROGRESS = a session that began and not yet END DATE
            $original_sessions = SessionModel::getSessionPageInfo()->toArray();
            $sessions = array();
            foreach($original_sessions as $session){
                if($session['begin_date']<=today()&&($session['end_date']>=today()||$session['end_date']==NULL||$session['end_date']=='')) {
                    if($session['status']==1){
                        $session["status"] = "IN PROGRESS";
                    } else {                    
                        $session["status"] = "PAUSED";
                    }
                } elseif($session['end_date']<=today()){
                    if($session['status']!=1){
                        $session["status"] = "CANCELED";
                    } else {
                        $session["status"] = "FINISHED";
                    }
                }
                array_push($sessions,  $session);
            }

            $authedUserId = auth()->user()->id;
            
            $activedStudents = User::getUserPageInfo(4)->count();
            if(auth()->user()->type == 1){
                $registeredUsers = User::where('id_creator', $authedUserId)->count()+$activedStudents;
            } else {
                $registeredUsers = User::whereIn('id_creator', User::get_members())->count()+$activedStudents;
            }
            $sessionsInProgress = SessionModel::where('begin_date', "<", today())->where(function ($query) {
                $query->where('end_date', ">", today())
                      ->orWhere('end_date', '=', null);
            })
            ->where('status', 1);
            if(session("client")!=null){
                $sessionsInProgress = $sessionsInProgress
                ->where("id_creator", session("client"));
            }
            $sessionsInProgress = $sessionsInProgress->count();

            $createdLessons = LessonsModel::getLessonByClient()->count();

            $finishedSessions = SessionModel::where('end_date', "<", today())->where("id_creator", session("client"))->count();

            $generatedReports = ReportsModel::getReportByClient()->count();

            return view('admindash', compact(['sessions', 'registeredUsers', 'activedStudents', 'sessionsInProgress', 'createdLessons', 'finishedSessions', 'generatedReports']));

        } else if(auth()->user()->type == 2){
            return redirect('training');
        } else if(auth()->user()->type == 4){
            return redirect('dash');
        }
    }

    public function sessionForAdminDashboard($id){
        $session = SessionModel::find($id);
        $participant = SessionModel::getParticipantListFromSessionForDash($session->participants, $id);
        $contentData = SessionModel::getContentDataFromSession($session->contents);
        $reports = ReportsModel::where("sessionId", $id)->where("id_creator", session("client"))->get()->toArray();
        // dd(array('contents'=>$content, 'participants'=>$participant, "session_info"=>$session->toArray()));
        // dd(User::getUserIDFromGroup(2));
        if ($contentData == null) {
            // print_r('abc');
            // exit;
            return;
        }

        return response()->json(['contents' => $contentData, 'participants' => $participant, "session_info" => $session->toArray(), "reports" => $reports]);
    }

    public function getUserData($id, $session_id){
        $user_info = User::getUserPageInfoFromId($id);
        $reports = ReportsModel::where('sessionId', $session_id)->where("id_creator", session("client"))->get();
        return response()->json(["user_info"=>$user_info, "reports"=>$reports]);
    }
}

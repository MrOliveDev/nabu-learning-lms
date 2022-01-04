<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionModel;
use App\Models\User;
use App\Models\ReportsModel;
use App\Models\DocumentModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\LessonsModel;
use League\CommonMark\Block\Element\Document;

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

            $freeSpace = $this->size(disk_free_space('/'));

            return view('admindash', compact(['sessions', 'registeredUsers', 'activedStudents', 'sessionsInProgress', 'createdLessons', 'finishedSessions', 'generatedReports', 'freeSpace']));

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

    
    public function size($size, array $options=null) {

        $o = [
            'binary' => false,
            'decimalPlaces' => 2,
            'decimalSeparator' => '.',
            'thausandsSeparator' => '',
            'maxThreshold' => false, // or thresholds key
            'sufix' => [
                'thresholds' => ['', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'],
                'decimal' => ' {threshold}B',
                'binary' => ' {threshold}iB'
            ]
        ];
    
        if ($options !== null)
            $o = array_replace_recursive($o, $options);
    
        $count = count($o['sufix']['thresholds']);
        $pow = $o['binary'] ? 1024 : 1000;
    
        for ($i = 0; $i < $count; $i++)
    
            if (($size < pow($pow, $i + 1)) ||
                ($i === $o['maxThreshold']) ||
                ($i === ($count - 1))
            )
                return
    
                    number_format(
                        $size / pow($pow, $i),
                        $o['decimalPlaces'],
                        $o['decimalSeparator'],
                        $o['thausandsSeparator']
                    ) .
    
                    str_replace(
                        '{threshold}',
                        $o['sufix']['thresholds'][$i],
                        $o['sufix'][$o['binary'] ? 'binary' : 'decimal']
                    );
    }

    public function getPersonDocumentBySession(request $request){
        // print_r($request->session_id); exit;
        $columns = array( 
            0 =>'session', 
            1 =>'first_name',
            2 =>'filename',
            3 =>'type',
            4 =>'detail',
            5 =>'created_time'
        );
        // $totalData = ReportsModel::getReportByClient()->count();
        $totalData = DocumentModel::getDocumentsBySession($request->session_id)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // $handler = new ReportsModel;
        $handler = new DocumentModel;
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_session as tb_session', "tb_session.id", "=", "tb_document.session_id");
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_users as tb_users', "tb_users.id", "=", "tb_document.user");
        $handler = $handler->where("session_id", $request->post('session_id'))->where('tb_document.type', 'person');
        // if(isset(session("permission")->limited)) {
        //     $handler = $handler->where("tb_reports.id_creator", auth()->user()->id);
        // } else {
        //     if(auth()->user()->type < 2) {
        //         $handler = $handler
        //         ->whereIn("tb_reports.id_creator", User::get_members());
        //     } else {
        //         $handler = $handler
        //         ->where("tb_reports.id_creator", session("client"))
        //         ->orWhere("tb_reports.id_creator", auth()->user()->id);
        //     }
        // }
        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $person_documents = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_document.id as id',
                        'tb_session.name as session',
                        'tb_users.first_name as first_name',
                        'tb_users.last_name as last_name',
                        'tb_document.filename as filename',
                        'tb_document.type as type',
                        'tb_document.created_date as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $person_documents =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_document.id','LIKE',"%{$search}%")
                            ->orWhere('tb_document.filename', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_document.id as id',
                                'tb_session.name as session',
                                'tb_users.first_name as first_name',
                                'tb_users.last_name as last_name',
                                'tb_document.filename as filename'
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_document.id','LIKE',"%{$search}%")
                                ->orWhere('tb_document.filename', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($person_documents))
        {
            foreach ($person_documents as $document)
            {
                $nestedData['id'] = $document->id;
                $nestedData['studentname'] = $document->first_name . ' ' . $document->last_name;
                $nestedData['depositedate'] = $document->created_time;
                // $nestedData['document'] = $document->filename;
                $nestedData['document'] = "
                $document->filename
                <i class='pl-3 fas fa-download doc_download' onclick='download_person_pdf(`".$document->filename."`)'></i>
                ";
                
                $nestedData['actions'] = "
                <div class='text-center d-flex'>
                    <a href='" .url('/').'/person_document' . '/'.$document->filename."' class='btn btn-primary mr-3' style='border-radius: 5px' target='_blank'>
                        <i class='fa fa-eye'></i>
                    </a>
                    <button type='button' class='js-swal-confirm btn btn-danger mr-3' onclick='delDocument({$nestedData['id']})' style='border-radius: 5px'>
                        <i class='fa fa-trash'></i>
                    </button>
                </div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );
        echo json_encode($json_data);
    }

    public function getGroupDocumentBySession(request $request){
        // print_r($request->session_id); exit;
        $columns = array( 
            0 =>'session', 
            1 =>'first_name',
            2 =>'filename',
            3 =>'type',
            4 =>'detail',
            5 =>'created_time',
            6 =>'group'
        );
        // $totalData = ReportsModel::getReportByClient()->count();
        $totalData = DocumentModel::getDocumentsBySession($request->session_id)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // $handler = new ReportsModel;
        $handler = new DocumentModel;
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_session as tb_session', "tb_session.id", "=", "tb_document.session_id");
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_users as tb_users', "tb_users.id", "=", "tb_document.user");
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_groups as tb_groups', "tb_groups.id", "=", "tb_document.type");
        $handler = $handler->where("session_id", $request->post('session_id'))->where('tb_document.type','!=', 'person');
        // if(isset(session("permission")->limited)) {
        //     $handler = $handler->where("tb_reports.id_creator", auth()->user()->id);
        // } else {
        //     if(auth()->user()->type < 2) {
        //         $handler = $handler
        //         ->whereIn("tb_reports.id_creator", User::get_members());
        //     } else {
        //         $handler = $handler
        //         ->where("tb_reports.id_creator", session("client"))
        //         ->orWhere("tb_reports.id_creator", auth()->user()->id);
        //     }
        // }
        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $group_documents = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_document.id as id',
                        'tb_session.name as session',
                        'tb_groups.name as group',
                        'tb_users.first_name as first_name',
                        'tb_users.last_name as last_name',
                        'tb_document.filename as filename',
                        'tb_document.type as type',
                        'tb_document.created_date as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $group_documents =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_document.id','LIKE',"%{$search}%")
                            ->orWhere('tb_document.filename', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_document.id as id',
                                'tb_session.name as session',
                                'tb_users.first_name as first_name',
                                'tb_users.last_name as last_name',
                                'tb_document.filename as filename'
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_document.id','LIKE',"%{$search}%")
                                ->orWhere('tb_document.filename', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($group_documents))
        {
            foreach ($group_documents as $document)
            {
                $nestedData['id'] = $document->id;
                $nestedData['groupname'] = $document->group;
                $nestedData['depositeby'] = $document->first_name . ' ' . $document->last_name;
                $nestedData['depositedate'] = $document->created_time;
                $nestedData['document'] = "
                $document->filename
                <i class='pl-3 fas fa-download doc_download' onclick='download_group_pdf(`".$document->filename."`)'></i>
                ";
                
                $nestedData['actions'] = "
                <div class='text-center d-flex'>
                    <a href='" .url('/').'/group_document' . '/'.$document->filename."' class='btn btn-primary mr-3' style='border-radius: 5px' target='_blank'>
                        <i class='fa fa-eye'></i>
                    </a>
                    <button type='button' class='js-swal-confirm btn btn-danger mr-3' onclick='delDocument({$nestedData['id']})' style='border-radius: 5px'>
                        <i class='fa fa-trash'></i>
                    </button>
                </div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );
        echo json_encode($json_data);
    }
}

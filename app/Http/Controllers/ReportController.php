<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\ReportsModel;
use App\Models\ReportTemplateModel;
use App\Models\ReportImages;
use App\Models\SessionModel;
use App\Models\TrainingsModel;
use App\Models\LessonCourses;
use App\Models\LanguageModel;
use App\Models\ScreenOptim;
use App\Models\User;
use App\Models\LessonsModel;
use App\Models\EvaluationQuestions;
use App\Models\InterfaceCfgModel;

use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
// use Spipu\Html2Pdf\Html2Pdf;

use Auth;
use Exception;
use ZipArchive;
use Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = ReportTemplateModel::getTemplateModelByClient();
        if(isset(session("permission")->limited)) {
            $images = ReportImages::where('userId', auth()->user()->id)->get();
        } else {
            if(auth()->user()->type < 2) {
                $images = ReportImages::whereIn('userId', User::get_members())->get();
            } else {
                $images = ReportImages::where('userId', session("client"))
                ->orWhere("userId", auth()->user()->id)->get();
            }
        }   

        $sessions = SessionModel::getSessionPageInfo();
        return view('report.view')->with('templates', $templates)->with('images', $images)->with('sessions', $sessions);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //
    }

    /**
     * Return server-side rendered table list.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function getReportListBySession(Request $request){
        $columns = array( 
            0 =>'session', 
            1 =>'first_name',
            2 =>'filename',
            3 =>'type',
            4 =>'detail',
            5 =>'created_time'
        );
        $totalData = ReportsModel::getReportByClient()->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new ReportsModel;
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_session as tb_session', "tb_session.id", "=", "tb_reports.sessionId");
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_users as tb_users', "tb_users.id", "=", "tb_reports.studentId");
        $handler = $handler->where("sessionId", $request->post('session_id'));
        if(isset(session("permission")->limited)) {
            $handler = $handler->where("tb_reports.id_creator", auth()->user()->id);
        } else {
            if(auth()->user()->type < 2) {
                $handler = $handler
                ->whereIn("tb_reports.id_creator", User::get_members());
            } else {
                $handler = $handler
                ->where("tb_reports.id_creator", session("client"))
                ->orWhere("tb_reports.id_creator", auth()->user()->id);
            }
        }
        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $reports = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_reports.id as id',
                        'tb_session.name as session',
                        'tb_users.first_name as first_name',
                        'tb_users.last_name as last_name',
                        'tb_reports.filename as filename',
                        'tb_reports.type as type',
                        'tb_reports.detail as detail',
                        'tb_reports.created_time as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $reports =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_reports.id','LIKE',"%{$search}%")
                            ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_reports.id as id',
                                'tb_session.name as session',
                                'tb_users.first_name as first_name',
                                'tb_users.last_name as last_name',
                                'tb_reports.filename as filename'
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_reports.id','LIKE',"%{$search}%")
                                ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($reports))
        {
            foreach ($reports as $report)
            {
                $nestedData['id'] = $report->id;
                $nestedData['session'] = $report->session;
                $nestedData['student'] = $report->first_name . ' ' . $report->last_name;
                $nestedData['filename'] = $report->filename;
                
                $nestedData['actions'] = "
                <div class='text-center d-flex'>
                    <a href='" .url('/').'/'. $report->type. '/'.$report->filename."' class='btn btn-primary mr-3' style='border-radius: 5px' target='_blank'>
                        <i class='fa fa-eye'></i>
                    </a>
                    <button type='button' class='js-swal-confirm btn btn-danger mr-3' onclick='delReport({$nestedData['id']})' style='border-radius: 5px'>
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
    /**
     * Return server-side rendered table list.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function getReportList(Request $request){
        $columns = array( 
            0 =>'session', 
            1 =>'first_name',
            2 =>'filename',
            3 =>'type',
            4 =>'detail',
            5 =>'created_time'
        );
        $totalData = ReportsModel::getReportByClient()->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new ReportsModel;
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_session as tb_session', "tb_session.id", "=", "tb_reports.sessionId");
        $handler = $handler->leftjoin(env('DB_DATABASE').'.tb_users as tb_users', "tb_users.id", "=", "tb_reports.studentId");
        if(isset(session("permission")->limited)){
            $handler = $handler->where("tb_reports.id_creator", auth()->user()->id);
        } else {
            if(auth()->user()->type < 2) {
                $handler = $handler->whereIn("tb_reports.id_creator", User::get_members());
            } else {
                $handler = $handler->where("tb_reports.id_creator", session("client"))
                ->orWhere("tb_reports.id_creator", auth()->user()->id);
            }
        }
        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $reports = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_reports.id as id',
                        'tb_session.name as session',
                        'tb_users.first_name as first_name',
                        'tb_users.last_name as last_name',
                        'tb_reports.filename as filename',
                        'tb_reports.type as type',
                        'tb_reports.detail as detail',
                        'tb_reports.created_time as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $reports =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_reports.id','LIKE',"%{$search}%")
                            ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_reports.id as id',
                                'tb_session.name as session',
                                'tb_users.first_name as first_name',
                                'tb_users.last_name as last_name',
                                'tb_reports.filename as filename',
                                'tb_reports.type as type',
                                'tb_reports.detail as detail',
                                'tb_reports.created_time as created_time',
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_reports.id','LIKE',"%{$search}%")
                                ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($reports))
        {
            foreach ($reports as $report)
            {
                $nestedData['id'] = $report->id;
                $nestedData['session'] = $report->session;
                $nestedData['student'] = $report->first_name . ' ' . $report->last_name;
                $nestedData['filename'] = $report->filename;
                $nestedData['type'] = $report->type;
                $nestedData['detail'] = $report->detail;
                $nestedData['created_time'] = $report->created_time;
                
                $nestedData['actions'] = "
                <div class='text-center'>
                    <a href='" .url('/').'/'.$report->type. '/'.$report->filename."' class='btn btn-primary mr-3' style='border-radius: 5px' target='_blank'>
                        <i class='fa fa-download'></i>
                    </a>
                    <button type='button' class='js-swal-confirm btn btn-danger mr-3' onclick='delReport({$nestedData['id']})' style='border-radius: 5px'>
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

    /**
     * Return model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getTemplateData(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id']);
            if(isset(session("permission")->limited)) {
                $template = $template
                ->where("id_creator", auth()->user()->id)
                ->first();
            } else {
                if(auth()->user()->type < 2) {
                    $template = $template
                    ->whereIn("id_creator", User::get_members())
                    ->first();
                } else {
                    $template = $template
                    ->where("id_creator", session("client"))
                    ->orWhere("id_creator", auth()->user()->id)
                    ->first();
                }
            }
            if($template)
                return response()->json(["success" => true, "data" => $template->data, "name" => $template->name]);
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveTemplateData(Request $request){
        if(!empty($request['id']) && !empty($request['name'])){
            $template = ReportTemplateModel::where('id', $request['id']);
            if(isset(session("permission")->limited)) {
                $template = $template
                ->where("id_creator", auth()->user()->id)
                ->first();
            } else {
                if(auth()->user()->type < 2) {
                    $template = $template
                    ->whereIn("id_creator", User::get_members())
                    ->first();
                } else {
                    $template = $template
                    ->where("id_creator", session("client"))
                    ->orWhere("id_creator", auth()->user()->id)
                    ->first();
                }
            }
            if($template){
                $template->name = $request['name'];
                $template->data = $request['data'];
                $template->id_creator = session("client");

                $template->save();
                return response()->json(["success" => true]);
            }
            else{
                $template = ReportTemplateModel::create([
                    'creatorId' => Auth::user()->id,
                    'name' => $request['name'],
                    'data' => $request['data'],
                    'created_time' => gmdate("Y-m-d\TH:i:s", time()),
                    'id_creator' => auth()->user()->id
                ]);
                return response()->json(["success" => true, "id" => $template->id]);
            }
        } else
            return response()->json(["success" => false, "message" => "Missing id or name."]);
    }

    /**
     * Delete model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function delTemplate(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id']);
            if(isset(session("permission")->limited)) {
                $template = $template
                ->where("id_creator", auth()->user()->id)
                ->first();
            } else {
                if(auth()->user()->type < 2) {
                    $template = $template
                    ->whereIn("id_creator", User::get_members())
                    ->first();
                } else {
                    $template = $template
                    ->where("id_creator", session("client"))
                    ->orWhere("id_creator", auth()->user()->id)
                    ->first();
                }
            }
            if($template){
                $template->delete();
                return response()->json(["success" => true]);
            }
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Delete model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getBlockHTML(Request $request){
        if(!empty($request['name'])){
            return response()->json(["success" => true, "html" => view('report.' . $request['name'])->render()]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save base64 image to db.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveReportImg(Request $request){
        if(!empty($request['data'])){
            ReportImages::create([
                'userId' => auth()->user()->id,
                'data' => $request['data']
            ]);
            return response()->json(["success" => true]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Retrieve students' list of the session.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getStudentsList(Request $request){
        if(!empty($request['sessionId'])){
            $session = SessionModel::find($request['sessionId']);
            if($session){
                $students = SessionModel::getStudentsFromSession($session->participants);
                return response()->json(["success" => true, "students" => $students]);
            } else
                return response()->json(["success" => false, "message" => "Cannot find the session."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Retrieve report data for a student of a session.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getReportData(Request $request){
        if(!empty($request['sessionId']) && !empty($request['studentId'])){
            $user = User::leftjoin('tb_companies', "tb_companies.id", "=", "tb_users.company")->where('tb_users.id', $request['studentId'])->first(array('tb_users.*', 'tb_companies.name as company_name'));
            if($user){
                $data['student'] = $user;
            } else
                response()->json(["success" => false, "message" => "Cannot find the student."]);

            $cfg = InterfaceCfgModel::where('id', Auth::user()->id_config)->first();
            if($cfg && $cfg->interface_color){
                $color = json_decode($cfg->interface_color);
                if($color && $color->menuBackground)
                    $data['background'] = $color->menuBackground;
            }
            
            $language_iso = LanguageModel::get_language_iso($user['lang']);
            if($language_iso == '')
                $language_iso = LanguageModel::get_language_iso(1);
            
            $session = SessionModel::find($request['sessionId']);
            if($session){
                if($session->participants){
                    $participants = json_decode($session->participants);
                    $teacherIds = isset($participants->t) ? $participants->t : array();
                    $teachers = array();
                    foreach($teacherIds as $teacherId){
                        $teacher = User::find($teacherId);
                        if($teacher)
                            array_push($teachers, $teacher->first_name . ' ' . $teacher->last_name);
                    }
                    $data['teachers'] = $teachers;
                }

                $trainingIds = explode("_", $session->contents);
                $data['trainings'] = array();
                foreach($trainingIds as $trainingId){
                    $training = TrainingsModel::find($trainingId);
                    $lessons = [];
                    if($training){
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
                    }

                    $data["are_eval_there"] = array("evals" => array(), "answer" => 0, "evalnums");
                    $first_date_view = FALSE;
                    $last_date_view = FALSE;
                    $totalTime = '00:00:00';
                    $lessonData = [];
                    foreach($lessons as $lesson){
                        $lessonInfo = array("lesson" => $lesson);
                        //$lessonCourse = LessonCourses::getLessonCourse($lesson['id'], $language_iso);
                        $lessonCourse = LessonCourses::where('curso_id', $lesson['id'])->where('lang', $language_iso)->first();
                        $lessonInfo["lessonCourse"] = $lessonCourse;
                       
                        if($lessonCourse && $lessonCourse->module_structure){
                            $module_structure = json_decode($lessonCourse->module_structure);
                            $lessonInfo["screensCount"] = $this->helperCountScreensModule($module_structure);
                            $lessonInfo["chaptersCount"] = $this->helperCountChaptersModule($module_structure);
                        } else{
                            $lessonInfo["screensCount"] = 0;
                            $lessonInfo["chaptersCount"] = 0;
                        }
                        
                        $lessonInfo["optim"] = $this->getScreenOptim($request['sessionId'], $request['studentId'], $lesson['idFabrica']);
                        if($lessonInfo["optim"]){
                            $lessonInfo["first_eval"] = $this->getEvaluation($request['sessionId'], $lessonInfo["optim"]->first_eval_id_screen_optim);
                            $lessonInfo["last_eval"] = $this->getEvaluation($request['sessionId'], $lessonInfo["optim"]->last_eval_id_screen_optim);
                            
                            if ($last_date_view == FALSE || (strtotime($lessonInfo['optim']->last_date_screen_optim) > strtotime($last_date_view)))
                                $last_date_view = $lessonInfo['optim']->last_date_screen_optim;

                            $progress_details = json_decode($lessonInfo['optim']->progress_details_screen_optim);
                            $lessonInfo["visitedScreens"] = $this->helperCountScreens($progress_details, $lessonInfo["optim"]);
                        } else{
                            $lessonInfo["first_eval"] = null;
                            $lessonInfo["last_eval"] = null;
                            $lessonInfo["visitedScreens"] = 0;
                        }
                        $lessonInfo["evalCounts"] = $this->getNbEvaluations($request['sessionId'], $request['studentId'], $lesson['idFabrica']);

                        $time_module = '00:00:00';
                        if(!empty($progress_details)){
                            foreach ($progress_details as $screen) {
                                if ($first_date_view == FALSE || (strtotime($screen->last_view) < strtotime($first_date_view)))
                                    $first_date_view = $screen->last_view;
                                $t_time = explode(':',$screen->time);
                                $time_module = date('H:i:s',strtotime("+".$t_time[0]." hours ".$t_time[1]." minutes ".$t_time[2]." seconds",strtotime($time_module)));
                                $totalTime = date('H:i:s',strtotime("+".$t_time[0]." hours ".$t_time[1]." minutes ".$t_time[2]." seconds",strtotime($totalTime)));
                            }
                        }

                        $time_eval = '00:00:00';
                        $lessonInfo["eval"] = '';
                        if($lessonInfo["last_eval"] != null){
                            $diff_time = $this->helperDateDiff(strtotime($lessonInfo['last_eval']->date_start),strtotime($lessonInfo['last_eval']->date_end));
                            $time_eval = date('H:i:s',strtotime("+".$diff_time['hour']." hours ".$diff_time['minute']." minutes ".$diff_time['second']." seconds",strtotime($time_eval)));
                            $lessonInfo['last_eval']->time_eval = $time_eval;
                            $lessonInfo['eval'] = 'first';
                            
                            $data["are_eval_there"]["answer"] ++;
                            $data["are_eval_there"]["evals"][] = array("module" => $lessonInfo["lesson"]["name"], "note" => $lessonInfo['last_eval']->note);
                            
                            $lessonInfo['eval_questions'] = $this->getQuestionDetails($request['sessionId'], $lessonInfo['last_eval']->id);
                        } else if($lessonInfo["first_eval"] != null){
                            $diff_time = $this->helperDateDiff(strtotime($lessonInfo['first_eval']->date_start),strtotime($lessonInfo['first_eval']->date_end));
                            $time_eval = date('H:i:s',strtotime("+".$diff_time['hour']." hours ".$diff_time['minute']." minutes ".$diff_time['second']." seconds",strtotime($time_eval)));
                            $lessonInfo['first_eval']->time_eval = $time_eval;
                            $lessonInfo['eval'] = 'first';
                            
                            $data["are_eval_there"]["answer"] ++;
                            $data["are_eval_there"]["evals"][] = array("module" => $lessonInfo["lesson"]["name"], "note" => $lessonInfo['first_eval']->note);
                            
                            $lessonInfo['eval_questions'] = $this->getQuestionDetails($request['sessionId'], $lessonInfo['first_eval']->id);
                        }

                        if (isset($lessonInfo['eval_questions'])) {
                            $questions = array();
                            $num = 0;
                            foreach ($lessonInfo['eval_questions'] as $one) {
                                try{
                                    $options =  unserialize($one->option_serialize);
                                } catch(Exception $e){
                                    $options = unserialize(str_replace("'", "''", $one->option_serialize));
                                }
                                if( $options == false )
                                    $options = unserialize(str_replace("'", "''", $one->option_serialize));
                                $reponses_attendus = $one->expected_response;
                                $reponses_recus = $one->reply;
                                $t_options = array();
                                // On parcours les options de la questions et on vérifie si la réponse donnée est la réponse attendue
                                foreach ($options as $key => $option) {
                                    $option_ok = 0;
                                    if (substr($reponses_attendus,$key,1) == substr($reponses_recus,$key,1))
                                        $option_ok = 1;
                                    $t_options[] = array('intitule' => $option,
                                        'attendu' => substr($reponses_attendus,$key,1),
                                        'recu' => substr($reponses_recus,$key,1),
                                        'ok' => $option_ok);
                                }
                                $questions[] = array('title' => $one->title,
                                    'points' => $one->points,
                                    'options' => $t_options,
                                    'result' => ( $reponses_attendus == $reponses_recus ? 1 : 0) );
                                if($reponses_attendus == $reponses_recus)
                                    $num ++;
                            }
                            $lessonInfo['eval_questions'] = $questions;
                            $data["are_eval_there"]["evalnums"][] = array("module" => $lessonInfo["lesson"]["name"], "num" => $num . " / " . count($lessonInfo['eval_questions']));
                        }

                        if ($time_eval != '00:00:00') {
                            $t_time_eval = explode(':',$time_eval);
                            $time_module = date('H:i:s',strtotime("+".$t_time_eval[0]." hours ".$t_time_eval[1]." minutes ".$t_time_eval[2]." seconds",strtotime($time_module)));
                            // MAJ du temps effectif total de la formation
                            $totalTime = date('H:i:s',strtotime("+".$t_time_eval[0]." hours ".$t_time_eval[1]." minutes ".$t_time_eval[2]." seconds",strtotime($totalTime)));
                        }
                        $lessonInfo['time_module'] = $time_module;

                        $lessonData[] = $lessonInfo;
                    }

                    $data['trainings'][] = array("training" => $training, "lessons" => $lessonData, "first_date" => $first_date_view, "last_date" => $last_date_view, "totalTime" => $totalTime);
                }
                return response()->json(["success" => true, "data" => $data]);
            } else
                response()->json(["success" => false, "message" => "Cannot find the session."]);
        } else
            return response()->json(["success" => false, "message" => "Empty parameters."]);
    }

    /**
     * Return count of screens from module structure.
     *
     * @param  Array  $module_structure
     * @return Integer
     */
    private function helperCountScreensModule($module_structure) {
        $nb_screens = 0;
        if (!empty($module_structure)) {
            foreach ($module_structure as $screen) {
                // On vire du total les screen nav = FALSE
                if (isset($screen->nav) && $screen->nav != "false") {
                    $nb_screens++;
                }
            }
        }
        return $nb_screens;
    }

    /**
     * Return count of chapters from module structure.
     *
     * @param  Array  $module_structure
     * @return Integer
     */
    private function helperCountChaptersModule($module_structure) {
        $nb_chapters = 0;
        if (!empty($module_structure)) {
            foreach ($module_structure as $screen) {
                // On vire du total les screen nav = FALSE
                if (!isset($screen->nav) || $screen->nav == "false") {
                    $nb_chapters++;
                }
            }
        }
        return $nb_chapters;
    }

    /**
     * Return count of visited screens from screen optim datas.
     *
     * @param  Array  $module_structure
     * @param  Array  $optim
     * @param  Bool   $eval
     * @return Integer
     */
    private function helperCountScreens($screens,$optim,$eval='') {
        $i = 0;
        if (!empty($screens)) {
            foreach ($screens as $screen)
                $i++;
        }
        // Si on a le paramètre $eval, c'est qu'on est en train de faire un treatOptimEval donc on ajoute 1 par défaut
        // if ($eval == TRUE)
        //     $i++;
        // else { // Si on traite pas une évaluation
        //     // Si on a une évaluation on compte un screen en plus
        //     if ($optim->first_eval_id_screen_optim != 0 || $optim->last_eval_id_screen_optim != 0)
        //         $i++;
        // }
        return $i;
    }

    public function getScreenOptim($sessionId, $studentId, $idFabrica){
        DB::connection('mysql_reports')->unprepared("CREATE TABLE IF NOT EXISTS `tb_screen_optim_".$sessionId."` (
            `id_screen_optim` int(11) NOT NULL AUTO_INCREMENT,
            `id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `id_curso_screen_optim` int(11) NOT NULL,
            `id_user_screen_optim` int(11) NOT NULL,
            `progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,
            `progress_screen_optim` float(5,2) NOT NULL,
            `last_date_screen_optim` datetime NOT NULL,
            `first_eval_id_screen_optim` int(11) NOT NULL,
            `last_eval_id_screen_optim` int(11) NOT NULL,
            `id_creator` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (id_screen_optim) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");
        $optim = DB::connection('mysql_reports')->selectOne('select * from tb_screen_optim_' . $sessionId . ' where id_user_screen_optim="'.$studentId.'" AND id_fabrique_screen_optim="'.$idFabrica.'"');
        return $optim;
	}

    public function getEvaluation($sessionId, $idEvaluation){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_start` datetime DEFAULT NULL,"
        . "`date_end` datetime DEFAULT NULL,"
        . "`is_presential` int(1) DEFAULT '0',"
        . "`user_keypad` int(11) DEFAULT '0',"
        . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
        . "`number_eval` int(11) DEFAULT NULL,"
        . "`progression` int(11) NOT NULL DEFAULT '0',"
        . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
        . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_creator` int(11) DEFAULT NULL DEFAULT '1',"
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->selectOne('select * from tb_evaluation_' . $sessionId . ' where id="'.$idEvaluation.'"');
        return $eval;
    }

    public function getNbEvaluations($sessionId, $studentId, $idFabrica){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_start` datetime DEFAULT NULL,"
        . "`date_end` datetime DEFAULT NULL,"
        . "`is_presential` int(1) DEFAULT '0',"
        . "`user_keypad` int(11) DEFAULT '0',"
        . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
        . "`number_eval` int(11) DEFAULT NULL,"
        . "`progression` int(11) NOT NULL DEFAULT '0',"
        . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
        . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_creator` int(11) NOT NULL DEFAULT '1',"
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->select('select COUNT(id) as nb_evals from tb_evaluation_' . $sessionId . ' where user_id="'.$studentId.'" AND id_lesson="'.$idFabrica.'"');
        if($eval && $eval[0])
            return $eval[0]->nb_evals;
        else
            return 0;
    }

    public function getQuestionDetails($sessionId, $idEvaluation){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_question_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`id_evaluation` int(11) DEFAULT NULL,"
        . "`id_q` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`name_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`num_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'order of question',"
        . "`title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`option_serialize` text COLLATE utf8_unicode_ci,"
        . "`expected_response` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`reply` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`points` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_creator` int(11) DEFAULT '1',"
        . "PRIMARY KEY (id) "
      . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->select('select * from tb_evaluation_question_' . $sessionId . ' where id_evaluation="'.$idEvaluation.'"');
        return $eval;
    }

    public function helperDateDiff($date1, $date2) {
        $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = array();
        $tmp = $diff;
        $retour['second'] = $tmp % 60;
        $tmp = floor( ($tmp - $retour['second']) / 60 );
        $retour['minute'] = $tmp % 60;
        $tmp = floor( ($tmp - $retour['minute']) / 60 );
        $retour['hour'] = $tmp % 24;
        $tmp = floor( ($tmp - $retour['hour']) / 24 );
        $retour['day'] = $tmp;
        return $retour;
    }

    public function downloadReportPDF(Request $request){
        if(isset($request['sessionId']) && isset($request['studentId'])){
            //set_time_limit(0);
            // ini_set('memory_limit', '-1');
            // $rep = '
            //         <page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm">
            //         <page_header> 
            //              ' . $request['header'] . '
            //         </page_header> 
            //         <page_footer> 
            //              ' . $request['footer'] . ' 
            //         </page_footer> 
            //         <style>
            //             td { padding-left: 5px; }
            //         </style>

            //         ';
            // $rep .= $request['content'];
            // $rep .= '</page>';

            // $filename = $request['sessionId'] . '_' . $request['studentId'] . '_' . time() . '.pdf';
            // $filelink = storage_path('pdf') . '/' . $filename;
            // $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8');
            // $html2pdf->writeHTML($rep);
            // $html2pdf->Output($filelink, 'F');

            $mpdf = new MPdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir'=>storage_path('tempdir'), 'setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
            $mpdf->SetHTMLHeader(str_replace("<br>", "<wbr> </wbr>", $request['header']));
            $mpdf->SetHTMLFooter(str_replace("<br>", "<wbr> </wbr>", $request['footer']));
            $mpdf->writeHTML(str_replace("<br>", "<wbr> </wbr>", '<style> td { padding-left: 5px; } </style>' . $request['content']));

            $filename = $request['sessionId'] . '_' . $request['studentId'] . '_' . time() . '.pdf';
            $filelink = storage_path('pdf') . '/' . $filename;
            $mpdf->Output($filelink, 'F');

            ReportsModel::create([
                'sessionId' => $request['sessionId'],
                'studentId' => $request['studentId'],
                'filename' => $filename,
                'type' => 'pdf',
                'created_time' => gmdate("Y-m-d\TH:i:s", time()),
                'id_creator' =>auth()->user()->type!=0?auth()->user()->id:session("client")
            ]);

            return response()->json(["success" => true, "filename" => $filename]);
        } else
            return response()->json(["success" => false, "message" => "Wrong Parameters."]);
    }

    public function getPDFContents($file){
        if(Storage::disk('pdf')->exists($file)){
            $file = Storage::disk('pdf')->get($file);

            $response = Response::make($file, 200);
            $response->header("Content-Type", 'application/pdf');

            return $response;
            // return response()->download(storage_path('pdf' . '/' . $file), null, ['Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0']);
        }
        else
            return 'File does not exist!';
    }

    public function downloadReportZip(Request $request){
        if(isset($request['sessionId']) && isset($request['data'])){
            set_time_limit(0);
            // ini_set('memory_limit', '-1');
            $filenames = array();
            foreach($request['data'] as $report){
                // $rep = '
                //     <page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm">
                //     <page_header> 
                //          ' . $report['header'] . '
                //     </page_header> 
                //     <page_footer> 
                //          ' . $report['footer'] . ' 
                //     </page_footer> 
                //     <style>
                //         td { padding-left: 5px; }
                //     </style>

                //     ';
                // $rep .= $report['content'];
                // $rep .= '</page>';

                // $filename = $request['sessionId'] . '_' . $report['studentId'] . '_' . time() . '.pdf';
                // $filenames[] = $filename;
                // $filelink = storage_path('pdf') . '/' . $filename;
                // $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8');
                // $html2pdf->writeHTML($rep);
                // $html2pdf->Output($filelink, 'F');

                $mpdf = new MPdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir'=>storage_path('tempdir'), 'setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
                $mpdf->SetHTMLHeader(str_replace("<br>", "<wbr> </wbr>", $report['header']));
                $mpdf->SetHTMLFooter(str_replace("<br>", "<wbr> </wbr>", $report['footer']));
                $mpdf->writeHTML(str_replace("<br>", "<wbr> </wbr>", '<style> td { padding-left: 5px; } </style>' . $report['content']));

                $filename = $request['sessionId'] . '_' . $report['studentId'] . '_' . time() . '.pdf';
                $filenames[] = $filename;
                $filelink = storage_path('pdf') . '/' . $filename;
                $mpdf->Output($filelink, 'F');

                ReportsModel::create([
                    'sessionId' => $request['sessionId'],
                    'studentId' => $report['studentId'],
                    'filename' => $filename,
                    'type' => 'pdf',
                    'created_time' => gmdate("Y-m-d\TH:i:s", time()),
                    'id_creator' => auth()->user()->type!=0?auth()->user()->id:session("client")
                ]);
            }

            $filename = $request['sessionId'] . '_' . time() . '.zip';
            $zip = new ZipArchive();
            $zip->open(storage_path('zip') . '/' . $filename, ZipArchive::CREATE);
            foreach($filenames as $file){
                $zip->addFile(storage_path('pdf') . '/' . $file, $file);
            }
            $zip->close();

            ReportsModel::create([
                'sessionId' => $request['sessionId'],
                'studentId' => 0,
                'filename' => $filename,
                'type' => 'zip',
                'created_time' => gmdate("Y-m-d\TH:i:s", time()),
                'id_creator' => auth()->user()->type!=0?auth()->user()->id:session("client")
            ]);

            return response()->json(["success" => true, "filename" => $filename]);
        } else
            return response()->json(["success" => false, "message" => "Wrong Parameters."]);
    }

    public function downloadZip($file){
        if(file_exists(storage_path('zip') . '/' . $file))
            return response()->download(storage_path('zip' . '/' . $file), null, ['Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0']);
        else
            return 'File does not exist!';
    }

    public function delReport(Request $request){
        if(!empty($request['id'])){
            $report = ReportsModel::where('id', $request['id']);
            if(isset(session("permission")->limited)) {
                $report = $report
                ->where("id_creator", auth()->user()->id)
                ->first();
            } else {
                if(auth()->user()->type < 2) {
                    $report = $report
                    ->whereIn("id_creator", User::get_members())
                    ->first();
                } else {
                    $report = $report
                    ->where("id_creator", session("client"))
                    ->orWhere("id_creator", auth()->user()->id)
                    ->first();
                }
            }
            if($report){
                if($report->filename){
                    if(file_exists(storage_path($report->type) . '/' . $report->filename))
                        unlink(storage_path($report->type) . '/' . $report->filename);
                    $report->delete();
                    return response()->json(["success" => true]);
                }
            } else 
                return response()->json(["success" => false, "message" => "Cannot find the report."]);
        } else
            return response()->json(["success" => false, "message" => "Empty Parameter."]);
    }
}

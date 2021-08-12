<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MailImages;
use App\Models\MailTemplateModel;
use App\Models\MailHistories;
use App\Models\User;
use App\Models\SessionModel;
use App\Models\GroupModel;

use Auth;
use Exception;
use ZipArchive;
use Mail;
use Mpdf\Mpdf;

class SendmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $templates = MailTemplateModel::get();
        $images = MailImages::where('userId', Auth::user()->id)->get();
        
        $activeTab = 0;
        $process = 'List of users';
        if($request['sessionId']){
            $users = array();
            $session = SessionModel::find($request['sessionId']);
            if($session && $session->participants){
                $participants = SessionModel::getParticipantDataFromSession($session->participants);
                if($participants['student']){
                    foreach($participants['student'] as $student)
                        if($student != NULL)
                            $users[] = $student;
                }
                if($participants['teacher']){
                    foreach($participants['teacher'] as $teacher)
                        if($teacher != NULL)
                            $users[] = $teacher;
                }
            }
            $activeTab = 1;
            $process = 'List of members of the Session ' . $session->name;
        } else if($request['groupId']){
            $users = User::getUserFromGroup($request['id']);
            $activeTab = 1;
            $group = GroupModel::find($request['id']);
            if($group)
                $process = 'List of members of the Group ' . $group->name;
        } else if($request['companyId']){
            $users = User::where('company', $request['companyId'])->get();
            $activeTab = 1;
            $company = CompanyModel::find($request['id']);
            if($company)
                $process = 'List of members of the Company ' . $company->name;
        } else if($request['studentId']){
            $users = array();
            $user = User::find($request['studentId']);
            if($user)
                $users[] = $user;
            $activeTab = 1;
            $process = 'Email to a Student';
        } else if($request['teacherId']){
            $users = array();
            $user = User::find($request['teacherId']);
            if($user)
                $users[] = $user;
            $activeTab = 1;
            $process = 'Email to a Teacher';
        } else if($request['authorId']){
            $users = array();
            $user = User::find($request['authorId']);
            if($user)
                $users[] = $user;
            $activeTab = 1;
            $process = 'Email to an Author';
        } else
            $users = User::get();

        $fromAddress = '';
        if(Auth::user()->contact_info){
            $contact = json_decode(Auth::user()->contact_info);
            if($contact && $contact->email)
                $fromAddress = $contact->email;
        }
        return view('mail.view')->with('templates', $templates)->with('images', $images)->with('users', $users)->with('fromAddress', $fromAddress)->with('activeTab', $activeTab)->with('process', $process);
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
    public function getMailHistories(Request $request){
        $columns = array( 
            0 =>'sender_first',
            1 =>'detail',
            2 =>'model',
            2 =>'created_time'
        );
        $totalData = MailHistories::count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new MailHistories;
        $handler = $handler->leftjoin('tb_users as senders', "senders.id", "=", "tb_mail_history.senderId")->leftjoin('tb_mail_model', 'tb_mail_model.id', "=", "tb_mail_history.modelId");

        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $histories = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_mail_history.id as id',
                        'senders.first_name as sender_first',
                        'senders.last_name as sender_last',
                        'tb_mail_model.name as model',
                        'tb_mail_history.detail as detail',
                        'tb_mail_history.created_time as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $histories =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_mail_history.id','LIKE',"%{$search}%")
                            ->orWhere('senders.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('senders.last_name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_model.name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_history.detail', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_history.created_time', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_mail_history.id as id',
                                'senders.first_name as sender_first',
                                'senders.last_name as sender_last',
                                'tb_mail_model.name as model',
                                'tb_mail_history.detail as detail',
                                'tb_mail_history.created_time as created_time',
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                            $q->where('tb_mail_history.id','LIKE',"%{$search}%")
                            ->orWhere('senders.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('senders.last_name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_model.name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_history.detail', 'LIKE',"%{$search}%")
                            ->orWhere('tb_mail_history.created_time', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($histories))
        {
            foreach ($histories as $history)
            {
                $nestedData['id'] = $history->id;
                $nestedData['sender'] = $history->sender_first . ' ' . $history->sender_last;
                $nestedData['detail'] = $history->detail;
                $nestedData['model'] = $history->model;
                $nestedData['created_time'] = $history->created_time;
                
                $nestedData['actions'] = "
                <div class='text-center'>
                    <a href='" .url('/').'/pdf/mail_result_'.$history->id.".pdf' class='btn btn-primary mr-3' style='border-radius: 5px' target='_blank'>
                        <i class='fa fa-download'></i>
                    </a>
                    <button type='button' class='js-swal-confirm btn btn-danger' onclick='delHistory({$history['id']})' style='border-radius: 5px'>
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
     * Return mail model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getMailTemplate(Request $request){
        if(!empty($request['id'])){
            $template = MailTemplateModel::where('id', $request['id'])->first();
            if($template)
                return response()->json(["success" => true, "data" => $template->data, "name" => $template->name, "subject" => $template->subject]);
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save mail model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveMailTemplate(Request $request){
        if(!empty($request['id']) && !empty($request['name']) && !empty($request['subject'])){
            $template = MailTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->name = $request['name'];
                $template->data = $request['data'];
                $template->subject = $request['subject'];
                $template->save();
                return response()->json(["success" => true]);
            }
            else{
                $template = MailTemplateModel::create([
                    'creatorId' => Auth::user()->id,
                    'name' => $request['name'],
                    'subject' => $request['subject'],
                    'data' => $request['data'],
                    'created_time' => gmdate("Y-m-d\TH:i:s", time())
                ]);
                return response()->json(["success" => true, "id" => $template->id]);
            }
        } else
            return response()->json(["success" => false, "message" => "Missing id or name."]);
    }

    /**
     * Delete mail model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function delMailTemplate(Request $request){
        if(!empty($request['id'])){
            $template = MailTemplateModel::where('id', $request['id'])->first();
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
     * Delete mail history.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function delMailHistory(Request $request){
        if(!empty($request['id'])){
            $history = MailHistories::where('id', $request['id'])->first();
            if($history){
                $history->delete();
                return response()->json(["success" => true]);
            } else 
                return response()->json(["success" => false, "message" => "Cannot find the history."]);
        } else
            return response()->json(["success" => false, "message" => "Empty Parameter."]);
    }

    /**
     * Save base64 image to db.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function saveMailImg(Request $request){
        if(!empty($request['data'])){
            MailImages::create([
                'userId' => Auth::user()->id,
                'data' => $request['data']
            ]);
            return response()->json(["success" => true]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Retrieve user info
     *
     * @param  Request  $request
     * @return JSON
     */
    public function getUserInfo(Request $request){
        if(!empty($request['id'])){
            $user = User::find($request['id']);
            if($user)
                return response()->json(["success" => true, "data" => $user]);
            else
                return response()->json(["success" => false, "message" => "Cannot find the user."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Send mail
     *
     * @param  Request  $request
     * @return JSON
     */
    public function mailsend(Request $request){
        if(!empty($request['from']) && !empty($request['to']) && !empty($request['content']) && !empty($request['userId']) && !empty($request['subject'])){

            $data = array("from" => $request['from'], "to" => $request['to'], "content" => $request['content'], "subject" => $request['subject']);
            Mail::send(array(), array(), function ($message) use ($data) {
                $message->to($data['to'])->from($data['from'], 'Nabu Learning')
                ->subject($data['subject'])
                ->setBody($data['content'], 'text/html');
            });

            return response()->json(["success" => true]);
        } else
            return response()->json(["success" => false, "message" => "Missing Parameters."]);
    }

    /**
     * Insert mail send history.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function insertMailHistory(Request $request){
        if(!empty($request['from']) && !empty($request['model']) && !empty($request['process']) && !empty($request['result'])){
            $history = MailHistories::create([
                'senderId' => Auth::user()->id,
                'detail' => $request['process'],
                'modelId' => $request['model'],
                'result' => $request['result'],
                'created_time' => gmdate("Y-m-d\TH:i:s", time())
            ]);

            $mpdf = new MPdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir'=>storage_path('tempdir'), 'setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
            $mpdf->writeHTML('<p><b>Email process report : </b> '. $request['process'] . ' </p>');
            
            $model = MailTemplateModel::find($request['model']);
            $mpdf->writeHTML('<p><b>Email model : </b> '. ($model ? $model->name : '') . ' </p>');

            $mpdf->writeHTML('<p><b>Sender : </b> '. $request['from'] . ' </p>');

            $mpdf->writeHTML('<p><b>Recipient : </b></p>');
            $mpdf->writeHTML(str_replace("<br>", "<wbr> </wbr>", $request['result']));
            $filelink = storage_path('pdf') . '/' . 'mail_result_' . $history->id . '.pdf';
            $mpdf->Output($filelink, 'F');

            return response()->json(["succes" => true]);
        } else
            return response()->json(["succes" => false]);
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MailImages;
use App\Models\MailTemplateModel;
use App\Models\MailHistories;
use App\Models\User;
use App\Models\SessionModel;

use Auth;
use Exception;
use ZipArchive;
use Mail;

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
        } else if($request['groupId']){
            $users = User::getUserFromGroup($request['id']);
        } else if($request['companyId']){
            $users = User::where('company', $request['companyId'])->get();
        } else if($request['studentId']){
            $users = array();
            $user = User::find($request['studentId']);
            if($user)
                $users[] = $user;
        } else if($request['teacherId']){
            $users = array();
            $user = User::find($request['teacherId']);
            if($user)
                $users[] = $user;
        } else if($request['authorId']){
            $users = array();
            $user = User::find($request['authorId']);
            if($user)
                $users[] = $user;
        } else
            $users = User::get();

        $fromAddress = '';
        if(Auth::user()->contact_info){
            $contact = json_decode(Auth::user()->contact_info);
            if($contact && $contact->email)
                $fromAddress = $contact->email;
        }
        return view('mail.view')->with('templates', $templates)->with('images', $images)->with('users', $users)->with('fromAddress', $fromAddress);
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
            1 =>'receiver_first',
            2 =>'detail',
            3 =>'created_time'
        );
        $totalData = MailHistories::count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new MailHistories;
        $handler = $handler->leftjoin('tb_users as senders', "senders.id", "=", "tb_mail_history.senderId")->leftjoin('tb_users as receivers', 'receivers.id', '=', 'tb_mail_history.receiverId');

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
                        'receivers.first_name as receiver_first',
                        'receivers.last_name as receiver_last',
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
                            ->orWhere('receivers.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('receivers.last_name', 'LIKE',"%{$search}%")
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
                                'receivers.first_name as receiver_first',
                                'receivers.last_name as receiver_last',
                                'tb_mail_history.detail as detail',
                                'tb_mail_history.created_time as created_time',
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                            $q->where('tb_mail_history.id','LIKE',"%{$search}%")
                            ->orWhere('senders.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('senders.last_name', 'LIKE',"%{$search}%")
                            ->orWhere('receivers.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('receivers.last_name', 'LIKE',"%{$search}%")
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
                $nestedData['receiver'] = $history->receiver_first . ' ' . $history->receiver_last;
                $nestedData['detail'] = $history->detail;
                $nestedData['created_time'] = $history->created_time;
                
                $nestedData['actions'] = "
                <div class='text-center'>
                    <button type='button' class='js-swal-confirm btn btn-danger mr-3' onclick='delHistory({$history['id']})' style='border-radius: 5px'>
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
                return response()->json(["success" => true, "data" => $template->data, "name" => $template->name]);
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
        if(!empty($request['id']) && !empty($request['name'])){
            $template = MailTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->name = $request['name'];
                $template->data = $request['data'];
                $template->save();
                return response()->json(["success" => true]);
            }
            else{
                $template = MailTemplateModel::create([
                    'creatorId' => Auth::user()->id,
                    'name' => $request['name'],
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
}

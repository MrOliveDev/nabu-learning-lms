<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use App\Models\GroupModel;
use App\Models\PositionModel;
use App\Models\CompanyModel;
use App\Models\ConfigModel;
use App\Models\LanguageModel;
use App\Models\SessionModel;
use App\Models\PermissionModel;
use App\Models\MailTemplateModel;
use App\Models\TemplateModel;
use App\Models\ReportsModel;
use App\Models\ReportTemplateModel;
use App\Models\ReportImages;
use App\Models\LessonsModel;
use App\Models\LessonCourses;
use App\Models\MailHistories;
use App\Models\MailImages;
use App\Models\TrainingsModel;

use DB;
use Mail;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;

/***
 * Class function: the functions that are contained in "/student" 
 */

class StudentController extends Controller
{
    public function index()
    {
        if(session("user_type") == 3){
            $students = SessionModel::getUserFromSessionByType(4);
            $teachers = SessionModel::getUserFromSessionByType(3);
            $authors = User::getUserPageInfo(2);
        } else {
            $students = User::getUserPageInfo(4);
            $teachers = User::getUserPageInfo(3);
            $authors = User::getUserPageInfo(2);
        }
        $groups = GroupModel::getGroupByClient();
        $positions = PositionModel::getPositionByClient();
        $companies = CompanyModel::getCompanyByClient();
        $languages = LanguageModel::all();
        $permissions = PermissionModel::where('show', 1)->get();

        $templates = MailTemplateModel::getMailTemplateByClient();

        $client = User::find(session('client'));
        if($client)
            $clientlang = $client->lang;
        else
            $clientlang = 1;

        return view('student', compact(['authors', 'teachers', 'students', 'groups', 'positions', 'companies', 'languages', 'permissions', 'templates', 'clientlang']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generator = new RequirementPasswordGenerator();

        $rand = "abcdefghijklmnopqrstuvwxyzAbCDEFGHIJKLMNOPQRSTUVWXYZ";

        $randName = substr(str_shuffle($rand), 0, 10);

        $generator
            ->setLength(8)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, true)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 1)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 3)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 3)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 3)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 3);
        $password = $generator->generatePassword();
        return response()->json([
            'name' => $randName,
            'password' => $password
        ]);
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

        $interfaceCfg = InterfaceCfgModel::create([
            'interface_color' => '',
            'interface_icon' => $request->post('base64_img_data'),
            'admin_id' => '1'
        ]);

        $contact_info = array(
            "address" => $request->post('contact_info'),
            'email' => $request->post('user-email')
        );
        if (null !== $request->post('position')) {
            $position = $request->post('position');
        }

        $user = User::create([
            'login' => $request->post('login'),
            'password' => base64_encode($request->post('password')),
            'first_name' => $request->post('first_name'),
            'last_name' => $request->post('last_name'),
            'contact_info' => json_encode($contact_info),
            'id_config' => $interfaceCfg->id,
            'status' => $request->input('user-status-icon'),
            'type' => $request->post('type'),
            'expired_date'=>$request->post('expired_date'),
            'permission_id'=>$request->post('permission')?$request->post('permission'):$request->post('type')
        ]);

        if (isset($request['company'])) {
            $user->company = $request->post('company');
        }
        if (isset($request['language'])) {
            $user->lang = $request->post('language');
        }else {
            $user->lang = 1;
        }
        if (isset($request['function'])) {
            $user->function = $request->post('function');
        }
        if ($request->post('generatepassword') != null) {
            $user->auto_generate = $request->post('generatepassword');
        }
        if ($request->post('permission') != null) {
            $user->permission_id = $request->post('permission')?$request->post('permission'):$request->post('type');
        }
        if (session("user_type") !== 0) {
            $user->id_creator = session("user_id");
        } else {
            $user->id_creator = session("client");
        }

        $user->creation_date = date("Y-m-d H:i:s");
        $user->update();

        // var_dump($user);exit;
        $lang= LanguageModel::where('language_id', $user->lang)->first();

        
        if($request->post("send_email")=="1"){
            $client = !empty(User::find(session("client"))->contact_info)?json_decode(User::find(session("client"))->contact_info)->email:null;
            $mail = $request->post('user-email');
            $template = MailTemplateModel::find($request->input("email_template"));
            $content = $template->data;
            $arr = explode("#first_name", $content);
            $content = implode($request->input("first_name"), $arr);
            $arr = explode("#last_name", $content);
            $content = implode($request->input("last_name"), $arr);
            $arr = explode("#username", $content);
            $content = implode($request->input("login"), $arr);
            $arr = explode("#password", $content);
            $content = implode($request->input("password"), $arr);
            if(!empty($client) && !empty($mail)){

                $data = array("from" => env("MAIL_FROM_ADDRESS"), "to" => $mail, "content" => $content, "subject" => "Welcome");
                try {
                    Mail::send(array(), array(), function ($message) use ($data) {
                        $message->to($data['to'])->from($data['from'], 'Nabu Learning')
                        ->subject($data['subject'])
                        ->setBody($data['content'], 'text/html');
                    });
                } catch (\Swift_TransportException  $e) {
                    return response()->json(['user'=>$user, 'lang'=>$lang->language_iso, 'mail_success'=>false]);
                } finally {
                    // print_r("this is f");
                    // return response()->json(['user'=>$user, 'lang'=>$lang->language_iso, 'mail_success'=>"f"]);
                }

                return response()->json(['user'=>$user, 'lang'=>$lang->language_iso, 'mail_success'=>true]);
            } else {
                return response()->json(['user'=>$user, 'lang'=>$lang->language_iso, 'mail_success'=>false]);
            }
        }
        return response()->json(['user'=>$user, 'lang'=>$lang->language_iso]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_info = User::getUserPageInfoFromId($id);
        // $session = SessionModel::select('name')->where('user_id',  $id)->get();

        return response()->json(['user_info' => $user_info /*, 'session' => $session */]);
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
        $user_info = User::getUserPageInfoFromId($id);
        // $session = SessionModel::select('session_name')->where('user_id',  $id)->get();

        return response()->json(['user_info' => $user_info /*, 'session' => $session */]);
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

        $user = User::find($id);
        $interface_cfg = null;
        if ($user->id_config == null || $user->id_config == '0') {
            $interface_cfg = InterfaceCfgModel::create([
                "interface_icon" => $request->input("base64_img_data"),
                'admin_id' => 1,
                'interface_color' => ''
            ]);
            if (InterfaceCfgModel::find($user->id_config) == null) {
                ConfigModel::create([
                    "id" => $interface_cfg->id,
                    "config" => ''
                ]);
            }
        } else if (InterfaceCfgModel::find($user->id_config) == null) {
            InterfaceCfgModel::create([
                'id' => $user->id_config,
                "interface_icon" => $request->input("base64_img_data"),
                'admin_id' => 1,
                'interface_color' => ''
            ]);
        } else {
            $interface_cfg = InterfaceCfgModel::find($user->id_config);
            $interface_cfg->interface_icon = $request->input("base64_img_data");
            $interface_cfg->update();
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->login = $request->input('login');
        if (isset($request['function'])) {
            $user->function = $request->input('function');
        }
        if (isset($request['company'])) {
            $user->company = $request->post('company');
        }
        if (isset($request['language'])) {
            $user->lang = $request->post('language');
        }
        if ($request->post('generatepassword')) {
            $user->auto_generate = $request->post('generatepassword');
        }
        $user->status = $request->input('user-status-icon');
        if ($request->input('password') != null) {
            $user->password = base64_encode($request->input('password'));
        }
        if ($user->contact_info != null) {
            $address = json_decode($user->contact_info);
            $address->address = $request->input('contact_info');
            $address->email = $request->input('user-email');
            $user->contact_info = json_encode($address);
        } else {
            $contact_info = array(
                "address" => $request->input('contact_info'),
                "email" => $request->input('user-email')
            );
            $user->contact_info = json_encode($contact_info);
        }
        if ($request->post('permission') != null) {
            $user->permission_id = $request->post('permission')?$request->post('permission'):null;
        }
        $user->expired_date=$request->post('expired_date');

        $user->update();
        $lang= LanguageModel::where('language_id', $user->lang)->first();
        return response()->json(['user'=>$user, 'lang'=>$lang->language_iso]);
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
        $user = User::find($id);

        $sessions = SessionModel::get();
        foreach($sessions as $session){
            if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_evaluation_{$session->id}")){
                $evals = DB::connection('mysql_historic')->select("SELECT id FROM `tb_evaluation_{$session->id}` WHERE user_id={$id}");
                DB::connection('mysql_historic')->delete("DELETE FROM `tb_evaluation_{$session->id}` WHERE user_id={$id}");
                if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_evaluation_question_{$session->id}")){
                    foreach($evals as $eval){
                        DB::connection('mysql_historic')->delete("DELETE FROM `tb_evaluation_question_{$session->id}` WHERE id_evaluation={$eval->id}");
                    }
                }
            }
            if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_screen_stats_{$session->id}"))
                DB::connection('mysql_historic')->delete("DELETE FROM `tb_screen_stats_{$session->id}` WHERE user_id={$id}");
            if(DB::connection('mysql_reports')->getSchemaBuilder()->hasTable("tb_screen_optim_{$session->id}"))
                DB::connection('mysql_reports')->delete("DELETE FROM `tb_screen_optim_{$session->id}` WHERE id_user_screen_optim={$id}");
            
            $participant_data = $session->participants;
            if (isset($participant_data) || $participant_data != "") {
                $participant = json_decode($participant_data);
                $studentList = isset($participant->s) ? $participant->s : array();
                $teacherList = isset($participant->t) ? $participant->t : array();
                $groupList = isset($participant->g) ? $participant->g : array();
                $newstudentList = array();
                $flag = false;
    
                if (isset($studentList) || $studentList != "") {
                    if (count($studentList) != 0) {
                        foreach ($studentList as $studentValue) {
                            if($studentValue != $id){
                                array_push($newstudentList, $studentValue);
                            } else {
                                $flag = true;
                            }
                        }
                    }
                }
                if($flag){
                    $newParticipant['s'] = $newstudentList;
                    $newParticipant['t'] = $teacherList;
                    $newParticipant['g'] = $groupList;
                    $session->participants = json_encode($newParticipant);
                    $session->update();
                }
            }
        }

        InterfaceCfgModel::where('id', $user->id_config)->delete();
        ConfigModel::where('id', $user->id_config)->delete();
        // User::drop_admin_table($id);

        // Delete Reports
        $reports = ReportsModel::where('id_creator', $id)->orWhere('studentId', $id)->get();
        foreach($reports as $report){
            if($report->filename && file_exists(storage_path('pdf') . '/' . $filename))
                unlink(file_exists(storage_path('pdf') . '/' . $filename));
            $report->delete();
        }
        ReportsModel::where('id_creator', $id)->delete();
        ReportsModel::where('studentId', $id)->delete();
        ReportTemplateModel::where('id_creator', $id)->delete();
        ReportImages::where('userId', $id)->delete();

        // Delete Companies
        CompanyModel::where('id_creator', $id)->delete();

        // Delete Groups
        GroupModel::where('id_creator', $id)->delete();

        // Delete Lessons
        $lessons = LessonsModel::where('idCreator', $id)->get();
        foreach($lessons as $lesson){
            LessonCourses::where('curso_id', $lesson->id)->delete();
        }
        LessonsModel::where('idCreator', $id)->delete();

        // Delete Mail Histories
        $histories = MailHistories::where('id_creator', $id)->orWhere('senderId', $id)->get();
        foreach($histories as $history){
            if(file_exists(storage_path('pdf') . "/mail_result_${$history->id}.pdf"))
                unlink(storage_path('pdf') . "/mail_result_${$history->id}.pdf");
            $history->remove();
        }
        MailTemplateModel::where('id_creator', $id)->delete();
        MailImages::where('userId', $id)->delete();

        // Delete Positions
        PositionModel::where('id_creator', $id)->delete();

        // Delete Sessions
        SessionModel::where('id_creator', $id)->delete();

        // Delete Templates
        $templates = TemplateModel::where('id_creator', $id)->get();
        foreach($templates as $template){
            DB::table('tb_template_html5')->where('alpha_id', $template->alpha_id)->delete();
            $template->delete();
        }

        // Delete Trainings
        TrainingsModel::where('id_creator', $id)->delete();

        // Delete users
        User::where('id_creator', $id)->delete();

        $user->delete();

        return response('successfully deleted!', 200);
        //
    }

    /**
     * Remove the multiple selected resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function multiDestroy(Request $request)
    {
        $ids = $request->post("data");

        User::whereIn("id", explode(",", $ids))->delete();

        return response('successfully deleted!', 200);
        //
    }

    /**
     * Joing the user item to group 
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response 
     */
    public function userJoinToGroup(Request $request)
    {
        $responseData = [];
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $value) {
                $user = User::find($value->id);

                $user->linked_groups = $value->target;

                $user->update();

                array_push($responseData, $user);
            }
        }
        return response()->json($responseData);
    }

    /**
     * Join the user items to any company
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function userJoinToCompany(Request $request)
    {
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $key => $value) {
                $user = User::find($value->id);

                $user->company = $value->target;

                $user->update();
            }
        }

        return response()->json($user);
    }

    /**
     * Join the user items to any function(position)
     * 
     * @param Request $request
     * @return \Illumate\Http\Response
     */
    public function userJoinToPosition(Request $request)
    {
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $key => $value) {
                $user = User::find($value->id);

                $user->function = $value->target;

                $user->update();
            }
        }

        return response()->json($user);
    }

    /**
     * Get session that contains the selected user
     * 
     * @param Request $reqeust
     * @return \Illuminate\Http\Response
     */
    public function getSessionFromUser(Request $request) {
        $sessionModel = new SessionModel;
        $sessions = $sessionModel->getSessionFromUser($request->post("data"));

        $sessionArray = array();
        foreach($sessions as $session) {
            $sessionItem = SessionModel::find($session);
            if(isset($sessionItem)){
                array_push($sessionArray, $sessionItem);
            }
        }
        return response()->json($sessionArray);
    }
    
    /**
     * Analyze CSV file and return content as array 
     *
     * @param  Request $request
     * @return JSON
     */
    public function getCSV(Request $request){
        $temp_path = $_FILES["import-file"]["tmp_name"];
        
        $separator  = $request['separator_man']!="" ? $request['separator_man']:"";
        $separator  = $separator=="" ? $request['separator']:$separator;
        $header     = $request['header'];
        
        $file_datas = $this->csvToArray($temp_path, $separator, !$header);
        if($file_datas == false)
            return response()->json(["success" => false, "message" => "Error while parsing csv file."]);
        else
            return response()->json(["success" => true, "data" => $file_datas]);
    }

    /**
     * 
     * @param string $file
     * @param string $separator 
     * @param boolean $header If the file's firstline conntains titles
     * @return type
     * @throws Exception
     */
    private function csvToArray($file, $separator, $header) {
        $rows = array();
        $headers = array();
        if (file_exists($file) && is_readable($file)) {
            $handle = fopen($file, 'r');
            while (!feof($handle)) {
                $row = fgetcsv($handle, 10240, $separator, '"');
                if ($header && empty($headers)) {
                    $headers = $row;
                } else if (is_array($row)) {
                    foreach ($row as $key => $value) {                        
                        $row[$key] = utf8_encode($value);
                    }
                    if ($header){
                        array_splice($row, count($headers));
                        $rows[] = array_combine($headers, $row);
                    } else {
                        $rows[] = $row;
                    }
                }
            }
            fclose($handle);
        } else {
            return false;
        }
        return $rows;
    }

    /**
     * Import CSV Users to DB
     *
     * @param  Request $request
     * @return JSON
     */
    public function importCSV(Request $request){
        if(!empty($request['fields']) && !empty($request['users']) && !empty($request['options'])){
            $fields = $request['fields'];
            $loginIdx = array_search('login', $fields);

            $check = false;
            foreach($request['users'] as $values){
                $idx = 0;
                if($loginIdx === false){
                    $user = new User;
                } else {
                    $login = $values[$loginIdx];
                    $user = User::where('login', $login)->first();
                    if(!$user)
                        $user = new User;
                    else if($request['forceupdate'] == "false"){
                        $check = true;
                        break;
                    }
                }

                foreach($values as $fieldvalue){
                    if($fields[$idx] == 'login'){
                        $user->login = $fieldvalue;
                    } else if($fields[$idx] == 'password'){
                        $user->password = base64_encode($fieldvalue);
                    } else if($fields[$idx] == 'name'){
                        $user->first_name = $fieldvalue;
                    } else if($fields[$idx] == 'surname'){
                        $user->last_name = $fieldvalue;
                    } else if($fields[$idx] == 'email'){
                        if($user->contact_info){
                            $contact_info = json_decode($user->contact_info);
                            $contact_info->email = $fieldvalue;
                            $user->contact_info = json_encode($contact_info);
                        } else {
                            $user->contact_info = json_encode(array("email" => $fieldvalue));
                        }
                    } else if($fields[$idx] == 'address'){
                        if($user->contact_info){
                            $contact_info = json_decode($user->contact_info);
                            $contact_info->address = $fieldvalue;
                            $user->contact_info = json_encode($contact_info);
                        } else {
                            $user->contact_info = json_encode(array("address" => $fieldvalue));
                        }
                    }

                    $idx ++;
                }

                if($request['options']['generate'] == "1"){
                    $user->login = $this->generateLogin($user->first_name, $user->last_name);
                    $user->password = base64_encode($this->randomGenerate());
                }
                if($request['options']['pw'])
                    $user->change_pw = 1;
                if($request['options']['language'])
                    $user->lang = $request['options']['language'];
                if($request['options']['group']){
                    if($user->linked_groups){
                        $groups = explode(",", $user->linked_groups);
                        $groups[] = $request['options']['group'];
                        $user->linked_groups = implode(",", $groups);
                    } else{
                        $groups = array($request['options']['group']);
                        $user->linked_groups = implode(",", $groups);
                    }
                }
                if($request['options']['company'])
                    $user->company = $request['options']['company'];
                if($request['options']['position'])
                    $user->function = $request['options']['position'];

                $user->save();
            }

            if($check)
                return response()->json(["success" => true, "message" => "Some logins are already exist. Others are imported successfully."]);
            else
                return response()->json(["success" => true]);
        } else
            return response()->json(["success" => false, "message" => "Wrong Paramters."]);
    }

    /**
     * 
     * @param string $name
     * @param string $surname
     * @return string
     */
    public function generateLogin($name, $surname) {
        //echo "name:".$name." | surname:".$surname."\n";
            // $login_name     = substr($name, 0, 3);
            // $login_surname  = substr($surname, 0, 3);
            // $login          = $login_name.$login_surname;
            // $login_clean    = preg_replace('/\s+/', '', $login);
            // $login_cod      = $login_clean.$this->randomGenerate(4);
            // $check = User::where('login', $login_cod)->first();
            // if(!$check){
            //     return $login_cod;
            // } else {
            //     return $this->generateLogin($name,$surname);
            // }
            $login_cod      = $this->randomGenerate(10);
            $check = User::where('login', $login_cod)->first();
            if(!$check){
                return $login_cod;
            } else {
                return $this->generateLogin($name,$surname);
            }
        }

    /**
     * 
     * @param int $car
     * @return string
     */
    public function randomGenerate($car=8) {
        $string = "";
        $chaine = "ABCDEFGHIJQLMNOPQRSTUVWXYZabcdefghijqlmnopqrstuvwxyz0123456789";
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < $car; $i++) {
            $string .= $chaine[rand() % strlen($chaine)];
        }
        return $string;
    }    

    public function getPPTConfig(Request $request, $id) {
        $user = User::find($id);
        if(isset($user->id_config)){
            $config = ConfigModel::find($user->id_config);
            if(isset($config)){
                return response()->json(["success"=>true, "allowed"=>($config->config==1)]);
            } else {
                return response()->json(["success"=>false, "allowed"=>false]);
            }

        } else {
            return response()->json(["success"=>false, "allowed"=>false]);
        }
    }
}

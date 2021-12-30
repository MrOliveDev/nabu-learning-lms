<?php

namespace App\Http\Controllers;

use App\Models\CursoModel;
use Illuminate\Http\Request;
use App\Models\LessonsModel;
use App\Models\TrainingsModel;
use App\Models\SessionModel;

use SimpleXMLElement;
use Exception;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = LessonsModel::getLessonByClient();

        return response()->json($lessons);
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
        $lesson = new LessonsModel();

        if ($request->post('lesson_name')) {
            $lesson->name = $request->post('lesson_name');
        }
        if ($request->post('lesson_duration')) {
            $lesson->duration = $request->post('lesson_duration');
        }
        if ($request->post('lesson_description')) {
            $lesson->description = $request->post('lesson_description');
        }
        if ($request->post('lesson_enddate')) {
            $lesson->date_end = $request->post('lesson_enddate');
        }
        if ($request->post('lesson_target')) {
            $lesson->publicAudio = $request->post('lesson_target');
        }
        if ($request->post('lesson_language')) {
            $lesson->lang = $request->post('lesson_language');
        }
        if ($request->post('lesson_status')) {
            $lesson->status = $request->post('lesson_status');
        }
        if ($request->post('upload-group-status')) {
            $lesson->upload_group_status = $request->post('upload-group-status');
        }
        if ($request->post('upload-person-status')) {
            $lesson->upload_person_status = $request->post('upload-person-status');
        }
        if ($request->post('threshold-score')) {
            $lesson->threshold_score = $request->post('threshold-score');
        }
        if (session("user_type") !== 0) {
            $lesson->idCreator = session("user_id");
        } else {
            $lesson->idCreator = session("client");
        }
        $lesson->idFabrica = $this->randomGenerate();
        $lesson->save();

        // $curso = new CursoModel();

        // if ($request->post('lesson_name')) {
        //     $curso->nome = $request->post('lesson_name');
        // }
        // if ($request->post('lesson_description')) {
        //     $curso->descricao = $request->post('lesson_description');
        // }
        // if ($request->post('lesson_enddate')) {
        //     $curso->dataCriacao = $request->post('lesson_enddate');
        // }
        // if ($request->post('lesson_target')) {
        //     $curso->publicoAlvo = $request->post('lesson_target');
        // }
        // if ($request->post('lesson_status')) {
        //     $curso->status = $request->post('lesson_status');
        // }
        // if ($request->post('threshold-score')) {
        //     $curso->threshold_score = $request->post('threshold-score');
        // }
        // $curso->idFabrica = $lesson->idFabrica;
        // $curso->idCriador = 1;
        // $curso->save();

        $this->createCourse($lesson->name, $lesson->idFabrica);

        return response()->json(LessonsModel::getLessonContainedTraining($lesson->id));
        //
    }

    /**
    * 
    * @param type $array
    * @return XML
    */
    private function createCourse($name, $productId) {
        //echo "--createCourse--"."<br>\n";
        //$course = parent::create ( $array );
        //echo "createCourse\n";
        // foreach ($array as $item) {
        //     if ($item[name] == "nome") {
        //         $name = $item[value];
        //     }
        //     if ($item[name] == "idFabrica") {
        //         $productId = $item[value];
        //     }
        // }
        //echo "name:".$name;
        //echo "productId:".$productId;
 
        $config = new SimpleXMLElement('<project></project>');
        $config->addAttribute('code', $productId);
        $config->addAttribute('label', $name);
        $n = $config->addChild('languages');
        $n->addChild('lang', session('language'));
        $t = $config->addChild('lessonPlan');
        $t->addAttribute('id', '0');
        $n2 = $t->addChild('title');
        $n2->addChild(session('language'), 'Menu Principal');
        //    Header('Content-type: text/xml');
        //    echo $config->asXML();
 
        $values = array('request' => '
         <request>
             <method>ProductCreate</method>
             <params>
                 <param name="code">' . $productId . '</param>
                 <param name="label">' . $name . '</param>
                 <param name="config"><![CDATA[' . $config->asXML() . ']]> </param>
             </params>
         </request>');
 
        //var_dump($values);
        $return = $this->doPostRequest(env('FABRIQUE_URL'), $values);
 
        //var_dump($return);
        return $return;
    }

    public function deleteCourse($productId) {
        $values = array('request' => '
                                        <request>
                                            <method>ProductDelete</method>
                                            <params>
                                                <param name="code">' . $productId . '</param>
                                            </params>
                                        </request>');
        $delete = $this->doPostRequest(env('FABRIQUE_URL'), $values);

        return $delete;
    }

    /**
     * 
     * @param type $url
     * @param type $data
     * @param type $optional_headers
     * @return \SimpleXMLElement
     * @throws Exception
     */
    private function doPostRequest($url, $data, $optional_headers = null) {
        $params = array(
            "http" => array(
                "method" => "POST",
                "content" => http_build_query($data)
            )
        );
        if ($optional_headers !== null) {
            $params["http"]["header"] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, "rb", false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url");
        }
        $xml = new SimpleXMLElement($response);
        return $xml;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = LessonsModel::getLessonForTrainingpage($id);
        $Alltrainings = TrainingsModel::getTrainingByClient();
        $sessions = SessionModel::getSessionPageInfo();
        $trainings = array();
        foreach ($Alltrainings as $training) {
            $session_linked = false;
            $session_status = 0;
            foreach ($sessions as $session) {
                if($training->id == $session->contents){
                    $session_linked = true;
                    if($session->status == 1){
                        $session_status = 1;
                    }
                }
            }
           array_push($trainings, ["training"=>$training, "session_linked"=>$session_linked, "session_status"=>$session_status]);
        }


        $session_linked = false;
        $session_status = 0;
            foreach ($trainings as $training) {
                if($training["session_linked"] == true){
                    if ($training['training']->lesson_content) {
                        $lessonList = json_decode($training['training']->lesson_content, true);
                        if ($lessonList != NULL) {
                            foreach ($lessonList as $value) {
                                if ($lesson['id'] == $value['item']) {
                                    $session_linked = true;
                                    if($training["session_status"] == 1){
                                        $session_status = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }

        return response()->json(["lesson"=>$lesson, "session_linked"=>$session_linked, "session_status"=>$session_status]);
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
        $lesson = LessonsModel::find($id);

        if ($request->post('lesson_name')) {
            $lesson->name = $request->post('lesson_name');
        }
        if ($request->post('lesson_duration')) {
            $lesson->duration = $request->post('lesson_duration');
        }
        if ($request->post('lesson_description')) {
            $lesson->description = $request->post('lesson_description');
        }
        if ($request->post('lesson_enddate')) {
            $lesson->date_end = $request->post('lesson_enddate');
        }
        if ($request->post('lesson_target')) {
            $lesson->publicAudio = $request->post('lesson_target');
        }
        if ($request->post('lesson_language')) {
            $lesson->lang = $request->post('lesson_language');
        }
        if ($request->post('lesson_status')) {
            $lesson->status = $request->post('lesson_status');
        }
        if ($request->post('upload-group-status') != NULL) {
            $lesson->upload_group_status = $request->post('upload-group-status');
        }
        if ($request->post('upload-person-status') != NULL) {
            $lesson->upload_person_status = $request->post('upload-person-status');
        }
        if ($request->post('threshold-score')) {
            $lesson->threshold_score = $request->post('threshold-score');
        }
        $lesson->update();

        // $curso = CursoModel::find($id);
        // if (isset($curso)) {
        //     if ($request->post('lesson_name')) {
        //         $curso->nome = $request->post('lesson_name');
        //     }
        //     if ($request->post('lesson_description')) {
        //         $curso->descricao = $request->post('lesson_description');
        //     }
        //     if ($request->post('lesson_target')) {
        //         $curso->publicoAlvo = $request->post('lesson_target');
        //     }
        //     if ($request->post('lesson_status')) {
        //         $curso->status = $request->post('lesson_status');
        //     }
        //     if ($request->post('threshold-score')) {
        //         $curso->threshold_score = $request->post('threshold-score');
        //     }
        //     $curso->update();
        // }

        $this->updateProduct($lesson->idFabrica, $lesson->name);

        return response()->json(LessonsModel::getLessonContainedTraining($lesson->id));
        //
    }

    private function updateProduct($productId, $name) {
        $values = array(
            'request' => '  <request>
                                <method>ProductRead</method>
                                <params>
                                    <param name="code">' . $productId . '</param>
                                </params>
                            </request>'
        );

        $return         = $this->doPostRequest(env('FABRIQUE_URL'), $values);
        
        $return_read    = get_object_vars($return);
        if ($return_read['@attributes']['type'] == "error") {
            $error = array("error" => "product can't be red > ".$return_read['message']);
            return $error;
        } else {
            $return_vars    = get_object_vars($return);
            $product        = get_object_vars($return_vars["product"]);
            $prd_config     = $product["config"];
            
            $project = new SimpleXMLElement($prd_config);
            $project->attributes()->label   = $name;
            $project->attributes()->code    = $productId;
            $project->languages->lang ->attributes()->productName = $name;
    
            $project->asXML();
    
            // Update product infos
            $values = array(
                'request' => '  <request>
                                    <method>ProductUpdate</method>
                                    <params>
                                        <param name="code">' . $productId . '</param>
                                        <param name="label">' . $name . '</param>
                                        <param name="config"><![CDATA[' . $project->asXML() . ']]> </param>
                                    </params>
                                </request>'
            );

            $return = $this->doPostRequest(env('FABRIQUE_URL'), $values);

            $return_update    = get_object_vars($return);
            if ($return_update['@attributes']['type'] == "error") {
                return array("error" => "nt> Product can't be updated > ".$return_update['message']);
            } else {
                return true;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = LessonsModel::where("idFabrica", $id)->first();
        
        $trainings=TrainingsModel::all();
        foreach ($trainings as $training) {            
            $arr=$training->lesson_content;
            $value=json_decode($arr);
            $temp=[];
            
            if($value){
                foreach($value as $ar) {
                    if(isset($ar->item) && $ar->item!=$lesson->id) {
                        array_push($temp, ["item"=>$ar->item]);	
                    }
                }
            }
            $training->lesson_content = json_encode($temp);
            $training->update();
        }
        
        $lesson->delete();
        $this->deleteCourse($id);
        
        return response()->json($id);
        //
    }

    public function getTrainingFromLesson($id)
    {
        $templesson = LessonsModel::getLessonContainedTraining($id);
        if (isset($templesson['training'])) {
            $trainingList = [];
            foreach ($templesson['training'] as $trainingId) {
                if (TrainingsModel::find($trainingId)) {
                    $trainingItem = TrainingsModel::getTrainingForTrainingpage($trainingId);
                    if(!empty($trainingItem)) {
                        if (!in_array($trainingItem, $trainingList)) {
                            if(auth()->user()->type == 0){
                                if($trainingItem->id_creator == session("client")) {
                                    array_push($trainingList, $trainingItem);
                                }
                            } else {
                                if($trainingItem->id_creator == session("client") || $trainingItem->id_creator == user()->auth()->id) {
                                    array_push($trainingList, $trainingItem);
                                }
                            }
                        }
                    }
                }
            }

            $response = json_encode([
                'isSuccess' => true,
                'data'  => $trainingList
            ]);

            return $response;
            // return response()->json($trainingList);
        } else {
            return response()->json([]);
        }
    }

    public function randomGenerate($car = 8)
    {
        $string = "";
        $chaine = "ABCDEFGHIJQLMNOPQRSTUVWXYZ0123456789";
        srand((float) microtime() * 1000000);
        for ($i = 0; $i < $car; $i++) {
            $string .= $chaine[rand() % strlen($chaine)];
        }
        return $string;
    }

    public function duplicateLesson(Request $request) {
        $lesson = LessonsModel::find($request->post('id'));
        $newlesson = new LessonsModel();

        if ($request->post('name')) {
            $newlesson->name = $request->post('name');
        }
        if ($lesson->duration) {
            $newlesson->duration = $lesson->duration;
        }
        if ($lesson->description) {
            $newlesson->description = $lesson->description;
        }
        if ($lesson->date_end) {
            $newlesson->date_end = $lesson->date_end;
        }
        if ($lesson->publicAudio) {
            $newlesson->publicAudio = $lesson->publicAudio;
        }
        if ($lesson->lang) {
            $newlesson->lang = $lesson->lang;
        }
        if ($lesson->status) {
            $newlesson->status = $lesson->status;
        }
        if ($lesson->upload_group_status) {
            $newlesson->upload_group_status = $lesson->upload_group_status;
        }
        if ($lesson->upload_person_status) {
            $newlesson->upload_person_status = $lesson->upload_person_status;
        }
        if ($lesson->threshold_score) {
            $newlesson->threshold_score = $lesson->threshold_score;
        }
        if (session("user_type") !== 0) {
            $newlesson->idCreator = session("user_id");
        } else {
            $newlesson->idCreator = session("client");
        }
        $newlesson->idFabrica = $this->randomGenerate();
        $newlesson->save();

        // $this->createCourse($newlesson->name, $newlesson->idFabrica);
        $values = array('request' => '
        <request>
            <method>ProductDuplicate</method>
            <params>
                <param name="source">' . $lesson->idFabrica . '</param>
                <param name="newcode">' . $newlesson->idFabrica . '</param>
                <param name="label">' . $newlesson->name . '</param>
            </params>
        </request>');

        $return = $this->doPostRequest(env('FABRIQUE_URL'), $values);
        $return_update = get_object_vars($return);
        // if ($return_update['@attributes']['type'] == "error") {
        //     return array("error" => "nt> Product can't be updated > ".$return_update['message']);
        // } else {
        // }
        return response()->json(LessonsModel::getLessonContainedTraining($newlesson->id));

    }
}

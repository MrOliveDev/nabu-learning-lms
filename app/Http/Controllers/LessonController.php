<?php

namespace App\Http\Controllers;

use App\Models\CursoModel;
use Illuminate\Http\Request;
use App\Models\LessonsModel;
use App\Models\TrainingsModel;

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
        //var_dump($xml);
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

        return response()->json($lesson);
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
        $lesson = LessonsModel::find($id);

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
}

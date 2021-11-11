<?php

namespace App\Http\Controllers;

use App\Models\LessonsModel;
use Illuminate\Http\Request;
use App\Models\TrainingsModel;
use App\Models\LanguageModel;
use App\Models\TemplateModel;

use SimpleXMLElement;
use App\Models\LessonCourses;

define("PRODUCTS_FABRIQUE_PATH", "/home/sites/default/www/export_fabrique/products/");
define("PRODUCTS_ONLINE_PATH", "/home/sites/default/www/export_online/");

use Auth;
use ZipArchive;
use Mail;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Exception;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = TrainingsModel::getTrainingByClient();
        $lessons = LessonsModel::getLessonsContainedTraining();
        $languages = LanguageModel::all();
        $templates = TemplateModel::getTemplateByClient();
        return view('training')->with(compact('trainings', 'lessons', 'languages', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $training = new TrainingsModel();
        if ($request->post('training_name') != NULL) {
            $training->name = $request->post('training_name');
        }
        if ($request->post('training_description') != NULL) {
            $training->description = $request->post('training_description');
        }
        if ($request->post('training_enddate') != NULL) {
            $training->date_end = $request->post('training_enddate');
        }
        if ($request->post('training_language') != NULL) {
            $training->lang = $request->post('training_language');
        }
        if ($request->post('training-status-icon') != NULL) {
            $training->status = $request->post('training-status-icon');
        }
        if ($request->post('training_type') != NULL) {
            $training->type = $request->post('training_type');
        }
        if ($request->post('base64_img_data') != NULL) {
            $training->training_icon = $request->post('base64_img_data');
        }
        // if ($request->post('name') != NULL) {
        //     $training->name = $request->post('name');
        // }
        // if ($request->post('description') != NULL) {
        //     $training->description = $request->post('description');
        // }
        if ($request->post('cate-status-icon') != NULL) {
            $training->status = $request->post('cate-status-icon');
        }
        if ($request->post('training_duration') != NULL) {
            $training->duration = $request->post('training_duration');
        }
        if (auth()->user()->type !== 0) {
            $training->id_creator = auth()->user()->id;
        } else {
            $training->id_creator = session("client");
        }
        $training->save();
        return response()->json(TrainingsModel::getTrainingForTrainingpage($training->id));
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
        $training = TrainingsModel::find($id);

        return response()->json($training);
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
        $training = TrainingsModel::find($id);
        if ($request->post('training_name')) {
            $training->name = $request->post('training_name');
        }
        if ($request->post('training_description') || $request->post('training_description') =='') {
            $training->description = $request->post('training_description');
        }
        if ($request->post('training_enddate')) {
            $training->date_end = $request->post('training_enddate');
        }
        if ($request->post('training_language')) {
            $training->lang = $request->post('training_language');
        }
        if ($request->post('training-status-icon')) {
            $training->status = $request->post('training-status-icon');
        }
        if ($request->post('training_type')) {
            $training->type = $request->post('training_type');
        }
        if ($request->post('base64_img_data')) {
            $training->training_icon = $request->post('base64_img_data');
        }
        // if ($request->post('name')) {
        //     $training->name = $request->post('name');
        // }
        // if ($request->post('description')) {
        //     $training->description = $request->post('description');
        // }
        if ($request->post('training_duration') != NULL) {
            $training->duration = $request->post('training_duration');
        }
        if ($request->post('cate-status-icon') != NULL) {
            $training->status = $request->post('cate-status-icon');
        }
        $training->update();

        return response()->json($training);
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
        $training = TrainingsModel::find($id);

        $training->delete();

        return response()->json($id);
        //
    }

    public function trainingLinkFromLesson(Request $request)
    {
        $training = TrainingsModel::find($request->post('id'));
        $training->lesson_content = $request->post('target');
        $training->update();
        return response()->json($training);
    }

    public function trainingUpdateType(Request $request)
    {
        $training = TrainingsModel::find($request->post('id'));
        $training->type = $request->post('type');
        $training->update();
        return response()->json($training);
    }

    public function getLessonFromTraining($id)
    {
        $training = TrainingsModel::getTrainingForTrainingpage($id);

        $lessons = [];
        if ($training->lesson_content) {
            $lessonList = json_decode($training->lesson_content, true);
            if ($lessonList != NULL) {
                foreach ($lessonList as $value) {
                    if (LessonsModel::find($value['item'])) {
                        $lessonContained = LessonsModel::getLessonContainedTraining($value['item']);
                        if($lessonContained!=null){
                            if (!in_array($lessonContained, $lessons)) {
                                array_push($lessons, $lessonContained);
                            }
                        }
                    }
                }
            }
        }

        return json_encode([
            'isSuccess' => true,
            'data'  => $lessons
        ]);
    }

    private function getListCourses($list)
    {

        $courses_list = array();
        foreach ($list as $item) {
            $new_item               = $item;
            $new_item['fabrique']   = $this->courseCheckFolders($item['idFabrica'], "fabrique");
            $new_item['online']     = $this->courseCheckFolders($item['idFabrica'], "online");
            $new_item['routeId']    = $this->getRouteId($item['idFabrica']);

            $courses_list[]         = $new_item;
        }
        return $courses_list;
    }

    private function courseCheckFolders($product_id, $type)
    {
        $path       = $type == "fabrique" ? $type . '/products' : $type;
        $folder = "/home/sites/default/www/export_$path/$product_id/";
        $exist  = file_exists($folder);
        return $exist;
    }

    public function getRouteId($datas)
    {
        $languageModel = new LanguageModel;
        $paths = array("fabrique" => PRODUCTS_FABRIQUE_PATH, "online" => PRODUCTS_ONLINE_PATH);
        $fabrique = false;
        $online = false;
        $types = array();
        foreach ($paths as $key => $path) {

            $dir = $path . $datas['productid'] . '/courses/';
            $files = scandir($dir);
            $langs = array();
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $file_arr = explode('_', $file);
                    $iso = $file_arr[2];
                    $course = $file_arr[1];
                    $langs[] = array("id" => $languageModel->get_language_id($iso), "iso" => $iso, "course" => $course, "name" => $languageModel->get_language_name($iso));
                    if ($key == "fabrique") {
                        $fabrique = true;
                    }
                    if ($key == "online") {
                        $online = true;
                    }
                }
            }
            if (count($langs) > 0) {
                $types[] = $langs;
            }
        }
        $types["fabrique"]  = $fabrique;
        $types["online"]    = $online;
        return $types;
    }

    /**
     * Generate Scorm and return zip file, and send email.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function generateScorm(Request $request){
        error_reporting(0);
        $zip = NULL;
        try{
            // Check the parameters
            if (!isset($request['trainingId'])) {
                return response()->json(["success" => false, "message" => "Empty training id."]);
            }
            $trainingId = $request['trainingId'];

            // Read the formation
            $training = TrainingsModel::find($trainingId);
            if(!$training)
                return response()->json(["success" => false, "message" => "Cannot find training."]);

            // Read the courses
            $lessons = [];
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

            // Create the destination folder if not exists
            $destFolder = env('EXPORT_SCORM_PATH');
            if (!is_dir($destFolder)) {
                mkdir($destFolder);
            }

            // Calculate the export filename
            $prefixFilename  = Auth::user()->login . '_training_' . $trainingId . '_';
            $filename  = $prefixFilename . date('dmYHis') . '.zip';

            // Clean the destination folder
            $limit = strtotime("-7 days");
            $files = scandir($destFolder);
            foreach ($files as $file) {
                if ($file==='.' || $file==='..') continue;
                $filepath = realpath($destFolder.'/'.$file);
                // If the file is too old, we remove it
                if (filemtime($filepath) <= $limit) {
                    unlink($filepath);
                } else if ( strpos($file, $prefixFilename) === 0 ) {    // If the file have same prefix than the new export, we remove it
                    unlink($filepath);
                }
            }

            // Create the zip archive
            $destination = $destFolder . $filename;
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE ) !== true) {
                $zip = NULL;
                return response()->json(["success" => false, "message" => "Scorm Export Folder Permission Not Granted."]);
            }

            // Copy the template
            //$this->addFolderToZip($zip, SERVER_ROOT.'/templates/'.$template['template_code'], 'template');

            // Copy the player
            $this->addFolderToZip($zip, env('SERVER_ROOT').'/templates/ngscorm/player-template');

            // For each courses, add the course folder
            $builtLessons = array();
            foreach ($lessons as $lesson) {
                $folderSource = realpath(env('PRODUCTS_ONLINE_PATH') . '/' . $lesson['idFabrica']);
                if($folderSource===false) continue;
                // Copy the course folder (aka product)
                $this->addProductToZip($zip, $folderSource, $lesson['idFabrica']);
                // Build the index for the course
                $indexFile = "index_".$lesson['idFabrica'].".html";
                $lessonData = array_merge($lesson, array(
                    "indexfile" => $indexFile
                ));
                $builtLessons[] = $lessonData;
                $lessonId = $lesson['idFabrica'];
                $content = (string)view('scorm.index')->with(compact('lessonId'));
                $zip->addFromString($indexFile, $content);
            }

            // Build the manifest
            $manifest = (string)view('scorm.imsmanifest')->with(compact('training', 'builtLessons'));
            $zip->addFromString('imsmanifest.xml', $manifest);

            // Build playerdata.json
            $templateId = $request['template_player'];
            $playerdata = (string)view('scorm.playerdata')->with(compact('templateId'));
            $zip->addFromString('assets/playerdata.json', $playerdata);

            //Build userConfig.json
            $threshold_score = $request['threshold_score'];
            $eval_attempts = $request['eval_attempts'];
            $userconfig = (string)view('scorm.userConfig')->with(compact('threshold_score', 'eval_attempts'));
            $zip->addFromString('assets/userConfig.json', $userconfig);

            //Build template json file
            $template = TemplateModel::find($request['template_player']);
            $template->style = unserialize( $template->style );
            $return = array('datas' => $template);
            $zip->addFromString('assets/template/'.$template->alpha_id.'.json', json_encode($return));

            // Close the archive
            $zip->close();
            $zip = NULL;

            // Send email
            $to = '';
            if(Auth::user()->contact_info){
                $contact = json_decode(Auth::user()->contact_info);
                if($contact && $contact->email)
                    $to = $contact->email;
            }
            $data = ["username" => Auth::user()->first_name . ' ' . Auth::user()->last_name, "link" => env('APP_URL') . "/scorm/" . $filename];

            Mail::send('scorm.mail', $data, function ($m) use ($to) {
                $m->from(env('MAIL_FROM_ADDRESS'), 'Nabu Learning')->to($to)->subject('Votre package SCORM est prêt à être téléchargé');
            });

            return response()->json(["success" => true]);
        } catch (Exception $e) {
            if($zip !== NULL) {
                $zip->close();
            }
            return response()->json(['success' => false, 'message'=>$e->getMessage()]);
        }
    }

    private function addFolderToZip(ZipArchive $zip, $folder, $prefix = '') {
        $folder = realpath($folder);
        if ( $folder === FALSE || !is_dir($folder) ) return FALSE;
        if($prefix !=='') $prefix = rtrim($prefix, '/').'/';

        $dIterator = new RecursiveDirectoryIterator($folder);
        $files = new RecursiveIteratorIterator($dIterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file) {
            if($file->getBasename()==='.' || $file->getBasename()==='..') continue;
            if($file->isDir()) continue;

            // Ignore xml, flv files
            $extension = $file->getExtension();
            if($extension == 'flv' || $extension == 'xml')
                continue;

            $filename = $file->getPathname();
            if(is_dir($filename)) continue;
            $destname = $prefix . str_replace($folder.'/', '', $filename);

            $zip->addFile($filename, $destname);
        }

        return TRUE;
    }

    private function addProductToZip(ZipArchive $zip, $folder, $idProduct) {
        $this->addFolderToZip($zip, $folder.'/content', 'assets/'.$idProduct.'/content');
        $this->addCoursesToZip($zip, $folder, $idProduct);
    }

    private function addCoursesToZip(ZipArchive $zip, $folder, $productId) {
        require_once(__DIR__.'/../../../html5_player_api/app/course/inc/contentsCourse.class.php');
        require_once(__DIR__.'/../../../html5_player_api/app/course/inc/courseProcessor.fnc.php');

        $lang = null;
        $chaptersList = array();
        $toKnowMoreList = array();
        $documentList = array();
        $return = array();
        $return['state'] = 'success';
        $return['productId'] = $productId;
        $return['dateCreate'] = date("m.d.y H:i");
        $return['msg'] = 'Le cours '.$productId.' existe bien.';
        $return['datas'] = array();
        $return['datas']['label'] = null;
        $return['datas']['lang'] = null;
        $return['datas']['start'] = null;
        $return['datas']['courses'] = null;

        $pathDefault = env('PRODUCTS_ONLINE_PATH');
        $urlDefault = env('PRODUCTS_ONLINE_URL');

        $fileUrl = $folder.'/configuration/product.xml';
        $courseName = "";
        $xmlParent = generateXml($fileUrl);
        if($xmlParent->courses){
            foreach($xmlParent->courses->course as $c){
                $lang = (string)$c->attributes()->lang;
                $courseId = (string)$c->attributes()->id;
                $courseName = (string)$c->attributes()->name;
                
                $tempDatas = array();
                $tempDatas['pathFolder'] = $pathDefault;
                $tempDatas['productId'] = $productId;
                $tempDatas['courseId'] = $courseId;
                $tempDatas['contentId'] = null;
                $tempDatas['lang'] = null;

                $fileUrl = fileUrl("courses", $tempDatas);
                $fileUrl = str_replace("//","/",$fileUrl);
                $tempDatas = null;
                if($fileUrl == null) break;

                $fullDatas = array(); 
                $xml = generateXml($fileUrl);
                
                // CHAPTERS
                foreach($xml->statistics->chapters->chapter as $chapter){
                    array_push($chaptersList, (string)$chapter->attributes()->id);
                }
                // TOKNOWMORE
                if($xml->toknowmore){
                    foreach($xml->toknowmore->item as $item){
                        $itemDatas = array();
                        $itemDatas['id'] = (string)$item->attributes()->id; // ID
                        $itemDatas['ref'] = null; // REFERENCE
                        if($item->attributes()->ref){
                            $itemDatas['ref'] = (string)$item->attributes()->ref;
                        }
                        $itemDatas['layout'] = null; // TEMPLATE
                        if($item->attributes()->layout){
                            $itemDatas['layout'] = (string)$item->attributes()->layout;
                        }
                        //$itemDatas['type'] = 'toKnowMore';
                        $itemDatas['contents'] = null;
                        $itemDatas['error'] = null;
                        $tempDatas = array();
                        $tempDatas['pathFolder'] = $pathDefault;
                        $tempDatas['productId'] = $productId;
                        $tempDatas['courseId'] = null;
                        $tempDatas['contentId'] = $itemDatas['ref'];
                        $tempDatas['lang'] = $lang;
                        $fileUrl = fileUrl("content", $tempDatas);
                        $tempDatas = null;
                        if($fileUrl == null){
                            $itemDatas['error'] = 'Le contenu de la page est inexistant (REF: '.$itemDatas['ref'].' )';
                        }else{
                            $contentXml = generateXml($fileUrl, "content");
                            $contentObj = array();
                            //$contentObj->type = 'toKnowMore';
                            $urlFile = './assets/'.$productId.'/content/'.$itemDatas['ref'].'/';
                            $contentObj = new ContentsCourse($contentXml, $itemDatas['layout'],true,$lang, $urlFile);
                            $itemDatas['contents'] = $contentObj->read();
                            $itemDatas['type'] = $contentObj->readType();
                        }
                        array_push($toKnowMoreList, $itemDatas);
                    }
                }
                // DOCUMENTS
                if($xml->documents){
                    foreach($xml->documents->document as $document){
                        $documentDatas = array();
                        $documentDatas['id'] = (string)$document->attributes()->id; // ID
                        $documentDatas['type'] = (string)$document->attributes()->type; // REFERENC
                        $documentDatas['url'] = $urlDefault.$productId.'/documents/'.(string)$document->attributes()->name;
                        array_push($documentList, $documentDatas);
                    }
                }
                
                foreach($xml->group as $datas){
                    $config = array();
                    $config['productId'] = $productId;
                    $config['lang'] = $lang;
                    $config['chaptersList'] = $chaptersList;
                    $config['toKnowMoreList'] = $toKnowMoreList;
                    $config['documentList'] = $documentList;
                    $config['pathFolder'] = $pathDefault;
                    $config['scorm'] = true;
                    $datasImport = array();            
                    $datasImport = processor($datas, $config);
                    array_push($fullDatas, $datasImport);
                }
                $return['state'] = 'success';
                $return['dateCreate'] = date("m.d.y H:i");
                $return['msg'] = 'Le cours '.$productId.' existe bien.';
                $return['datas'] = array();
                $return['datas']['label'] = (string)$xml->attributes()->label;
                $return['datas']['courseName'] = (string)$xml->attributes()->label;
                $return['datas']['lang'] = (string)$xml->attributes()->lang;
                $return['datas']['start'] = (string)$xml->attributes()->start;
                $return['datas']['courses'] = $fullDatas;

                $lesson = LessonsModel::where('idFabrica', $productId)->first();
                $return['nome'] = $lesson->name;

                $zip->addFromString('assets/'.$productId.'/courses/'.$lang.'.json', json_encode($return));
            }
        }
    }

    public function downloadScorm($file){
        if(file_exists(env('EXPORT_SCORM_PATH') . $file))
            return response()->download(env('EXPORT_SCORM_PATH') . $file, null, ['Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0']);
        else
            return 'File does not exist!';
    }

    /**
     * Move the exported contents from fabrique to online.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function putOnline(Request $request )
    {
        $id = $request['id'];
        $templesson = LessonsModel::where('id', $id)->first();
        $productId = $templesson->idFabrica;
        
        $dir2copy = env('PRODUCTS_FABRIQUE_PATH') . $productId . "/";
        $dir_paste = env('PRODUCTS_ONLINE_PATH') . $productId . "/";
        $folder_courses = "courses/";
        $list_fichiers = $this->list_fichiers($dir2copy);
        if(count($list_fichiers) == 0)
            return response()->json(["success" => false, "message" => "You need to publish the lesson first by changing its status to online, in order to actualize it"]);

        foreach ($list_fichiers as $file) {
            $file_path = $folder_courses . $file;
            if (file_exists($dir_paste . $file_path)) {
                //On supprime dans screenstat les id supprimer dans l'xml
                $listeIds = $this->getItemDeleted($dir2copy . $file_path, $dir_paste . $file_path);
                
                //$this->deleteItemsFormScreenStat($listeIds);
            }
        }

        $put = $this->putCourseOnline($dir2copy, $dir_paste,$id, $productId);

        return response()->json(["success" => true, "product_id" => $productId]);
    }

    public function clearDir($folder) {
        $ouverture = @opendir($folder);
        if (!$ouverture) {
            return;
        }
        while ($file = readdir($ouverture)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($folder . "/" . $file)) {
                $r = $this->clearDir($folder . "/" . $file);
                if (!$r) {
                    return false;
                }
            } else {
                $r = @unlink($folder . "/" . $file);
                if (!$r) {
                    return false;
                }
            }
        }
        closedir($ouverture);

        $r = @rmdir($folder);
        if (!$r) {
            return false;
        }

        return true;
    }

    public function list_fichiers($dirname) {
        $return = array();
        if (file_exists($dirname)){
            $dir = opendir($dirname);
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..' && !is_dir($dirname . $file)) {
                    $return [] = $file;
                }
            }
            closedir($dir);
        } 
        return ($return);
    }

    public function putCourseOnline($dir2copy, $dir_paste,$curso_id, $idFabrica,$database = false){
        $count = 0;
        $error = "";
        if (is_dir($dir_paste)) {
            $clear = $this->clearDir($dir_paste);
            if (!$clear) {
                return $clear;
            }
        }
        if (is_dir($dir2copy)) {
            // Si oui, on l'ouvre
            $dh = opendir($dir2copy);
            if ($dh) {
                while (($file = readdir($dh)) !== false) {
                    if (!is_dir($dir_paste) && !$database) {
                        $result = mkdir($dir_paste, 0777);
                        if(!$result) {
                            $error = array("error"=>"nt> Unable to create $dir_paste");
                        }
                    }
                    if (is_dir($dir2copy . $file) && $file != '..' && $file != '.') {
                        $this->putCourseOnline($dir2copy.$file.'/', $dir_paste.$file.'/', $curso_id, $idFabrica, $database);
                    } else if ($file != '..' && $file != '.') {
                        if(!$database) {
                            $result = copy($dir2copy . $file, $dir_paste . $file);
                            if(!$result) {
                                $error = array("error"=>"nt> Unable to copy $file in $dir_paste");
                            }
                        }
                        if(strpos($file, "course_")>-1) {
                            $count++;
                            $result = $this->insertCourseXMLDatas($dir_paste.$file, $curso_id, $idFabrica, $database);
                            if(!$result) {
                                $error = array("error"=>"nt> Entry couldn't be created in database for $file");
                            }
                        }
                    }
                }
                closedir($dh);
            } else {
                $error = array("error"=>"nt> opendir $dir2copy failed !");
            }
        }
        return array("success"=>$result, "count"=>$count, "error"=>$error);
    }

    public function getItemDeleted($file1, $file2) {
        return array_diff($this->XMLtoArray($file1), $this->XMLtoArray($file2));
    }

    public function deleteItemsFormScreenStat($arrayIds) {
        $result = true;
        /*foreach ($arrayIds as $id) {
            $sql = "DELETE FROM screen_stats WHERE id_screen = $id";
            $result = $this->getDatas($sql);
            if (!$result) {
                break;
            }
        }*/
        return $result;
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

        LessonsModel::whereIn("id", explode(",", $ids))->delete();

        return response('successfully deleted!', 200);
        //
    }


    public function insertCourseXMLDatas($url, $curso_id, $product_id, $database=false) {
        $this->module_structure = array();
        $this->screens_titles = array();
        $xml = new SimpleXMLElement($url, null, true);
        $test = "";
        $error = "";
        if ($xml === false) {
            echo "Failed loading XML: ";
            foreach (libxml_get_errors() as $error) {
                echo "<br>", $error->message;
                $error .= $error->message."\n";
            }
            return array("error"=>$error);
        } else {
            $lang = (string) $xml->attributes()->lang;
            $xml_ref = explode("_", $xml->attributes()->ref);
            $course_id = $xml_ref[1];
            $datas_bdd = array();
            $datas_bdd["lang"] = $lang;
            $datas_bdd["course_id"] = $course_id;
            $datas_bdd["curso_id"] = $curso_id;
            $datas_bdd["product_id"] = $product_id;
            $datas_bdd["profile"] = $xml_ref[3];
            $datas_bdd["screens_total"] = (string) $xml->statistics->screens->attributes()->total;
            $datas_bdd["xml_src"] = json_encode($xml);
            $this->getLessonsDatas($xml->children()->group, $lang, $product_id);
            $datas_bdd["module_structure"] = json_encode($this->module_structure);
            $datas_bdd["screens_titles"] = json_encode($this->screens_titles);

            $count = LessonCourses::where('course_id', $course_id)->where('curso_id', $curso_id)->count();
            if ($count > 0) {
                $lessonCourse = LessonCourses::where('course_id', $course_id)->where('curso_id', $curso_id)->first();
                foreach($datas_bdd as $column => $value){
                    $lessonCourse[$column] = $value;
                }
                $lessonCourse->save();
            } else {
                LessonCourses::create($datas_bdd);

            }
        }
    }

    public function getLessonsDatas($xml, $lang, $product_id, $parent = null) {
        foreach ($xml->children() as $child) {
            $type = (string) $child->getName();
            if ($type == "group" || $type == "item") {

                $id = (string) $child->attributes()->id;
                $item = array();
                $item['id'] = $id;
                $item['nav'] = (string) $child->attributes()->nav;
                $item['type'] = $type;
                $item['title'] = (string) $child->title->$lang;
                $item['parent'] = $parent;
                $item['ref'] = (string) $child->attributes()->nav;
                if ($type == "item" && $child->attributes()->hasEvaluation) {
                    $item['hasevaluation'] = (string) $child->attributes()->hasEvaluation;
                }
                if ($child->attributes()->ref) {
                    $item['ref'] = (string) $child->attributes()->ref;
                    $groupnames = $this->getPoolDatas($product_id, $item['ref'], $lang);
                    if (count($groupnames) > 0) {
                        $item['groupnames'] = $groupnames;
                    }
                }

                array_push($this->module_structure, $item);

                array_push($this->screens_titles, array("id" => $item['id'], "title" => $item['title']));

                $children = $child->children();
                if (count($children) > 1) {
                    $sub = $this->getLessonsDatas($child, $lang, $product_id, $item['id']);
                }

            }
        }
    }

    public function getPoolDatas($product_id, $ref, $lang) {
        $url = env('PRODUCTS_FABRIQUE_PATH') . "$product_id/content/$ref/" . $ref . "_" . $lang . ".xml";
        $pools_arr = array();

        $xml = new SimpleXMLElement($url, null, true);

        if ($xml === false) {
            echo "Failed loading XML at $xml: ";
            foreach (libxml_get_errors() as $error) {
                echo "<br>", $error->message;
            }
        } else {
            $zone1 = $xml->children()->content->children()->zone1;
            if($zone1 && $zone1->children() && $zone1->children()->evaluation) {
                $pools = $zone1->children()->evaluation->children()->pools;
                if (count($pools) > 0) {
                    foreach ($pools->children() as $pool) {
                        $pool_item = array();
                        $pool_item['id'] = $pool->attributes()->id;
                        if ($pool->attributes()->name) {
                            $pool_item['name'] = $pool->attributes()->name;
                        }
                        $pools_arr[] = $pool_item;
                    }
                }
            }
        }

        return $pools_arr;
    }
}

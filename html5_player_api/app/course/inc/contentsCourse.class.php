<?php
class ContentsCourse {

    public $reference = null;
    public $layout;
    public $type = null;
    public $idPool = null;
    public $namePool = null;
    public $time = null;
    public $attempts = null;
    public $questionRandom = array();
    public $tempXmlCols = array();
    public $resourcesArray = array();
    public $poolArray = array();
    public $actionsArray = array();
    public $contentsArray = array();
    public $colomnsArray = array();
    public $urlFile = null;
    public $randomEvaluation = false;
    public $background = null;

    function __construct($datasXml, $layout, $hasEvaluation, $lang, $urlFile, $evaluation = false, $step = 0)
    {
        if(!isset($lang)){
            $lang = "fr";
        }
        if(!isset($hasEvaluation)){
            $hasEvaluation = false;
        }
        if(!isset($layout)){
            $layout="twoleft";
        }
        $this->layout = $layout;
        $this->urlFile = $urlFile;
        $this->isEvaluation = $evaluation;
        $this->stepEvaluation = $step;
        $this->reference = (string)$datasXml->attributes()->ref;
        if($datasXml->attributes()->background)
            $this->background = (string)$datasXml->attributes()->background;
        $this->initRessources($datasXml->resources);
        $this->initActions($datasXml->actions);
        $this->initColumns($datasXml->content);
        $this->traitementContent($hasEvaluation);
    }

    function read(){
        return $this->colomnsArray;
    }

    function readType(){
        return $this->type;
    }

    function readQuestionRandom(){
        return $this->questionRandom;
    }

    function readIdPool(){
        return $this->idPool;
    }

    function readNamePool(){
        return $this->namePool;
    }

    function readTime(){
        return $this->time;
    }

    function readRandom(){
        return $this->randomEvaluation;
    }

    function readAttempts(){
        return $this->attempts;
    }

    function readBackground(){
        if($this->background)
            return $this->resourcesArray[(string)$this->background];
        else
            return null;
    }

    function readNbrPool(){
        $count = 0;
        foreach($this->tempXmlCols as $column){
            if($column->evaluation){
                if($column->evaluation){
                    foreach($column->evaluation->pools->pool as $pool){
                        $count = $count+$pool->count();
                    }
                }
            }
        }
        return $count;
    }

    function initRessources($ressourcesXml){
        foreach($ressourcesXml->img as $media){
            $id = (int)$media->attributes()->id;
            $medias = array();
            $medias['type'] = "image";
            $medias['extension'] = "jpg";
            $medias['url'] = $this->urlFile.(string)$media->attributes()->src;
            $this->resourcesArray[$id] = $medias;
        }
        foreach($ressourcesXml->sound as $media){
            $id = (int)$media->attributes()->id;
            $medias = array();
            $medias['type'] = "sound";
            $medias['extension'] = "mp3";
            $medias['url'] = $this->urlFile.(string)$media->attributes()->src;
            $this->resourcesArray[$id] = $medias;
        }
        foreach($ressourcesXml->movie as $media){
            $id = (int)$media->attributes()->id;
            $medias = array();
            $medias['type'] = "movie";
            $medias['extension'] = "mp4";
            $medias['url'] = str_replace('.flv','.mp4',$this->urlFile.(string)$media->attributes()->src);
            $this->resourcesArray[$id] = $medias;
        }
    }

    function initActions($actionsXml){
        foreach($actionsXml->action as $action){
            $id = (int)$action->attributes()->id;
            $actions = array();
            $actions['type'] = (string)$action->attributes()->type;
            if($action->src && $this->resourcesArray[(string)$action->src]){
                $actions['src'] = $this->resourcesArray[(string)$action->src];
            }else{
                $actions['src'] = null;
            }
            $actions['play'] = (string)$action->play;
            $actions['action'] = (string)$action->action;
            $actions['visible'] = (string)$action->visible;
            $actions['text'] = (string)$action->text;
            $actions['targets'] = array();
            $actions['li'] = array();
            foreach($action->target as $target){
                if($target->attributes()->child){
                    $tmp = array();
                    $tmp['list'] = (string)$target;
                    $tmp['item'] = (string)$target->attributes()->child;
                    $actions['targets'][] = $tmp;
                }else{
                    $actions['targets'][] = (string)$target;
                }
            }
            $this->actionsArray[$id] = $actions;
        }
    }

    function initColumns($columnsXml){
        if($this->layout){
            switch ($this->layout) {
                case "twoleft":
                    $this->tempXmlCols[0] = $columnsXml->zone1;
                    $this->tempXmlCols[1] = $columnsXml->zone2;
                    break;
                case "tworight":
                    $this->tempXmlCols[1] = $columnsXml->zone1;
                    $this->tempXmlCols[0] = $columnsXml->zone2;
                    break;
                case "free":
                    $this->tempXmlCols[0] = $columnsXml->zone1;
                    break;
                case "simple":
                    $this->tempXmlCols[0] = $columnsXml->zone1;
                    $this->tempXmlCols[1] = $columnsXml->zone2;
                    break;
                default:
                    if( $columnsXml->zone1 )
                        $this->tempXmlCols[0] = $columnsXml->zone1;
                    if( $columnsXml->zone2 )
                        $this->tempXmlCols[1] = $columnsXml->zone2;
                    break;
            }
        }else{
            if($columnsXml->zone1){
                $this->tempXmlCols[0] = $columnsXml->zone1;
            }
            if($columnsXml->zone2){
                $this->tempXmlCols[1] = $columnsXml->zone2;
            }
        }
    }

    function orderContent($column){
        $i = 0;
        foreach($column->children() as $key=>$datas){
            $datas->addAttribute('orderPosition', $i);
            if($key=='qr' || $key=='qa' || $key=='evaluation'){
                $i++;
            }
            $i++;
        }
        return $column;
    }


    function traitementContent(){
        foreach($this->tempXmlCols as $col){
            $col = $this->orderContent($col);
            $this->traitementColumn($col);
            array_push($this->colomnsArray, $this->contentsArray);
        }
    }

    function traitementColumn($col, $datasEvaluation = null){
        $this->contentsArray = array();
        $arrayReturn = $this->traitementQ($col);
        foreach($arrayReturn as $retour){
            array_push($this->contentsArray, $retour);
        }
        $arrayReturn = $this->traitementColumnContent($col);
        foreach($arrayReturn as $retour){
            array_push($this->contentsArray, $retour);
        }
        foreach($col->evaluation as $evaluation){
            $componant = array();
            if($this->isEvaluation==false){
                $componant = $this->gestionTypeEvaluation($evaluation);
                $componant['attributesZone'] = $col->attributes();
                array_push($this->contentsArray, $componant);
            }else{
                $componant = $this->gestionTypeEvaluationDatas($evaluation, $this->stepEvaluation);
                $this->contentsArray = $componant;
            }
        }
    }

    function traitementQ($col){
        $contentsArray = array();
        foreach($col->qr as $qr){
            // QUESTION
            $componant = array();
            $componant = $this->gestionTypeQuestion($qr);
            array_push($contentsArray, $componant);
            $componant = array();
            $componant = $this->gestionTypeQrQa($qr, "qr");
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->qa as $qa){
            // QUESTION
            $componant = array();
            $componant = $this->gestionTypeQuestion($qa);
            array_push($contentsArray, $componant);
            $componant = array();
            $componant = $this->gestionTypeQrQa($qa, "qa");
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        return $contentsArray;
    }

    function traitementColumnContent($col){
        $contentsArray = array();
        foreach($col->media as $media){
            $componant = array();
            $componant = $this->gestionTypeMedia($media);
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h1 as $h1){
            $componant = array();
            $componant = $this->gestionTypeText($h1 , 'h1');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h2 as $h2){
            $componant = array();
            $componant = $this->gestionTypeText($h2 , 'h2');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h3 as $h3){
            $componant = array();
            $componant = $this->gestionTypeText($h3 , 'h3');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h4 as $h4){
            $componant = array();
            $componant = $this->gestionTypeText($h4 , 'h4');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h5 as $h5){
            $componant = array();
            $componant = $this->gestionTypeText($h5 , 'h5');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h6 as $h6){
            $componant = array();
            $componant = $this->gestionTypeText($h6 , 'h6');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->p as $p){
            $componant = array();
            $componant = $this->gestionTypeText($p , 'p');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->h8 as $h8){
            $componant = array();
            $componant = $this->gestionTypeText($h8 , 'h8');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->ul as $ul){
            $componant = array();
            $componant = $this->gestionTypeList($ul , 'ul');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->ol as $ol){
            $componant = array();
            $componant = $this->gestionTypeList($ol , 'ol');
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->picto as $picto){
            $componant = array();
            $componant = $this->gestionTypePicto($picto);
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->feedback as $feedback){
            $componant = array();
            $componant = $this->gestionTypeFeedback($feedback);
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->menu as $menu){
            $componant = array();
            $componant = $this->gestionTypeMenu($menu);
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        foreach($col->edit as $edit){
            $componant = array();
            $componant = $this->gestionTypeEdit($edit);
            $componant['attributesZone'] = $col->attributes();
            array_push($contentsArray, $componant);
        }
        return $contentsArray;
    }

    function gestionTypeQrQa($datas, $type){
        $componant = array();
        $componant['type'] = $type;
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['seqid'] = (string)$datas->attributes()->seqid;

        // Init content
        $contentArray = array();
        $contentArray['unique'] = (string)$datas->attributes()->unique;
        $this->attempts = (int)$datas->attributes()->attempts; // Nbr d'essais
        $this->time = (int)$datas->attributes()->time; // Nbr d'essais
        if($datas->attributes()->onstart){
            $onstart = explode(",", (string)$datas->attributes()->onstart);
            $actions = array();
            foreach($onstart as $a){
                array_push($actions, $this->actionsArray[(int)$a]);
            }
            $contentArray['onstart'] = $actions;
            //$contentArray['onstart'] = $this->actionsArray[(int)$datas->attributes()->onstart];
        }
        if($datas->attributes()->oninit){
            $contentArray['oninit'] = $this->actionsArray[(int)$datas->attributes()->oninit];
        }
        if($datas->attributes()->onquestionclick){
            $contentArray['onquestionclick'] = $this->actionsArray[(int)$datas->attributes()->onquestionclick];
        }
        $contentArray['ifReponseTrue'] = null;
        $contentArray['ifReponseFalse'] = null;
        $contentArray['ifTimeOver'] = null;
        $contentArray['answers'] = array();

        // Answer
        foreach($datas->answers->answer as $answer){
            $answerArray = array();
            $answerArray['id'] = (int)$answer->source->attributes()->id;
            $componant['x'] = (string)$datas->attributes()->x;
            $componant['y'] = (string)$datas->attributes()->y;
            $componant['index'] = (string)$componant['id'];
            // $componant['index'] = '9';
            // for($i=1; $i <= intval($componant['id']); $i++){
            //     $componant['index'] .= '9';
            // }
            $componant['width'] = (string)$datas->attributes()->width;
            $componant['height'] = (string)$datas->attributes()->height;
            $componant['attributes'] = $datas->attributes();
            $answerArray['order'] = (string)$answer->attributes()->order;
            $answerArray['responseRight'] = (string)$answer->attributes()->right;
            switch ($type) {
                case "qr":
                    if($answer->attributes()->resource){
                        if($this->type==null){
                            $this->type = "qi";
                        }
                        $answerArray['type'] = "image";
                        $answerArray['content'] =  $this->resourcesArray[(string)$answer->attributes()->resource];
                        $answerArray['text'] =  (string)$answer;
                    }else{
                        if($this->type==null){
                            $this->type = "qr";
                        }
                        $answerArray['type'] = "text";
                        $answerArray['content'] =  (string)$answer;
                    }
                    break;
                case "qa":
                    if($this->type==null){
                        $this->type = "qa";
                    }
                    $answerArray['source'] = array();
                    if($answer->source->attributes()->resource!=NULL){
                        $answerArray['source']['media'] = $this->resourcesArray[(string)$answer->source->attributes()->resource];
                    }
                    if((string)$answer->source){
                        $answerArray['source']['text'] = (string)$answer->source;
                    }
                    $answerArray['target'] = array();
                    if($answer->target->attributes()->resource!=NULL){
                        $answerArray['target']['media'] = $this->resourcesArray[(int)$answer->target->attributes()->resource];
                    }
                    if((string)$answer->target){
                        $answerArray['target']['text'] = (string)$answer->target;
                    }
                    break;
            }
            array_push($contentArray['answers'], $answerArray);
        }
        // Actions Validation
        if($datas->valid){
            if($datas->valid->right){
                $right = explode(",", (string)$datas->valid->right);
                $actions = array();
                foreach($right as $a){
                    array_push($actions, $this->actionsArray[(int)$a]);
                }
                $contentArray['ifReponseTrue'] = $actions;
            }

            if($datas->valid->wrong){
                $wrong = explode(",", (string)$datas->valid->wrong);
                $actions = array();
                foreach($wrong as $a){
                    array_push($actions, $this->actionsArray[(int)$a]);
                }
                $contentArray['ifReponseFalse'] = $actions;
            }

            if($datas->valid->lastchance){
                $lastchance = explode(",", (string)$datas->valid->lastchance);
                $actions = array();
                foreach($lastchance as $a){
                    array_push($actions, $this->actionsArray[(int)$a]);
                }
                $contentArray['ifReponseLast'] = $actions;
            }

            if($datas->valid->case){
                $actions = array();
                foreach($datas->valid->case as $case)
                {
                    $caseIds = explode(",", (string)$case);
                    foreach($caseIds as $caseId){
                        $caseData = $this->actionsArray[(int)$caseId];
                        if( $case->attributes() && $case->attributes()->value )
                            $caseData['value'] = (string)$case->attributes()->value;
                        if( $case->attributes() && $case->attributes()->score )
                            $caseData['score'] = (string)$case->attributes()->score;
                        array_push($actions, $caseData);
                    }
                }
                $contentArray['ifReponseCase'] = $actions;
            }
        }
        if($datas->timeover){
            $timeover = explode(",", (string)$datas->timeover);
            $actions = array();
            foreach($timeover as $a){
                array_push($actions, $this->actionsArray[(int)$a]);
            }
            $contentArray['ifTimeOver'] = $actions;
        }
        $componant['content'] = $contentArray;

        $attr = clone $datas->attributes();
        $attr->orderPosition = intval($attr->orderPosition)+1;
        //$tmp = (string)$datas->attributes()->orderPosition;
        //(string)$datas->attributes()->orderPosition = $tmp.'b';
        $componant['attributes'] = $attr;
        return $componant;
    }
    function gestionTypeQuestion($datas){
        $componant = array();
        $componant['type'] = "question";
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = (string)$datas->question;
        return $componant;
    }
    function gestionTypeMedia($datas){
        $medias = $this->resourcesArray[(int)$datas->attributes()->src];
        $componant = array();
        $componant['type'] = "media";
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['styles'] = array();
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['styles']['x'] = (string)$datas->attributes()->x;
        $componant['styles']['y'] = (string)$datas->attributes()->y;
        $componant['styles']['width'] = (string)$datas->attributes()->width;
        $componant['styles']['height'] = (string)$datas->attributes()->height;
        $componant['styles']['orderPosition'] = (string)$datas->attributes()->orderPosition;
        $componant['styles']['z-index'] = (string)$componant['id'];
        // $componant['styles']['z-index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['styles']['z-index'] .= '9';
        // }
        $componant['content'] = array();
        $componant['content']['type'] = $medias['type'];
        $componant['content']['extension'] = $medias['extension'];
        $componant['content']['url'] = $medias['url'];
        $componant['content']['state'] = 'pause';
        $componant['content']['controllers'] = (string)$datas->attributes()->controllers;

        if($datas->attributes()->onstart){
            $componant['content']['onStart'] = $this->actionsArray[(int)$datas->attributes()->onstart];
        }
        if($datas->attributes()->oninit){
            $componant['content']['onInit'] = $this->actionsArray[(int)$datas->attributes()->oninit];
        }
        if($datas->cuepoints){
            if($this->type==null){
                $this->type = 'sync';
            }
            $componant['content']['cuepoints'] = array();
            foreach($datas->cuepoints->cuepoint as $cuepoint){
                $cuepointArray = array();
                $cuepointArray['time'] = (int)$cuepoint->attributes()->time;
                $cuepointArray['actions'] = $this->actionsArray[(int)$cuepoint->attributes()->actions];
                array_push($componant['content']['cuepoints'], $cuepointArray);
            }
        }
        return $componant;
    }
    function gestionTypeText($datas , $type){
        $componant = array();
        $componant['type'] = $type;
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = (string)$datas;
        return $componant;
    }
    function gestionTypeEdit($datas){
        $componant = array();
        $componant['type'] = 'edit';
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        if($this->type==null){
            $this->type = 'edit';
        }
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = (string)$datas;
        return $componant;
    }
    function gestionTypeFeedback($datas){
        $componant = array();
        $componant['type'] = "feedback";
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = null;
        return $componant;
    }
    function gestionTypeMenu($datas){
        $componant = array();
        $componant['type'] = "menu";
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = null;
        return $componant;
    }
    function gestionTypeEvaluation($datas){
        $random = (string)$datas->attributes()->random;
        $this->randomEvaluation = $random;
        if($this->type==null){
            $this->type = 'evaluation';
        }
        if($random=="true"){
            foreach($datas->questions->pool as $pool){
                array_push($this->questionRandom, (string)$pool);
            }
        }else{
            $i = 0;
            foreach($datas->questions->pool as $key => $pool){
                array_push($this->questionRandom, $i);
                $i++;
            }
        }

    }

    function gestionTypeEvaluationDatas($datas, $stepEvaluation){
        $componantsPool = array();
        $random = (string)$datas->attributes()->random;
        $this->randomEvaluation = $random;
        // $componantsPool['content'] = [];
        $i = 0;
        $j = 0;
        foreach($datas->pools->pool as $pool){
            // Initialisation du titre
            $componantTmp = array();
            $componantTmp['attributes'] = $pool->attributes();
            $componantTmp['type'] = 'h9';
            $componantTmp['content'] = (string)$pool->attributes()->name;

            $arrayReturn = $this->traitementQ($pool);
            foreach($arrayReturn as $key=>$retour){
                if($i == $stepEvaluation*2){
                    $componants = array();
                    if($random=="true"){
                        $this->idPool = (string)$pool->attributes()->id;
                    }else{
                        $this->idPool = $j;
                    }
                    $this->namePool = (string)$pool->attributes()->name;
                    array_push($componantsPool, $componantTmp);
                    array_push($componantsPool, $arrayReturn[$key]);
                    array_push($componantsPool, $arrayReturn[$key+1]);
                    // $componantsPool['type'] = $arrayReturn[$key+1]["type"];
                    $i++;
                }
                $i++;
            }
            $j++;
        }
        return $componantsPool;
    }

    function gestionTypeList($datas , $type){

        $componant = array();
        $componant['type'] = $type;
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = array();
        $componant['content']['li'] = array();
            foreach($datas->li as $key=>$li){
                $componant['content']['li'][] = (string)$li;
            }
        return $componant;
    }
    function gestionTypePicto($datas){
        $componant = array();
        $componant['type'] = 'picto';
        $componant['id'] = (string)$datas->attributes()->id;
        $componant['x'] = (string)$datas->attributes()->x;
        $componant['y'] = (string)$datas->attributes()->y;
        $componant['index'] = (string)$componant['id'];
        // $componant['index'] = '9';
        // for($i=1; $i <= intval($componant['id']); $i++){
        //     $componant['index'] .= '9';
        // }
        $componant['seqid'] = (string)$datas->attributes()->seqid;
        $componant['width'] = (string)$datas->attributes()->width;
        $componant['height'] = (string)$datas->attributes()->height;
        $componant['attributes'] = $datas->attributes();
        $componant['content'] = (string)$datas->attributes()->name;
        return $componant;
    }
}
?>

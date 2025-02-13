<?php

$seqid = 0;

/* ----------------------------------------------------------------------
    - GENERATION DU SLUG
    -  @return String
    -
    -
    ----------------------------------------------------------------------- */
function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

/* ----------------------------------------------------------------------
    - RECHERCHE DU FICHIER
    -  @return || String ou false si pas de fichier existant
    -  $type || Peut prendre les valeurs: 'courses', 'content', 'medias'
    -  $datas || Array keys: 'pathFolder', 'productId', 'courseId', 'contentId, lang'
    -
    ----------------------------------------------------------------------- */
function fileUrl($type, $datas)
{
    if (!isset($type)) {
        $type  = "courses";
    }
    if (empty($datas['pathFolder'])) {
        $datas['pathFolder'] = FABRIQUE_PRODUCTS_PATH;
    }
    if (!isset($datas['productId'])) {
        return false;
        die();
    }
    $url_file = $datas['pathFolder'] . $datas['productId'] . '/';
    switch ($type) {
        case "parent":
            if (!isset($datas['courseId'])) {
                return false;
                die();
            }
            $fileUrl = $url_file . 'configuration/product.xml';

            break;
        case "courses":
            if (!isset($datas['courseId'])) {
                return false;
                die();
            }
            $file = $url_file . 'courses/course_' . $datas['courseId'];
            $fileUrl = glob($file . '*');
            //return $file;
            if (count($fileUrl) > 0) {
                $fileUrl = $fileUrl[0];
            } else {
                $file = $url_file . 'courses/course_0';
                $fileUrl = glob($file . '*');
                if (count($fileUrl) > 0) {
                    $fileUrl = $fileUrl[0];
                } else {
                    return false;
                    die();
                }
            }
            break;
        case "content":
            if (!isset($datas['contentId'])) {
                return false;
                die();
            }
            if (empty($datas['lang'])) {
                $datas['lang'] = 'fr';
            }
            $file = $url_file . 'content/' . $datas['contentId'] . '/' . $datas['contentId'] . '_' . $datas['lang'] . '.xml';
            $fileUrl = glob($file . '*');
            if (count($fileUrl) > 0) {
                $fileUrl = $fileUrl[0];
            } else {
                $file = $url_file . 'content/' . $datas['contentId'] . '/' . $datas['contentId'] . '_fr.xml';
                $fileUrl = glob($file . '*');
                if (count($fileUrl) > 0) {
                    $fileUrl = $fileUrl[0];
                } else {
                    return false;
                    die();
                }
            }
            break;
        case "media":
            if (empty($datas['contentId']) || empty($datas['mediaName'])) {
                return false;
                die();
            }
            $file = $url_file . 'content/content/' . $datas['contentId'] . '/' . $datas['mediaName'];
            $fileUrl = glob($file);
            if (count($fileUrl) > 0) {
                $fileUrl = $fileUrl[0];
            } else {
                return false;
                die();
            }
            break;
        default:
            return false;
            die();
    }
    return $fileUrl;
}


/* ----------------------------------------------------------------------
    - RECHERCHE DU FICHIER
    -  @return || XML
    -  $type || Peut prendre les valeurs: 'courses', 'content', 'medias'
    -  $file || path du fichier à traiter
    -
    ----------------------------------------------------------------------- */
function generateXml($file, $type = "course")
{
    $xmlString = "<?xml version='1.0' standalone='yes'?>";
    $xmlString .= file_get_contents($file);

    global $seqid;
    $seqid = 0;
    $pattern = '/<h1 |<h2 |<h3 |<h4 |<h5 |<h6 |<h7 |<h8 |<p |<qr |<qa |<qi |<evaluation |<media |<picto |<ul |<ol |<feedback |<menu |<group |<item /';
    $xmlConverted = preg_replace_callback($pattern, 'addSequenceId', $xmlString);

    // Change '&' to '&amp'
    //$xmlConverted = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xmlConverted);

    $xml = simplexml_load_string($xmlConverted);

    if ($type == "courses") {
        $xml = $xml->group;
    }
    return $xml;
}

function addSequenceId($matches)
{
    global $seqid;
    return $matches[0] . 'seqid="' . ($seqid++) . '" ';
}

/* ----------------------------------------------------------------------
    - PARSE LES FICHIERS XML POUR EN GENERER UN JSON UNIQUE
    -  @return || array
    -  $config || Array keys: 'productId', 'lang', 'chaptersList', 'toKnowMoreList', 'documentList', 'pathFolder'
    -  $content || $contenu XML à traiter
    -
    ----------------------------------------------------------------------- */
function processor($content, $config)
{
    // INIT LES VARIABLES DE RETOUR
    $return = array();
    $return['id'] = (string)$content->attributes()->id; // ID
    $return['seqid'] = (string)$content->attributes()->seqid; // Sequence ID
    $return['ref'] = null; // REFERENCE
    if ($content->attributes()->ref) {
        $return['ref'] = (string)$content->attributes()->ref;
    }
    $name = get_object_vars($content->title);
    $return['name'] = $name[$config['lang']]; // NOM
    if (is_string($return['name']) && $return['name'] == "{}") {
        $return['name'] = "";
    }
    if (is_object($return['name'])) {
        $return['name'] = "";
    }
    $return['slug'] = slugify($return['name']); // SLUG
    $return['type'] = null;
    $return['time'] = null;
    $return['attempts'] = null;
    $return['viewTime'] = 'null';
    $return['resultTime'] = 'null';
    $return['layout'] = (string)$content->attributes()->layout;
    $return['nav'] = (string)$content->attributes()->nav;
    if ($return['nav'] == "") {
        $return['nav'] = "true";
    }
    $return['nextPage'] = null;
    $return['isChapter'] = false;
    $return['isEvaluation'] = (bool)$content->attributes()->hasEvaluation;
    $return['contents'] = null;
    $return['toKnowMore'] = array();
    $return['documents'] = array();
    $return['childrens'] = array();
    $return['error'] = null;
    // INIT isChapter
    if (in_array($return['id'], $config['chaptersList'], true)) {
        $return['isChapter'] = true;
    }

    // INIT type = chapter
    if ($return['ref'] == "") {
        $return['type'] = "chapter";
    }

    $toknowmoresIds = (string)$content->attributes()->toknowmore;
    $toknowmoresIdsArray = explode(",", $toknowmoresIds);
    if ($toknowmoresIdsArray[0] == "") {
        $toknowmoresIdsArray = array();
    }
    if (count($toknowmoresIdsArray) > 0) {
        foreach ($config['toKnowMoreList'] as $d) {
            if (in_array($d['id'], $toknowmoresIdsArray, true)) {
                array_push($return['toKnowMore'], $d);
            }
        }
    }

    $documentsIds = (string)$content->attributes()->documents;
    $documentsIdsArray = explode(",", $documentsIds);
    if ($documentsIdsArray[0] == "") {
        $documentsIdsArray = array();
    }
    if (count($documentsIdsArray) > 0) {
        foreach ($config['documentList'] as $d) {
            if (in_array($d['id'], $documentsIdsArray, true)) {
                array_push($return['documents'], $d);
            }
        }
    }


    // CHILDS GROUPS
    if ($content->group) {
        foreach ($content->group as $group) {
            $datasGroup = array();
            $datasGroup = processor($group, $config);
            $datasGroup['isChapter'] = true;
            array_push($return['childrens'], $datasGroup);
        }
    }
    // CHILDS ITEMS
    if ($content->item) {
        foreach ($content->item as $item) {
            $datasItem = array();
            $datasItem = processor($item, $config);
            array_push($return['childrens'], $datasItem);
        }
    }

    if ($return['ref']) {
        $tempDatas = array();
        $tempDatas['pathFolder'] = $config['pathFolder'];
        $tempDatas['productId'] = $config['productId'];
        $tempDatas['courseId'] = null;
        $tempDatas['contentId'] = $return['ref'];
        $tempDatas['lang'] = $config['lang'];
        $fileUrl = fileUrl("content", $tempDatas);
        $tempDatas = null;
        if ($fileUrl == null) {
            $return['error'] = 'Le contenu de la page est inexistant (REF: ' . $return['ref'] . ' )';
        } else {
            $contentXml = generateXml($fileUrl, "content");
            $form_data  = json_decode(file_get_contents('php://input'));
            if ($form_data->preview) {
                $preview = $form_data->preview;
            }
            if ($config['scorm']) {
                $urlFile = './assets/' . $config['productId'] . '/content/' . $return['ref'] . '/';
            } else {
                if ($preview == true) {
                    $urlFile = PRODUCTS_FABRIQUE_URL . $config['productId'] . '/content/' . $return['ref'] . '/';
                } else {
                    $urlFile = FABRIQUE_PRODUCTS_URL . $config['productId'] . '/content/' . $return['ref'] . '/';
                }
            }

            $contentObj = new ContentsCourse($contentXml, $return['layout'], true, $config['lang'], $urlFile);
            $return['contents'] = $contentObj->read();
            if ($contentObj->readType() != null) {
                $return['type'] = $contentObj->readType();
            }
            if ($contentObj->readTime() != null) {
                $return['time'] = $contentObj->readTime();
            }
            if ($contentObj->readAttempts() != null) {
                $return['attempts'] = $contentObj->readAttempts();
            }
            if ($contentObj->readBackground() != null) {
                $return['background'] = $contentObj->readBackground();
            }
            if ($return['type'] == "evaluation") {
                $return['contents'] = array();
                $return['contents']['questionRandom'] = $contentObj->readQuestionRandom();
                $return['contents']['pools'] = array();

                $tmpReturn = array();
                $tmpReturn['id'] = $return['id']; // ID
                $tmpReturn['type'] = $return['type'];
                $tmpReturn['time'] = $return['time'];
                $tmpReturn['attempts'] = $return['attempts'];
                $tmpReturn['viewTime'] = $return['viewTime'];
                $tmpReturn['resultTime'] = $return['resultTime'];
                $tmpReturn['layout'] = $return['layout'];
                $tmpReturn['contents'] = array();
                for ($i = 0; $i < $contentObj->readNbrPool(); $i++) {
                    $loopReturn = $tmpReturn;
                    $contentPoolObj = new ContentsCourse($contentXml, $loopReturn['layout'], true, $config['lang'], $urlFile, true, $i);
                    $loopReturn['contents'] = $contentPoolObj->read();
                    if ($contentPoolObj->readRandom() == "true") {
                        if ($contentPoolObj->readIdPool() != null) {
                            $loopReturn['idPool'] = $contentPoolObj->readIdPool();
                            $loopReturn['namePool'] = $contentPoolObj->readNamePool();
                        }
                    } else {
                        $loopReturn['namePool'] = $contentPoolObj->readNamePool();
                        $loopReturn['idPool'] = strval($i);
                    }
                    $loopReturn['idSubPool'] = strval($i);
                    if ($contentPoolObj->readType() != null) {
                        $loopReturn['type'] = $contentPoolObj->readType();
                    }
                    if ($contentPoolObj->readTime() != null) {
                        $loopReturn['time'] = $contentPoolObj->readTime();
                    }
                    if ($contentPoolObj->readAttempts() != null) {
                        $loopReturn['attempts'] = $contentPoolObj->readAttempts();
                    }
                    $return['contents']['pools'][$i] = array();
                    $return['contents']['pools'][$i] = $loopReturn;
                }
            }
        }
    }
    return $return;
}

<?php
/*
TODO : récupérer le curso_id dans tb_lesson_courses en fonction du profil et de la langue du user
Faire le progress_screen
*/
//error_reporting(E_ALL);
// mysql_connect('localhost','root','BKGqmh1Q') or die("mysql server fail(connection)");
// mysql_select_db('lms') or die("mysql db fail (connection)Problemas com o arquivos de dados");
// mysql_query("SET NAMES utf8");

/*$optim_eval_datas = array('id_user' => '6557',
    'id_fabrique' => '9JQ5XCJO',
    'id_eval' => '43');
treatOptimEval($optim_eval_datas);*/
/*$optim_datas = array('id_user' => '6557',
    'id_fabrique' => '9JQ5XCJO',
    'id_screen' => 3,
    'hour_begin' => '00:59:00',
    'hour_end' => '00:01:28',
    'reg_date' => '2015-09-25');
treatOptim($optim_datas);*/


// Routine principale appelée depuis open/api.php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    // ini_set('display_errors', TRUE);
    // ini_set('display_startup_errors', TRUE);
    // @ini_set('display_errors', 'on');
    // @error_reporting(E_ALL | E_STRICT);

function treatOptim($optim_datas) {
    $user = modelGetUser($optim_datas['id_user']); // On récupère le user
    
    if ($user != FALSE) {
        $language_iso = modelGetLanguageIso($user['lang']); // On récupère la langue du user
        $defaut_language_iso = modelGetLanguageIso(1); // On récupère la langue par defaut voir CONFIG.PHP
        if (empty($language_iso) || $language_iso == '')
            $language_iso = $defaut_language_iso;
        if ($user['profile'] == -1)
            $user['profile'] = 0;
        
        $id_curso = modelGetCursoByIdFabrique($optim_datas['id_fabrique']);
        if ($id_curso == FALSE)
            return 0;
        $lesson_course = modelGetCourseByIdLangProfile($id_curso,$user['profile'],$language_iso);
        if ($lesson_course == FALSE)
            $lesson_course = modelGetCourseByIdLangProfile($id_curso,0,$language_iso);
        if($lesson_course == FALSE)
            $lesson_course = modelGetCourseByIdLangProfile($id_curso,0,$defaut_language_iso);
        
        $module_structure = json_decode($lesson_course['module_structure']);
        $nb_screens_module = helperCountScreensModule($module_structure); // On récupère le nombre d'écran du cours
        
        // On regarde si l'écran ne doit être comptabilisé : isChapter = TRUE et nav = FALSE
        $is_screen_counted = helperIsScreenCounted($module_structure,$optim_datas['id_screen']);
        if ($is_screen_counted == -1)
            return 0;
        if ($is_screen_counted == 0)
            return 0;
        
        // On récupère l'optim pour la fabrique, le cours et le user
        $optim = modelGetOptim($optim_datas['id_fabrique'],$optim_datas['id_user'],$id_curso);
        
        if ($optim != FALSE) { // Si on a déjà une ligne optim
            // On récupère le progress details puis on check si l'écran courrant est présent dedans
            $progress_details = json_decode($optim['progress_details_screen_optim']);
            if (existsScreenProgressDetails($progress_details,$optim_datas['id_screen'])) {
                $progress_details = updateScreenProgressDetails($progress_details,$optim_datas['id_screen'],$optim_datas['hour_begin'],$optim_datas['hour_end'],$optim_datas['reg_date'],$optim_datas['status']);
            } else {
                $progress_details = addScreenProgressDetails($progress_details,$optim_datas['id_screen'],$optim_datas['hour_begin'],$optim_datas['hour_end'],$optim_datas['reg_date'],$optim_datas['status']);
            }
            
            // On récupère le nombre de screens vu pour faire le calcul de la progression
            $nb_screens = helperCountScreens($progress_details,$optim);
            $progress_screen = helperCalcProgress($nb_screens,$nb_screens_module);
            
            $payload = array('progress_details' => json_encode($progress_details),
                'progress_screen' => $progress_screen,
                'last_date' => $optim_datas['reg_date'].' '.$optim_datas['hour_end']);
            modelUpdateOptim($payload,$optim['id_screen_optim']);
        } else { // Si il faut créer la ligne optim
            // On crée le progress detail et on ajoute le screen courant
            $progress_details = createScreenProgressDetails();
            $progress_details = addScreenProgressDetails($progress_details,$optim_datas['id_screen'],$optim_datas['hour_begin'],$optim_datas['hour_end'],$optim_datas['reg_date'],$optim_datas['status']);
            
            // On récupère le nombre de screens vu pour faire le calcul de la progression
            $nb_screens = helperCountScreens($progress_details,$optim);
            $progress_screen = helperCalcProgress($nb_screens,$nb_screens_module);
            
            $payload = array('id_fabrique' => $optim_datas['id_fabrique'],
                'id_curso' => $id_curso,
                'id_user' => $optim_datas['id_user'],
                'progress_details' => json_encode($progress_details),
                'progress_screen' => $progress_screen,
                'last_date' => $optim_datas['reg_date'].' '.$optim_datas['hour_end']);
            modelInsertOptim($payload);
        }
        return $payload;
    }
}

// Routine pour gérer les évaluations appelée depuis open/api.php
function treatOptimEval($optim_datas) {
    $user = modelGetUser($optim_datas['id_user']); // On récupère le user
    
    if ($user != FALSE) {
        $language_iso = modelGetLanguageIso($user['lang']); // On récupère la langue du user
        $defaut_language_iso = modelGetLanguageIso(1); // On récupère la langue par defaut voir CONFIG.PHP
        if (empty($language_iso) || $language_iso == '')
            $language_iso = $defaut_language_iso;
        if ($user['profile'] == -1)
            $user['profile'] = 0;
        
        $id_curso = modelGetCursoByIdFabrique($optim_datas['id_fabrique']);
        if ($id_curso == FALSE)
            return 0;
        $lesson_course = modelGetCourseByIdLangProfile($id_curso,$user['profile'],$language_iso);
        if ($lesson_course == FALSE)
            $lesson_course = modelGetCourseByIdLangProfile($id_curso,0,$language_iso);
        $module_structure = json_decode($lesson_course['module_structure']);
        $nb_screens_module = helperCountScreensModule($module_structure); // On récupère le nombre d'écran du cours
    
        // On récupère l'optim pour la fabrique et le user
        $optim = modelGetOptim($optim_datas['id_fabrique'],$optim_datas['id_user'],$id_curso);
        
        if ($optim != FALSE) { // Si on a déjà une ligne optim
            if ($optim['first_eval_id_screen_optim'] == 0) { // Si on a pas de first_eval_id_screen_optim on l'insère
                $payload = array('first_eval_id_screen_optim' => $optim_datas['id_eval'],
                    'last_date' => $optim_datas['date_end']);
                modelUpdateFirstEvalOptim($payload,$optim['id_screen_optim']);
            } else { // Si on a déjà une first_eval_id_screen_optim on met en last_eval_id_screen_optim
                $payload = array('last_eval_id_screen_optim' => $optim_datas['id_eval'],
                    'last_date' => $optim_datas['date_end']);
                modelUpdateLastEvalOptim($payload,$optim['id_screen_optim']);
            }
            
            // On MAJ la progression
            $progress_details = json_decode($optim['progress_details_screen_optim']);
            $nb_screens = helperCountScreens($progress_details,$optim,TRUE);
            $progress_screen = helperCalcProgress($nb_screens,$nb_screens_module);
            // Max 100 progress_screen
            // if( $progress_screen > 100 ) 
            //     $progress_screen = "100";

            $payload = array('progress_details' => json_encode($progress_details),
                'progress_screen' => $progress_screen,
                'last_date' => $optim_datas['date_end']);
            modelUpdateOptim($payload,$optim['id_screen_optim']);
            
        } else { // Si il faut créer la ligne optim
            $payload = array('id_fabrique' => $optim_datas['id_fabrique'],
                'id_curso' => $id_curso,
                'id_user' => $optim_datas['id_user'],
                'progress_details' => '',
                'progress_screen' => '0.00',
                'last_date' => $optim_datas['date_end']);
            $id_optim_inserted = modelInsertOptim($payload);
            $payload = array('first_eval_id_screen_optim' => $optim_datas['id_eval']);
            modelUpdateFirstEvalOptim($payload,$id_optim_inserted);
            
            // On MAJ la progression
            $progress_screen = number_format((1*100)/$nb_screens_module,2);
            $payload = array('progress_details' => '',
                'progress_screen' => $progress_screen,
                'last_date' => $optim_datas['date_end']);
            modelUpdateOptim($payload,$id_optim_inserted);
        }
    }
}

// Test si on a déjà le screen dans le tableau progress_details
function existsScreenProgressDetails($obj,$id_screen) {
    if (isset($obj->{$id_screen}))
        return TRUE;
    else
        return FALSE;
}

// Crée un objet pour le tableau progress_details
function createScreenProgressDetails() {
    //$obj = array();
    $obj = new stdClass;
    return $obj;
}

// Ajoute un screen dans le tableau progress_details
function addScreenProgressDetails($obj,$id_screen,$hour_begin,$hour_end,$reg_date,$status) {
    // On calcule la différence entre hour_begin et hour_end
    $h_begin = intval(substr($hour_begin,0,2));
    $h_end = intval(substr($hour_end,0,2));
    if ($h_begin < $h_end) { // Si l'heure se début est inférieur à l'heure de fin on est sur la même journée
        $h1 = strtotime('1988-01-20 '.$hour_begin);
        $h2 = strtotime('1988-01-20 '.$hour_end);
    } else { // Si l'heure de début est supérieur à l'heure de fin on est passé sur une autre journée
        $h1 = strtotime('1988-01-20 '.$hour_begin);
        $h2 = strtotime('1988-01-21 '.$hour_end);
    }
    $diff_time = helperDateDiff($h1,$h2);
    $time = date('H:i:s',strtotime('1988-01-20 '.$diff_time['hour'].':'.$diff_time['minute'].':'.$diff_time['second']));
    
    $screen = new stdClass;
    $screen->id = intval($id_screen);
    $screen->visu = 1;
    $screen->time = $time;
    $screen->last_view = $reg_date.' '.$hour_end;
    $screen->status = $status;
    // On crée l'objet et on le renvoie
    $obj->{$id_screen} = $screen;
    return $obj;
}

// MAJ un screen dans le tableau progress_details
function updateScreenProgressDetails($obj,$id_screen,$hour_begin,$hour_end,$reg_date,$status) {
    // On calcule la différence entre hour_begin et hour_end
    $h_begin = intval(substr($hour_begin,0,2));
    $h_end = intval(substr($hour_end,0,2));
    if ($h_begin < $h_end) { // Si l'heure se début est inférieur à l'heure de fin on est sur la même journée
        $h1 = strtotime('1988-01-20 '.$hour_begin);
        $h2 = strtotime('1988-01-20 '.$hour_end);
    } else { // Si l'heure de début est supérieur à l'heure de fin on est passé sur une autre journée
        $h1 = strtotime('1988-01-20 '.$hour_begin);
        $h2 = strtotime('1988-01-21 '.$hour_end);
    }
    $diff_time = helperDateDiff($h1,$h2);
    $time = date('H:i:s',strtotime('1988-01-20 '.$diff_time['hour'].':'.$diff_time['minute'].':'.$diff_time['second']));
    // On ajoute au time courrant
    $t_time = explode(':',$time);
    $time = date('H:i:s',strtotime("+".$t_time[0]." hours ".$t_time[1]." minutes ".$t_time[2]." seconds",strtotime($obj->{$id_screen}->time)));
    
    // On incrément le nombre de visu
    $visu = $obj->{$id_screen}->visu + 1;
    
    $screen = new stdClass;
    $screen->id = intval($id_screen);
    $screen->visu = $visu;
    $screen->time = $time;
    $screen->last_view = $reg_date.' '.$hour_end;
    $screen->status = $status;
    // On recrée l'objet et on le renvoie
    $obj->{$id_screen} = $screen;
    return $obj;
}


/*****************************************************
******************************************************
******************************************************
*********************** MODELS ***********************
******************************************************
******************************************************
*****************************************************/

// Récupère un user dans le DB
function modelGetUser($id_user) {
    $sql = "SELECT u.*, c.name AS company_name
        FROM tb_users u
        LEFT JOIN tb_companies c ON c.id = u.company
        WHERE u.id = ".$id_user;
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->errorCode() == 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } else
        return FALSE;
}

// Insert une ligne dans la table screen_optim
function modelInsertOptim($datas) {
    $sql = "INSERT INTO tb_screen_optim(`id_fabrique_screen_optim`,`id_curso_screen_optim`,`id_user_screen_optim`,`progress_details_screen_optim`,`progress_screen_optim`,`last_date_screen_optim`)
        VALUES('".$datas['id_fabrique']."',
        '".$datas['id_curso']."',
        '".$datas['id_user']."',
        '".($datas['progress_details'])."',
        '".($datas['progress_screen'])."',
        '".$datas['last_date']."')";
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $inserted_id = $db->lastInsertId();
    return $inserted_id;
}

// MAJ une ligne dans la table screen_optim
function modelUpdateOptim($datas,$id_row) {
    $sql = "UPDATE tb_screen_optim
        SET progress_details_screen_optim = '".($datas['progress_details'])."',
            progress_screen_optim = ".($datas['progress_screen']).",
            last_date_screen_optim = '".$datas['last_date']."'
        WHERE id_screen_optim = ".($id_row);
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

// MAJ la first_eval_id_screen_optim d'une ligne dans la table screen_optim
function modelUpdateFirstEvalOptim($datas,$id_row) {
    $sql = "UPDATE tb_screen_optim
        SET first_eval_id_screen_optim = ".($datas['first_eval_id_screen_optim']).",
            last_date_screen_optim = '".$datas['last_date']."'
        WHERE id_screen_optim = ".($id_row);
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

// MAJ la last_eval_id_screen_optim d'une ligne dans la table screen_optim
function modelUpdateLastEvalOptim($datas,$id_row) {
    $sql = "UPDATE tb_screen_optim
        SET last_eval_id_screen_optim = ".($datas['last_eval_id_screen_optim']).",
            last_date_screen_optim = '".$datas['last_date']."'
        WHERE id_screen_optim = ".($id_row);
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

// Récupère une ligne dans la table screen_optm
function modelGetOptim($id_fabrique,$id_user,$id_curso='') {
    $sql = "SELECT * FROM tb_screen_optim
        WHERE id_fabrique_screen_optim = '".($id_fabrique)."'
        AND id_user_screen_optim = ".($id_user);
    if ($id_curso != '') {
        $sql .= "
            AND id_curso_screen_optim = ".($id_curso);
    }
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->errorCode() == 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } else
        return FALSE;
}

// Récupère un user dans le DB
function modelGetLanguageIso($id_lang) {
    $sql = "SELECT language_iso
        FROM tb_languages
        WHERE language_id = ".($id_lang);
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->errorCode() == 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['language_iso'];
    } else
        return FALSE;
}

// Récupère un user dans le DB
function modelGetCursoByIdFabrique($id_fabrique) {
    $sql = "SELECT id
        FROM tb_lesson
        WHERE idFabrica = '".($id_fabrique)."'";
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->errorCode() == 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    } else
        return FALSE;
}

// Récupère un user dans le DB
function modelGetCourseByIdLangProfile($id_curso,$profile,$lang) {
    $sql = "SELECT * FROM tb_lesson_courses
        WHERE curso_id = ".($id_curso)."
        AND profile = ".($profile)."
        AND lang = '".($lang)."'";
    $db = new PDO("mysql:host=localhost;dbname=laravel", "root", "mabrQv$%2x", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->errorCode() == 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } else
        return FALSE;
}



/******************************************************
*******************************************************
*******************************************************
*********************** HELPERS ***********************
*******************************************************
*******************************************************
******************************************************/

function helperDateDiff($date1, $date2){
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

function helperCalcProgress($progress,$total){
    if($total == 0 || $total == "0")
        return "0";
    else
        return number_format(($progress*100)/$total,2);
    // else
    // {
    //     $progress_screen = number_format(($progress*100)/$total,2);
    //     // Max 100 progress_screen
    //     if( $progress_screen > 100 ) 
    //         $progress_screen = "100";
    //     return $progress_screen;
    // }
}

function helperCountScreens($screens,$optim,$eval='') {
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
    //     if ($optim['first_eval_id_screen_optim'] != 0 || $optim['last_eval_id_screen_optim'] != 0)
    //         $i++;
    // }
    return $i;
}

function helperCountScreensModule($module_structure) {
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

function helperIsScreenCounted($module_structure,$id_screen) {
    if (!empty($module_structure)) {
        foreach ($module_structure as $screen) {
            if ($screen->id == $id_screen) {
                if (isset($screen->nav) && $screen->nav != "false")
                    return 1; // On retourne 1 si le nav est à TRUE
                else
                    return 0; // On retourne 0 si le nav du screen est à FALSE
            }
        }
    }
    return -1; // Le screen n'existe pas (id 0 par exemple)
}

/*function throw_error($message) {
    throw new Exception($message);
}*/

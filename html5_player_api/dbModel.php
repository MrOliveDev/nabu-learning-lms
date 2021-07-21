<?php

Abstract Class dbModel {

    protected $db;
    protected $api_url;
    public $user_logo;
    public $user_color;

    public function __construct($dbdsn = null) {
        try {
            if(!$dbdsn){
                $this->db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            } else
                $this->db = new PDO($dbdsn, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

            $this->user_logo = "logo.png";
            $this->user_color = "#ED1C24";
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        //echo "DB connexion OK"."<br>\n";
    }


    /** Generic datas getter
     *
     * @param string $sql query needed to get the list
     * @return array
     */
    public function getDatas($sql, $database = false) {
// print_r($database);
// print_r($sql);
// exit;
        $dataf = array();

        if ($database) {
            //echo "use:".$database."\n";
            $this->db->exec("use $database");
        }
    //echo $sql."<br>\n";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->errorCode() == 0) {
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
                array_push($dataf, $data);
            endwhile;
            //var_dump($dataf);
            return $dataf;
        } else {
            $errors = $stmt->errorInfo();
            echo($errors[2]);
        }
    }

    /**
     *
     * @return int
     */
    public function getLastIdInserted() {
        return $this->db->lastInsertId();
    }

    /**
     * Dynamic method to show values required without affect user perception
     *
     * @param string $type
     * @param array $str
     */
    public function listen($type, $str, $exit = false) {
        //echo "debugmode:".$_SESSION['debugmode'];
        if (auth()->user()->debugmode == "listen") {
            if ($type == "echo") {
                echo $str;
            } else if ($type == "dump") {
                var_dump($str);
            }
            echo "<br>\n";

            if ($exit) {
                exit;
            }
        }
    }

    /**
     *
     * @param type $array
     * @return XML
     */
    public function createCourse($array) {
        //echo "--createCourse--"."<br>\n";
        //$course = parent::create ( $array );
        //echo "createCourse\n";
        foreach ($array as $item) {
            if ($item[name] == "nome") {
                $name = $item[value];
            }
            if ($item[name] == "idFabrica") {
                $productId = $item[value];
            }
        }
        //echo "name:".$name;
        //echo "productId:".$productId;

        $config = new SimpleXMLElement('<project></project>');
        $config->addAttribute('code', $productId);
        $config->addAttribute('label', $name);
        $n = $config->addChild('languages');
        $n->addChild('lang', auth()->user()->lang);
        $t = $config->addChild('lessonPlan');
        $t->addAttribute('id', '0');
        $n2 = $t->addChild('title');
        $n2->addChild(auth()->user()->lang, 'Menu Principal');
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
        $return = $this->doPostRequest(FABRIQUE_URL, $values);

        //var_dump($return);
        return $return;
    }

    /**
     *
     * @param type $url
     * @param type $data
     * @param type $optional_headers
     * @return \SimpleXMLElement
     * @throws Exception
     */
    public function doPostRequest($url, $data, $optional_headers = null) {
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
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        $xml = new SimpleXMLElement($response);
        //var_dump($xml);
        return $xml;
    }


    public function tableExists($name) {
        $results = $this->db->query("SHOW TABLES LIKE '$name'");
        if (!$results) {
            die(print_r($this->db->errorInfo(), TRUE));
        }
        return $results->rowCount()>0;
    }


    public function formatrewriting($chaine) {
        //les accents
        /*$chaine = trim($chaine);
        $chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        $chaine = strtolower($chaine);*/

        $a = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
        $b = 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
        $chaine = utf8_encode(strtr(utf8_decode($chaine), utf8_decode($a), utf8_decode($b)));
        $chaine = strtolower($chaine);


        //les caracètres spéciaux (autres que lettres et chiffres en fait)
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        return $chaine;
    }

    /**
     *
     * @param string $datas
     * @param string $filename
     */
    public function datasToCsv($datas, $filename) {
        $url = "reports/csv/".$filename;

        $fp = fopen(APP_ROOT.$url, "w");
        $error = !$fp ? "fopen failed":"";
        $write = fwrite($fp, $datas);
        $error = !$write ? "fwrite failed":"";
        fclose($fp);

        return $error=="" ? true:array("error"=>$error);
    }

    /**
     *
     * @param id $reporting_creator
     * @param string $reporting_file
     * @param string $reporting_file_type
     * @param string $reporting_details
     * @param string $pdfs_list
     * @return int
     */
    public function inserthistory($reporting_creator, $reporting_file, $reporting_file_type, $reporting_details, $pdfs_list = "") {

        //echo "creator:".$reporting_creator."\n";
        //echo "file:".$reporting_file."\n";
        //echo "file_type:".$reporting_file_type."\n";
        //echo "details:".$reporting_details."\n";
        //echo "list:".$pdf_list."\n";

        $sql = 'INSERT INTO reporting_history (reporting_creator, reporting_file, reporting_file_type, reporting_details, pdfs_list, reporting_date)
				VALUES (:reporting_creator, :reporting_file, :reporting_file_type, :reporting_details, :pdfs_list, now() ) ';
        //echo $sql."\n";
        $stmt = $this->db->prepare($sql);
        // $stmt->bindValue( "translation_string", $translation_string, PDO::PARAM_STR );
        $stmt->bindValue("reporting_creator", $reporting_creator, PDO::PARAM_INT);
        $stmt->bindValue("reporting_file", $reporting_file, PDO::PARAM_STR);
        $stmt->bindValue("reporting_file_type", $reporting_file_type, PDO::PARAM_STR);
        $stmt->bindValue("reporting_details", $reporting_details, PDO::PARAM_STR);
        $stmt->bindValue("pdfs_list", $pdfs_list, PDO::PARAM_STR);
        $execute = $stmt->execute();

        return $this->getLastIdInserted();
    }

    /** Return an array with the years,months,days differences between 2 dates
     *
     * @param string $start
     * @param string $end
     * @return array
     */
    public function getDateDiff($start, $end, $notpast=false) {
    //echo "end:".$end."<br>\n";
    //echo "-zero:".($end<0)."<br>\n";
        if($end=="0000-00-00" || $end=="" || !$end || $end<0) {
    //echo "true"."<br>\n";
            $result = true;
        } else {
    //echo "test:".(strtotime($end)<strtotime($start))."<br>\n";
            if($notpast && strtotime($end)<strtotime($start)) {
                $result = false;
            } else {
                $year   = 365*60*60*24;
                $month  = 30*60*60*24;
                $day    = 60*60*24;
                $hour   = 60*60;
                $min    = 60;

                $diff   = abs(strtotime($end) - strtotime($start));
                $years  = floor($diff / $year);
                $months = floor(($diff - $years * $year) / $month);
                $days   = floor(($diff - $years * $year - $months*$month) / $day);
                $hours  = floor(($diff - $years * $year - $months*$month - $days*$day) / $hour)-1;
                $mins   = floor(($diff - $years * $year - $months*$month - $days*$day - ($hours+1)*$hour) / $min);
                $secs   = floor(($diff - $years * $year - $months*$month - $days*$day - ($hours+1)*$hour) - $mins*$min);

                $result = array("days"=>$days,"months"=>$months,"years"=>$years,"hours"=>$hours,"mins"=>$mins,"secs"=>$secs);
            }
        }
    //echo "<pre>result:";var_dump($result);echo "</pre>";
        return $result;
    }

    /**
     *
     * @param string $table
     * @param int $user_id
     * @param int $days
     * @return int/boolean
     */
    public function isPeriodSession($user_id, $days=0) {
        $sql = "SELECT * FROM tb_users_sessions";
        $sql .= " WHERE user_id=$user_id";
        $sql .= " ORDER BY start DESC";
    //echo $sql."<br>\n";

        $result = $this->getDatas($sql);
    //echo "<pre>result:";var_dump($result);echo "</pre>";

        if(count($result)>0) {
            $start = $result[0]['start'];
    //echo "start:".$start."<br>\n";
            $today  = date("Y-m-d H:i:s");
    //echo "today:".$today."<br>\n";
            $diff   = $this->getDateDiff($today, $start);
    //echo "<pre>diff:";var_dump($diff);echo "</pre>";
            $already = !$diff || ($diff['years']<=0 && $diff['months']<=0 && $diff['days']<=$days);
    //echo "already:".$already."<br>\n";
    //echo "<pre>result:";var_dump($result[0]);echo "</pre>";
    //echo "result['id']:".$result[0]['id']."<br>\n";
            return $already ? $result[0]:false;
        }
    }

    public function getSessions($fisrt=0,$last=0) {
        $sql = "SELECT us.*, u.id_creator";
        $sql .= " FROM tb_users_sessions AS us";
        $sql .= " INNER JOIN tb_users AS u ON u.id = us.user_id";
        $sql .= " ORDER BY us.id DESC";
    //echo $sql."<br>\n";
        $results = $this->getDatas($sql);
        $session_activ = $fisrt==0 && $last==0;
    //echo "session_activ:".$session_activ."<br>\n";

        $sessions = 0;
        foreach ($results as $session) {
            $dateformat = $session_activ ? "Y-m-d H:i:s":"Y-m-d";
            $start  = date($dateformat, strtotime($session['start']));
            $stop   = date($dateformat, strtotime($session['stop']));
            $online = $session['online'];
            $today  = date($dateformat);
            $theday  = $session_activ ? date($dateformat, strtotime($today. " + 1 hours")):$today;

    //echo "online:".$online."<br>\n";
    //echo "<pre>diff:";var_dump($diff_start);echo "</pre>";
    //echo "start:".$start." / today:".$today."<br>\n";
            // If 'online' in database
            //$is = $session_activ && $online;
    //echo "is:".$is."<br>\n";
            // If is admin
            $is_admin = auth()->user()->type==0;
    //echo "is_admin:".$is_admin."<br>\n";
            // If is client
    //echo "session user_id:".$session['user_id']."<br>\n";
    //echo "SESSION user_id:".$_SESSION['user_id']."<br>\n";
            $is_client = auth()->user()->type==1 && auth()->user()->user_id==$session['user_id'];
    //echo "is_client:".$is_client."<br>\n";
            // If is client's user
            $is_client_user = auth()->user()->type==1 && $session['id_creator']==auth()->user()->id;
    //echo "is_client_user:".$is_client_user."<br>\n";
            $user_authorised = $is_admin || $is_client || $is_client_user;

            $is = $session_activ && $online && $user_authorised;
            // Check if user has been active since 15 mins (see isActivSession method in usersModel)
            $diff_start   = $this->getDateDiff($theday, $start);
            $is = $is && $diff_start['years']<=0 && $diff_start['months']<=0 && $diff_start['days']<=0 && $diff_start['hours']<=0 && $diff_start['mins']<=15;
    //echo "still there:".$is."<br>\n";
            if(!$is && (auth()->user()->id!=$session['user_id']) ) {
                $this->storeSession($session['session_id'], true);
            }

    //echo "is:".$is."<br>\n";

            $is     = !$is && !$session_activ && $user_authorised ? $diff_start['years']<=0:$is;
    //echo "is:".$is."<br>\n";
    //echo "diff['days']:".$diff_start['days']."<br>\n";
    //echo "diff['hours']:".$diff_start['hours']."<br>\n";
    //echo "session_activ:".$session_activ."<br>\n";
            $is     = $is && !$session_activ  ? $diff_start['months']<=0 && $fisrt<=$diff_start['days'] && $diff_start['days']<=$last:$is;
    //echo "is:".$is."<br>\n";


            if($is){
                $sessions++;
            }
    //echo "<br>\n";
        }
    //echo "sessions:".$sessions."<br><br>\n";exit;
        return $sessions;
    }

    /**
     *
     * @param boolean $offline
     * @param int $session_id
     */
    public function storeSession($session_id=null, $offline=false) {
    //echo "<pre>SESSION:";var_dump($_SESSION);echo "</pre>";//exit;
        $table      = "tb_users_sessions";
        $user_id    = isset(auth()->user()->user_id) ? auth()->user()->user_id:null;
    //echo "user_id:".$user_id."<br>\n";

        $is_day_session = $user_id!=null && $this->isPeriodSession($user_id) ? $this->isPeriodSession($user_id):false;
    //echo "<pre>is_day_session:";var_dump($is_day_session);echo "</pre>";
    //echo "session_id:".$session_id."<br>\n";

        $session_id = isset(auth()->user()->session_id) ? auth()->user()->session_id:$session_id;
    //echo "session_id:".$session_id."<br>\n";
        $session_id = $session_id==null && isset($is_day_session['id']) ? $is_day_session['id']:$session_id;
    //echo "session_id:".$session_id."<br>\n";

        $date_zero = "0000-00-00 00:00:00";
        if ($session_id==null) {
            $sql = "INSERT INTO $table (user_id, start, stop,  online) VALUES ($user_id, now(), '$date_zero', 1)";
        } else {
    //echo "offline:".$offline."<br>\n";
            $online      = $offline ? 0:1;
    //echo "online:".$online."<br>\n";
            $field      = $offline ? "stop":"start";

            $sql = "UPDATE $table SET";
            $sql .= " $field=now()";
            $sql .= ", online=".$online;
            $sql .= " WHERE id=$session_id";
        }
    //echo $sql."<br>\n";//exit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        auth()->user()->session_id = $session_id == null || $session_id == "" ? $this->db->lastInsertId():$session_id;
    }

    /**
     *
     * @param string $tablename
     * @return array
     */
    public function getColsDescrption($tablename) {
        $sql = "DESCRIBE tb_$tablename";
    //echo $sql."<br>\n";

        $results = $this->getDatas($sql);

        $cols = array();
        foreach ($results as $col) {
            $cols[] = $col['Field'];
        }
    //var_dump($cols);exit;
        return $cols;
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

    /**
     *
     * @param string $name
     * @param string $surname
     * @return string
     */
    public function generateLogin($name, $surname, $test=0) {
    //echo "name:".$name." | surname:".$surname."\n";
        $login_name     = substr($name, 0, 3);
        $login_surname  = substr($surname, 0, 3);
        $login          = $login_name.$login_surname;
        $login_clean    = preg_replace('/\s+/', '', $login);
        $login_cod      = $login_clean.$this->randomGenerate(4);
        //$login_cod = $test_r>0 ? $login_cod:"admin";
    //echo "login_cod:".$login_cod."\n";
        $exist = $this->checkLogin($login_cod);
    //echo "exist:".$exist."\n";
        if(!$exist){
            return $login_cod;
        } else {
    //echo "else"."\n";
            //$test++;
    //echo "test_r:".$test_r."\n";
            $this->generateLogin($name,$surname,$test);
        }
    }

    /** Used to check if an login is already used for this client, so don't allow user creation
     *
     * @param array $datas
     * @param int $creator_col
     * @return boolean
     */
    public function checkLogin($datas, $creator_col) {
    //echo "action:".$datas['tipo']."\n";
        $creator_id = $this->is_creator($datas['formdatas'], $creator_col);
        if(!$creator_id) {
            $creator_id = auth()->user()->type==4 ? auth()->user()->id_creator:auth()->user()->id;
        }
    //echo "name:".$name."\n";exit;
    //echo "creator_id:".$creator_id."\n";
        $sql = "SELECT COUNT(*) AS nb";
        $sql .= " FROM tb_users u";
        $sql .= " WHERE u.name = '".$datas['login']."'";
        $sql .= " AND u.id_creator = $creator_id";
    //echo $sql."\n";
        $result = $this->getDatas($sql);
    //echo $result[0][nb];exit;
        return $result[0]['nb']>0;
    }

    /**
     *
     * @param array $formdatas
     * @param string $creator_col
     * @return int
     */
    public function is_creator($formdatas, $creator_col) {
        foreach ($formdatas as $item) {
            if($item['name'] == $creator_col) {
                $id_creator = $item['value'];
                break;
            }
        }
        return $id_creator;
    }

    /** Returns query result or errors in a array
     *
     * @param array $update
     * @param string $msg
     * @return array
     */
    public function returnResult($update, $msg="") {
        $error = $msg=="" ? $update['error']:$msg;
        $result = !$update ? array("error"=>$error):$update;
    //var_dump($result);
        return $result;
    }

    /**
     *
     * @param string $root
     * @param string $folder
     * @return array
     */
    public function createDir($root, $folder) {
        $path = SERVER_ROOT . $root . $folder;
    //echo "path:".$path."\n";
        if (!file_exists($path)){
            $make = mkdir($path, 0777);
        }
        return !$make ? array("error"=>"Unable to create the folder '$folder' in '".ROOTPATH . $root."'"):true;
    }

    /**
     *
     * @param string $src
     * @param string $dst
     * @param string $code
     */
    public function recurse_copy($src, $dst, $code) {
        $dir = opendir($src);
    //echo "dir:".$dir."\n";
    //echo "dst:".$dst."\n";
        @mkdir($dst, 0777, true);
    //echo "file_exists:".file_exists($dst)."\n";exit;
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
    //echo "file:".$file."\n";
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file, $code);
                } else {
                    if(strpos($file, "default")>-1){
                        $file_arr = explode(".", $file);
                        $file_new = $code.".".$file_arr[1];
                    } else {
                        $file_new = $file;
                    }
    //echo "file_new:".$file_new."\n";
    //echo "file_new:".$dst . '/' .$file_new."\n";
                    copy($src . '/' . $file, $dst . '/' . $file_new);
                }
            }
        }
        closedir($dir);
    }
}

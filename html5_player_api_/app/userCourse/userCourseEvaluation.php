<?php
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $productId;
    -  @Input $courseId;
    -  @Input $userId;
    -  @Input $screenId
    -  @Input $state
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */
    $return                 = array();
    $return['state']        = 'success';
    $return['productId']    = $productId;
    $return['courseId']     = $courseId;
    $return['screenId']     = $screenId;
    $return['userId']       = $userId;
    $return['date']         = date( 'm.d.y H:i:s' );
    $return['msg']          = 'OK';
    $return['datas']        = array();

    $_SESSION['user_id'] = 6664;
    if ( !$_SESSION['user_id'] )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucunes données trouvées';
        $return['datas']    = array();
    } // eo if
    else
    {
        // Get JSON datas
        $form_data  = json_decode( file_get_contents( 'php://input' ) );

        if ( ! isset( $form_data->startDate ) || ! isset( $form_data->endDate ) )
        {
            $return['state']    = 'error';
            $return['msg']      = 'Toutes les variables requises ne sont pas transmises ';
        } // eo if
        else
        {
            include( dirname( __FILE__ ) . '/../../config/config.php' );
            include( dirname( __FILE__ ) . '/../../dbModel.php' );

            class openModel extends dbModel
            {
                public function __construct($dbdsn = null)
                {
                    parent::__construct($dbdsn);
                } // eo constructor

                public function query( $sql )
                {
                    $results = $this->db->query( $sql );

                    if ( ! $results )
                    {
                        die( print_r( $this->db->errorInfo(), true ) );
                    }
                }
            } // eo openModel class

            $openModel  = new openModel;

            // Verify session and product
            $sql        = "SELECT idFabrica FROM tb_user_session WHERE session = '" . $form_data->session . "' ";
            $results    = $openModel->getDatas( $sql );

            if ( count( $results ) == 0 )
            {
                $return['state']    = 'error';
                $return['msg']      = 'Erreur la session n\'existe pas.';
            } //eo if
            else
            {
                $row    = $results[0];

                if ( strtolower( $productId ) != strtolower( $row['idFabrica'] ) )
                {
                    $return['state']    = 'error';
                    $return['msg']      = 'Session invalide.';
                } // eo if
                else
                {
                    // everythings allright
                    // Calculate evaluation note
                    if ( intval( $form_data->scoreMax ) == 0 )
                    {
                        $note   = 0;
                    } // eo if
                    else
                    {
                        $note   = ( intval( $form_data->scoreRaw ) * 100 ) / intval( $form_data->scoreMax );
                    } // eo else

                    if($sessionId){
                        $insertModel = new openModel(DB_HISTORIC_DSN);
                        $evalTableName = "tb_evaluation_" . $sessionId;
                        $createSql = "CREATE TABLE IF NOT EXISTS `{$evalTableName}` ("
                            . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                            . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`date_start` datetime DEFAULT NULL,"
                            . "`date_end` datetime DEFAULT NULL,"
                            . "`is_presential` int(1) DEFAULT '0',"
                            . "`user_keypad` int(11) DEFAULT '0',"
                            . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
                            . "`number_eval` int(11) DEFAULT NULL,"
                            . "`progression` int(11) NOT NULL DEFAULT '0',"
                            . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
                            . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "PRIMARY KEY (id) "
                          . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
                        $insertModel->query( $createSql );
                        $questionTableName = "tb_evaluation_question_" . $sessionId;
                        $createSql = "CREATE TABLE IF NOT EXISTS `{$questionTableName}` ("
                            . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                            . "`id_evaluation` int(11) DEFAULT NULL,"
                            . "`id_q` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`id_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`name_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`num_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'order of question',"
                            . "`title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`option_serialize` text COLLATE utf8_unicode_ci,"
                            . "`expected_response` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`reply` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "`points` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                            . "PRIMARY KEY (id) "
                          . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
                        $insertModel->query( $createSql );
                    } else {
                        $insertModel = new openModel;
                        $evalTableName = "evaluation";
                        $questionTableName = "evaluation_question";
                    }

                    // Insert evaluation
                    $sql  = "INSERT INTO {$evalTableName}( `session`, `user_id`, `date_start`, `date_end`, `is_presential`, `id_lesson`, `note`, `status`, `number_eval` ) VALUES( ";
                    $sql .= "  '" . $form_data->session . "'";
                    $sql .= ", '" . $form_data->user_id . "'";
                    $sql .= ", '" . $form_data->startDate . "'";
                    $sql .= ", '" . $form_data->endDate . "'";
                    $sql .= ", 0 ";
                    $sql .= ", '" . $productId . "'";
                    $sql .= ", "  . number_format( $note, 2 );
                    $sql .= ", '" . $form_data->status . "'";
                    $sql .= ", 0 ) ";

                    // Execute query
                    $results        = $insertModel->query( $sql );
                    $evaluation_id  = $insertModel->getLastIdInserted();

                    $optim_eval_datas   = array(
                         'id_user'       => $form_data->user_id
                        ,'id_fabrique'   => $productId
                        ,'id_eval'       => $evaluation_id
                        ,'date_end'      => $form_data->endDate
                    );

                    // Test for preproduction, for PHP7 compatiblity turnaround
                    if ( ! isset( $preproduction ) || ! $preproduction  )
                    {
                        /** Connexion MySQL obligatoire car optim utilise des instrutions mysql_* au lieu de PDO comme ailleurs dans le LMS ... */
                        // mysql_connect('localhost','root', DB_PASSWORD ) or die("mysql server fail(connection)");
                        // mysql_select_db('lms') or die("mysql db fail (connection)Problemas com o arquivos de dados");
                        // mysql_query("SET NAMES utf8");
                        require_once( dirname( __FILE__ ) . '/../open/optim.php' );
                        treatOptimEval( $optim_eval_datas );
                    } // eo if

                    // Insert evaluation questions responses
                    foreach( $form_data->questions as $question )
                    {
                        // Prepare SQL statement
                        // Calulate question ID
                        $qid        = 'G' . $question->pool_id . 'Q' . $question->interractionId;
                        $options    = serialize( $question->options );

                        $sql  = "INSERT INTO {$questionTableName} ( `id_evaluation`, `id_q`, `id_group`, `name_group`, `num_order`, `title`, `option_serialize`, `expected_response`, `reply`, `points` ) VALUES( ";
                        $sql .= $evaluation_id;
                        $sql .= ", '" . $qid . "'";
                        $sql .= ", '" . $question->pool_id . "'";
                        $sql .= ", '" . $question->pool_name . "'";
                        $sql .= ", '" . $question->order . "'";
                        $sql .= ", '" . $question->question . "'";
                        $sql .= ", '" . $options . "'";
                        $sql .= ", '" . $question->expectedResponse . "'";
                        $sql .= ", '" . $question->userResponse . "'";
                        $sql .= ", '" . $question->scoreRaw . "')";

                        // Execute query
                        $results        = $insertModel->query( $sql );
                    } // eo foreach
                } // eo else
            } // eo else
        } // eo else
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

?>

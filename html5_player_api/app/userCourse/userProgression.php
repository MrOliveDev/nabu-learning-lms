<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $productId;
    -  @Input $courseId;
    -  @Input $userId;
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return = array();
        $return['state']        = 'success';
        $return['productId']    = $productId;
        $return['userId']       = $userId;
        $return['date']         = date( 'm.d.y H:i:s' );
        $return['msg']          = 'OK';
        $return['datas']        = array();
    /* ----------------------------------------------------------------------
    - Préparation du XML
    -
    -
    ----------------------------------------------------------------------- */
    /*
    $xmlString = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlString .= '<historic>';
            $xmlString .= '<userId>'.$userId.'</userId>';
            $xmlString .= '<productCode>'.$productId.'</productCode>';
            $xmlString .= '<courseId>'.$courseId.'</courseId>';
        $xmlString .= '</historic>';
    */

    /* ----------------------------------------------------------------------
    - REQUETE CURL
    -
    -
    ----------------------------------------------------------------------- */


    /* ----------------------------------------------------------------------
    - ENVOI DE LA REPONSE FORMAT JSON
    -
    -
    ----------------------------------------------------------------------- */
    if ( !(auth()->check()) )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucunes données trouvées';
        $return['datas']    = array();
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

        /**
         * GET historic datas from DATABASE
         */

        $openModel  = new openModel;
        $curso_sql = 'select * from tb_lesson where idFabrica = "'.$productId.'"';
        $curso_result = $openModel->getDatas( $curso_sql );
        $cursoId = $curso_result[0]['id'];
        $return['cursoId']       = $cursoId;

        if($sessionId){
            $tableName = "tb_screen_optim_" . $sessionId;
            $openModel = new openModel(DB_REPORTS_DSN);
            $createSql = "CREATE TABLE IF NOT EXISTS `{$tableName}` ("
            . "`id_screen_optim` int(11) NOT NULL AUTO_INCREMENT,"
            . "`id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,"
            . "`id_curso_screen_optim` int(11) NOT NULL,"
            . "`id_user_screen_optim` int(11) NOT NULL,"
            . "`progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,"
            . "`progress_screen_optim` float(5,2) NOT NULL,"
            . "`last_date_screen_optim` datetime NOT NULL,"
            . "`first_eval_id_screen_optim` int(11) NOT NULL,"
            . "`last_eval_id_screen_optim` int(11) NOT NULL,"
            . "PRIMARY KEY (id_screen_optim) "
            . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            $openModel->query( $createSql );
        } else {
            $openModel  = new openModel;
            $tableName = "tb_screen_optim";
        }
        $sql         = "SELECT `id_screen_optim`, `id_fabrique_screen_optim`, `id_curso_screen_optim`, `id_user_screen_optim`, `progress_details_screen_optim` ";
        $sql        .= "FROM `{$tableName}` ";
        $sql        .= "WHERE `id_fabrique_screen_optim` = '".$productId."' AND `id_curso_screen_optim` = ".$cursoId." AND `id_user_screen_optim` = ".$userId;
        $sql        .= " ORDER BY `id_screen_optim` DESC";

        $results    = $openModel->getDatas( $sql );

        if(count($results) == 0)
        {
            $return['details'] = array();
        }
        else
            $return['details']  = $results[0]['progress_details_screen_optim'];

    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

?>

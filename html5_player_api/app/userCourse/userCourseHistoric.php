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
        $return['courseId']     = $courseId;
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
    if ( !$_SESSION['user_id'] )
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

        if($sessionId){
            $openModel = new openModel(DB_HISTORIC_DSN);
            $tableName = 'tb_screen_stats_' . $sessionId;
            $createSql = "CREATE TABLE IF NOT EXISTS `tb_screen_stats_" . $sessionId . "` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`date` date DEFAULT NULL,"
                     . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`id_screen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`question` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`h_begin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`h_end` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`reg_date` date DEFAULT NULL,"
                     . "`idFabrica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
                     . "`is_chapter` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'to know if a screen is a chapter',"
                     . "PRIMARY KEY (id) "
                     . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            $openModel->query( $createSql );
        } else{
            $openModel  = new openModel;
            $tableName = 'screen_stats';
        }

        /**
         * GET historic datas from DATABASE
         */
        $sql         = "SELECT `{$tableName}`.`id_screen`, `{$tableName}`.`status`, CONCAT( `{$tableName}`.`reg_date`, ' ', `{$tableName}`.`h_end` ) AS `date_screen` ";
        //$sql        .= "FROM `{$tableName}` INNER JOIN `tb_lesson` ON `tb_lesson`.`idFabrica` = `{$tableName}`.`idFabrica` ";
        $sql        .= "FROM `{$tableName}` ";
        $sql        .= "WHERE `{$tableName}`.`user_id` = " . intval( $userId ) . " AND `{$tableName}`.`idFabrica` = '" . $productId . "' ";
        $sql        .= "ORDER BY `date_screen` DESC";

        $results    = $openModel->getDatas( $sql );

        $return['datas']['stateItems']  = array();

        if ( count( $results ) == 0 )
        {
            $return['state']    = 'success';
            $return['msg']      = 'Pas d\'historique';
        } // eo if
        else
        {
            // Read datas
            $items                          = array();
            $countRow                       = 0;

            foreach( $results as $row )
            {
                // Check for lastitem
                if ( $countRow == 0 )
                {
                    $return['datas']['lastItem']    = $row['id_screen'];
                } // eo if

                // Verify if item is already read
                if ( in_array( intval( $row['id_screen'] ), $items ) )
                {
                    continue;
                } // eo if

                $return['datas']['stateItems'][$row['id_screen']]   = $row['status']; // Vue partiellement
                $items[]                                            = intval( $row['id_screen'] );

                $countRow++;
            } // eo foreach
        } // eo else

    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

?>

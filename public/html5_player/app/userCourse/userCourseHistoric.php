<?php
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
    if ( ! session()->exists('user_id') )
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
            public function __construct()
            {
                parent::__construct();
            } // eo constructor
        } // eo openModel class

        $openModel  = new openModel;

        /**
         * GET historic datas from DATABASE
         */
        $sql         = "SELECT `screen_stats`.`id_screen`, `screen_stats`.`status`, CONCAT( `screen_stats`.`reg_date`, ' ', `screen_stats`.`h_end` ) AS `date_screen` ";
        $sql        .= "FROM `screen_stats` INNER JOIN `tb_curso` ON `tb_curso`.`idFabrica` = `screen_stats`.`idFabrica` ";
        $sql        .= "WHERE `screen_stats`.`user_id` = " . intval( $userId ) . " AND `tb_curso`.`idFabrica` = '" . $productId . "' ";
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

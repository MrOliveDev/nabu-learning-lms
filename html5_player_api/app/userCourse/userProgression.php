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
            public function __construct()
            {
                parent::__construct();
            } // eo constructor
        } // eo openModel class

        $openModel  = new openModel;

        /**
         * GET historic datas from DATABASE
         */

        $curso_sql = 'select * from tb_lesson where idFabrica = "'.$productId.'"';
        $curso_result = $openModel->getDatas( $curso_sql );
        $cursoId = $curso_result[0]['id'];
        $return['cursoId']       = $cursoId;

        $sql         = "SELECT `id_screen_optim`, `id_fabrique_screen_optim`, `id_curso_screen_optim`, `id_user_screen_optim`, `progress_details_screen_optim` ";
        $sql        .= "FROM `tb_screen_optim` ";
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

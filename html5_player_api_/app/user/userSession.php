<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $userId;
    -  @Input $productId;
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return             = array();
    $return['state']    = 'success';
    $return['date']     = date( 'm.d.y H:i:s' );
    $return['msg']      = 'Session crée';
    $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    -
    -
    ----------------------------------------------------------------------- */
    function aleatorio( $limite = 10 )
    {
        $novo_valor = '';
        $valor      = 'abcdefghijklmnopqrstuvwxyz0123456789';

        srand( (double) microtime() * 1000000 );

        for ( $i = 0; $i < $limite; $i++ )
        {
            $novo_valor.= $valor[rand() % strlen( $valor )];
        } // eo for

        return $novo_valor;
    } // eo aleatorio function

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
    $_SESSION['user_id'] = 6664;
    if ( !$_SESSION['user_id'] )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Votre session a expirée ou vous ne vous êtes pas identifié - veuillez vous reconnecter';
        $return['datas']    = array();
    } // eo if
    else
    {
        if ( ! isset( $userId ) )
        {
            $return['state']    = 'error';
            $return['msg']      = 'User ID manquant';
        } // eo if
        else
        {
            $sql            = "SELECT * FROM tb_users WHERE id = " . $userId;
            $results        = $openModel->getDatas( $sql );
            $user_creator   = $results[0]['id_creator'];
            $user_type      = $results[0]['type'];
            // $edit           = $user_type<=1 && isset( $_GET['edit'] ) ? "_edit" : ""; // Normalement, ne sert à rien
            $id_client      = $user_type <= 1 ? $userId : $user_creator;

            if ( $user_type == 4 )
            {
                $sql        = "SELECT * FROM tb_users WHERE id = " . $user_creator . " AND `type` = 3";
                $results    = $openModel->getDatas( $sql );

                if ( count( $results ) > 0 )
                {
                    $id_client  = $results[0]['id_creator'];
                } // eo if
            } // eo if

            if ( ! isset( $_GET['ID_session'] ) )
            {
                $ID_session = aleatorio();
                $sql        = "INSERT INTO tb_user_session (id, session, idFabrica, user_id) VALUES (NULL, '$ID_session', '" . $productId . "', '$userId' )";

                $openModel->getDatas( $sql );
            } // eo if
            else
            {
                $ID_session = $_GET['ID_session'];
            } // eo else
        } // eo else

        $return['datas']['sessionId']   = $ID_session;
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

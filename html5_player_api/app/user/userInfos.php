<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $userId;
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return             = array();
    $return['state']    = 'success';
    $return['date']     = date( 'm.d.y H:i:s' );
    $return['msg']      = 'Utilisateur existant';
    $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    -
    -
    ----------------------------------------------------------------------- */
    function aleatorio( $limite = 10 )
    {
        $novo_valor     = '';
        $valor          = 'abcdefghijklmnopqrstuvwxyz0123456789';

        srand( (double) microtime() * 1000000 );

        for ( $i = 0; $i < $limite; $i++ )
        {
            $novo_valor.= $valor[rand() % strlen( $valor )];
        }

        return $novo_valor;
    }
    if ( !(auth()->check()) )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Votre session a expirée ou vous ne vous êtes pas identifié - veuillez vous reconnecter';
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
         * GET user datas from DATABASE
         */

        $sql            = "SELECT * FROM tb_users WHERE id = " . $userId;
        $results        = $openModel->getDatas( $sql );
        $user_datas     = $results[0];
        $lang           = $user_datas['lang'];
        $type           = $user_datas['type'];
        $profil         = $user_datas['profile'];
        $user_creator   = $user_datas['id_creator'];

        if ( count( $results ) == 0 )
        {
            $return['state']    = 'error';
            $return['msg']      = 'Utilisateur inexistant';
        } // eo if
        else
        {
            $return['datas']['userId']  = $userId;
            $return['datas']['lang']    = $lang;
            $return['datas']['type']    = $type;
            $return['datas']['profil']  = $profil;
        } // eo else
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

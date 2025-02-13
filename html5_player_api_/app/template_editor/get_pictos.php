<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $debug_api  = false;

    if ( $debug_api )
    {
        echo "/* Debug mode is on */";
    }

    $return = array();
        $return['state']    = 'success';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Pictos list retrieved';
        $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    - SELECT * FROM `tb_awesome_hexa`
    -
    ----------------------------------------------------------------------- */
    // var_dump(session('user_id'));
    $_SESSION['user_id'] = 6664;
    if ( !$_SESSION['user_id'] )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucune données trouvées';
        $return['datas']    = array();
    }
    else
    {
        include( dirname( __FILE__ ) . '/../../config/config.php' );
        include( dirname( __FILE__ ) . '/../../dbModel.php' );

        class openModel extends dbModel
        {
            public function __construct()
            {
                parent::__construct();
            }
        }

        $openModel  = new openModel;
        $sql        = "SELECT * FROM tb_awesome_hexa ";

        if ( $debug_api )
        {
            echo "/*SQL ==> \n$sql */";
            $return['sql']    = $sql;
        }

        $results    = $openModel->getDatas( $sql );

        $return['datas']['pictos']  = $results;
    }

    header( 'Content-type: application/json' );
    echo json_encode( $return );

    die();

?>

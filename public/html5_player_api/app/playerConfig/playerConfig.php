<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $productId;
    -  @Input $courseId;
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return = array();
        $return['state']    = 'success';
        $return['date']     = date("m.d.y H:i:s");
        $return['msg']      = 'Template config';
        $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE 
    -
    -
    ----------------------------------------------------------------------- */
    if ( ! isset( $_SESSION['user_id'] ) )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucune données trouvées';
        $return['datas']    = array();
    }
    else
    {
        $return['datas']['templateId']  = "e400cccbf753850c825cefecc1ba0113"; // Temporaire
    }

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();
<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $templateId;
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
        $return['msg']      = 'Template configuration retrieved';
        $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    - SELECT * FROM `tb_awesome_hexa`
    -
    ----------------------------------------------------------------------- */
    if ( ! session()->exists('user_id') )
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

        $sql        = "SELECT * FROM tb_template_html5_edit WHERE alpha_id='" . $templateId . "'";

        if ( $debug_api )
        {
            echo "/*SQL ==> \n$sql */";
            $return['sql']    = $sql;
        }

        $results                        = $openModel->getDatas( $sql );
        $results[0]['style']            = unserialize( $results[0]['style'] );
        $return['datas']                = $results[0];
    }

    header( 'Content-type: application/json' );
    echo json_encode( $return );

    die();

?>

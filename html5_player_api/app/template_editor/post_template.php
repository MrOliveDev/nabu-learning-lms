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
        $return['msg']      = 'Template configuration saved';
        $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    - SELECT * FROM `tb_awesome_hexa`
    -
    ----------------------------------------------------------------------- */
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

            public function query( $sql )
            {
                $results = $this->db->query( $sql );

                if ( ! $results )
                {
                    die( print_r( $this->db->errorInfo(), true ) );
                }
            }
        }

        $form_data  = json_decode( file_get_contents( 'php://input' ) );
        $style      = serialize( $form_data->json );

            switch ( $form_data->xaction )
        {
            case 'save' :
            {
                $sql         = "UPDATE tb_template_html5_edit SET style='$style', published=0, name='" . $form_data->name . "' WHERE alpha_id='" . $templateId . "'";
                break;
            }
            case 'publish' :
            {
                $sql         = "UPDATE tb_template_html5 SET style='$style', name='" . $form_data->name . "' WHERE alpha_id='" . $templateId . " '; ";
                $sql        .= "UPDATE tb_template_html5_edit SET style='$style', published=1, name='" . $form_data->name . "' WHERE alpha_id='" . $templateId . "'";
                break;
            }
            default :
            {
                $return['state']    = 'error';
                $return['date']     = date( 'm.d.y H:i:s' );
                $return['msg']      = 'xaction inconnu';
                $return['datas']    = array();
                $return['form_data']    = json_encode( $form_data );
                break;
            }
        }

        $openModel   = new openModel;

        if ( $debug_api )
        {
            echo "/*SQL ==> \n$sql */";
            $return['sql']    = $sql;
        }

        $results    = $openModel->query( $sql );

        $return['datas']['sql']  = $sql;
        $return['datas']['results']  = $results;
    }

    header( 'Content-type: application/json' );
    echo json_encode( $return );

    die();

?>

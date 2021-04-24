<?php
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $productId;
    -  @Input $courseId;
    -  @Input $userId;
    -  @Input $screenId
    -  @Input $state
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */
    $return                 = array();
    $return['state']        = 'success';
    $return['productId']    = $productId;
    $return['courseId']     = $courseId;
    $return['screenId']     = $screenId;
    $return['userId']       = $userId;
    $return['date']         = date( 'm.d.y H:i:s' );
    $return['msg']          = 'OK';
    $return['datas']        = array();

    if ( ! session()->exists('user_id') )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucunes données trouvées';
        $return['datas']    = array();
    } // eo if
    else
    {
        // Get JSON datas
        $form_data  = json_decode( file_get_contents( 'php://input' ) );

        // TODO Alain : Voir si isAppendix sert à quelque chose.

        if ( ! isset( $form_data->isChapter ) || ! isset( $form_data->isAppendix ) || ! isset( $form_data->startDate ) || ! isset( $form_data->endDate ) )
        {
            $return['state']    = 'error';
            $return['msg']      = 'Toutes les variables requises ne sont pas transmises ';
            $return['form_data'] = $form_data;
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

                public function query( $sql )
                {
                    $results = $this->db->query( $sql );

                    if ( ! $results )
                    {
                        die( print_r( $this->db->errorInfo(), true ) );
                    }
                }
            } // eo openModel class

            $openModel  = new openModel;

            // Verify session and product
            $sql        = "SELECT idFabrica FROM tb_session WHERE session = '" . $form_data->session . "' ";
            $results    = $openModel->getDatas( $sql );

            if ( count( $results ) == 0 )
            {
                $return['state']    = 'error';
                $return['msg']      = 'Erreur la session n\'existe pas.';
            } // eo if
            else
            {
                $row    = $results[0];

                if ( strtolower( $productId ) != strtolower( $row['idFabrica'] ) )
                {
                    $return['state']    = 'error';
                    $return['msg']      = 'Session invalide.';
                } // eo if
                else
                {
                    // everythings allright
                    $hour_begin = substr( $form_data->startDate, 11, 8 );
                    $hour_end   = substr( $form_data->endDate, 11, 8 );
                    $reg_date   = substr( $form_data->startDate, 0, 10 );
                    $question   = $form_data->question;

                    // Insert screen_stats
                    $sql = "INSERT INTO screen_stats (user_id, id_screen, session, question, h_begin, h_end,status, reg_date, idFabrica, is_chapter) VALUES ( ";
                    $sql .= "  '" . $form_data->user_id . "'";
                    $sql .= ", '" . $form_data->id_screen . "'";
                    $sql .= ", '" . $form_data->session . "'";
                    $sql .= ", '" . $question . "'";
                    $sql .= ", '" . $hour_begin . "'";
                    $sql .= ", '" . $hour_end . "'";
                    $sql .= ", '" . $form_data->status . "'";
                    $sql .= ", '" . $reg_date . "'";
                    $sql .= ", '" . $productId . "' ";
                    $sql .= ", '" . $form_data->isChapter . "' )";

                    // Execute query
                    $results        = $openModel->query( $sql );

                    $optim_datas    = array(
                         'id_user'       => $form_data->user_id
                        ,'id_fabrique'   => $productId
                        ,'id_screen'     => $form_data->id_screen
                        ,'hour_begin'    => $hour_begin
                        ,'hour_end'      => $hour_end
                        ,'reg_date'      => $reg_date
                        ,'status'        => $form_data->status
                    );

                    // Test for preproduction, for PHP7 compatiblity turnaround
                    if ( ! isset( $preproduction ) || ! $preproduction  )
                    {
                        /** Connexion MySQL obligatoire car optim utilise des instrutions mysql_* au lieu de PDO comme ailleurs dans le LMS ... */
                        //mysql_connect('localhost','root', DB_PASSWORD ) or die("mysql server fail(connection)");
                        //mysql_select_db('lms') or die("mysql db fail (connection)Problemas com o arquivos de dados");
                        //mysql_query("SET NAMES utf8");
			$return['optim_datas'] = $optim_datas;
                        require_once( dirname( __FILE__ ) . '/../../../open/optim.php' );
                        $return['payload'] = treatOptim( $optim_datas );
                    }
                } // eo else
            } // eo else
        } // eo else
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

?>

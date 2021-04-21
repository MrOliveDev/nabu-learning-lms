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
    
    if ( ! isset( $_SESSION['user_id'] ) )
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

        if ( ! isset( $form_data->startDate ) || ! isset( $form_data->endDate ) )
        {
            $return['state']    = 'error';
            $return['msg']      = 'Toutes les variables requises ne sont pas transmises ';
        } // eo if
        else
        {
            include( dirname( __FILE__ ) . '/../../../config/config.php' );
            include( dirname( __FILE__ ) . '/../../../model/dbModel.php' );
    
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
            } //eo if
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
                    // Calculate evaluation note
                    if ( intval( $form_data->scoreMax ) == 0 )
                    {
                        $note   = 0;
                    } // eo if
                    else
                    {
                        $note   = ( intval( $form_data->scoreRaw ) * 100 ) / intval( $form_data->scoreMax );
                    } // eo else

                    // Insert evaluation
                    $sql  = "INSERT INTO evaluation( `session`, `user_id`, `date_start`, `date_end`, `is_presential`, `id_lesson`, `note`, `status`, `number_eval` ) VALUES( ";
                    $sql .= "  '" . $form_data->session . "'"; 
                    $sql .= ", '" . $form_data->user_id . "'";
                    $sql .= ", '" . $form_data->startDate . "'";
                    $sql .= ", '" . $form_data->endDate . "'";
                    $sql .= ", 0 "; 
                    $sql .= ", '" . $productId . "'"; 
                    $sql .= ", "  . number_format( $note, 2 ); 
                    $sql .= ", '" . $form_data->status . "'"; 
                    $sql .= ", 0 ) "; 

                    // Execute query
                    $results        = $openModel->query( $sql );
                    $evaluation_id  = $openModel->getLastIdInserted();

                    $optim_eval_datas   = array(
                         'id_user'       => $form_data->user_id
                        ,'id_fabrique'   => $productId
                        ,'id_eval'       => $evaluation_id
                        ,'date_end'      => $form_data->endDate
                    );

                    // Test for preproduction, for PHP7 compatiblity turnaround
                    if ( ! isset( $preproduction ) || ! $preproduction  )
                    {
                        /** Connexion MySQL obligatoire car optim utilise des instrutions mysql_* au lieu de PDO comme ailleurs dans le LMS ... */
                        mysql_connect('localhost','root', DB_PASSWORD ) or die("mysql server fail(connection)");
                        mysql_select_db('lms') or die("mysql db fail (connection)Problemas com o arquivos de dados");
                        mysql_query("SET NAMES utf8");
                        require_once( dirname( __FILE__ ) . '/../../../open/optim.php' );
                        treatOptimEval( $optim_eval_datas );
                    } // eo if

                    // Insert evaluation questions responses
                    foreach( $form_data->questions as $question )
                    {
                        // Prepare SQL statement
                        // Calulate question ID
                        $qid        = 'G' . $question->pool_id . 'Q' . $question->interractionId;
                        $options    = serialize( $question->options );

                        $sql  = "INSERT INTO evaluation_question ( `id_evaluation`, `id_q`, `id_group`, `name_group`, `num_order`, `title`, `option_serialize`, `expected_response`, `reply`, `points` ) VALUES( ";
                        $sql .= $evaluation_id;
                        $sql .= ", '" . $qid . "'";
                        $sql .= ", '" . $question->pool_id . "'";
                        $sql .= ", '" . $question->pool_name . "'";
                        $sql .= ", '" . $question->order . "'";
                        $sql .= ", '" . $question->question . "'";
                        $sql .= ", '" . $options . "'";
                        $sql .= ", '" . $question->expectedResponse . "'";
                        $sql .= ", '" . $question->userResponse . "'";
                        $sql .= ", '" . $question->scoreRaw . "')";

                        // Execute query
                        $results        = $openModel->query( $sql );
                    } // eo foreach
                } // eo else
            } // eo else
        } // eo else
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

?>
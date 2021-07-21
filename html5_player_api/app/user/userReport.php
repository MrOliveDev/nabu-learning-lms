<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return             = array();
    $return['state']    = 'success';
    $return['date']     = date( 'm.d.y H:i:s' );
    $return['msg']      = 'Est connecté';
    $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE CURL
    -
    -
    ----------------------------------------------------------------------- */
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

        $form_data  = json_decode( file_get_contents( 'php://input' ) );

        $sql = "INSERT INTO tb_user_report (id, userid, content, lessoncode, screencode) VALUES (NULL, '" . $userId . "', '" . $form_data->report . "', '" . $form_data->lessoncode . "', '" . $form_data->screencode . "' )";

        $openModel->getDatas( $sql );

        $sql            = "SELECT * FROM tb_users WHERE id = " . $userId;
        $results        = $openModel->getDatas( $sql );
        $user_datas     = $results[0];

        $headers = "MIME-Version: 1.0\n";
        $headers.= "Content-type: text/html; charset=utf-8\n";
        $headers.= "From: " . $user_datas['email'] . "\n";
        $headers.= "Bcc: olivesondev@gmail.com" . "\n";

        $body = "<p>UserID: ". $userId . "</p>\n";
        $body .= "<p>User Login: ". $user_datas['login'] . "</p>\n";
        $body .= "<p>Lesson Code: ". $form_data->lessoncode . "</p>\n";
        $body .= "<p>Screen Code: ". $form_data->screencode . "</p>\n";
        $body .= "<p>Server Name: ov-c70599.infomaniak.ch (DEV) </p>\n";
        $body .= "<p>Report Text: ". $form_data->report . "</p>\n";
        $body .= "<p>Report Time: ". date( 'm.d.y H:i:s' ) . "</p>\n";

        $headers.= "Reply-To: " . $user_datas['email'] . "\n";
        $antispam = "-f" . $user_datas['email'];

        mail('olivesondev@gmail.com', 'NabuLMS Report', $body, $headers, $antispam);
        mail('s.acacia@nabu-learning.com', 'NabuLMS Report', $body, $headers, $antispam);
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

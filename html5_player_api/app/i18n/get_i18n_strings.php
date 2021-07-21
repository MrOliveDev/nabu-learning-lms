<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $languageId
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $debug_api  = false;

    if ( $debug_api )
    {
        echo "/* Debug mode is on */";
    } // eo if

    $return             = array();
    $return['state']    = 'success';
    $return['date']     = date( 'm.d.y H:i:s' );
    $return['msg']      = 'Pictos list retrieved';
    $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    - SELECT * FROM `tb_awesome_hexa`
    -
    ----------------------------------------------------------------------- */
    if ( !(auth()->check()) )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Aucune données trouvées';
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

        $openModel   = new openModel;
        $sql         = "SELECT CONCAT( REPLACE( UPPER( cei_process_special_chars(t.translation_string) ), ' ', '_') ) AS 'string_alpha_id', t.translation_string, t.translation_value ";
        $sql        .= "FROM `tb_languages` AS l INNER JOIN tb_translations AS t ON l.language_id=t.language_id WHERE l.language_iso='$languageId' ; ";

        if ( $debug_api )
        {
            echo "/*SQL ==> \n$sql */";
            $return['sql']    = $sql;
        } // eo if

        $results    = $openModel->getDatas( $sql );

        foreach ( $results as $key => $row )
        {
            if ( ( $row['translation_value'] == '' ) || ( $row['translation_value'] == null ) )
            {
                $results[$key]['translation_value']   = $row['translation_string'];
            } // eo if
        } // eo foreach

        $return['datas']['translated_strings']  = $results;
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );

    die();

?>

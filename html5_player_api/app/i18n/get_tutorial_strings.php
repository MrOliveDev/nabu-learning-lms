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
    $return['msg']      = 'Tutorial strings retrieved';
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
        if($appType == 'player'){
            $lang = 'fr';
            if( $language && $language != '' ) $lang = $language;

            $sql         = "SELECT element, intro, position, sortIndex from tb_tutorial_translations where lang = '" . $lang . "' AND type = 'player'";

            $results    = $openModel->getDatas( $sql );
            if(count($results) == 0){
                $sql = "SELECT element, intro, position, sortIndex from tb_tutorial_translations where lang = 'en' AND type = 'player'";
                $results = $openModel->getDatas( $sql );
            }
        } else {
            $sql         = "SELECT element, intro, position, lang, sortIndex, type from tb_tutorial_translations where type = '" . $appType . "'";
            if(isset($language) && $language != 'full')
                $sql = $sql . " AND lang = '" . $language . "'";

            $results    = $openModel->getDatas( $sql );
        }

        if ( $debug_api )
        {
            //echo "/*SQL ==> \n$sql */";
            $return['sql']    = $sql;
        } // eo if

        $return['datas'] = $results;
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );

    die();

?>

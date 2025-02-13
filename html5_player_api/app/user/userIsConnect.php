<?php
    use Illuminate\Contracts\Session\Session;

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
        $return['datas']['userId']  = auth()->user()->id;
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();

<?php

$doc = simplexml_load_string( '<?xml version="1.0" standalone="yes"?>' . file_get_contents( '../../../../../../export_online/VQZ6QXBF/content/OTAO0VGB4/OTAO0VGB4_fr.xml' ) );

// dirty fix
foreach ( $doc->children() as $item )
{
    echo $item->getName() . "\n";
    
    if ( $item->getName() == 'content' )
    {
        doOrder( $item );
    }
}

function doOrder ( $node )
{

}


?>
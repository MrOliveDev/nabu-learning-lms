<?php
	include( dirname( __FILE__ ) . '/../config/config.php' );
	include ("fileSearch.php");

	if(isset($_POST['idFabrica']))
	{
		$fileSearch = new fileSearch;
		$fileSearch->initialize();
		if($_POST['mode'] == 'online')
			$fileSearch->listFolderFiles(FABRIQUE_PRODUCTS_PATH.$_POST['idFabrica']);
		else if($_POST['mode'] == 'fabrique')
			$fileSearch->listFolderFiles(PRODUCTS_FABRIQUE_PATH.$_POST['idFabrica']);
		else if($_POST['mode'] == 'api')
			$fileSearch->listFolderFiles(FABRIQUE_API_PRODUCTS.$_POST['idFabrica']);
		
        echo json_encode($fileSearch->flvArray);
	}
	else
		echo json_encode(array());
?>
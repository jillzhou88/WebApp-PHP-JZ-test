<?php


session_start();

//var_dump($_SESSION);

if($_SESSION['check'] == TRUE) {
	$_SESSION['check'] = FALSE;
	
	$_SESSION['row'] = array();

	header('Location: login.php');
}

?>
<?php 
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'authenticate.php';

	function GetUser() {
		// check if username and password keys are in url
		if (!empty($_GET['email']) && !empty($_GET['password'] )) {
			if (Authenticate($_GET['email'], $_GET['password'])) {
				echo json_encode(Authenticate($_GET['email'], $_GET['password']));
			}
		} else echo 'No username/password param(s) provided, use ?email=x&password=x in url';

	}
	GetUser();
?>
<?php 
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


//sql to create user table
/*
CREATE TABLE `todoapi`.`users` ( `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT , `email` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `Firstname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `Lastname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `Password` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , PRIMARY KEY (`ID`), UNIQUE (`email`)) ENGINE = MyISAM;
*/

?>
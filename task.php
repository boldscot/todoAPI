<?php
include 'authenticate.php';

function CreateTask() {
	// check if username and password keys are in url
	if (!empty($_GET['email']) && !empty($_GET['password'])) {
		// check if valid email and pw
		if (Authenticate($_GET['email'], $_GET['password'])) {
			// check if valid fields are present for task creation
			if (!empty($_GET['taskName']) && !empty($_GET['taskType']) && !empty($_GET['taskPriority'])) {
				// 
				$name=  $_GET['taskname'];
				$type = $_GET['taskType'];
				$priority = $_GET['priority'];

				// priority will be between 1 and 10
				if ($priority > 10) $priority = 10
				if ($priority < 1) $priority = 1;

				//validate name
				if (strlen($name) > 100 || strlen($name) < 5) {
					echo json_encode("Task name to short/long, n > 5 < 100");
					return;
				} 

				// validate status
				$type= strtolower($type);
				if ($type != 'home' || $type != 'work') {
					echo json_encode("Task type should be home or work");
					return;
				}

			}
		}
	} else echo json_encode('No username/password param(s) provided, use ?email=x&password=x in url');	

}

CreateTask();


/*

CREATE TABLE `todoapi`.`TASK` ( `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,  `ownerID` INT UNSIGNED NOT NULL ,  `priority` TINYINT UNSIGNED NOT NULL ,  `type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,  `status` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,  `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,    PRIMARY KEY  (`ID`)) ENGINE = MyISAM;
*/

?>

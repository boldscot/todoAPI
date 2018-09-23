<?php
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'authenticate.php';

	function DeleteTask() {
		// check if email and password are in the url
		if (!empty($_GET['email']) && !empty($_GET['password'])) {
			if (Authenticate($_GET['email'], $_GET['password'])) {
				if(!empty($_GET['id']) && !empty($_GET['name'])) {
					// get the id of the uask owner
					$conn = GetConnection();
					$stmt = "SELECT ID FROM users WHERE email='$_GET[email]'";
					$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
					$row = mysqli_fetch_row($data);
					//set id to the id of the owner
					$id = $row[0];
					$stmt = "DELETE FROM task WHERE ownerID=$id AND name= '$_GET[name]'";
					$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				} else echo json_encode('Get id and task name from task list, getUsersTasks.php');
			} 
		} else echo json_encode('No email/password param(s) provided, use ?email=x&password=x in url');
	}
	DeleteTask();
?> 

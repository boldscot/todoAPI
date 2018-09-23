<?php
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'authenticate.php';

function CreateTask() {
	// check if username and password keys are in url
	if (!empty($_GET['email']) && !empty($_GET['password'])) {
		// check if valid email and pw
		if (Authenticate($_GET['email'], $_GET['password'])) {
			// check if valid fields are present for task creation
			if (!empty($_GET['name']) && !empty($_GET['type']) && !empty($_GET['priority'])) {
				// store keys 
				$_POST['name'] = $name=  $_GET['name'];
				$_POST['type'] = $type = $_GET['type'];
				$_POST['priority'] = $priority = $_GET['priority'];

				// priority will be between 1 and 10
				if ($priority > 10) $_POST['priority'] = 10;
				if ($priority < 1) $_POST['priority'] = 1;

				//validate name
				if (strlen($name) > 100 || strlen($name) < 5) {
					echo json_encode("Task name to short/long, n > 5 < 100");
					return;
				} 

				// validate type
				$type= strtolower($type);
				if ($type != 'home' && $type != 'work') {
					echo json_encode("Task type should be home or work");
					return;
				}

				// get the id of the user creating the task
				$conn = GetConnection();
				$stmt = "SELECT ID FROM users WHERE email='$_GET[email]'";
				$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				$row = mysqli_fetch_row($data);
				//set id to the id of the owner
				$_POST['id'] = $row[0];
				// tasks always start as todo
				$_POST['status']= 'todo';

				// Creat the insert statement to add task entry
				$stmt="INSERT INTO task (ownerID,priority,type,status,name) VALUES ".
					"('$_POST[id]','$_POST[priority]','$_POST[type]', '$_POST[status]', '$_POST[name]')";

				$conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				echo json_encode('Task created');
				//close the connection to the database
				mysqli_close($conn);
			}else echo json_encode('No name/type/priority param(s) provided, use ?name=x&type=x&priority=x in url');
		}
	} else echo json_encode('No email/password param(s) provided, use ?email=x&password=x in url');	

}

CreateTask();
?>

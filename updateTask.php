<?php
include 'authenticate.php';

function UpdateTask() {
	// check if username and password keys are in url
	if (!empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['taskID']) ) {
		// check if valid email and pw
		if (Authenticate($_GET['email'], $_GET['password'])) {
			if(!empty($_GET['priority'])) {
				$priority = $_GET['priority'];
				// priority will be between 1 and 10
				if ($priority > 10) $_POST['priority'] = 10;
				if ($priority < 1) $_POST['priority'] = 1;
			}

			if (!empty($_GET['status'])) {
				if (strtolower($_GET['status']) != 'todo' || strtolower($_GET['status']) != 'doing' 
					|| strtolower($_GET['status']) != 'done') {
					echo json_encode("Task status is todo/doing/done.");
					return;
				} else $_POST['status'] = $_GET['status'];
			}

			// get the id of the user creating the task
			$conn = GetConnection();
			$stmt = "SELECT ID FROM users WHERE email='$_GET[email]'";
			$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
			$row = mysqli_fetch_row($data);
			//set id to the id of the owner
			$id= $row[0];

			$stmt = "UPDATE task SET password='$_POST[changePassword]' WHERE email='$_GET[email]'";
						$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));


		}
	} else echo json_encode('No username/password param(s) provided, use ?email=x&password=x in url');


}

?>

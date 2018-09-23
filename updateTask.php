<?php
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'authenticate.php';

function UpdateTask() {
	// check if username and password keys are in url
	if (!empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['taskID']) ) {
		// check if valid email and pw
		if (Authenticate($_GET['email'], $_GET['password'])) {
			if (empty($_GET['priority']) && empty($_GET['status'])) {
				echo json_encode('Need to provide priority/status params');
				return;
			}

			// get the id of the user updating the task
			$conn = GetConnection();
			$stmt = "SELECT ID FROM users WHERE email='$_GET[email]'";
			$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
			$row = mysqli_fetch_row($data);
			//set id to the id of the task owner
			$id= $row[0];
			$stmt = "";

			// task status and priotity can be updated
			if(!empty($_GET['priority'])) {
				$_POST['priority']= $priority = $_GET['priority'];
				// priority will be between 1 and 10
				if ($priority > 10) $_POST['priority'] = 10;
				if ($priority < 1) $_POST['priority'] = 1;
				
				// Update the priority field, tasks ownersID must be the logged in users id
				$stmt = "UPDATE task SET priority='$_POST[priority]' WHERE ownerID='$id' AND ID='$_GET[taskID]'";
				$conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
			}

			if (!empty($_GET['status'])) {
				if (strtolower($_GET['status']) != 'todo' && strtolower($_GET['status']) != 'doing' 
					&& strtolower($_GET['status']) != 'done') {
					echo json_encode("Task status is todo/doing/done.");
					return;
				} else {
					$_POST['status'] = $_GET['status'];
					// Update the status field, tasks ownersID must be the logged in users id
					$stmt = "UPDATE task SET status='$_POST[status]' WHERE ownerID='$id' AND ID='$_GET[taskID]'";
					$conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				}
			}

			//close the connection to the database
			mysqli_close($conn);
		}
	} else echo json_encode('No username/password/id param(s) provided, use ?email=x&password=x&taskID=x in url');

}

UpdateTask();

?>

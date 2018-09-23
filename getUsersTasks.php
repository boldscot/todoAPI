<?php
include 'authenticate.php';

	function GetTasks() {
		// check if email and password are in the url
		if (!empty($_GET['email']) && !empty($_GET['password'])) {
			if (Authenticate($_GET['email'], $_GET['password'])) {
				// get the id of the user
				$conn = GetConnection();
				$stmt = "SELECT ID FROM users WHERE email='$_GET[email]'";
				$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				$row = mysqli_fetch_row($data);
				//users id
				$id = $row[0];
				$stmt = "SELECT * FROM task WHERE ownerID='$id'";
				$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));

				$result= array();
				while ($row = $data->fetch_array(MYSQL_ASSOC)) {
					$result[] = $row;
				}

				// if the response is empty there are no tasks
				if (count($result) > 0) {	
					echo json_encode($result);
				} else {
					echo json_encode('You have no tasks');
					return false;
				}


				//close the connection to the database
				mysqli_close($conn); 
			}
		} else echo json_encode('No username/password param(s) provided, use ?email=x&password=x in url');
	}

	GetTasks();


?> 

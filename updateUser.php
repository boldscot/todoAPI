<?php
include 'authenticate.php';

	function UpdateUser() {
		// check if username and password keys are in url
		if (!empty($_GET['email']) && !empty($_GET['password'])) {
			if (Authenticate($_GET['email'], $_GET['password'])) {
				if (!empty($_GET['username'])) {
					// connect to db
					$conn = GetConnection();
					// update the users username
					$stmt = "UPDATE users SET username='$_GET[username]' WHERE email='$_GET[email]'";
					$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
				}
			}
		} else echo 'No username/password param(s) provided, use ?email=x&password=x in url';

	}

	UpdateUser();

?>

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

					//close the connection to the database
					mysqli_close($conn);
				}

				if (!empty($_GET['changePassword'])) {
					// connect to db
					$conn = GetConnection();
					// store new password
					$password = $_GET['changePassword'];

					// Validate password. NEEDS IMPROVING
					if (ctype_alnum($password) && strlen($password) <= 20 && strlen($password) > 8) {
    					echo json_encode('Good password');
    					// ENCRYPT PW HERE
    					$_POST['changePassword'] = crypt($password, '$5$rounnds=5000$testSalt$');

    					$stmt = "UPDATE users SET password='$_POST[changePassword]' WHERE email='$_GET[email]'";
						$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
					} else {
						echo json_encode('Bad password, mustbe <= 20 & > 8 chars and contain letters and at least one number');
						return;
					} 
					
					//close the connection to the database
					mysqli_close($conn);
				}
			}
		} else echo 'No username/password param(s) provided, use ?email=x&password=x in url';

	}

	UpdateUser();

?>

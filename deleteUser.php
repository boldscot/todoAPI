<?php
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'authenticate.php';

function DeleteUser() {
		// check if username and password keys are in url
		if (!empty($_GET['email']) && !empty($_GET['password'])) {
			if (Authenticate($_GET['email'], $_GET['password'])) {

				if (!empty($_GET['deleteMe']) && $_GET['deleteMe'] == true) {
					$conn = GetConnection();
					// update the users username
					$stmt = "DELETE FROM users WHERE email='$_GET[email]'";
					$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));

					//close the connection to the database
					mysqli_close($conn);
					echo json_encode('User deleted');
				} else echo json_encode('Use the deleteMe=true param to delete this user');
			} 
		} else echo json_encode('No username/password param(s) provided, use ?email=x&password=x in url');

	}

	DeleteUser();

?>

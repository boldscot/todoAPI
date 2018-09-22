<?php 
include 'connection.php';
	
	// Function that posts a user to a database
	function PostUser() {
		// call connection function 
		$conn = GetConnection();

		// check if email, password  and username keys are in url
		if (!empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['username'])) {
			// Store key values
			$_POST['email'] = $email = $_GET['email'];
			$password = $_GET['password'];
			$_POST['username'] = $username = $_GET['username'];
			$hash;

			// Validate email format
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 30) {
				echo json_encode('Invalid email format');
				return;
			} else echo json_encode('Good email');

			// Validate password. NEEDS IMPROVING
			if (ctype_alnum($password) && strlen($password) <= 20 && strlen($password) > 8) {
    			echo json_encode('Good password');
    			// ENCRYPT PW HERE
    			if (CRYPT_SHA256 == 1) {
    				$_POST['password'] = $hash = crypt($password, '$5$rounnds=5000$testSalt$');
    			} else {
    				json_encode('SHA256 not supported');
    				return;
    			}
			} else {
				echo json_encode('Bad password, mustbe <= 20 & > 8 chars and contain letters and at least one number');
				return;
			} 

			// Validate username. needs improving
			if (ctype_alnum($username) && strlen($username) >= 5 && strlen($username) <=30) {
				echo json_encode('Good username');
			} else {
				echo json_encode('Bad username, must >= 5 & <=30 chars and contain only letters and numbers');
				return;
			}

			// check email not present in database (emails must be unique)
			if (CheckIsEmailUnique($email, $conn)) {
				$stmt="INSERT INTO users (email,password,username) VALUES ".
					"('$_POST[email]','$_POST[password]','$_POST[username]')";

				$result = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));
			}

		} else echo json_encode('No email/username/password param(s) provided, use ?email=x&password=x&username=x in url');

		//close db connection
		mysqli_close($conn);

	}

	// Function that validates email uniqueness
	function CheckIsEmailUnique($email, $connection) {
		// email not case sensitive
		$em = strtolower($email);
		// query db for an entry with the same email
		$result =array();
		$stmt = "SELECT * FROM users WHERE email='$em'";
		$data = $connection->query($stmt) or die('Query failed: ' . mysqli_error($connection));

		while ($row = $data->fetch_array(MYSQL_ASSOC)) {
			$result[] = $row;
		}

		// if the response is emty the email is usable
		if (count($result) > 0) {
			echo json_encode('Email already used');
			return false;
		} else return true;

	}

	// Call the post user function
	PostUser();
?>	

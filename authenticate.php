<?php
/**
 * todoAPI
 * @author Stephen Collins
 * @Version 1.0
 */
 
include 'connection.php';

	function Authenticate($email, $password) {
		// call connection function 
		$conn = GetConnection();
		// email not case sensitive
		$em = strtolower($email);
		// query db for an entry with the same email
		$hash= crypt($password, '$5$rounnds=5000$testSalt$'); 
		$result =array();
		$stmt = "SELECT * FROM users WHERE email='$em' AND password='$hash'";
		$data = $conn->query($stmt) or die('Query failed: ' . mysqli_error($conn));

		while ($row = $data->fetch_array(MYSQL_ASSOC)) {
			$result[] = $row;
		}

		// if the response is emty the email and password combo is not in database
		if (count($result) > 0) {	
			return $result;
		} else {
			echo json_encode('Email/password combo invalid');
			return false;
		}
		
		//close the connection to the database
		mysqli_close($conn);
	}	

?>

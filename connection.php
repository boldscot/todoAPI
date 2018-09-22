<?php

	// Define global constants for database connection 
	define("DATABASE", "todoapi", true);
	define("SERVER", "localhost", true);
	define("USER", "root", true);
	define("PASSWORD", "", true);

	function GetConnection() {
		// attempt server connection
		$connection = new mysqli(SERVER, USER, PASSWORD, DATABASE);

		// check server connection status, return the connection if established
		if($connection->connect_error) 
			die ("No Server connection " . $connection->connect_error);
		else return $connection;
	}
	
?>
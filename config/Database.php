<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "elms_db";

	try 
	{
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		date_default_timezone_set('Asia/Manila');
	} 
	catch(PDOException $e) 
	{
	  die( "Error connecting to Database: " . $e->getMessage() );
	}
?>
<?php
	session_start();

	include('../../config/Database.php');

	$sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';     
    $stmt1= $conn->prepare($sql1);
    $stmt1->execute([$_SESSION['TeacherID'], 'Logout', date('Y/m/d H:i A')]);
    $stmt1->closeCursor();

	session_unset();
	session_destroy();
	
	header('refresh:0; ../../login.php');
?>
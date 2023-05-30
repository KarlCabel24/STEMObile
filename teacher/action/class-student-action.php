<?php
	session_start();
    include('../../config/Database.php');

	if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $sectionID = $_POST['sectionID'];
        $Action = 'delete class student';

        $query = 'UPDATE tbl_student
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../class-student.php?sectionID='.$sectionID);
    }
?>
<?php 
    session_start();
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
    	$gradeLevel  = $_POST['gradeLevel'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        $sql = 'INSERT INTO tbl_grade (Grade, DateCreated, CreatedByID) VALUES (?, ?, ?)';

        $stmt= $conn->prepare($sql);

        $stmt->execute([$gradeLevel, $DateCreated, $CreatedByID]);

        $stmt->closeCursor();

        header('location: ../grade.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id          = $_POST['id'];
        $gradeLevel  = $_POST['gradeLevel'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_grade
                     SET Grade = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';

        $stmt= $conn->prepare($query);
        
        $stmt->execute([$gradeLevel, $DateUpdated, $UpdatedByID, $id]);

        $stmt->closeCursor();

        header('location: ../grade.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_grade SET isDeleted = 1 WHERE ID = ? ';

        $stmt= $conn->prepare($query);

        $stmt->execute([$id]);

        $stmt->closeCursor();

        header('location: ../grade.php');
    }
?>
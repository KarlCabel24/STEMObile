<?php 
    session_start();
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
    	$schoolYear  = $_POST['schoolYear'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        $sql = 'INSERT INTO tbl_schoolyear
                              (SchoolYear, DateCreated, CreatedByID)
                       VALUES (?, ?, ?) 
                 ';

        $stmt= $conn->prepare($sql);

        $stmt->execute([$schoolYear, $DateCreated, $CreatedByID]);

        $stmt->closeCursor();

         header('location: ../school-year.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id   = $_POST['id'];
        $schoolYear  = $_POST['schoolYear'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_schoolyear
                     SET SchoolYear = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';

        $stmt= $conn->prepare($query);

        $stmt->execute([$schoolYear, $DateUpdated, $UpdatedByID, $id]);

        $stmt->closeCursor();

        header('location: ../school-year.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_schoolyear SET isDeleted = 1 WHERE ID = ?';

        $stmt= $conn->prepare($query);

        $stmt->execute([$id]);

        $stmt->closeCursor();

        header('location: ../school-year.php');
    }
?>
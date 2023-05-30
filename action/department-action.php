<?php 
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
    	$department  = $_POST['department'];
        $DateCreated = date('Y/m/d h:i A');
        $CreatedByID = 1;

        $query = 'INSERT INTO tbl_department
                              (Department, DateCreated, CreatedByID)
                       VALUES (?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$department, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        header('location: ../department.php');
    }

    if(isset($_POST['update']))
    {
        $id   = $_POST['id'];
        $department  = $_POST['department'];
        $DateUpdated = date('Y/m/d h:i A');
        $UpdatedByID = 1;

        $query = 'UPDATE tbl_department
                     SET Department = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$department, $DateUpdated, $UpdatedByID, $id]);
        $stmt->closeCursor();

        header('location: ../department.php');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_department
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../department.php');
    }
?>
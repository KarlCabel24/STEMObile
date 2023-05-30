<?php 
    session_start();
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $section      = $_POST['section'];
        $gradeID      = $_POST['gradeOption'];
    	$schoolYearID = $_POST['schoolYearOption'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        $query = 'INSERT INTO tbl_section
                              (Section, SchoolYearID, GradeID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$section, $schoolYearID, $gradeID, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        header('location: ../section.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id      = $_POST['id'];
        $section = $_POST['section'];
        $gradeID = $_POST['gradeOption'];
        $schoolYearID = $_POST['schoolYearOption'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_section
                     SET Section = ?,
                         SchoolYearID = ?,
                         GradeID = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$section, $schoolYearID, $gradeID, $DateUpdated, $UpdatedByID, $id]);
        $stmt->closeCursor();

        header('location: ../section.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id = $_POST['id'];

        $query = 'UPDATE tbl_section
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../section.php');
    }
?>
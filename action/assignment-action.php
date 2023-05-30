<?php 
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $assignmentTitle = $_POST['assignmentTitle'];
        $sectionID = $_POST['sectionOption'];
        $subjectID = $_POST['subjectOption'];
    	$teacherID = $_POST['teacherOption'];

        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_assignment
                              (AssignmentTitle, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$assignmentTitle, $sectionID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        header('location: ../assignment.php?submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_assignment
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../assignment.php');
    }
?>
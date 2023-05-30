<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $assignmentTitle = $_POST['assignmentTitle'];
        $sectionID = $_POST['sectionOption'];
        $subjectID = $_POST['subjectOption'];
    	$teacherID = $_SESSION['TeacherID'];
        $Action = 'Add assignment';

        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_assignment
                              (AssignmentTitle, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$assignmentTitle, $sectionID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../assignment.php?submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $Action = 'delete assignment';

        $query = 'UPDATE tbl_assignment
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

        header('location: ../assignment.php');
    }
?>
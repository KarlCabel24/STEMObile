<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
    	$gradeLevel  = $_POST['gradeLevel'];
        $DateCreated = date('Y/m/d h:i A');
        $CreatedByID = $_SESSION['TeacherID'];
        $Action = 'Add grade';

        $query = 'INSERT INTO tbl_grade
                              (Grade, DateCreated, CreatedByID)
                       VALUES (?, ?, ?) 
                 ';
        $stmt = $conn->prepare($query);
        $stmt->execute([$gradeLevel, $DateCreated, $CreatedByID]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../grade.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id   = $_POST['id'];
        $gradeLevel  = $_POST['gradeLevel'];
        $DateUpdated = date('Y/m/d h:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;
        $Action = 'update grade ID:'.$id;

        $query = 'UPDATE tbl_grade 
                     SET Grade = ?, DateUpdated = ?, UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt = $conn->prepare($query);
        $stmt->execute([$gradeLevel, $DateUpdated, $UpdatedByID, $id]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../grade.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id = $_POST['id'];
        $Action = 'delete grade ID:'.$id;

        $query = 'UPDATE tbl_grade 
                     SET isDeleted = 1
                   WHERE ID = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../grade.php');
    }
?>
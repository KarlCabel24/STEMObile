<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
    	$schoolYear  = $_POST['schoolYear'];
        $DateCreated = date('Y/m/d h:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_schoolyear
                              (SchoolYear, DateCreated, CreatedByID)
                       VALUES (?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$schoolYear, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'add school year', date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../school-year.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id   = $_POST['id'];
        $schoolYear  = $_POST['schoolYear'];
        $DateUpdated = date('Y/m/d h:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'UPDATE tbl_schoolyear
                     SET SchoolYear = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$schoolYear, $DateUpdated, $UpdatedByID, $id]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'update school year ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../school-year.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_schoolyear
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'delete school year ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../school-year.php');
    }
?>
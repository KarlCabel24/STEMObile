<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $section      = $_POST['section'];
        $gradeID      = $_POST['gradeOption'];
    	$schoolYearID = $_POST['schoolYearOption'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_section
                              (Section, SchoolYearID, GradeID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$section, $schoolYearID, $gradeID, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'add section', date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../section.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id      = $_POST['id'];
        $section = $_POST['section'];
        $gradeID = $_POST['gradeOption'];
        $schoolYearID = $_POST['schoolYearOption'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

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

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'update section ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

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

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'delete section ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../section.php');
    }
?>
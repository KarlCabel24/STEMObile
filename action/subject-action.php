<?php 
    session_start();
    include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $subject  = $_POST['subject'];
        $code     = $_POST['code'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_subject
                              (Subject, Code, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$subject, $code, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        header('location: ../subject.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id      = $_POST['id'];
        $subject = $_POST['subject'];
        $code    = $_POST['code'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'UPDATE tbl_subject
                     SET Subject = ?,
                         Code = ?
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$subject, $code, $DateUpdated, $UpdatedByID, $id]);
        $stmt->closeCursor();

        header('location: ../subject.php?updated=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_subject
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../subject.php');
    }
?>
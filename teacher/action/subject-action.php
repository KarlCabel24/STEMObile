<?php 
    session_start();
    include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $subject  = $_POST['subject'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_subject
                              (Subject, DateCreated, CreatedByID)
                       VALUES (?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$subject, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'add subject', date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../subject.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id          = $_POST['id'];
        $subject     = $_POST['subject'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'UPDATE tbl_subject
                     SET Subject = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$subject, $DateUpdated, $UpdatedByID, $id]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'update subject ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../subject.php?updated=success');
    }

    if(isset($_POST['delete']))
    {
        $id = $_POST['id'];

        $query = 'UPDATE tbl_subject
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'delete subject ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../subject.php');
    }
?>
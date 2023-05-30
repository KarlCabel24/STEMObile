<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $quizTitle = $_POST['quizTitle'];
        $sectionID = $_POST['sectionOption'];
        $subjectID = $_POST['subjectOption'];
    	$teacherID = $_SESSION['TeacherID'];
        $Action = 'Add Quiz '.$quizTitle;

        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = $_SESSION['TeacherID'];

        $query = 'INSERT INTO tbl_quiz
                              (QuizTitle, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$quizTitle, $sectionID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);

        $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
             ';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$CreatedByID, $Action, $DateCreated]);

        $stmt->closeCursor();
        $stmt1->closeCursor();

        header('location: ../quiz.php?submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $Action = 'Delete Quiz ID:'.$id;

        $query = 'UPDATE tbl_quiz
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();

        header('location: ../quiz.php');
    }
?>
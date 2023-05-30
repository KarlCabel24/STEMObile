<?php 
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $quizTitle = $_POST['quizTitle'];
        $sectionID = $_POST['sectionOption'];
        $subjectID = $_POST['subjectOption'];
    	$teacherID = $_POST['teacherOption'];

        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_quiz
                              (QuizTitle, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$quizTitle, $sectionID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);
        $stmt->closeCursor();

        header('location: ../quiz.php?submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_quiz
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../quiz.php');
    }
?>
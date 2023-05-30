<?php 
    session_start();
    include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $subjectOption = $_POST['subjectOption'];
        $teacherID     = $_SESSION['TeacherID'];
        $studentID     = $_POST['studentID'];
        $DateCreated   = date('Y/m/d H:i A');
        $CreatedByID   = $_SESSION['TeacherID'];
        $Action = 'Add student subject of studentID:'.$studentID;

        foreach ($subjectOption as $subjectID)
        {
            $query = 'INSERT INTO tbl_student_subject
                              (StudentID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                     ';

            $stmt= $conn->prepare($query);
            $stmt->execute([$studentID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);

            $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
             ';
            $stmt1= $conn->prepare($sql1);
            $stmt1->execute([$_SESSION['TeacherID'], $Action, date('Y/m/d H:i A')]);

            $stmt->closeCursor();
            $stmt1->closeCursor();
        }

        header('location: ../student-subject.php?studentID='.$studentID.'&submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id        = $_POST['id'];
        $studentID = $_POST['studentID'];
        $Action = 'delete subject of studentID:'.$studentID;
        
        $query = 'UPDATE tbl_student_subject
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

        header('location: ../student-subject.php?studentID='.$studentID.'');
    }
?>
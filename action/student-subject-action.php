<?php 
    include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $subjectOption = $_POST['subjectOption'];
        $teacherID     = $_POST['teacherOption'];
        $studentID     = $_POST['studentID'];
        $DateCreated   = date('Y/m/d H:i A');
        $CreatedByID   = 0;

        foreach ($subjectOption as $subjectID)
        {
            $query = 'INSERT INTO tbl_student_subject
                              (StudentID, SubjectID, TeacherID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                     ';

            $stmt= $conn->prepare($query);
            $stmt->execute([$studentID, $subjectID, $teacherID, $DateCreated, $CreatedByID]);
            $stmt->closeCursor();
        }

        header('location: ../student-subject.php?studentID='.$studentID.'&submit=success');
    }

    if(isset($_POST['delete']))
    {
        $id        = $_POST['id'];
        $studentID = $_POST['studentID'];
        
        $query = 'UPDATE tbl_student_subject
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../student-subject.php?studentID='.$studentID.'');
    }
?>
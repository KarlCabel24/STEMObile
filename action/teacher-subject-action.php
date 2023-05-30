<?php
	include('../config/Database.php');

	if (isset($_POST['create']))
	{
		$teacherID = $_POST['teacherID'];
		$sectionID = $_POST['sectionOption'];
        $subjectOption = $_POST['subjectOption'];
		$DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        foreach ($subjectOption as $subjectID) 
        {
           $query = 'INSERT INTO tbl_teacher_subject
                              (TeacherID, SubjectID, SectionID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                    ';
            $stmt= $conn->prepare($query);
            $stmt->execute([$teacherID, $subjectID, $sectionID, $DateCreated, $CreatedByID]);

            $stmt->closeCursor();
        }

        header('location: ../teacher-subject.php?teacherID='.$teacherID.'&submit=success');
	}

	if (isset($_POST['update']))
	{
		$id 	   = $_POST['id'];
		$teacherID = $_POST['teacherID'];
		$sectionID = $_POST['sectionID'];
        $subjectID = $_POST['subjectID'];

		$DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_teacher_subject
                     SET SectionID = ?,
                         SubjectID = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$sectionID, $subjectID, $DateUpdated, $UpdatedByID, $id]);

        header('location: ../teacher-subject.php?teacherID='.$teacherID.'&update=success');
	}

	if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $teacherID = $_POST['teacherID'];

        $query = 'UPDATE tbl_teacher_subject
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

       header('location: ../teacher-subject.php?teacherID='.$teacherID);
    }
?>
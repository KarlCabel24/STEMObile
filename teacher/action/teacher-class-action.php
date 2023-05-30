<?php
    session_start();
	include('../../config/Database.php');

	if (isset($_POST['create']))
	{
		$teacherID = $_SESSION['TeacherID'];
		$sectionOption = $_POST['sectionOption'];
		$DateCreated = date('Y/m/d H:i A');
        $CreatedByID = $_SESSION['TeacherID'];
        $Action = 'Add class';

        foreach ($sectionOption as $sectionID) 
        {
            $sql = 'INSERT INTO tbl_class
                                  (TeacherID, SectionID, DateCreated, CreatedByID)
                           VALUES (?, ?, ?, ?) 
                     ';
            $stmt= $conn->prepare($sql);
            $stmt->execute([$teacherID, $sectionID, $DateCreated, $CreatedByID]);

            $sql1 = 'INSERT INTO user_logs
                                  (TeacherID, Action, DateHappened)
                           VALUES (?, ?, ?) 
                     ';
            $stmt1= $conn->prepare($sql1);
            $stmt1->execute([$teacherID, $Action, $DateCreated]);

            $stmt->closeCursor();
            $stmt1->closeCursor();
        }

        header('location: ../class.php?teacherID='.$teacherID.'&submit=success');
	}

	if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $teacherID = $_POST['teacherID'];
        $Action = 'Delete class ID:'.$id;

        $query = 'UPDATE tbl_class
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$teacherID, $Action, date('Y/m/d H:i A')]);

        $stmt->closeCursor();

       header('location: ../class.php?teacherID='.$teacherID);
    }
?>
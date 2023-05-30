<?php
	include('../config/Database.php');

	if (isset($_POST['create']))
	{
		$teacherID = $_POST['teacherID'];
		$sectionOption = $_POST['sectionOption'];
		$DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        foreach ($sectionOption as $sectionID) 
        {
            $query = 'INSERT INTO tbl_class
                                  (TeacherID, SectionID, DateCreated, CreatedByID)
                           VALUES (?, ?, ?, ?) 
                     ';
            $stmt= $conn->prepare($query);
            $stmt->execute([$teacherID, $sectionID, $DateCreated, $CreatedByID]);

            $stmt->closeCursor();
        }

        header('location: ../teacher-class.php?teacherID='.$teacherID.'&submit=success');
	}

	if (isset($_POST['update']))
	{
		$id 	   = $_POST['id'];
		$teacherID = $_POST['teacherID'];
		$sectionID = $_POST['sectionID'];
		$DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_class
                     SET SectionID = ?,
                         DateUpdated = ?,
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$sectionID, $DateUpdated, $UpdatedByID, $id]);

        header('location: ../teacher-class.php?teacherID='.$teacherID.'&update=success');
	}

	if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];
        $teacherID = $_POST['teacherID'];

        $query = 'UPDATE tbl_class
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

       header('location: ../teacher-class.php?teacherID='.$teacherID);
    }
?>
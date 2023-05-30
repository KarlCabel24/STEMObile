<?php 
  session_start();
	include('../config/Database.php');

	if (isset($_POST['new'])) 
	{
    $announcement = $_POST['announcement'];
    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_POST['teacherOption'];

    $DateCreated = date('Y/m/d H:i A');
    $CreatedByID = 0;

  	$query = 'INSERT INTO tbl_announcement
                        (Announcement, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                 VALUES (?, ?, ?, ?, ?, ?) 
           ';
  	$stmt= $conn->prepare($query);
  	$stmt->execute([$announcement, $sectionID, $subjectID, $TeacherID, $DateCreated, $CreatedByID]);

    $stmt->closeCursor();

  	header('location: ../announcement.php?submit=success');
	}

  if(isset($_POST['update']))
  {
    $id = $_POST['id'];
    $announcement = $_POST['announcement'];
    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_POST['teacherOption'];

    $DateUpdated = date('Y/m/d H:i A');
    $UpdatedByID = 0;

      $query = 'UPDATE tbl_announcement
                   SET Announcement = ?,
                       SectionID = ?,
                       SubjectID = ?,
                       TeacherID = ?,
                       DateUpdated = ?,
                       UpdatedByID = ?
                 WHERE ID = ?
               ';
      $stmt= $conn->prepare($query);
      $stmt->execute([$announcement, $sectionID, $subjectID, $TeacherID, $DateUpdated, $UpdatedByID, $id]);
      $stmt->closeCursor();

      header('location: ../announcement.php?update=success');
  }

  if(isset($_POST['delete']))
  {
    $id = $_POST['id'];

      $query = 'UPDATE tbl_announcement
                   SET isDeleted = 1
                 WHERE ID = ?
               ';
      $stmt= $conn->prepare($query);
      $stmt->execute([$id]);
      $stmt->closeCursor();

      header('location: ../announcement.php?update=success');
  }

?>
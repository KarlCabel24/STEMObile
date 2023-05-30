<?php 
  session_start();
	include('../../config/Database.php');

	if (isset($_POST['new'])) 
	{
    $announcement = $_POST['announcement'];
    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_SESSION['TeacherID'];

    $DateCreated = date('Y/m/d H:i A');
    $CreatedByID = 0;

  	$query = 'INSERT INTO tbl_announcement
                        (Announcement, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                 VALUES (?, ?, ?, ?, ?, ?) 
           ';
  	$stmt= $conn->prepare($query);
  	$stmt->execute([$announcement, $sectionID, $subjectID, $TeacherID, $DateCreated, $CreatedByID]);
    $stmt->closeCursor();

    $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
    $stmt1= $conn->prepare($sql1);
    $stmt1->execute([$_SESSION['TeacherID'], 'Add new announcement', date('Y/m/d H:i A')]);
    $stmt1->closeCursor();

  	header('location: ../announcement.php?submit=success');
	}

  if(isset($_POST['update']))
  {
    $id = $_POST['id'];
    $announcement = $_POST['announcement'];
    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_SESSION['TeacherID'];

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

      $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
    $stmt1= $conn->prepare($sql1);
    $stmt1->execute([$_SESSION['TeacherID'], 'Update announcement', date('Y/m/d H:i A')]);
    $stmt1->closeCursor();

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

      $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
                 ';
    $stmt1= $conn->prepare($sql1);
    $stmt1->execute([$_SESSION['TeacherID'], 'delete announcement', date('Y/m/d H:i A')]);
    $stmt1->closeCursor();

      header('location: ../announcement.php?update=success');
  }

?>
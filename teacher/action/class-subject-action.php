<?php
  session_start();
	include('../../config/Database.php');

	if (isset($_POST['create']))
	{
		$sectionID = $_POST['sectionID'];
    $subjectOption = $_POST['subjectOption'];
		$DateCreated = date('Y/m/d H:i A');
    $CreatedByID = $_SESSION['TeacherID'];
    $Action = 'Add class subject';

    foreach ($subjectOption as $subjectID) 
    {
      $sql = 'INSERT INTO tbl_teacher_subject
                          (TeacherID, SubjectID, SectionID, DateCreated, CreatedByID)
                   VALUES (?, ?, ?, ?, ?) 
                ';
      $stmt= $conn->prepare($sql);
      $stmt->execute([$CreatedByID, $subjectID, $sectionID, $DateCreated, $CreatedByID]);

      $sql1 = 'INSERT INTO user_logs
                          (TeacherID, Action, DateHappened)
                   VALUES (?, ?, ?) 
             ';
      $stmt1= $conn->prepare($sql1);
      $stmt1->execute([$CreatedByID, $Action, $DateCreated]);

      $stmt->closeCursor();
      $stmt1->closeCursor();
    }

    header('location: ../class-subject.php?sectionID='.$sectionID.'&submit=success');
	}

  if(isset($_POST['delete']))
  {
    $id   = $_POST['id'];
    $sectionID = $_POST['sectionID'];
    $CreatedByID = $_SESSION['TeacherID'];
    $Action = 'Delete class subject ID:'.$id;

    $query = 'UPDATE tbl_teacher_subject
                 SET isDeleted = 1
               WHERE ID = ?
             ';
    $stmt= $conn->prepare($query);
    $stmt->execute([$id]);

    $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
    $stmt1= $conn->prepare($sql1);
    $stmt1->execute([$CreatedByID, $Action, date('Y/m/d H:i A')]);

    $stmt->closeCursor();
    $stmt1->closeCursor();

    header('location: ../class-subject.php?sectionID='.$sectionID);
  }

?>
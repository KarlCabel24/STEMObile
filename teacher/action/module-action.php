<?php 
  session_start();
	include('../../config/Database.php');

	if (isset($_POST['upload'])) 
	{
    $fileName = $_FILES['uploadFile']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_SESSION['TeacherID'];

    $DateCreated = date('Y/m/d h:i A');
    $CreatedByID = $_SESSION['TeacherID'];

    $pathto="../../uploads/".$fileName;

    $allowed_ext = ['xls','csv','xlsx','doc','docm','docx','pptx','pptm','ppt','pdf'];

    if(in_array($file_ext, $allowed_ext)) 
    {
    	$query = 'INSERT INTO tbl_module
                          (Module, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                   VALUES (?, ?, ?, ?, ?, ?) 
             ';
    	$stmt= $conn->prepare($query);
    	$stmt->execute([$fileName, $sectionID, $subjectID, $TeacherID, $DateCreated, $CreatedByID]);

      $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
      $stmt1= $conn->prepare($sql1);
      $stmt1->execute([$_SESSION['TeacherID'], 'add module', date('Y/m/d H:i A')]);
      $stmt1->closeCursor();

      if($stmt)
      {
        move_uploaded_file($_FILES['uploadFile']['tmp_name'],$pathto) or die( "Could not copy file!");
      }
      $stmt->closeCursor();

    	header('location: ../module.php');
    }
	}

  if(isset($_POST['delete']))
  {
    $id = $_POST['id'];

      $query = 'UPDATE tbl_module
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
    $stmt1->execute([$_SESSION['TeacherID'], 'delete module', date('Y/m/d H:i A')]);
    $stmt1->closeCursor();

    header('location: ../module.php?update=success');
  }
?>
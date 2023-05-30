<?php 
  session_start();
	include('../config/Database.php');

	if (isset($_POST['upload'])) 
	{
    $fileName = $_FILES['uploadFile']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $subjectID = $_POST['subjectOption'];
    $sectionID = $_POST['sectionOption'];
    $TeacherID = $_POST['teacherOption'];

    $DateCreated = date('Y/m/d h:i A');
    $CreatedByID = 0;

    $pathto="../uploads/".$fileName;

    $allowed_ext = ['xls','csv','xlsx','doc','docm','docx','pptx','pptm','ppt','pdf'];

    if(in_array($file_ext, $allowed_ext)) 
    {
    	$query = 'INSERT INTO tbl_module
                          (Module, SectionID, SubjectID, TeacherID, DateCreated, CreatedByID)
                   VALUES (?, ?, ?, ?, ?, ?) 
             ';
    	$stmt= $conn->prepare($query);
    	$stmt->execute([$fileName, $sectionID, $subjectID, $TeacherID, $DateCreated, $CreatedByID]);

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
      $id   = $_POST['id'];

      $query = 'UPDATE tbl_module
                   SET isDeleted = 1
                 WHERE ID = ?
               ';
      $stmt= $conn->prepare($query);
      $stmt->execute([$id]);
      $stmt->closeCursor();

      header('location: ../module.php');
  }
?>
<?php 
    session_start();
    include('../../config/Database.php');
    
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if(isset($_POST['create']))
    {
        $firstName   = $_POST['firstName'];
        $middleName  = $_POST['middleName'];
        $lastName    = $_POST['lastName'];
        $age         = $_POST['age'];
        $idNumber    = $_POST['idNumber'];
        $password    = $_POST['password'];
        $address     = $_POST['address'];
        $sectionID   = $_POST['sectionOption'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'INSERT INTO tbl_student
                              (FirstName, MiddleName, LastName, IDnumber, Age, Address, SectionID, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $age, $address, $sectionID, $DateCreated, $CreatedByID]);

        $getlastInsertId = $conn->lastInsertId();

        $query2 = 'INSERT INTO tbl_user
                              (StudentID, Username, Password, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                 ';
        $stmt2= $conn->prepare($query2);
        $stmt2->execute([$getlastInsertId, $idNumber, $password, $DateCreated, $CreatedByID]);

        $stmt->closeCursor();
        $stmt2->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'add student', date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../student.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id          = $_POST['id'];
        $firstName   = $_POST['firstName'];
        $middleName  = $_POST['middleName'];
        $lastName    = $_POST['lastName'];
        $age         = $_POST['age'];
        $idNumber    = $_POST['idNumber'];
        $address     = $_POST['address'];
        $sectionID   = $_POST['sectionID'];
        $password    = empty($_POST['password']) ? 'password@1234' : $_POST['password'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = isset($_SESSION['TeacherID']) ? $_SESSION['TeacherID'] : 0;

        $query = 'UPDATE tbl_student
                     SET FirstName = ?, 
                         MiddleName = ?, 
                         LastName = ?, 
                         IDnumber = ?,
                         Age = ?,
                         Address = ?,
                         SectionID = ?,
                         DateUpdated = ?, 
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $age, $address, $sectionID, $DateUpdated, $UpdatedByID, $id]);

        $query2 = 'UPDATE tbl_user
                     SET Username = ?, 
                         Password = ?,
                         DateUpdated = ?, 
                         UpdatedByID = ?
                   WHERE StudentID = ?
                 ';
        $stmt2= $conn->prepare($query2);
        $stmt2->execute([$idNumber, $password, $DateUpdated, $UpdatedByID, $id]);

        $stmt->closeCursor();
        $stmt2->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'update student ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../student.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_student
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        $sql1 = 'INSERT INTO user_logs (TeacherID, Action, DateHappened) VALUES (?, ?, ?)';
        $stmt1= $conn->prepare($sql1);
        $stmt1->execute([$_SESSION['TeacherID'], 'delete student ID:'.$id, date('Y/m/d H:i A')]);
        $stmt1->closeCursor();

        header('location: ../student.php');
    }

    if(isset($_POST['upload']))
    {
        $fileName = $_FILES['uploadFile']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed_ext = ['xls','csv','xlsx'];

        if(in_array($file_ext, $allowed_ext)) 
        {
            $inputFileNamePath = $_FILES['uploadFile']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $count = '0';
            foreach($data as $row)
            {
                if($count > 0)
                {
                    $firstName  = $row['0'];
                    $middleName = $row['1'];
                    $lastName   = $row['2'];
                    $idNumber   = $row['3'];
                    $age        = $row['4'];
                    $address    = $row['5'];
                    $password   = 'password@1234';
                    $DateCreated = date('Y/m/d H:i A');
                    $CreatedByID = 0;

                    if ($firstName && $middleName && $lastName && $idNumber && $age && $address) 
                    {
                      $studentQuery = 'INSERT INTO tbl_student
                                                 (FirstName, MiddleName, LastName, IDnumber, Age, Address, DateCreated, CreatedByID)
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
                                    ';
                      $stmt= $conn->prepare($studentQuery);
                      $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $age, $address, $DateCreated, $CreatedByID]);

                      $getlastInsertId = $conn->lastInsertId();

                      $studentAccountQuery = 'INSERT INTO tbl_user
                                                          (StudentID, Username, Password, DateCreated, CreatedByID)
                                                   VALUES (?, ?, ?, ?, ?) 
                                             ';
                      $stmt2= $conn->prepare($studentAccountQuery);
                      $stmt2->execute([$getlastInsertId, $idNumber, $password, $DateCreated, $CreatedByID]);

                      $stmt->closeCursor();
                      $stmt2->closeCursor();

                      $msg = true;
                    }
                }
                else
                {
                    $count = '1';
                }
            }

            if(isset($msg))
            {
                header('location: ../student.php?success=fileupload');
                exit();
            }
            else
            {
                header('location: ../student.php?error=fileuploadfailed');
                exit();
            }
        } 
        else 
        {
            header('location: ../student.php?error=invalidfile');
            exit();
        }
        
    }
?>
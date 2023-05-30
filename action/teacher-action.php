<?php 
    include('../config/Database.php');
    
    require '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if(isset($_POST['create']))
    {
    	$firstName   = $_POST['firstName'];
        $middleName  = $_POST['middleName'];
        $lastName    = $_POST['lastName'];
        $idNumber    = $_POST['idNumber'];
    	$password    = $_POST['password'];
        $DateCreated = date('Y/m/d H:i A');
        $CreatedByID = 0;

        $query = 'INSERT INTO tbl_teacher
                              (FirstName, MiddleName, LastName, IDnumber, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?, ?) 
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $DateCreated, $CreatedByID]);

        $getlastInsertId = $conn->lastInsertId();

        $query2 = 'INSERT INTO tbl_user
                              (TeacherID, Username, Password, DateCreated, CreatedByID)
                       VALUES (?, ?, ?, ?, ?) 
                 ';
        $stmt2= $conn->prepare($query2);
        $stmt2->execute([$getlastInsertId, $idNumber, $password, $DateCreated, $CreatedByID]);

        $stmt->closeCursor();
        $stmt2->closeCursor();

        header('location: ../teacher.php?submit=success');
    }

    if(isset($_POST['update']))
    {
        $id          = $_POST['id'];
        $firstName   = $_POST['firstName'];
        $middleName  = $_POST['middleName'];
        $lastName    = $_POST['lastName'];
        $idNumber    = $_POST['idNumber'];
        $password    = empty($_POST['password']) ? 'password@1234' : $_POST['password'];
        $DateUpdated = date('Y/m/d H:i A');
        $UpdatedByID = 0;

        $query = 'UPDATE tbl_teacher
                     SET FirstName = ?, 
                         MiddleName = ?, 
                         LastName = ?, 
                         IDnumber = ?,
                         DateUpdated = ?, 
                         UpdatedByID = ?
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $DateUpdated, $UpdatedByID, $id]);

        $query2 = 'UPDATE tbl_user
                     SET Username = ?, 
                         Password = ?,
                         DateUpdated = ?, 
                         UpdatedByID = ?
                   WHERE TeacherID = ?
                 ';
        $stmt2= $conn->prepare($query2);
        $stmt2->execute([$idNumber, $password, $DateUpdated, $UpdatedByID, $id]);

        $stmt->closeCursor();
        $stmt2->closeCursor();

        header('location: ../teacher.php?update=success');
    }

    if(isset($_POST['delete']))
    {
        $id   = $_POST['id'];

        $query = 'UPDATE tbl_teacher
                     SET isDeleted = 1
                   WHERE ID = ?
                 ';
        $stmt= $conn->prepare($query);
        $stmt->execute([$id]);
        $stmt->closeCursor();

        header('location: ../teacher.php');
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
                    $password   = 'password@1234';
                    $DateCreated = date('Y/m/d H:i A');
                    $CreatedByID = 0;

                    if($firstName && $middleName && $lastName && $idNumber){
                        $teacherQuery = 'INSERT INTO tbl_teacher
                                                     (FirstName, MiddleName, LastName, IDnumber, DateCreated, CreatedByID)
                                              VALUES (?, ?, ?, ?, ?, ?) 
                                        ';
                        $stmt= $conn->prepare($teacherQuery);
                        $stmt->execute([$firstName, $middleName, $lastName, $idNumber, $DateCreated, $CreatedByID]);

                        $getlastInsertId = $conn->lastInsertId();

                        $teacherAccountQuery = 'INSERT INTO tbl_user
                                                            (TeacherID, Username, Password, DateCreated, CreatedByID)
                                                     VALUES (?, ?, ?, ?, ?) 
                                               ';
                        $stmt2= $conn->prepare($teacherAccountQuery);
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
                header('location: ../teacher.php?success=fileuploaded');
                exit();
            }
            else
            {
                header('location: ../teacher.php?error=fileuploadfailed');
                exit();
            }
        } 
        else 
        {
            header('location: ../teacher.php?error=invalidfile');
            exit();
        }
        
    }
?>
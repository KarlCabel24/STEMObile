<?php  
	include_once('../config/Database.php');
	
	if(isset($_POST['login']))
	{
		if(empty($_POST['username']) || empty($_POST['password']))
		{
			header('location: ../login.php?error=emptyinput');
			exit();
		}

		if(!empty($_POST['username']) || !empty($_POST['password']))
		{
			$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

			$query = 'SELECT
					    ID,
					    Username,
					    Password,
					    StudentID,
					    TeacherID
					  FROM
					  	tbl_user
					  WHERE
					    Username = ? AND Password = ? AND isDeleted = 0
					 ';

			$stmt = $conn->prepare($query);
			$stmt->execute([$username, $password]); 
			$result = $stmt->fetch();

			if($stmt->rowCount() == 0)
			{
				header('location: ../login.php?error=invaliduser');
				exit();
			}

			if($result)
			{	
				session_start();

				$_SESSION['ID'] = $result['ID'];
				$_SESSION['Username'] = $result['Username'];
                $_SESSION['Password'] = $result['Password'];
                $_SESSION['StudentID'] = $result['StudentID'];
                $_SESSION['TeacherID'] = $result['TeacherID'];

                if ($_SESSION['TeacherID']) 
                {
                	$Action = 'Logged on';
                	$DateCreated = date('Y/m/d H:i A');
                	
                	$sql1 = 'INSERT INTO user_logs
			                             (TeacherID, Action, DateHappened)
			                      VALUES (?, ?, ?) 
			                ';

			        $stmt1= $conn->prepare($sql1);
			        $stmt1->execute([$_SESSION['TeacherID'], $Action, $DateCreated]);
			        $stmt1->closeCursor();

                	header('location: ../teacher/class.php');
                }

                if ($_SESSION['StudentID']) 
                {
                	$Action = 'Logged on';
                	$DateCreated = date('Y/m/d H:i A');

                	$sql1 = 'INSERT INTO user_logs
			                             (StudentID, Action, DateHappened)
			                      VALUES (?, ?, ?) 
			                ';

			        $stmt1= $conn->prepare($sql1);
			        $stmt1->execute([$_SESSION['StudentID'], $Action, $DateCreated]);
			        $stmt1->closeCursor();
                	header('location: ../student/subject.php');
                }

                if (!$_SESSION['StudentID'] && !$_SESSION['TeacherID']) {
                	header('location: ../index.php');
                }
			}
		}
	}

?>
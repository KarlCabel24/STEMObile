<?php
	session_start();
	include('../../config/Database.php');

	if (!isset($_SESSION['score']))
	{
		$_SESSION['score'] = 0;
	}

	if (isset($_POST['submit']))
	{
		$assignmentID = $_POST['assignmentID'];
		$number = $_POST['number'];
		$selected_choice = $_POST['choice'];
		$next = $number+1;

		$query1 = 'SELECT COUNT(ID) FROM tbl_assign_question WHERE assignmentID = ?';
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute([$assignmentID]);

		// get total question
		$total = $stmt1->fetchColumn();

		// get correct choice
		$query = 'SELECT ID FROM tbl_assign_choices WHERE assignmentID = ? AND QuestionNumber = ? AND IsAnswer = 1';
		$stmt = $conn->prepare($query);
		$stmt->execute([$assignmentID,$number]);

		// get row
		$row = $stmt->fetch();

		// set correct choice
		$correct_choice = $row['ID'];

		// comapre
		if ($correct_choice == $selected_choice) 
		{
			// answer is correct
			$_SESSION['score']++;
		}

		// check if last question
		if ($number == $total)
		{
			header('location: ../assignment-final.php?assignmentID='.$assignmentID);
			exit();
		}
		else
		{
			header('location: ../assignment-question.php?assignmentID='.$assignmentID.'&qno='.$next);
		}
	}

	if (isset($_POST['finish'])) {
		$score = $_POST['score'];
		$studentID = $_SESSION['StudentID'];
		$assignmentID = $_POST['assignmentID'];

		$sql = 'INSERT INTO tbl_assign_score (assignmentID, StudentID, TotalScore) VALUES (?, ?, ?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$assignmentID, $studentID, $score]);

		$sqlp = 'INSERT INTO user_logs (StudentID, Action, DateHappened) VALUES (?, ?, ?)';
	    $stmtp= $conn->prepare($sqlp);
	    $stmtp->execute([$_SESSION['StudentID'], 'finish assignment', date('Y/m/d H:i A')]);
	    $stmtp->closeCursor();

	    unset($_SESSION['score']);

		header('location: ../assignment.php');
	}
?>
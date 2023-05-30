<?php
	session_start();
	include('../../config/Database.php');

	if (!isset($_SESSION['score']))
	{
		$_SESSION['score'] = 0;
	}

	if (isset($_POST['submit']))
	{
		$quizID = $_POST['quizID'];
		$number = $_POST['number'];
		$selected_choice = $_POST['choice'];
		$next = $number+1;

		$query1 = 'SELECT COUNT(ID) FROM tbl_question WHERE QuizID = ?';
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute([$quizID]);

		// get total question
		$total = $stmt1->fetchColumn();

		// get correct choice
		$query = 'SELECT ID FROM tbl_choices WHERE QuizID = ? AND QuestionNumber = ? AND IsAnswer = 1';
		$stmt = $conn->prepare($query);
		$stmt->execute([$quizID,$number]);

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
			header('location: ../final.php?quizID='.$quizID);
			exit();
		}
		else
		{
			header('location: ../question.php?quizID='.$quizID.'&qno='.$next);
		}
	}

	if (isset($_POST['finish'])) {
		$score = $_POST['score'];
		$studentID = $_SESSION['StudentID'];
		$quizID = $_POST['quizID'];

		$sql = 'INSERT INTO tbl_score (QuizID, StudentID, TotalScore) VALUES (?, ?, ?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$quizID, $studentID, $score]);

		$sqlp = 'INSERT INTO user_logs (StudentID, Action, DateHappened) VALUES (?, ?, ?)';
	    $stmtp= $conn->prepare($sqlp);
	    $stmtp->execute([$_SESSION['StudentID'], 'finish quiz', date('Y/m/d H:i A')]);
	    $stmtp->closeCursor();

	    unset($_SESSION['score']);

		header('location: ../quiz.php');
	}
?>
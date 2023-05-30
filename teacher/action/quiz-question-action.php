<?php 
    session_start();
	include('../../config/Database.php');

    if(isset($_POST['create']))
    {
        $quizID         = $_POST['quizID'];
        $questionNumber = $_POST['questionNumber'];
        $question       = $_POST['question'];
        $correctChoice  = $_POST['correctChoice'];

        $choices = array();
        $choices[1] = $_POST['choice1'];
        $choices[2] = $_POST['choice2'];
        $choices[3] = $_POST['choice3'];
        $choices[4] = $_POST['choice4'];

        $questionQuery = 'INSERT INTO tbl_question(QuizID, QuestionNumber, Question) 
                               VALUES (?, ?, ?)
                         ';
        $questionStmt= $conn->prepare($questionQuery);
        $questionStmt->execute([$quizID, $questionNumber, $question]);

        if ($questionStmt)
        {
            foreach ($choices as $choice => $value) 
            {
                if ($value != '') 
                {
                    if ($correctChoice == $choice)
                    {
                        $isAnswer = 1;
                    }
                    else
                    {
                        $isAnswer = 0;
                    }

                    $choiceQuery = 'INSERT INTO tbl_choices(QuizID, QuestionNumber, Choices, IsAnswer)
                                        VALUES(?, ?, ?, ?)
                                   ';
                    $choicesStmt= $conn->prepare($choiceQuery);
                    $choicesStmt->execute([$quizID, $questionNumber, $value, $isAnswer]);

                    if ($choicesStmt)
                    {
                        continue;
                    }
                    else
                    {
                        die();
                    }
                }
            }
            header('location: ../quiz-question.php?quizID='.$quizID);
            exit();
        }
    }

    if (isset($_POST['delete'])) 
    {
        $questionID     = $_POST['questionID'];
        $quizID         = $_POST['quizID'];
        $questionNumber = $_POST['questionNumber'];

        $query = 'DELETE FROM tbl_question WHERE ID = ?';
        $stmt= $conn->prepare($query);
        $stmt->execute([$questionID]);

        if ($stmt) 
        {
            $query1 = 'DELETE FROM tbl_choices WHERE QuizID = ? AND QuestionNumber = ?';
            $stmt2= $conn->prepare($query1);
            $stmt2->execute([$quizID, $questionNumber]);
        }

        header('location: ../quiz-question.php?quizID='.$quizID);
        exit();
    }
?>
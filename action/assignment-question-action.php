<?php 
	include('../config/Database.php');

    if(isset($_POST['create']))
    {
        $assignmentID   = $_POST['assignmentID'];
        $questionNumber = $_POST['questionNumber'];
        $question       = $_POST['question'];
        $correctChoice  = $_POST['correctChoice'];

        $choices = array();
        $choices[1] = $_POST['choice1'];
        $choices[2] = $_POST['choice2'];
        $choices[3] = $_POST['choice3'];
        $choices[4] = $_POST['choice4'];

        $questionQuery = 'INSERT INTO tbl_assign_question(AssignmentID, QuestionNumber, Question) 
                               VALUES (?, ?, ?)
                         ';
        $questionStmt= $conn->prepare($questionQuery);
        $questionStmt->execute([$assignmentID, $questionNumber, $question]);

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

                    $choiceQuery = 'INSERT INTO tbl_assign_choices(AssignmentID, QuestionNumber, Choices, IsAnswer)
                                        VALUES(?, ?, ?, ?)
                                   ';
                    $choicesStmt= $conn->prepare($choiceQuery);
                    $choicesStmt->execute([$assignmentID, $questionNumber, $value, $isAnswer]);

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
            header('location: ../assignment-question.php?assignmentID='.$assignmentID);
            exit();
        }
    }

    if (isset($_POST['delete'])) 
    {
        $questionID     = $_POST['questionID'];
        $assignmentID   = $_POST['assignmentID'];
        $questionNumber = $_POST['questionNumber'];

        $query = 'DELETE FROM tbl_assign_question WHERE ID = ?';
        $stmt= $conn->prepare($query);
        $stmt->execute([$questionID]);

        if ($stmt) 
        {
            $query1 = 'DELETE FROM tbl_assign_choices WHERE AssignmentID = ? AND QuestionNumber = ?';
            $stmt2= $conn->prepare($query1);
            $stmt2->execute([$assignmentID, $questionNumber]);
        }

        header('location: ../assignment-question.php?assignmentID='.$assignmentID);
        exit();
    }
?>
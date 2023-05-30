<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('../config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);

	$sqlp = 'INSERT INTO user_logs (StudentID, Action, DateHappened) VALUES (?, ?, ?)';
    $stmtp= $conn->prepare($sqlp);
    $stmtp->execute([$_SESSION['StudentID'], 'Start quiz', date('Y/m/d H:i A')]);
    $stmtp->closeCursor();

	$sql = 'SELECT QuizTitle FROM tbl_quiz WHERE ID = ? ';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['quizID']]);
	$row = $stmt->fetch();

	$number = (int) $_GET['qno'];

	$sql1 = 'SELECT COUNT(ID) FROM tbl_question WHERE QuizID = ?';
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute([$_GET['quizID']]);

	// get total question
	$total = $stmt1->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<?php include('../include/head.php'); ?>

<body>

	<!-- Main navbar -->
	<?php include('../include/navbar.php'); ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content">

					<div class="col-lg-8  mx-auto">
						<div class="card border-secondary">
							<div class="card-header bg-dark border-secondary header-elements-inline">
								<h6 class="card-title text-white">
									Question <?= $number; ?> of <?= $total; ?>
								</h6>
							</div>

							<div class="card-body">
								
								<div class="col-lg-12">
									<?php 
										$questionQuery = 'SELECT ID,
														         QuizID,
														         QuestionNumber,
														         Question
														  FROM   tbl_question
														  WHERE  QuizID = ? AND QuestionNumber = ?
													     ';
										$questionStmt = $conn->prepare($questionQuery);
										$questionStmt->execute([$_GET['quizID'], $number]);

										while($questionRow = $questionStmt->fetch()) { 
									?>
									<div class="card border-secondary">
										<div class="card-header bg-light border-secondary header-elements-inline">
											<h6 class="card-title"><?= $questionRow['Question']; ?></h6>
										</div>

										<form method="POST" action="action/process.php">
										<div class="card-body">
											<?php
												$choicesQuery = 'SELECT ID,
																        QuizID,
																        QuestionNumber,
																        Choices
																 FROM tbl_choices
																 WHERE QuizID = ? AND QuestionNumber = ?
													   ';
												$choicesStmt = $conn->prepare($choicesQuery);
												$choicesStmt->execute([$_GET['quizID'],$questionRow['QuestionNumber']]);

												while($choicesRow = $choicesStmt->fetch()) { 
											?>
											<input type="radio" value="<?= $choicesRow['ID']; ?>" name="choice"> <?= $choicesRow['Choices']; ?> <br>
											<?php } ?>

											<br>
											<input type="hidden" name="number" value="<?=$number;?>">
											<input type="hidden" name="quizID" value="<?=$_GET['quizID'];?>">
											<input type="submit" name="submit" value="Submit" class="btn btn-light">
										</div>
										</form>
									</div>
									<?php } ?>
								</div>

							</div>
						</div>
					</div>
				
				</div>
				<!-- /content area -->

				<!-- Footer -->
				<?php include('../include/footer.php'); ?>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
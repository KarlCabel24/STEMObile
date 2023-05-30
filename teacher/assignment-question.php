<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('../config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);

	$sql = 'SELECT AssignmentTitle FROM tbl_assignment WHERE ID = ?
				     ';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['assignmentID']]);
	$row = $stmt->fetch();
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

		<!-- Main sidebar -->
		<?php include('../include/sidebar.php'); ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header page-header-light">
					<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
						<div class="d-flex">
							<div class="breadcrumb">
								<a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Main</a>
								<span class="breadcrumb-item active">Assignment Question</span>
							</div>
						</div>
					</div>
				</div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">

					<div class="col-lg-8">
						<div class="card border-secondary">
							<div class="card-header bg-dark border-secondary header-elements-inline">
								<h6 class="card-title text-white">
									<?= $row['AssignmentTitle']; ?>
								</h6>

								<h6 class="card-title">
									<button class="btn btn-light font-weight-semibold" data-toggle="modal" data-target="#new">
										ADD QUESTION
									</button>
								</h6>
							</div>

							<div class="card-body">
								
								<div class="col-lg-12">
									<?php 
										$questionQuery = 'SELECT ID,
														         AssignmentID,
														         QuestionNumber,
														         Question
														  FROM   tbl_assign_question
														  WHERE  AssignmentID = ?
														  ORDER BY QuestionNumber ASC
													     ';
										$questionStmt = $conn->prepare($questionQuery);
										$questionStmt->execute([$_GET['assignmentID']]);

										while($questionRow = $questionStmt->fetch()) { 
									?>
									<div class="card border-secondary">
										<div class="card-header bg-light border-secondary header-elements-inline">
											<h6 class="card-title"><?= $questionRow['QuestionNumber'].'. '.$questionRow['Question']; ?></h6>
											<button class="btn btn-light font-weight-bold text-danger" data-toggle="modal" data-target="#delete<?=$questionRow['ID'];?>">X</button>
										</div>

										<div class="card-body">
											<?php
												$choicesQuery = 'SELECT ID,
																        AssignmentID,
																        QuestionNumber,
																        Choices,
																        IsAnswer
															 	 FROM tbl_assign_choices
																 WHERE AssignmentID = ? AND QuestionNumber = ?
															   ';
												$choicesStmt = $conn->prepare($choicesQuery);
												$choicesStmt->execute([$_GET['assignmentID'],$questionRow['QuestionNumber']]);

												while($choicesRow = $choicesStmt->fetch()) { 
											?>
											<input type="checkbox" <?= $choicesRow['IsAnswer'] == 1 ? 'checked' : ''; ?> disabled> <?= $choicesRow['Choices']; ?><br>
											<?php } ?>
										</div>
									</div>

									<!-- delete modal -->
									<div id="delete<?= $questionRow['ID']; ?>" class="modal fade" tabindex="-1">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title font-weight-semibold">Delete</h5>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>

												<legend></legend>

												<form action="action/assignment-question-action.php" method="POST" autocomplete="off">
													<div class="modal-body">
														<div class="form-group d-none">
															<div class="row">
																<div class="col-sm-12">
																	<label class="font-weight-semibold">Question ID</label>
																	<input type="text" class="form-control" name="questionID" required value="<?= $questionRow['ID']; ?>">
																</div>
															</div>
														</div>

														<div class="form-group d-none">
															<div class="row">
																<div class="col-sm-12">
																	<label class="font-weight-semibold">Assignment ID</label>
																	<input type="text" class="form-control" name="assignmentID" required value="<?= $questionRow['AssignmentID']; ?>">
																</div>
															</div>
														</div>

														<div class="form-group d-none">
															<div class="row">
																<div class="col-sm-12">
																	<label class="font-weight-semibold">Question Number</label>
																	<input type="text" class="form-control" name="questionNumber" required value="<?= $questionRow['QuestionNumber']; ?>">
																</div>
															</div>
														</div>

														<h5 class="text-center">Are you sure to delete?</h5>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
														<button type="submit" name="delete" class="btn btn-danger">Delete</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- /delete modal -->
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

	<!-- new modal -->
	<div id="new" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-semibold">New</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<legend></legend>

				<form action="action/assignment-question-action.php" method="POST" autocomplete="off">
					<div class="modal-body">
						<div class="form-group d-none">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Assignment ID</label>
									<input type="text" class="form-control" name="assignmentID" value="<?= $_GET['assignmentID']; ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Question Number</label>
									<input type="number" class="form-control" name="questionNumber" placeholder="1">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Question</label>
									<input type="text" class="form-control" name="question" placeholder="What does HTML stand for?">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Choice #1</label>
									<input type="text" class="form-control" name="choice1" placeholder="Hyperlinks and Text Markup Language">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Choice #2</label>
									<input type="text" class="form-control" name="choice2" placeholder="Home Tool Markup Language">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Choice #3</label>
									<input type="text" class="form-control" name="choice3" placeholder="Hyper Text Markup Language">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Choice #4</label>
									<input type="text" class="form-control" name="choice4" placeholder="How To Make Lumpia">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold mb-0">Correct Answer Choice #</label>
									<input type="number" class="form-control" name="correctChoice" placeholder="4">
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" name="create" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /new modal -->

	<script>
		$('input[type="checkbox"]').on('change', function() {
		    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
		});
	</script>

</body>
</html>
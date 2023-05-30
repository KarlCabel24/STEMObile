<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('../config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);

	$sql = 'SELECT AssignmentTitle FROM tbl_assignment WHERE ID = ? ';
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
									You're Done!
								</h6>
							</div>

							<div class="card-body">
								
								<div class="col-lg-12">
									<div class="card border-secondary">
										<div class="card-header bg-light border-secondary header-elements-inline">
											<h6 class="card-title">
												Congrats! You have completed the test
											</h6>
										</div>
										<div class="card-body">
											<p>Final Score: <?= $_SESSION['score']; ?></p>

											<form method="POST" action="action/assign-process.php">
											<input type="hidden" name="score" value="<?= $_SESSION['score']; ?>">
											<input type="hidden" name="assignmentID" value="<?= $_GET['assignmentID']; ?>">

											<input type="submit" name="finish" class="btn btn-light" value="Finish">
											</form>
										</div>
										
									</div>
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
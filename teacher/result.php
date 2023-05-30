<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('../config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);
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
								<span class="breadcrumb-item active">Result</span>
							</div>

							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>
				</div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">

					<!-- Style combinations -->
					<div class="card">

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Quiz Title</th>
									<th>Subject</th>
									<th>Student</th>
									<th>Score</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT a.ID,
											   a.QuizID,
										       b.QuizTitle,
										       a.StudentID,
										       c.FirstName,
										       c.MiddleName,
										       c.LastName,
										       a.TotalScore,
										       d.Section,
										       e.Grade,
										       f.SchoolYear,
										       g.Subject
										FROM tbl_score a 
											LEFT JOIN tbl_quiz b ON b.ID = a.QuizID
										    LEFT JOIN tbl_student c ON c.ID = a.StudentID
										    LEFT JOIN tbl_section d ON d.ID = c.SectionID
										    LEFT JOIN tbl_grade e ON e.ID = d.GradeID
										    LEFT JOIN tbl_schoolyear f ON f.ID = d.SchoolYearID   
										    LEFT JOIN tbl_subject g ON g.ID = b.SubjectID
										WHERE a.QuizID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$_GET['quizID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['QuizTitle']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['LastName'] .', '. $row['FirstName'] .' | '. $row['MiddleName']; ?></td>
									<td><?= $row['TotalScore']; ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- /style combinations -->

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
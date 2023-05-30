<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('../config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);

	$sqlx = 'SELECT SectionID FROM tbl_student WHERE ID = ? AND isDeleted = 0';
	$stmtx = $conn->prepare($sqlx);
	$stmtx->execute([$_SESSION['StudentID']]);
	$rowx = $stmtx->fetch();
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
								<span class="breadcrumb-item active">Quiz</span>
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
									<th>Teacher</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT 
										    a.ID,
										    a.QuizTitle,
										    d.Subject,
										    b.FirstName,
										    b.MiddleName,
										    b.LastName,
										    c.Section,
										    e.Grade,
										    f.SchoolYear
										FROM tbl_quiz a
										    LEFT JOIN tbl_teacher b on b.ID = a.TeacherID
										    LEFT JOIN tbl_section c on c.ID = a.SectionID
										    LEFT JOIN tbl_subject d on d.ID = a.SubjectID
										    LEFT JOIN tbl_grade e on e.ID = c.GradeID
										    LEFT JOIN tbl_schoolyear f on f.ID = c.SchoolYearID
										WHERE a.isDeleted = 0 AND a.SectionID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$rowx['SectionID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['QuizTitle']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['FirstName'] .' '. $row['MiddleName'] .', '. $row['LastName']; ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<?php 
											$sqll = 'SELECT ID, StudentID FROM tbl_score where QuizID = ? AND StudentID = ?'; 
											$stmtt = $conn->prepare($sqll);
											$stmtt->execute([$row['ID'],$_SESSION['StudentID']]);
											$taken = $stmtt->fetchColumn();

											if($taken) {
										?>
										<button class="btn btn-outline-dark" disabled>Taken</button>
										<?php } else { ?>
										<a href="question.php?quizID=<?=$row['ID'];?>&qno=1" class="btn btn-outline-primary">Start</a>
										<?php } ?>
									</td>
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
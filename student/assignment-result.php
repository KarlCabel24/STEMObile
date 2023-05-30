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
								<span class="breadcrumb-item active">Assignment Result</span>
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
									<th>Assignment Title</th>
									<th>Subject</th>
									<th>Teacher</th>
									<th>Score</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT 
										    a.ID,
										    a.AssignmentTitle,
										    d.Subject,
										    b.FirstName,
										    b.MiddleName,
										    b.LastName,
										    c.Section,
										    e.Grade,
										    f.SchoolYear,
										    g.TotalScore
										FROM tbl_assignment a
										    LEFT JOIN tbl_teacher b on b.ID = a.TeacherID
										    LEFT JOIN tbl_section c on c.ID = a.SectionID
										    LEFT JOIN tbl_subject d on d.ID = a.SubjectID
										    LEFT JOIN tbl_grade e on e.ID = c.GradeID
										    LEFT JOIN tbl_schoolyear f on f.ID = c.SchoolYearID
										    LEFT JOIN tbl_assign_score g on g.AssignmentID = a.ID
										WHERE a.isDeleted = 0 AND a.SectionID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$rowx['SectionID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['AssignmentTitle']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['FirstName'] .' '. $row['MiddleName'] .', '. $row['LastName']; ?></td>
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
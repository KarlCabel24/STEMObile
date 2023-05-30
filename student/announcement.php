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
								<span class="breadcrumb-item active">Announcement</span>
							</div>
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
									<th>Announcement</th>
									<th>Subject</th>
									<th>Teacher</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="d-none"></th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT a.ID,
											   a.Announcement,
										       a.SectionID,
										       b.Section,
										       c.Grade,
										       d.SchoolYear,
										       a.SubjectID,
										       e.Subject,
										       a.TeacherID,
										       f.FirstName,
										       f.MiddleName,
										       f.LastName
										FROM tbl_announcement a
											LEFT JOIN tbl_section b ON b.ID = a.SectionID
										    LEFT JOIN tbl_grade c ON c.ID = b.GradeID
										    LEFT JOIN tbl_schoolyear d ON d.ID = b.SchoolYearID
										    LEFT JOIN tbl_subject e ON e.ID = a.SubjectID
										    LEFT JOIN tbl_teacher f ON f.ID = a.TeacherID
										WHERE a.isDeleted = 0 AND a.SectionID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$sessionRow['SectionID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Announcement']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['FirstName'] .' '. $row['MiddleName'] .', '. $row['LastName']; ?></td>
									<td class="d-none"></td>
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
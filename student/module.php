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
								<span class="breadcrumb-item active">Module</span>
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
									<th>Module</th>
									<th>Subject</th>
									<th>Teacher</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT a.ID,
											   a.Module,
										       a.SectionID,
										       d.Section,
										       a.SubjectID,
										       c.Subject,
										       a.TeacherID,
										       b.FirstName,
										       b.MiddleName,
										       b.LastName,
										       e.Grade,
										       f.SchoolYear
										FROM tbl_module a
											LEFT JOIN tbl_teacher b ON b.ID = a.TeacherID
											LEFT JOIN tbl_subject c ON c.ID = a.SubjectID
											LEFT JOIN tbl_section d ON d.ID = a.SectionID
											LEFT JOIN tbl_grade e ON e.ID = d.GradeID
											LEFT JOIN tbl_schoolyear f ON f.ID = d.SchoolYearID
										WHERE a.isDeleted = 0 AND a.SectionID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$sessionRow['SectionID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Module']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['LastName'].', '.$row['FirstName'].' '.$row['MiddleName']; ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<div class="list-icons">
											<div class="dropdown">
												<a href="#" class="list-icons-item" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right">
													<a href="../uploads/<?= $row['Module']; ?>" download="<?= $row['Module']; ?>" class="dropdown-item"><i class="icon-file-download"></i> Download</a>
												</div>
											</div>
										</div>
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
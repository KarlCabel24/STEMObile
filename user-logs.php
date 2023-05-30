<?php 
	session_start();

	if(!isset($_SESSION['ID']))
	{
		header('refresh:0; login.php');
		exit();
	}

	include('config/Database.php');

	$dir = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('include/head.php'); ?>

<body>

	<!-- Main navbar -->
	<?php include('include/navbar.php'); ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include('include/sidebar.php'); ?>
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

						<div class="card-body font-weight-bold">
							Teacher Logs
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Teacher Name</th>
									<th>Action</th>
									<th>Date Happened</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="d-none"></th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql1 = 'SELECT a.ID,
											   a.StudentID,
										       b.FirstName,
										       b.MiddleName,
										       b.LastName,
										       a.Action,
										       a.DateHappened
										FROM user_logs a
											LEFT JOIN tbl_teacher b ON b.ID = a.TeacherID
										 WHERE a.StudentID IS NULL
									   ';
								$stmt1 = $conn->prepare($sql1);
								$stmt1->execute();

								while($row1 = $stmt1->fetch()){
							?>
								<tr>
									<td><?= $row1['LastName'].', '.$row1['FirstName'].' '.$row1['MiddleName']; ?></td>
									<td><?= $row1['Action']; ?></td>
									<td><?= date('M j, Y h:i A',strtotime($row1['DateHappened'])); ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
								</tr>

							<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- /style combinations -->

					<!-- Style combinations -->
					<div class="card">

						<div class="card-body font-weight-bold">
							Student Activity Logs
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Student Name</th>
									<th>Action</th>
									<th>Date Happened</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="d-none"></th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT a.ID,
											   a.StudentID,
										       b.FirstName,
										       b.MiddleName,
										       b.LastName,
										       a.Action,
										       a.DateHappened
										FROM user_logs a
											LEFT JOIN tbl_student b ON b.ID = a.StudentID
										 WHERE a.TeacherID IS NULL';
								$stmt = $conn->prepare($sql);
								$stmt->execute();

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['LastName'].', '.$row['FirstName'].' '.$row['MiddleName']; ?></td>
									<td><?= $row['Action']; ?></td>
									<td><?= date('M j, Y h:i A',strtotime($row['DateHappened'])); ?></td>
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
				<?php include('include/footer.php'); ?>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
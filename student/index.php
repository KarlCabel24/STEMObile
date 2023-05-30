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
								<span class="breadcrumb-item active">Dashboard</span>
							</div>

							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Dashboard content -->
					<div class="row">
						<div class="col-xl-12">

							<!-- Quick stats boxes -->
							<div class="row">
								<div class="col-lg-3">

									<div class="card bg-secondary text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">
													<?php  
														$sql1 = 'SELECT 
																	IFNULL(COUNT(ID), 0) as TeacherCount
																FROM tbl_teacher
																WHERE isDeleted = 0
															   ';
														$stmt1 = $conn->prepare($sql1);
														$stmt1->execute();
														$row1 = $stmt1->fetch();

														echo $row1['TeacherCount'];

														$stmt1->closeCursor();
													?>
												</h3>
						                	</div>
						                	
						                	<div>
												Teacher(s)
											</div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>

								</div>

								<div class="col-lg-3">

									<div class="card bg-secondary text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">
													<?php  
														$sql2 = 'SELECT 
																	IFNULL(COUNT(ID), 0) as StudentCount
																 FROM tbl_student
																 WHERE isDeleted = 0
															    ';
														$stmt2 = $conn->prepare($sql2);
														$stmt2->execute();
														$row2 = $stmt2->fetch();

														echo $row2['StudentCount'];

														$stmt2->closeCursor();
													?>
												</h3>
						                	</div>
						                	
						                	<div>
												Student(s)
											</div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>

								</div>

								<div class="col-lg-3">

									<div class="card bg-secondary text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">
													<?php  
														$sql3 = 'SELECT 
																	IFNULL(COUNT(ID), 0) as SubjectCount
																 FROM tbl_subject
																 WHERE isDeleted = 0
															    ';
														$stmt3 = $conn->prepare($sql3);
														$stmt3->execute();
														$row3 = $stmt3->fetch();

														echo $row3['SubjectCount'];

														$stmt3->closeCursor();
													?>
												</h3>
						                	</div>
						                	
						                	<div>
												Subject(s)
											</div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>

								</div>

								<div class="col-lg-3">

									<div class="card bg-secondary text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">
													<?php  
														$sql4 = 'SELECT 
																	IFNULL(COUNT(ID), 0) as SectionCount
																 FROM tbl_section
																 WHERE isDeleted = 0
															    ';
														$stmt4 = $conn->prepare($sql4);
														$stmt4->execute();
														$row4 = $stmt4->fetch();

														echo $row4['SectionCount'];

														$stmt4->closeCursor();
													?>
												</h3>
						                	</div>
						                	
						                	<div>
												Section(s)
											</div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>

								</div>
							</div>
							<!-- /quick stats boxes -->

						</div>
					</div>
					<!-- /dashboard content -->

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
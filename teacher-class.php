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
								<span class="breadcrumb-item active">Teacher</span>
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

						<div class="card-body">
							<button type="button" class="btn btn-light" data-toggle="modal" data-target="#new">
								<i class="icon-file-plus"></i> New 
							</button>
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Grade Level</th>
									<th>Section</th>
									<th>School Year</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT 
											a.ID,
											d.Grade,
											b.ID as SectionID,
											b.Section,
											c.SchoolYear
										FROM tbl_class a
											LEFT JOIN tbl_section b on b.ID = a.SectionID
											LEFT JOIN tbl_schoolyear c on c.ID = b.SchoolYearID
											LEFT JOIN tbl_grade d on d.ID = b.GradeID
										WHERE a.isDeleted = 0 AND a.TeacherID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$_GET['teacherID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Grade']; ?></td>
									<td><?= $row['Section']; ?></td>
									<td><?= $row['SchoolYear'];  ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<div class="list-icons">
											<div class="dropdown">
												<a href="#" class="list-icons-item" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right">
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit<?= $row['ID']; ?>"><i class="icon-pencil"></i> Edit</a>
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete<?= $row['ID']; ?>"><i class="icon-trash"></i> Delete</a>
												</div>
											</div>
										</div>
									</td>
								</tr>

								<!-- edit modal -->
								<div id="edit<?= $row['ID']; ?>" class="modal fade" tabindex="-1">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title font-weight-semibold">New</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<legend></legend>

											<form action="action/teacher-class-action.php" method="POST" autocomplete="off">
												<div class="modal-body">
													<div class="form-group">
														<div class="row">
									                        <div class="col-sm-12">
									                            <label class="font-weight-semibold">Grade - Section</label>
									                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="sectionID" data-fouc required>
									                            	<?php if($row['SectionID'] != 0) { ?>
																	<option value="<?= $row['SectionID'] ?>"><?= $row['Grade'].' - '.$row['Section'].' | '.$row['SchoolYear']; ?></option>
																	<?php } else { ?>
																	<option value=""></option>
									                                <?php
									                                	}
									                                	
																		$sql2 = 'SELECT a.ID, 
																						a.Section,
																						b.Grade,
																						d.SchoolYear
																				 FROM 	tbl_section a
																				  		LEFT JOIN tbl_grade b ON b.ID = a.GradeID
																				  		LEFT JOIN tbl_schoolyear d ON d.ID = a.SchoolYearID
																				 WHERE a.isDeleted = 0 AND a.ID != ?
																				';
																		$stmt2 = $conn->prepare($sql2);
																		$stmt2->execute([$row['SectionID']]);

																		while($row2 = $stmt2->fetch()){
																	?>
									                                <option value="<?= $row2['ID']; ?>"><?= $row2['Grade'].' - '.$row2['Section'].' | '.$row2['SchoolYear']; ?></option>
																	<?php } $stmt2->closeCursor(); ?>
									                            </select>
									                        </div>
														</div>
							                        </div>

							                        <div class="form-group d-none">
														<div class="row">
															<div class="col-sm-12">
																<label class="font-weight-semibold">ID</label>
																<input type="text" class="form-control" name="id" required value="<?= $row['ID']; ?>">
															</div>
														</div>
													</div>

													<div class="form-group d-none">
														<div class="row">
									                        <div class="col-sm-12">
																<label class="font-weight-semibold">TeacherID</label>
																<input type="text" name="teacherID" value="<?= $_GET['teacherID']; ?>" class="form-control" readonly>
															</div>
														</div>
							                        </div>
												</div>

												<div class="modal-footer">
													<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
													<button type="submit" name="update" class="btn btn-primary">Submit</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!-- /edit modal -->

								<!-- delete modal -->
								<div id="delete<?= $row['ID']; ?>" class="modal fade" tabindex="-1">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title font-weight-semibold">Delete</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<legend></legend>

											<form action="action/teacher-class-action.php" method="POST" autocomplete="off">
												<div class="modal-body">
													<div class="form-group d-none">
														<div class="row">
															<div class="col-sm-12">
																<label class="font-weight-semibold">ID</label>
																<input type="text" class="form-control" name="id" required value="<?= $row['ID']; ?>">
															</div>
														</div>
													</div>

													<div class="form-group d-none">
														<div class="row">
									                        <div class="col-sm-12">
																<label class="font-weight-semibold">TeacherID</label>
																<input type="text" name="teacherID" value="<?= $_GET['teacherID']; ?>" class="form-control" readonly>
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

	<!-- new modal -->
	<div id="new" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-semibold">New</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<legend></legend>

				<form action="action/teacher-class-action.php" method="POST" autocomplete="off">
					<div class="modal-body">
                        <div class="form-group">
							<div class="row">
		                        <div class="col-sm-12">
		                            <label class="font-weight-semibold">Class</label>
									<select class="form-control multiselect" multiple="multiple" name="sectionOption[]" data-fouc>
										<?php
											$sql1 = 'SELECT a.ID, 
															a.Section,
															b.Grade,
															d.SchoolYear
													 FROM 	tbl_section a
													  		LEFT JOIN tbl_grade b ON b.ID = a.GradeID
													  		LEFT JOIN tbl_schoolyear d ON d.ID = a.SchoolYearID
													 WHERE a.isDeleted = 0
													';
											$stmt1 = $conn->prepare($sql1);
											$stmt1->execute();

											while($row1 = $stmt1->fetch()){
										?>
										<option value="<?= $row1['ID']; ?>"><?= $row1['Grade'] .' - '. $row1['Section'] .' | '. $row1['SchoolYear']; ?></option>
										<?php } $stmt1->closeCursor(); ?>
									</select>
		                        </div>
							</div>
                        </div>

                        <div class="form-group d-none">
							<div class="row">
		                        <div class="col-sm-12">
									<label class="font-weight-semibold">TeacherID</label>
									<input type="text" name="teacherID" value="<?= $_GET['teacherID']; ?>" class="form-control" readonly>
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

</body>
</html>
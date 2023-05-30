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
								<span class="breadcrumb-item active">Section</span>
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
								<i class="icon-plus22"></i> New 
							</button>
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Section</th>
									<th>Grade Level</th>
									<th class="d-none"></th>
									<th>School Year</th>
									<th class="d-none">Date Created</th>
									<th class="d-none">Date Updated</th>
									<th class="text-center" width="10%">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT 
											a.ID,
											a.Section,
											d.ID as GradeID,
											d.Grade,
											c.ID as SchoolYearID,
											c.SchoolYear
										FROM tbl_section a
											LEFT JOIN tbl_schoolyear c on c.ID = a.SchoolYearID
											LEFT JOIN tbl_grade d on d.ID = a.GradeID
										WHERE a.isDeleted = 0
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute();

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Section']; ?></td>
									<td><?= $row['Grade']; ?></td>
									<td class="d-none"></td>
									<td><?= $row['SchoolYear']; ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<div class="list-icons">
											<div class="dropdown">
												<a href="#" class="list-icons-item" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right">
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit<?=$row['ID'];?>"><i class="icon-pencil"></i> Edit</a>
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete<?=$row['ID'];?>"><i class="icon-trash"></i> Delete</a>
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
												<h5 class="modal-title font-weight-semibold">Edit</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<legend></legend>

											<form action="action/section-action.php" method="POST" autocomplete="off">
												<div class="modal-body">
													<div class="form-group d-none">
														<div class="row">
															<div class="col-sm-12">
																<label class="font-weight-semibold">ID</label>
																<input type="text" class="form-control" name="id" required value="<?= $row['ID']; ?>">
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<div class="col-sm-12">
																<label class="font-weight-semibold">Section</label>
																<input type="text" class="form-control" name="section" value="<?= $row['Section']; ?>" required placeholder="Explorative">
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<div class="col-sm-12">
									                            <label class="font-weight-semibold">Grade Level</label>
									                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="gradeOption" data-fouc required>
																	<option value="<?= $row['GradeID']; ?>"><?= $row['Grade']; ?></option>
																	<?php
																		$sql1 = 'SELECT  ID, Grade FROM tbl_grade WHERE isDeleted = 0';
																		$stmt1 = $conn->prepare($sql1);
																		$stmt1->execute();

																		while($row1 = $stmt1->fetch()){
																	?>
									                                <option value="<?= $row1['ID']; ?>"><?= $row1['Grade']; ?></option>
																	<?php } $stmt1->closeCursor(); ?>
									                            </select>
									                        </div>
														</div>
								                    </div>

								                    <div class="form-group">
														<div class="row">
															<div class="col-sm-12">
									                            <label class="font-weight-semibold">School Year</label>
									                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="schoolYearOption" data-fouc required>
																	<option value="<?= $row['SchoolYearID']; ?>"><?= $row['SchoolYear']; ?></option>
									                                <?php
																		$sql3 = 'SELECT  ID, SchoolYear FROM tbl_schoolyear WHERE isDeleted = 0';
																		$stmt3 = $conn->prepare($sql3);
																		$stmt3->execute();

																		while($row3 = $stmt3->fetch()){
																	?>
									                                <option value="<?= $row3['ID']; ?>"><?= $row3['SchoolYear']; ?></option>
																	<?php } $stmt3->closeCursor(); ?>
									                            </select>
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

											<form action="action/section-action.php" method="POST" autocomplete="off">
												<div class="modal-body">
													<div class="form-group d-none">
														<div class="row">
															<div class="col-sm-12">
																<label class="font-weight-semibold">ID</label>
																<input type="text" class="form-control" name="id" required value="<?= $row['ID']; ?>">
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
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-semibold">New</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<legend></legend>

				<form action="action/section-action.php" method="POST" autocomplete="off">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold">Section</label>
									<input type="text" class="form-control" name="section" required placeholder="Explorative">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
		                            <label class="font-weight-semibold">Grade Level</label>
		                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="gradeOption" data-fouc required>
										<option value=""></option>
										<?php
											$sql2 = 'SELECT  ID, Grade FROM tbl_grade WHERE isDeleted = 0 ';
											$stmt2 = $conn->prepare($sql2);
											$stmt2->execute();

											while($row2 = $stmt2->fetch()){
										?>
		                                <option value="<?= $row2['ID']; ?>"><?= $row2['Grade']; ?></option>
										<?php } $stmt2->closeCursor(); ?>
		                            </select>
		                        </div>
							</div>
	                    </div>

	                    <div class="form-group">
							<div class="row">
								<div class="col-sm-12">
		                            <label class="font-weight-semibold">School Year</label>
		                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="schoolYearOption" data-fouc required>
										<option value=""></option>
		                                <?php
											$sql4 = 'SELECT  ID, SchoolYear FROM tbl_schoolyear WHERE isDeleted = 0 ';
											$stmt4 = $conn->prepare($sql4);
											$stmt4->execute();

											while($row4 = $stmt4->fetch()){
										?>
		                                <option value="<?= $row4['ID']; ?>"><?= $row4['SchoolYear']; ?></option>
										<?php } $stmt4->closeCursor(); ?>
		                            </select>
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
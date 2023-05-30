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
								<span class="breadcrumb-item active">Subject</span>
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
									<th>Subject</th>
									<th>Date Added</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT a.ID,
											   a.TeacherID,
										       a.SubjectID,
										       b.Subject,
										       a.SectionID,
										       c.Section,
										       a.DateCreated
										FROM tbl_teacher_subject a
											LEFT JOIN tbl_subject b ON b.ID = a.SubjectID
											LEFT JOIN tbl_section c ON c.ID = a.SectionID
										WHERE a.isDeleted = 0 AND a.SectionID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$_GET['sectionID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Subject']; ?></td>
									<td><?= date('M j, Y h:i A',strtotime($row['DateCreated'])); ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<div class="list-icons">
											<div class="dropdown">
												<a href="#" class="list-icons-item" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right">
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete<?=$row['ID'];?>"><i class="icon-trash"></i> Delete</a>
												</div>
											</div>
										</div>
									</td>
								</tr>

								<!-- delete modal -->
								<div id="delete<?= $row['ID']; ?>" class="modal fade" tabindex="-1">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title font-weight-semibold">Delete</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<legend></legend>

											<form action="action/class-subject-action.php" method="POST" autocomplete="off">
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
																<label class="font-weight-semibold">Section ID</label>
																<input type="text" class="form-control" name="sectionID" required value="<?= $row['SectionID']; ?>">
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

				<form action="action/class-subject-action.php" method="POST" autocomplete="off">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
		                        <div class="col-sm-12">
		                            <label class="font-weight-semibold">Subject</label>
									<select class="form-control multiselect" multiple="multiple" name="subjectOption[]" data-fouc>
										<?php
											$sql3 = 'SELECT ID, Subject FROM tbl_subject WHERE isDeleted = 0';
											$stmt3 = $conn->prepare($sql3);
											$stmt3->execute();

											while($row3 = $stmt3->fetch()){
										?>
										<option value="<?= $row3['ID']; ?>"><?= $row3['Subject']; ?></option>
										<?php } $stmt3->closeCursor(); ?>
									</select>
		                        </div>
							</div>
                        </div>

                        <div class="form-group d-none">
							<div class="row">
								<div class="col-sm-12">
									<label class="font-weight-semibold">ID</label>
									<input type="text" class="form-control" name="sectionID" required value="<?=$_GET['sectionID'];?>">
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
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

						<div class="card-body">
							<button type="button" class="btn btn-light" data-toggle="modal" data-target="#upload">
								<i class="icon-file-upload"></i> Upload 
							</button>
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Module</th>
									<th>Subject</th>
									<th>Class</th>
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
										WHERE a.isDeleted = 0 AND a.TeacherID = ?
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute([$_SESSION['TeacherID']]);

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['Module']; ?></td>
									<td><?= $row['Subject']; ?></td>
									<td><?= $row['Grade'].' - '.$row['Section'].' | '.$row['SchoolYear']; ?></td>
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
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete<?= $row['ID']; ?>"><i class="icon-trash"></i> Delete</a>
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

											<form action="action/module-action.php" method="POST" autocomplete="off">
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

	<!-- upload modal -->
	<div id="upload" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-semibold">Upload</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<legend></legend>

				<form action="action/module-action.php" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
		                        <div class="col-sm-12">
		                            <label class="font-weight-semibold">Class</label>
		                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="sectionOption" data-fouc required>
										<option value=""></option>
		                                <?php
											$classQuery = 'SELECT a.ID,
														    a.TeacherID,
													        a.SectionID,
													        c.Section,
													        d.Grade,
       														e.SchoolYear
													 FROM tbl_class a
													 	 LEFT JOIN tbl_teacher_subject b on b.TeacherID = a.TeacherID
													     LEFT JOIN tbl_section c on c.ID = a.SectionID
													     LEFT JOIN tbl_grade d on d.ID = c.GradeID
    													 LEFT JOIN tbl_schoolyear e on e.ID = c.SchoolYearID
													 WHERE a.isDeleted = 0 AND a.TeacherID = ?
													 GROUP BY a.SectionID';
											$classStmt = $conn->prepare($classQuery);
											$classStmt->execute([$_SESSION['TeacherID']]);

											while($classRow = $classStmt->fetch()){
										?>
		                                <option value="<?= $classRow['SectionID']; ?>"><?= $classRow['Grade'].' - '.$classRow['Section'].' | '.$classRow['SchoolYear']; ?></option>
										<?php } $classStmt->closeCursor(); ?>
		                            </select>
		                        </div>
							</div>
                        </div>

						<div class="form-group">
							<div class="row">
		                        <div class="col-sm-12">
		                            <label class="font-weight-semibold">Subject</label>
		                            <select data-placeholder="-SELECT-" class="form-control form-control-select2" name="subjectOption" data-fouc required>
										<option value=""></option>
		                                <?php
											$subjectQuery = 'SELECT ID, Subject FROM tbl_subject WHERE isDeleted = 0';
											$subjectStmt = $conn->prepare($subjectQuery);
											$subjectStmt->execute();

											while($subjectRow = $subjectStmt->fetch()){
										?>
		                                <option value="<?= $subjectRow['ID']; ?>"><?= $subjectRow['Subject']; ?></option>
										<?php } $subjectStmt->closeCursor(); ?>
		                            </select>
		                        </div>
							</div>
                        </div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<input type="file" class="form-control h-auto" name="uploadFile" required>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" name="upload" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /upload modal -->
</body>
</html>
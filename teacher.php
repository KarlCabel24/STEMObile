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
								<i class="icon-plus2"></i> New 
							</button>

							<button type="button" class="btn btn-light" data-toggle="modal" data-target="#upload">
								<i class="icon-file-upload"></i> Upload 
							</button>
						</div>

						<table class="table datatable-basic table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>ID Number</th>
									<th>Password</th>
									<th class="d-none"></th>
									<th class="d-none"></th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  
								$sql = 'SELECT 
											a.ID,
											a.FirstName,
											a.MiddleName,
											a.LastName,
											a.IDnumber,
											b.Password
										FROM tbl_teacher a
											LEFT JOIN tbl_user b on b.TeacherID = a.ID
										WHERE a.isDeleted = 0
										ORDER BY a.FirstName ASC
									   ';
								$stmt = $conn->prepare($sql);
								$stmt->execute();

								while($row = $stmt->fetch()){
							?>
								<tr>
									<td><?= $row['FirstName'] .' '. $row['MiddleName'] .', '. $row['LastName']; ?></td>
									<td><?= $row['IDnumber']; ?></td>
									<td><?= $row['Password'];  ?></td>
									<td class="d-none"></td>
									<td class="d-none"></td>
									<td class="text-center">
										<div class="list-icons">
											<div class="dropdown">
												<a href="#" class="list-icons-item" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right">
													<a href="teacher-class.php?teacherID=<?= $row['ID']; ?>" class="dropdown-item"><i class="icon-address-book2"></i> Class</a>
													<a href="teacher-subject.php?teacherID=<?= $row['ID']; ?>" class="dropdown-item"><i class="icon-books"></i> Subject</a>
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
												<h5 class="modal-title font-weight-semibold">Edit</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<legend></legend>

											<form action="action/teacher-action.php" method="POST" autocomplete="off">
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
															<div class="col-sm-4">
																<label class="font-weight-semibold">First Name</label>
																<input type="text" class="form-control" name="firstName" required value="<?= $row['FirstName']; ?>">
															</div>

															<div class="col-sm-4">
																<label class="font-weight-semibold">Middle Name</label>
																<input type="text" class="form-control" name="middleName" required value="<?= $row['MiddleName']; ?>">
															</div>

															<div class="col-sm-4">
																<label class="font-weight-semibold">Last Name</label>
																<input type="text" class="form-control" name="lastName" required value="<?= $row['LastName']; ?>">
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<div class="col-sm-6">
																<label class="font-weight-semibold">ID Number</label>
																<input type="text" class="form-control" name="idNumber" maxlength="10" required value="<?= $row['IDnumber']; ?>">
															</div>

															<div class="col-sm-6">
																<label class="font-weight-semibold">Password</label>
																<input type="text" class="form-control" name="password" value="<?= $row['Password']; ?>">
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

											<form action="action/teacher-action.php" method="POST" autocomplete="off">
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

				<form action="action/teacher-action.php" method="POST" autocomplete="off">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-4">
									<label class="font-weight-semibold">First Name</label>
									<input type="text" class="form-control" name="firstName" required placeholder="John">
								</div>

								<div class="col-sm-4">
									<label class="font-weight-semibold">Middle Name</label>
									<input type="text" class="form-control" name="middleName" required placeholder="N">
								</div>

								<div class="col-sm-4">
									<label class="font-weight-semibold">Last Name</label>
									<input type="text" class="form-control" name="lastName" required placeholder="Doe">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label class="font-weight-semibold">ID Number</label>
									<input type="text" class="form-control" name="idNumber" maxlength="12" required placeholder="201900287">
								</div>

								<div class="col-sm-6">
									<label class="font-weight-semibold">Password</label>
									<div class="input-group">
										<input type="text" id="password" class="form-control" name="password" required>
										<span class="input-group-append">
											<button type="button" class="btn btn-light" onclick="randomPassword()" data-popup="tooltip" title="Random Password">
												<i class="icon-magic-wand"></i>
											</button>
										</span>
									</div>
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

	<!-- upload modal -->
	<div id="upload" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-semibold">Upload</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<legend></legend>

				<form action="action/teacher-action.php" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
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

	<script type="text/javascript">
		function randomPassword(){
			var characters = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz0123456789!@#$";
			var lenString = 10;
			var randomstring = '';
	  
			for (var i=0; i<lenString; i++){
				var rnum = Math.floor(Math.random() * characters.length);
				randomstring += characters.substring(rnum, rnum+1);
			}
	   
			$('#password').val(randomstring);  
		}
	</script>
</body>
</html>
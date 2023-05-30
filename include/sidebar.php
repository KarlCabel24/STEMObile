<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-section sidebar-user my-1">
			<div class="sidebar-section-body">
				<div class="media">

					<a href="#" class="mr-3">
						<img src="images/icon-user.png" class="rounded-pill mr-lg-2" height="34" alt="">
					</a>

					<div class="media-body">
						<div class="font-weight-semibold">
							<?php  
								if(isset($_SESSION['StudentID']))
								{
									$sessionQuery = 'SELECT a.ID,
														    a.StudentID,
													        a.Username,
														    a.Password,
														    b.FirstName,
														    b.MiddleName,
														    b.LastName,
														    b.SectionID
													 FROM 	tbl_user a
															LEFT JOIN tbl_student b 
																   ON b.ID = a.StudentID
													 WHERE 	a.isDeleted = 0 
															AND b.ID = ?
												   ';
									$sessionStmt = $conn->prepare($sessionQuery);
									$sessionStmt->execute([$_SESSION['StudentID']]);

									if($sessionStmt)
									{
										$sessionRow = $sessionStmt->fetch();
										echo $sessionRow['FirstName'].' '. $sessionRow['MiddleName'].' '. $sessionRow['LastName'];
									}
								}

								if(isset($_SESSION['TeacherID']))
								{
									$sessionQuery = 'SELECT a.ID,
														    a.TeacherID,
													        a.Username,
														    a.Password,
														    b.FirstName,
														    b.MiddleName,
														    b.LastName
													 FROM 	tbl_user a
															LEFT JOIN tbl_teacher b 
																   ON b.ID = a.TeacherID
													 WHERE 	a.isDeleted = 0 
															AND b.ID = ?
												   ';
									$sessionStmt = $conn->prepare($sessionQuery);
									$sessionStmt->execute([$_SESSION['TeacherID']]);

									if($sessionStmt)
									{
										$sessionRow = $sessionStmt->fetch();
										echo $sessionRow['FirstName'].' '. $sessionRow['MiddleName'].' '. $sessionRow['LastName'];
									}
								}
								
								if(!isset($_SESSION['StudentID']) && !isset($_SESSION['TeacherID']))
								{
									echo 'Administrator';
								}
							?>
						</div>
						<div class="font-size-sm line-height-sm opacity-50">
							<?php
								if(isset($_SESSION['StudentID']))
								{
									echo 'Student';
								}

								if(isset($_SESSION['TeacherID']))
								{
									echo 'Teacher';
								}

								if(!isset($_SESSION['StudentID']) && !isset($_SESSION['TeacherID']))
								{
									echo 'Developer';
								}
							?>
						</div>
					</div>

					<div class="ml-3 align-self-center">
						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
							<i class="icon-transmission"></i>
						</button>

						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
							<i class="icon-cross2"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="sidebar-section">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<?php if (!isset($_SESSION['TeacherID']) && !isset($_SESSION['StudentID'])): ?>
				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
				<li class="nav-item">
					<a href="index.php" class="nav-link <?= $dir=='index.php' ? 'active' : '' ?>">
						<i class="icon-home4"></i>
						<span>Dashboard</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="school-year.php" class="nav-link <?= $dir=='school-year.php' ? 'active' : '' ?>">
						<i class="icon-quill2"></i>
						<span>School Year</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="grade.php" class="nav-link <?= $dir=='grade.php' ? 'active' : '' ?>">
						<i class="icon-medal"></i>
						<span>Grade Level</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="section.php" class="nav-link <?= $dir=='section.php' ? 'active' : '' ?>">
						<i class="icon-list"></i>
						<span>Section</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="subject.php" class="nav-link <?= $dir=='subject.php' ? 'active' : '' ?>">
						<i class="icon-books"></i>
						<span>Subject</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="teacher.php" class="nav-link <?= $dir=='teacher.php' ? 'active' : '' ?>">
						<i class="icon-user-tie"></i>
						<span>Teacher</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="quiz.php" class="nav-link <?= $dir=='quiz.php' ? 'active' : '' ?>">
						<i class="icon-pencil7"></i>
						<span>Quiz</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="assignment.php" class="nav-link <?= $dir=='assignment.php' ? 'active' : '' ?>">
						<i class="icon-pencil7"></i>
						<span>Assignment</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="student.php" class="nav-link <?= $dir=='student.php' ? 'active' : '' ?>">
						<i class="icon-user"></i>
						<span>Student</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="module.php" class="nav-link <?= $dir=='module.php' ? 'active' : '' ?>">
						<i class="icon-drawer3"></i>
						<span>Module</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="announcement.php" class="nav-link <?= $dir=='announcement.php' ? 'active' : '' ?>">
						<i class="icon-megaphone"></i>
						<span>Announcement</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="user-logs.php" class="nav-link <?= $dir=='user-logs.php' ? 'active' : '' ?>">
						<i class="icon-file-eye"></i>
						<span>User Logs</span>
					</a>
				</li>
				<!-- /main -->
				<?php endif ?>

				<!-- Teacher -->
				<?php if (isset($_SESSION['TeacherID'])): ?>
				
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
				<li class="nav-item">
					<a href="class.php" class="nav-link <?= $dir=='class.php' ? 'active' : '' ?>">
						<i class="icon-address-book2"></i>
						<span>My Class</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="quiz.php" class="nav-link <?= $dir=='quiz.php' ? 'active' : '' ?>">
						<i class="icon-pencil7"></i>
						<span>Quiz List</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="assignment.php" class="nav-link <?= $dir=='assignment.php' ? 'active' : '' ?>">
						<i class="icon-pencil7"></i>
						<span>Assignment</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="module.php" class="nav-link <?= $dir=='module.php' ? 'active' : '' ?>">
						<i class="icon-drawer3"></i>
						<span>Module</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="student.php" class="nav-link <?= $dir=='student.php' ? 'active' : '' ?>">
						<i class="icon-user"></i>
						<span>Student</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="announcement.php" class="nav-link <?= $dir=='announcement.php' ? 'active' : '' ?>">
						<i class="icon-megaphone"></i>
						<span>Announcement</span>
					</a>
				</li>

				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Parameter</div> <i class="icon-menu" title="Parameter"></i></li>
				<li class="nav-item">
					<a href="school-year.php" class="nav-link <?= $dir=='school-year.php' ? 'active' : '' ?>">
						<i class="icon-quill2"></i>
						<span>School Year</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="grade.php" class="nav-link <?= $dir=='grade.php' ? 'active' : '' ?>">
						<i class="icon-medal"></i>
						<span>Grade Level</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="section.php" class="nav-link <?= $dir=='section.php' ? 'active' : '' ?>">
						<i class="icon-list"></i>
						<span>Section Class</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="subject.php" class="nav-link <?= $dir=='subject.php' ? 'active' : '' ?>">
						<i class="icon-books"></i>
						<span>Subject</span>
					</a>
				</li>
				
				<?php endif ?>
				<!-- /teacher -->

				<?php if (isset($_SESSION['StudentID'])): ?>
				<!-- Student -->
				
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Student</div> <i class="icon-menu" title="Student"></i></li>
				<li class="nav-item">
					<a href="announcement.php" class="nav-link <?= $dir=='announcement.php' ? 'active' : '' ?>">
						<i class="icon-megaphone"></i>
						<span>Announcement</span>
					</a>
				</li>
	
				<li class="nav-item">
					<a href="subject.php" class="nav-link <?= $dir=='subject.php' ? 'active' : '' ?>">
						<i class="icon-books"></i>
						<span>Subject</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="quiz.php" class="nav-link <?= $dir=='quiz.php' ? 'active' : '' ?>">
						<i class="icon-file-text2"></i>
						<span>Quiz List</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="result.php" class="nav-link <?= $dir=='result.php' ? 'active' : '' ?>">
						<i class="icon-medal"></i>
						<span>Quiz Result</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="assignment.php" class="nav-link <?= $dir=='assignment.php' ? 'active' : '' ?>">
						<i class="icon-pencil7"></i>
						<span>Assignment</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="assignment-result.php" class="nav-link <?= $dir=='assignment-result.php' ? 'active' : '' ?>">
						<i class="icon-medal2"></i>
						<span>Assignment Result</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="module.php" class="nav-link <?= $dir=='module.php' ? 'active' : '' ?>">
						<i class="icon-drawer3"></i>
						<span>Module</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="classmate.php" class="nav-link <?= $dir=='classmate.php' ? 'active' : '' ?>">
						<i class="icon-users"></i>
						<span>Classmates</span>
					</a>
				</li>
				
				<!-- /student -->
				<?php endif ?>
				
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->
	
</div>

<script>
	$.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>
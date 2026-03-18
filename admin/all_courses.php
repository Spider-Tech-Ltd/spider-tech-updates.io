<?php 
require('superadmin_functions.php');
require('secured-login.php');

//query schools
$course_query=mysqli_query($srcoe_db, "SELECT course_id, course_name, dep_name, level, credit_unit, semester, students, prog_name  FROM courses c, department d, programme p  
                           WHERE c.department = d.dep_id AND c.programme = p.prog_id ORDER BY dep_name, semester asc") or die(mysqli_error($srcoe_db));
$course_row=mysqli_fetch_assoc($course_query);
//create session and store course id for course edit function
if(isset($_GET['course']))
{
	$course_id = mysqli_real_escape_string($srcoe_db, $_GET['course']);
	$_SESSION['course'] =  $course_id;
	header('location:edit_courses.php');
	
	}

?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head>
	<?php require'head-section.html'; ?>
</head>
<!-- END HEAD -->

<body
	class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white green-sidebar-color logo-white">
	<div class="page-wrapper">
		<!-- start header -->
		<?php require'header-section.php'; ?>
		<!-- end header -->
		<!-- start color quick setting -->
		<?php require'setting-section.html'; ?>
		<!-- end color quick setting -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php require'side-menu-section.html'; ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">All Courses List</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Courses</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">All Courses List</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Courses Table</header>
                                    <!--
                                    <button id="panel-button"
										class="mdl-button mdl-js-button mdl-button--icon pull-right"
										data-upgraded=",MaterialButton">
										<i class="material-icons">more_vert</i>
									</button>
									<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
										data-mdl-for="panel-button">
										<li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">print</i>Another action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else
											here</li>
                                    </ul>
                                    -->
								</div>
								<div class="card-body " id="bar-parent">
                                <div class="row">
									<div class="col-md-6 col-sm-6 col-6">
										<div class="btn-group">
											<a href="add_courses.php" id="addRow"
												class="btn btn-info">
												Add New <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
								</div>
                                <div class="card-body">				
									<div class="table-scrollable">
										<table id="exportTable" class="display nowrap table-hover" style="width:100%" >
											<thead>
												<tr>
													<th>Course Name</th>
													<th>Department</th>
													<th>Level</th>
													<th>Programme</th>
													<th>Category</th>
													<th>Weight</th>
													<th>Edit</th>
												</tr>
											</thead>
											<tbody>
											<?php
											do{
											$course=$course_row['course_id'];
											$level_query=mysqli_query($srcoe_db, "SELECT * FROM level WHERE level_name = '".$course_row['level']."'") or die(mysqli_error($srcoe_db));
											$level_row=mysqli_fetch_assoc($level_query);
											echo
												'<tr>
													<td>'.$course_row['course_name'].'</td>
													<td>'.$course_row['dep_name'].'</td>
													<td>'.$level_row['short_code'].'</td>
													<td>'.$course_row['prog_name'].'</td>
													<td>'.$course_row['students'].'</td>
													<td>'.$course_row['credit_unit'].'</td>
													<td>
														<a href="all_courses.php?course='.$course.'"
															class="btn btn-primary btn-xs">
															<i class="fa fa-pencil"></i>
														</a>
													</td>
												</tr>';
											}while($course_row = mysqli_fetch_assoc($course_query));
											?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<?php require'setting_and_chat_section.php';?>
			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php require'footer-section.html'; ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
    <?php require'js-section.html'; ?>
	<!-- end js include path -->
</body>

</html>
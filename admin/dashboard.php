<?php 

require('db_function/function.php');

require('secured-login.php');


//get total number of services
$sql_services = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_services FROM services_tb");
$record_services = mysqli_fetch_assoc($sql_services);

//get total number projects
$sql_projects = mysqli_query($spider_tech_db, "SELECT COUNT(project_id) total_projects FROM projects_tb") or die(mysqli_error($spider_tech_db));
$record_projects = mysqli_fetch_assoc($sql_projects);

//get total number events
$sql_events = mysqli_query($spider_tech_db, "SELECT COUNT(event_id) total_events FROM events") or die(mysqli_error($spider_tech_db));
$record_events = mysqli_fetch_assoc($sql_events);

//get total number testimonials
$sql_testimonials = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_testimonials FROM testimonials_tb") or die(mysqli_error($spider_tech_db));
$record_testimonials = mysqli_fetch_assoc($sql_testimonials);

//get total number trainings
$sql_trainings = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_trainings FROM trainings_tb") or die(mysqli_error($spider_tech_db));
$record_trainings = mysqli_fetch_assoc($sql_trainings);

//get total number faqs
$sql_faq = mysqli_query($spider_tech_db, "SELECT COUNT(faq_id) total_faq FROM faq_tb") or die(mysqli_error($spider_tech_db));
$record_faq = mysqli_fetch_assoc($sql_faq);

//get total number applicants
$sql_applicants = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_applicants FROM dse_application") or die(mysqli_error($spider_tech_db));
$record_applicants = mysqli_fetch_assoc($sql_applicants);

/*
//get students
$sql_students = mysqli_query($spider_tech_db, "SELECT COUNT(*) total_students FROM students ");
$record_students = mysqli_fetch_assoc($sql_students);

//get new students
$session = (date("Y"))."/".(date("Y")+1);
$sql_new_students = mysqli_query($spider_tech_db, "SELECT COUNT(*) total_students FROM students WHERE entry_session = '$session' ORDER BY entry_session ") or die(mysqli_error($spider_tech_db));
$record_new_students = mysqli_fetch_assoc($sql_new_students);
*/
?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head>
	<?php require('head-section.html'); ?>
</head>
<!-- END HEAD -->

<body
	class="<?php require('body-tag-css.html'); ?>">
	<div class="page-wrapper">
		<!-- start header -->
		<?php require('header-section.php'); ?>
		<!-- end header -->
		<!-- start color quick setting -->
		<?php require('setting-section.html'); ?>
		<!-- end color quick setting -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php require('side-menu-section.php'); ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Dashboard</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Dashboard</li>
							</ol>
						</div>
					</div>
					<!-- start widget -->
					<div class="state-overview">
						<div class="row">
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-b-green">
									<span class="info-box-icon push-bottom"><i class="material-icons">question_answer</i></span>
									<div class="info-box-content">
										<span class="info-box-text">Total Services</span>
										<span class="info-box-number"><?php echo $record_services['total_services']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_services.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col-->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-b-yellow">
									<span class="info-box-icon push-bottom"><i class="material-icons">folder</i></span>
									<div class="info-box-content">
										<span class="info-box-text">Total Projects</span>
										<span class="info-box-number"><?php echo $record_projects['total_projects']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_projects.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-b-blue">
									<span class="info-box-icon push-bottom"><i class="material-icons">event</i></span>
									<div class="info-box-content">
										<span class="info-box-text">Total Events</span>
										<span class="info-box-number"><?php echo $record_events['total_events']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_events.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-b-pink">
									<span class="info-box-icon push-bottom"><i
											class="material-icons">comment</i></span>
									<div class="info-box-content">
										<a href="sales.php" class="text-white"><span class="info-box-text">Total Testimonials</span></a>
										<span class="info-box-number"><?php echo $record_testimonials['total_testimonials']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_testimonials.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-info">
									<span class="info-box-icon push-bottom"><i
											class="material-icons">people</i></span>
									<div class="info-box-content">
										<a href="sales.php" class="text-white"><span class="info-box-text">Total Trainings</span></a>
										<span class="info-box-number"><?php echo $record_trainings['total_trainings']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_trainings.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-danger">
									<span class="info-box-icon push-bottom"><i
											class="material-icons">help</i></span>
									<div class="info-box-content">
										<a href="sales.php" class="text-white"><span class="info-box-text">Total FAQ</span></a>
										<span class="info-box-number"><?php echo $record_faq['total_faq']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_faq.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-xl-3 col-md-6 col-12">
								<div class="info-box bg-success">
									<span class="info-box-icon push-bottom"><i
											class="material-icons">people</i></span>
									<div class="info-box-content">
										<a href="sales.php" class="text-white"><span class="info-box-text">Total DSE Applicants</span></a>
										<span class="info-box-number"><?php echo $record_applicants['total_applicants']?></span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<a href="all_applicants.php" class="text-white">View Details</a>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
						</div>
					</div>
					<!-- end widget -->
					<!-- chart start 
					<div class="row">
						
                        <div class="col-sm-6">
							<div class="card card-box">
								<div class="card-head">
									<header>University Survey</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body">
									<div class="recent-report__chart">
										<div id="chart1"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card card-box">
								<div class="card-head">
									<header>University Survey</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body">
									<div class="recent-report__chart">
										<div id="chart2"></div>
									</div>
								</div>
							</div>
						</div>
                        
					</div>
					-->
					<!-- Chart end -->
					<!-- start course list 
                    
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12 col-sm-6">
							<div class="blogThumb">
								<div class="thumb-center"><img class="img-responsive" alt="user"
										src="../assets/img/course/course1.jpg"></div>
								<div class="course-box">
									<h4>PHP Development Course</h4>
									<div class="text-muted"><span class="m-r-10">April 23</span>
										<a class="course-likes m-l-10" href="#"><i class="fa fa-heart-o"></i> 654</a>
									</div>
									<p><span><i class="ti-alarm-clock"></i> Duration: 6 Months</span></p>
									<p><span><i class="ti-user"></i> Professor: Jane Doe</span></p>
									<p><span><i class="fa fa-graduation-cap"></i> Students: 200+</span></p>
									<button type="button"
										class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-info">Read
										More</button>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12 col-sm-6 ">
							<div class="blogThumb">
								<div class="thumb-center"><img class="img-responsive" alt="user"
										src="../assets/img/course/course2.jpg"></div>
								<div class="course-box">
									<h4>PHP Development Course</h4>
									<div class="text-muted"><span class="m-r-10">April 23</span>
										<a class="course-likes m-l-10" href="#"><i class="fa fa-heart-o"></i> 654</a>
									</div>
									<p><span><i class="ti-alarm-clock"></i> Duration: 6 Months</span></p>
									<p><span><i class="ti-user"></i> Professor: Jane Doe</span></p>
									<p><span><i class="fa fa-graduation-cap"></i> Students: 200+</span></p>
									<button type="button"
										class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-info">Read
										More</button>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12 col-sm-6">
							<div class="blogThumb">
								<div class="thumb-center"><img class="img-responsive" alt="user"
										src="../assets/img/course/course3.jpg"></div>
								<div class="course-box">
									<h4>PHP Development Course</h4>
									<div class="text-muted"><span class="m-r-10">April 23</span>
										<a class="course-likes m-l-10" href="#"><i class="fa fa-heart-o"></i> 654</a>
									</div>
									<p><span><i class="ti-alarm-clock"></i> Duration: 6 Months</span></p>
									<p><span><i class="ti-user"></i> Professor: Jane Doe</span></p>
									<p><span><i class="fa fa-graduation-cap"></i> Students: 200+</span></p>
									<button type="button"
										class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-info">Read
										More</button>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12 col-sm-6">
							<div class="blogThumb">
								<div class="thumb-center"><img class="img-responsive" alt="user"
										src="../assets/img/course/course4.jpg"></div>
								<div class="course-box">
									<h4>PHP Development Course</h4>
									<div class="text-muted"><span class="m-r-10">April 23</span>
										<a class="course-likes m-l-10" href="#"><i class="fa fa-heart-o"></i> 654</a>
									</div>
									<p><span><i class="ti-alarm-clock"></i> Duration: 6 Months</span></p>
									<p><span><i class="ti-user"></i> Professor: Jane Doe</span></p>
									<p><span><i class="fa fa-graduation-cap"></i> Students: 200+</span></p>
									<button type="button"
										class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-info">Read
										More</button>
								</div>
							</div>
						</div>
					</div>
                	-->
					<!-- End course list -->
					<div class="row">
						<!-- Quick Mail start 
						<div class="col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="inbox">
								<div class="card card-topline-gray">
									<div class="card-body no-padding height-9">
										<div class="inbox-body">
											<div class="mail-list">
												<div class="compose-mail">
													<form method="post">
														<div class="email-form">
															<label for="to" class="">To:</label> <input type="text"
																tabindex="1" id="to" class="form-control itemField">
															<div class="compose-options">
																<a onclick="$(this).hide(); $('#cc').parent().removeClass('hidden'); $('#cc').focus();"
																	href="javascript:;">Cc</a> <a
																	onclick="$(this).hide(); $('#bcc').parent().removeClass('hidden'); $('#bcc').focus();"
																	href="javascript:;">Bcc</a>
															</div>
														</div>
														<div class="email-form hidden">
															<label for="cc" class="">Cc:</label> <input type="text"
																tabindex="2" id="cc" class="form-control itemField">
														</div>
														<div class="email-form hidden">
															<label for="bcc" class="">Bcc:</label> <input type="text"
																tabindex="2" id="bcc" class="form-control itemField">
														</div>
														<div class="email-form">
															<label for="subject" class="">Subject:</label> <input
																type="text" tabindex="1" id="subject"
																class="form-control itemField">
														</div>
														<div class="mt-4">
															<div id="summernote"></div>
															<input type="file" class="default" multiple>
														</div>
														<div class="box-footer clearfix">
															<button type="button"
																class="mdl-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-primary pull-right">
																Send <i class="fa fa-paper-plane-o"></i>
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						-->
						<!-- Quick Mail end -->
						<!-- Activity feed start 
						<div class="col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="card-box">
								<div class="card-head">
									<header>Activity Feed</header>
									<button id="feedMenu" class="mdl-button mdl-js-button mdl-button--icon pull-right"
										data-upgraded=",MaterialButton">
										<i class="material-icons">more_vert</i>
									</button>
									<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
										data-mdl-for="feedMenu">
										<li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">print</i>Another action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else
											here</li>
									</ul>
								</div>
								<div class="card-body ">
									<ul class="feedBody">
										<li class="active-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std1.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblFileStyle">File</span> Sarah Smith <small
													class="text-muted">6 hours ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												hii John, I have upload doc related to task.
											</p>
										</li>
										<li class="diactive-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std2.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblTaskStyle">Task </span> Jalpa Joshi<small
													class="text-muted">5 hours
													ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												Please do as specify. Let me know if you have any query.
											</p>
										</li>
										<li class="diactive-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std3.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblCommentStyle">comment</span> Lina
												Smith<small class="text-muted">6 hours ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												Hey, How are you??
											</p>
										</li>
										<li class="active-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std4.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblReplyStyle">Reply</span> Jacob Ryan
												<small class="text-muted">7 hours ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												I am fine. You??
											</p>
										</li>
										<li class="active-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std5.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblFileStyle">File</span> Sarah Smith <small
													class="text-muted">6 hours ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												hii John, I have upload doc related to task.
											</p>
										</li>
										<li class="diactive-feed">
											<div class="feed-user-img">
												<img src="../assets/img/std/std6.jpg" class="img-radius "
													alt="User-Profile-Image">
											</div>
											<h6>
												<span class="feedLblStyle lblTaskStyle">Task </span> Jalpa Joshi<small
													class="text-muted">5 hours
													ago</small>
											</h6>
											<p class="m-b-15 m-t-15">
												Please do as specify. Let me know if you have any query.
											</p>
										</li>
									</ul>
								</div>
							</div>
						</div>
						-->
						<!-- Activity feed end -->
					</div>
					<!--
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="card-box">
								<div class="card-head">
									<header>Exam Toppers</header>
									<button id="panel-button8"
										class="mdl-button mdl-js-button mdl-button--icon pull-right"
										data-upgraded=",MaterialButton">
										<i class="material-icons">more_vert</i>
									</button>
									<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
										data-mdl-for="panel-button8">
										<li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">print</i>Another action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else
											here</li>
									</ul>
								</div>
								<div class="card-body ">
									<div class="table-responsive">
										<table class="table table-striped custom-table table-hover">
											<thead>
												<tr>
													<th>Roll No</th>
													<th>Name</th>
													<th>Graph</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>23</td>
													<td>John Smith</td>
													<td>
														<div id="sparkline"></div>
													</td>
													<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
															title="Edit">
															<i class="fa fa-check"></i></a>
														<a href="javascript:void(0)" class="text-inverse" title="Delete"
															data-toggle="tooltip">
															<i class="fa fa-trash"></i></a>
													</td>
												</tr>
												<tr>
													<td>12</td>
													<td>Sneha Pandit</td>
													<td>
														<div id="sparkline1"></div>
													</td>
													<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
															title="Edit">
															<i class="fa fa-check"></i></a>
														<a href="javascript:void(0)" class="text-inverse" title="Delete"
															data-toggle="tooltip">
															<i class="fa fa-trash"></i></a>
													</td>
												</tr>
												<tr>
													<td>45</td>
													<td>Sarah Smith</td>
													<td>
														<div id="sparkline2"></div>
													</td>
													<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
															title="Edit">
															<i class="fa fa-check"></i></a>
														<a href="javascript:void(0)" class="text-inverse" title="Delete"
															data-toggle="tooltip">
															<i class="fa fa-trash"></i></a>
													</td>
												</tr>
												<tr>
													<td>34</td>
													<td>John Deo</td>
													<td>
														<div id="sparkline3"></div>
													</td>
													<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
															title="Edit">
															<i class="fa fa-check"></i></a>
														<a href="javascript:void(0)" class="text-inverse" title="Delete"
															data-toggle="tooltip">
															<i class="fa fa-trash"></i></a>
													</td>
												</tr>
												<tr>
													<td>15</td>
													<td>Jay Soni</td>
													<td>
														<div id="sparkline4"></div>
													</td>
													<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
															title="Edit">
															<i class="fa fa-check"></i></a>
														<a href="javascript:void(0)" class="text-inverse" title="Delete"
															data-toggle="tooltip">
															<i class="fa fa-trash"></i></a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="card-box">
								<div class="card-head">
									<header>Todo List</header>
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
								</div>
								<div class="card-body ">
									<ul class="to-do-list ui-sortable" id="sortable-todo">
										<li class="clearfix">
											<div class="todo-check pull-left">
												<input type="checkbox" value="None" id="todo-check1">
												<label for="todo-check1"></label>
											</div>
											<p class="todo-title">Add fees details in system
											</p>
											<div class="todo-actionlist pull-right clearfix">
												<a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
											</div>
										</li>
										<li class="clearfix">
											<div class="todo-check pull-left">
												<input type="checkbox" value="None" id="todo-check2">
												<label for="todo-check2"></label>
											</div>
											<p class="todo-title">Announcement for holiday
											</p>
											<div class="todo-actionlist pull-right clearfix">
												<a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
											</div>
										</li>
										<li class="clearfix">
											<div class="todo-check pull-left">
												<input type="checkbox" value="None" id="todo-check3">
												<label for="todo-check3"></label>
											</div>
											<p class="todo-title">call bus driver</p>
											<div class="todo-actionlist pull-right clearfix">
												<a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
											</div>
										</li>
										<li class="clearfix">
											<div class="todo-check pull-left">
												<input type="checkbox" value="None" id="todo-check4">
												<label for="todo-check4"></label>
											</div>
											<p class="todo-title">School picnic</p>
											<div class="todo-actionlist pull-right clearfix">
												<a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
											</div>
										</li>
										<li class="clearfix">
											<div class="todo-check pull-left">
												<input type="checkbox" value="None" id="todo-check5">
												<label for="todo-check5"></label>
											</div>
											<p class="todo-title">Exam time table generate
											</p>
											<div class="todo-actionlist pull-right clearfix">
												<a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>-->
					<!-- start new student list 
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card  card-box">
								<div class="card-head">
									<header>New Student List</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body ">
									<div class="table-wrap">
										<div class="table-responsive">
											<table class="table display product-overview mb-30" id="support_table">
												<thead>
													<tr>
														<th>No</th>
														<th>Name</th>
														<th>Assigned Professor</th>
														<th>Date Of Admit</th>
														<th>Fees</th>
														<th>Branch</th>
														<th>Edit</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>Jens Brincker</td>
														<td>Kenny Josh</td>
														<td>27/05/2016</td>
														<td>
															<span class="label label-sm label-success">paid</span>
														</td>
														<td>Mechanical</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>2</td>
														<td>Mark Hay</td>
														<td> Mark</td>
														<td>26/05/2017</td>
														<td>
															<span class="label label-sm label-warning">unpaid </span>
														</td>
														<td>Science</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>3</td>
														<td>Anthony Davie</td>
														<td>Cinnabar</td>
														<td>21/05/2016</td>
														<td>
															<span class="label label-sm label-success ">paid</span>
														</td>
														<td>Commerce</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>4</td>
														<td>David Perry</td>
														<td>Felix </td>
														<td>20/04/2016</td>
														<td>
															<span class="label label-sm label-danger">unpaid</span>
														</td>
														<td>Mechanical</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>5</td>
														<td>Anthony Davie</td>
														<td>Beryl</td>
														<td>24/05/2016</td>
														<td>
															<span class="label label-sm label-success ">paid</span>
														</td>
														<td>M.B.A.</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>6</td>
														<td>Alan Gilchrist</td>
														<td>Joshep</td>
														<td>22/05/2016</td>
														<td>
															<span class="label label-sm label-warning ">unpaid</span>
														</td>
														<td>Science</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>7</td>
														<td>Mark Hay</td>
														<td>Jayesh</td>
														<td>18/06/2016</td>
														<td>
															<span class="label label-sm label-success ">paid</span>
														</td>
														<td>Commerce</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
													<tr>
														<td>8</td>
														<td>Sue Woodger</td>
														<td>Sharma</td>
														<td>17/05/2016</td>
														<td>
															<span class="label label-sm label-danger">unpaid</span>
														</td>
														<td>Mechanical</td>
														<td><a href="javascript:void(0)" class="" data-toggle="tooltip"
																title="Edit"><i class="fa fa-check"></i></a>
															<a href="javascript:void(0)" class="text-inverse"
																title="Delete" data-toggle="tooltip"><i
																	class="fa fa-trash"></i></a></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					 end new student list -->
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
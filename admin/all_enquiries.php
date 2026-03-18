<?php 
require('superadmin_functions.php');
require('secured-login.php');

//query schools
$news_query=mysqli_query($en_klave_db, "SELECT * FROM enquiry_tb") or die(mysqli_error($en_klave_db));
$news_row=mysqli_fetch_assoc($news_query);
//create session and store dept id for department edit function
if(isset($_GET['news']))
{
	$news_id = mysqli_real_escape_string($en_klave_db, $_GET['news']);
	$_SESSION['news_id'] =  $news_id;
	header('location:edit_news.php');
	
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
	class="<?php require('body-tag-css.html'); ?>">
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
			<?php require'side-menu-section.php'; ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Inbox</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Email</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Inbox</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-topline-gray">
								<div class="card-body no-padding height-9">
									<div class="inbox">
										<div class="row">
											<div class="col-md-3">
												<div class="inbox-sidebar">
													<a href="email_compose.html" data-title="Compose"
														class="btn red compose-btn btn-block">
														<i class="fa fa-edit"></i> Compose </a>
													<ul class="inbox-nav inbox-divider">
														<li class="active"><a href="email_inbox.html"><i
																	class="fa fa-inbox"></i> Inbox <span
																	class="label mail-counter-style label-danger pull-right">2</span></a>
														</li>
														<li><a href="#"><i class="fa fa-envelope"></i> Sent Mail</a>
														</li>
														<li><a href="#"><i class="fa fa-briefcase"></i> Important</a>
														</li>
														<li><a href="#"><i class="fa fa-star"></i> Starred </a>
														</li>
														<li><a href="#"><i class=" fa fa-external-link"></i> Drafts
																<span
																	class="label mail-counter-style label-info pull-right">30</span></a>
														</li>
														<li><a href="#"><i class=" fa fa-trash-o"></i> Trash</a>
														</li>
													</ul>
													<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
														<li>
															<h4>Labels</h4>
														</li>
														<li><a href="#"><i class="fa fa-tags"></i> Work</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags"></i> Design
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Family
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Friends
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Office
															</a>
														</li>
													</ul>
													<ul class="nav nav-pills nav-stacked labels-info inbox-divider ">
														<li>
															<h4>Buddy online</h4>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-comments text-success"></i> Jhone Doe
																<span class="online-status">I do not think</span>
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-comments text-danger"></i> Sumon
																<span class="online-status">Busy with coding</span>
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-comments text-muted "></i> Anjelina
																Joli
																<span class="online-status">I out of control</span>
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-comments text-muted "></i> Jonathan
																Smith
																<span class="online-status">I am not here</span>
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-comments text-muted "></i> Tawseef
																<span class="online-status">I do not think</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
											<div class="col-md-9">
												<div class="inbox-body">
													<div class="inbox-header">
														<div class="mail-option no-pad-left">
															<div class="btn-group group-padding">
																<a class="btn mini tooltips" href="#"
																	data-toggle="dropdown" data-placement="top"
																	data-original-title="Refresh">
																	<i class=" fa fa-refresh fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Archive"> <i
																		class=" fa fa-archive fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Trash"> <i
																		class=" fa fa-trash-o fa-lg"></i>
																</a>
															</div>
															<div class="btn-group res-email-btn">
																<a class="btn mini tooltips" href="#"
																	data-original-title="Folders"> <i
																		class=" fa fa-folder fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Tag"> <i
																		class=" fa fa-tag fa-lg"></i>
																</a>
															</div>
															<div class="btn-group hidden-phone">
																<a class="btn mini blue-bgcolor" href="#"
																	data-toggle="dropdown" aria-expanded="false"> More
																	<i class="fa fa-angle-down downcolor"></i>
																</a>
																<ul class="dropdown-menu">
																	<li><a href="#"><i class="fa fa-pencil"></i> Mark as
																			Read</a>
																	</li>
																	<li><a href="#"><i class="fa fa-ban"></i>
																			Spam</a>
																	</li>
																	<li class="divider"></li>
																	<li><a href="#"><i class="fa fa-trash-o"></i>
																			Delete</a>
																	</li>
																</ul>
															</div>
															<div class="btn-group pull-right btn-prev-next">
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-left"></i>
																</button>
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-right"></i>
																</button>
															</div>
															<!-- 				                                            <div class="todo-check pull-left m-l-20"> -->
															<!-- 			                                                    <input type="checkbox" value="None" id="todo-check30"> -->
															<!-- 			                                                    <label for="todo-check30"></label> -->
															<!-- 			                                                </div> -->
														</div>
													</div>
													<div class="inbox-body no-pad table-responsive">
														<table class="table table-inbox table-hover">
															<tbody>
																<tr class="unread">
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check1">
																			<label for="todo-check1"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std8.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message  dont-show">Leena Smith</td>
																	<td class="view-message "><a
																			href="email_compose.html">Jatin I found you
																			on LinkedIn.</a></td>
																	<td class="view-message  inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message  text-right">10:27 AM</td>
																</tr>
																<tr class="unread ">
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check2">
																			<label for="todo-check2"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std2.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Sarah Smith</td>
																	<td class="view-message"><a
																			href="email_compose.html">Fwd: Important
																			Notice Regarding Your Domain Name</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Nov 15</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check3">
																			<label for="todo-check3"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<span class="bg-success">R</span>
																		</a>
																	</td>
																	<td class="view-message dont-show">Rakesh maheta
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">pls take a print
																			of attachments</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">may 11</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check4">
																			<label for="todo-check4"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std4.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Kehn Anderson
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">Apply for Ortho
																			Surgeon</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">may 01</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check5">
																			<label for="todo-check5"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<span class="bg-primary">X</span>
																		</a>
																	</td>
																	<td class="view-message dont-show">XYZ bank <span
																			class="label mail-label pull-right">Office</span>
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">Transaction Alert
																			from XYZ Bank</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">May 23</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check6">
																			<label for="todo-check6"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std2.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Sarah Smith</td>
																	<td class="view-message"><a
																			href="email_compose.html">Find web design
																			and develomnent work</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">june 24</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check7">
																			<label for="todo-check7"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<span class="bg-warning">V</span>
																		</a>
																	</td>
																	<td class="view-message dont-show">Viral Shah</td>
																	<td class="view-message"><a
																			href="email_compose.html">A big thank for
																			the support</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">Jan 09</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check8">
																			<label for="todo-check8"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std6.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Jennifer Maklen
																		<span
																			class="label mail-label pull-right">friends</span>
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">(no subject)</a>
																	</td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Mar 04</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check9">
																			<label for="todo-check9"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std7.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Vlad Cardella
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Problem List</a>
																	</td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Mar 13</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check10">
																			<label for="todo-check10"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std1.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Rajesh <span
																			class="label mail-label pull-right">family</span>
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">you have 1
																			notification</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Mar 24</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check11">
																			<label for="todo-check11"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std4.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Kehn Anderson
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">Presenting WAF in
																			Munich web week</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">March 09</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check12">
																			<label for="todo-check12"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std10.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="dont-show">Anjelina Cardella</td>
																	<td class="view-message"><a
																			href="email_compose.html">Request for leave
																			application</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">july 10</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check13">
																			<label for="todo-check13"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std3.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">John Deo</td>
																	<td class="view-message"><a
																			href="email_compose.html">Web framework
																			presentation file</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">jan 18</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check14">
																			<label for="todo-check14"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std8.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="dont-show">Leena Smith</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Wedding Reception
																			Invitation</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">feb 14</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check15">
																			<label for="todo-check15"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std4.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Kehn Anderson
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">Your Interview
																			schedule....</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">feb 17</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check16">
																			<label for="todo-check16"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<span class="blue-bgcolor">F</span>
																		</a>
																	</td>
																	<td class="view-message dont-show">Facebook</td>
																	<td class="view-message"><a
																			href="email_compose.html">Ritu jani tagged
																			you in a post on Facebook</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">mar 14</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check17">
																			<label for="todo-check17"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std3.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">John Deo</td>
																	<td class="view-message"><a
																			href="email_compose.html">And you thought
																			you recycled everything you
																			could !</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Aug 10</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check18">
																			<label for="todo-check18"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std5.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Jacob Ryan</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Presenting WAF in
																			Munich web week</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">Aug 14</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check19">
																			<label for="todo-check19"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std6.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Jennifer Maklen
																	</td>
																	<td class="view-message"><a
																			href="email_compose.html">Apply for web
																			developer</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">June 11</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check20">
																			<label for="todo-check20"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std9.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Jeff Adem</td>
																	<td class="view-message"><a
																			href="email_compose.html">pls take a print
																			of attachments</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Aug 15</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check21">
																			<label for="todo-check21"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std10.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Anjelina Cardella
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Find web design
																			and develomnent
																			work</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">April 19</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check22">
																			<label for="todo-check22"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std7.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Vlad Cardella
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Transaction Alert
																			from XYZ Bank</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">April 14</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check23">
																			<label for="todo-check23"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std8.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Leena Smith</td>
																	<td class="view-message"><a
																			href="email_compose.html">Jatin I found you
																			on LinkedIn.</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">mar 26</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check24">
																			<label for="todo-check24"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std3.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">John Deo</td>
																	<td class="view-message"><a
																			href="email_compose.html">You have 1 new
																			message</a></td>
																	<td class="view-message inbox-small-cells"></td>
																	<td class="view-message text-right">Aug 10</td>
																</tr>
																<tr>
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check25">
																			<label for="todo-check25"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star-o"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="../assets/img/std/std4.jpg"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message dont-show">Kehn Anderson
																	</td>
																	<td class="view-message view-message"><a
																			href="email_compose.html">Merry
																			Christmas</a></td>
																	<td class="view-message inbox-small-cells"><i
																			class="fa fa-paperclip"></i>
																	</td>
																	<td class="view-message text-right">dec 14</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
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
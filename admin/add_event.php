<?php 
require('superadmin_functions.php');
require('secured-login.php');
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
								<div class="page-title">Add Events</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_events">Events</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add Events</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Basic Information</header>
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
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
                                            <div class="form-group row">
                                                <div class=" col-md-3">
                                                </div>
												<div class="col-md-5">
                                                    <?php 
                                                        if(!empty($event_error_counter)) 
                                                        {
                                                            echo $event_error_counter; 
                                                            }
                                                        if(!empty($event_success_msg))
                                                        {
                                                            echo $event_success_msg;
                                                            }
                                                    ?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Event Title
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="event_title" placeholder="Enter event title"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_event'])) 
                                                        {echo stripslashes($event_title); }?>" required max-size="10" /> 
                                                        <?php if(isset($_POST['add_event'])) {echo $event_titleErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Event Date
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon" class="input-group datePicker">
															<input class="formDatePicker form-control" name="event_date" type="text"
																placeholder="Select Date.." value="<?php if(isset($_POST['add_event'])) 
                                                                {echo stripslashes($event_date); }?>" data-input>
															<span class="dateBtn">
																<a class="input-button" title="toggle" data-toggle>
																	<i class="icon-calendar"></i>
																</a>
																<a class="input-button" title="clear" data-clear>
																	<i class="icon-close"></i>
																</a>
															</span>
														</div>
                                                    </div>
                                                    <?php if(isset($_POST['add_event'])) {echo $event_dateErr; }?>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Event Date2
													<span class="required"> * </span>
												</label>
											<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon" class="input-group datePicker">
															<input class="formDatePicker form-control" name="event_date2" type="text"
																placeholder="Select Date.." value="<?php if(isset($_POST['add_event'])) 
                                                                {echo stripslashes($event_date); }?>" data-input>
															<span class="dateBtn">
																<a class="input-button" title="toggle" data-toggle>
																	<i class="icon-calendar"></i>
																</a>
																<a class="input-button" title="clear" data-clear>
																	<i class="icon-close"></i>
																</a>
															</span>
														</div>
                                                    </div>
                                                    <?php if(isset($_POST['add_event'])) {echo $event_date2Err; }?>
												</div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Event Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="event_time" placeholder="Select time..."
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_event'])) 
                                                        {echo stripslashes($event_time); }?>"  required /> 
                                                        <?php if(isset($_POST['add_event'])) {echo $event_timeErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Event Address
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="event_address" placeholder="Enter address"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_event'])) 
                                                        {echo stripslashes($event_address); }?>" required max-size="10" /> 
                                                        <?php if(isset($_POST['add_event'])) {echo $event_addressErr; }?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Breif Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="event_content" placeholder="Enter description"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_event'])) 
                                                        {echo stripslashes($event_content); }?>" /> 
                                                        <?php if(isset($_POST['add_event'])) {echo $event_contentErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Event Status
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<select class="form-control input-height" name="event_status" required>
                                                        <?php
                                                        if(isset($_POST['add_event']) && !empty($event_status))
                                                        {
                                                        echo
                                                        '<option value="'.$event_status.'" selected>'.$event_status.'</option>
                                                        <option value="Upcoming">Upcoming</option>
                                                        <option value="Past">Past</option>';
                                                        }
                                                        else
                                                        {
                                                        echo
                                                        '<option value="" selected>Select...</option>
                                                        <option value="Upcoming">Upcoming event</option>
                                                        <option value="Past">Past event</option>';   
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if(isset($_POST['add_event'])) {echo $event_statusErr; }?>
												</div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Upload Picture 
                                                    <span class="required"> * </span>
												</label>
												<div class="col-md-5 ">
													<input type="file" class="default" name="img" required>
                                                    <?php if(isset($_POST['add_event'])) {echo '<div>'.$event_imgErr.'</div>'; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Brief Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Content"
                                                        class="form-control-textarea" rows="3" name="event_detail" required><?php if(isset($_POST['add_event'])) 
                                                        {echo stripslashes($_POST['event_detail']); }?></textarea>
                                                        <?php if(isset($_POST['add_event'])) {echo $event_detailErr; }?>
												</div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_event">Submit</button>
														<button type="button" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>
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
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
	class="<?php require'body-tag-css.html'; ?>">
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
								<div class="page-title">Add News</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_news">News</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add News</li>
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
                                                        if(!empty($news_error_counter)) 
                                                        {
                                                            echo $news_error_counter; 
                                                            }
                                                        if(!empty($news_success_msg))
                                                        {
                                                            echo $news_success_msg;
                                                            }
                                                    ?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">News Title
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="news_title" placeholder="Enter news title"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_news'])) 
                                                        {echo stripslashes($news_title); }?>" required max-size="10" /> 
                                                        <?php if(isset($_POST['add_news'])) {echo $news_titleErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">News Body
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter body"
                                                        class="form-control-textarea" rows="3" name="news_body" required><?php if(isset($_POST['add_news'])) 
                                                        {echo stripslashes($_POST['news_body']); }?></textarea>
                                                        <?php if(isset($_POST['add_news'])) {echo $news_bodyErr; }?>
												</div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_news">Submit</button>
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
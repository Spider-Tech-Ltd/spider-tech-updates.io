<?php 
//db connection
require('db_function/function.php');


/*manage about page information*/
if(isset($_POST['add_about']))
{
	$about_detailsError = "";
	$about_Error = 0;
	$about_success_msg = "";
	$about_error_counter = "";
	
	$about_details = mysqli_real_escape_string($spider_tech_db, $_POST['about_details']);
	
	/*check for empty field*/
	if(empty($_POST['about_details']))
	{
		$about_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$about_Error = 1;
		}
	if($about_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM about_info ");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$about_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									About Information record exisit. You can only edit already existing record for this item.
								  </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO about_info (details) VALUES('$about_details')");
        unset($_POST);
		$about_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new record added.
							</div>';		
		}
	}//end of about_Error
	
	
}//end of first if

/*edit about page history and tradition*/
if(isset($_POST['edit_about']))
{
	$about_detailsError = "";
	$about_nameError = "";
	$about_Error = 0;
	$about_success_msg = "";
	$about_error_counter = "";
	
	$about_name = mysqli_real_escape_string($spider_tech_db, $_POST['about_name']);
	$about_details = mysqli_real_escape_string($spider_tech_db, $_POST['about_details']);
	$about_id = mysqli_real_escape_string($spider_tech_db, $_POST['about_id']);
	
	/*check for empty field*/
    if(empty($_POST['about_name']))
	{
		$about_nameError = '<font color="#FF0000">Field cannot be empty</font>';
		$about_Error = 1;
		}

	if(empty($_POST['about_details']))
	{
		$about_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$about_Error = 1;
		}
		
	if($about_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE about_info SET title = '$about_name', details = '$about_details' WHERE id='$about_id' ");
		$about_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, record updated.
							 </div>';		
	}//end of about_Error	
}//end of first if
 
/*manage about page mission statement*/
if(isset($_POST['add_mission']))
{
	$mission_detailsError = "";
	$mission_Error = 0;
	$mission_success_msg = "";
	$mission_error_counter = "";
	
	$mission_details = mysqli_real_escape_string($spider_tech_db, $_POST['mission_details']);
	
	/*check for empty field*/
	if(empty($_POST['mission_details']))
	{
		$mission_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$mission_Error = 1;
		}
	if($mission_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM about_mission ");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$mission_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									     Mission statement record exist. You can only edit already existing record for this item.
								     </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO about_mission (details) VALUES('$mission_details')");
        unset($_POST);
		$mission_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, new record added.
							    </div>';		
		}
	}//end of mission_Error
	
	
}//end of first if

/*edit about page mission statement*/
if(isset($_POST['edit_mission']))
{
	$mission_detailsError = "";
	$mission_Error = 0;
	$mission_success_msg = "";
	$mission_error_counter = "";
	
	$mission_details = mysqli_real_escape_string($spider_tech_db, $_POST['mission_details']);
	
	/*check for empty field*/
	if(empty($_POST['mission_details']))
	{
		$mission_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$mission_Error = 1;
		}
		
	if($mission_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE about_mission SET details = '$mission_details'");
		$mission_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, record updated.
							</div>';		
	}//end of mission_Error	
}//end of first if

/*manage about page vision statement*/
if(isset($_POST['add_vision']))
{
	$vision_detailsError = "";
	$vision_Error = 0;
	$vision_success_msg = "";
	$vision_error_counter = "";
	
	$vision_details = mysqli_real_escape_string($spider_tech_db, $_POST['vision_details']);
	
	/*check for empty field*/
	if(empty($_POST['vision_details']))
	{
		$vision_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$vision_Error = 1;
		}
	if($vision_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM about_vision ");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$vision_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									    Vision statement record exist. You can only edit already existing record for this item.
								  </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO about_vision (details) VALUES('$vision_details')");
        unset($_POST);
		$vision_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new record added.
							</div>';		
		}
	}//end of vision_Error
	
}//end of first if

/*edit about page vision statement*/
if(isset($_POST['edit_vision']))
{
	$vision_detailsError = "";
	$vision_Error = 0;
	$vision_success_msg = "";
	$vision_error_counter = "";
	
	$vision_details = mysqli_real_escape_string($spider_tech_db, $_POST['vision_details']);
	
	/*check for empty field*/
	if(empty($_POST['vision_details']))
	{
		$vision_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$vision_Error = 1;
		}
		
	if($vision_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE about_vision SET details = '$vision_details'");
		$vision_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, record updated.
							</div>';		
	}//end of vision_Error	
}//end of first if

/*manage about page core values*/
if(isset($_POST['add_core_value']))
{
	$cv_detailsError = "";
	$cv_Error = 0;
	$cv_success_msg = "";
	$cv_error_counter = "";
	
	$cv_details = mysqli_real_escape_string($spider_tech_db, $_POST['cv_details']);
	
	/*check for empty field*/
	if(empty($_POST['cv_details']))
	{
		$cv_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$cv_Error = 1;
		}
	if($cv_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM about_core_value ");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$cv_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert-danger">
									Core Value record exist. You can only edit already existing record for this item.
								  </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO about_core_value (cv_details) VALUES('$cv_details')");
        unset($_POST);
		$cv_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new record added.
							</div>';		
		}
	}//end of cv_Error
	
}//end of first if

/*edit about page core values*/
if(isset($_POST['edit_core_value']))
{
	$cv_detailsError = "";
	$cv_Error = 0;
	$cv_success_msg = "";
	$cv_error_counter = "";
	
	$cv_details = mysqli_real_escape_string($spider_tech_db, $_POST['cv_details']);
	
	/*check for empty field*/
	if(empty($_POST['cv_details']))
	{
		$cv_detailsError = '<font color="#FF0000">Field cannot be empty</font>';
		$cv_Error = 1;
		}
		
	if($cv_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE about_core_value SET cv_details = '$cv_details'");
		$cv_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, record updated.
							</div>';		
	}//end of cv_Error	
}//end of first if

/*manage about page organisational Structure*/
if(isset($_POST['add_organisation_structure']))
{
	$os_imgError = "";
	$os_Error = 0;
	$os_success_msg = "";
	$os_error_counter = "";

	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(1920 => 1280);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/resources/'.$new_name;
	
	/*check for empty field*/
	if(empty($_FILES['img']['tmp_name']))
	{
		$os_imgError = '<font color="#bf0006">'."No file is selected.".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
		$os_imgError = '<font color="#bf0006">'."Unsupported File Format".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
		$os_imgError = '<font color="#bf0006">'."Larger Image Size".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
		$os_imgError = '<font color="#bf0006">'."Similar File Exist".'</font>';
		$os_Error = 1;
		}	    
	if($os_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM about_organisational_structure ");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$os_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									Organisational structure record exist. You can only edit already existing record for this item.
								  </div>';
			}
		elseif($row == 0)
		{
		foreach ($size as $w => $h) 
		{
		$files[] = resize($w, $h);
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO about_organisational_structure (organisational_structure) VALUES('$path')");
        unset($_POST);
		$os_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new record added.
							</div>';		
		}
		}
	}//end of os_Error
	
}//end of first if

/*edit about page organisational structure values*/
if(isset($_POST['edit_organisation_structure']))
{
	$os_imgError = "";
	$os_Error = 0;
	$os_success_msg = "";
	$os_error_counter = "";

	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(1920 => 1280);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/resources/'.$new_name;
	
	/*check for empty field*/
	if(empty($_FILES['img']['tmp_name']))
	{
		$os_imgError = '<font color="#bf0006">'."No file is selected.".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
		$os_imgError = '<font color="#bf0006">'."Unsupported File Format".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
		$os_imgError = '<font color="#bf0006">'."Larger Image Size".'</font>';
		$os_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
		$os_imgError = '<font color="#bf0006">'."Similar File Exist".'</font>';
		$os_Error = 1;
		}	    
	if($os_Error == 0)
	{
		unlink($_POST['old_img']);
		foreach ($size as $w => $h) 
		{
		$files[] = resize($w, $h);
		$update_record = mysqli_query($spider_tech_db, "UPDATE about_organisational_structure SET organisational_structure = '$path'");
		$os_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, record updated.
							</div>';
		}		
	}//end of os_Error	
}//end of first if

//Manage Departments
if(isset($_POST['add_depart']))
{
	$dept_nameErr="";
	$dept_codeErr="";
	$dept_emailErr="";
	$dept_schErr="";
	$dept_descriptionErr="";
	$dept_philoErr="";
	$dept_Error=0;
	$dept_success_msg="";
	$dept_error_counter = "";
	$dept_imgErr = "";
	$dept_philo=mysqli_real_escape_string($spider_tech_db, $_POST['dept_philo']);
	$dept_name=mysqli_real_escape_string($spider_tech_db, $_POST['dept_name']);
	$dept_code=mysqli_real_escape_string($spider_tech_db, $_POST['dept_code']);
	$dept_email=mysqli_real_escape_string($spider_tech_db, $_POST['dept_email']);
	$dept_description=mysqli_real_escape_string($spider_tech_db, $_POST['dept_description']);
	$dept_sch=mysqli_real_escape_string($spider_tech_db, $_POST['dept_sch']);
	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(360 => 250);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/resources/'.$new_name;

	if(empty($dept_name))
	{
		$dept_nameErr='<font color="#FF0000">'."Department Name is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_code))
	{
		$dept_codeErr='<font color="#FF0000">'."Department Code is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_email))
	{
		$dept_emailErr='<font color="#FF0000">'."Department Email is Required".'</font>';
		$dept_Error=1;
		}
	if(!empty($dept_email) && filter_var($dept_email, FILTER_VALIDATE_EMAIL)===false)
	{
		$dept_emailErr='<font color="#FF0000">'."Invalid Email Address".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_sch))
	{
		$dept_schError='<font color="#FF0000">'."School Name is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_description))
	{
		$dept_descriptionErr='<font color="#FF0000">'."About department is required.".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_philo))
	{
		$dept_philoErr='<font color="#FF0000">'."Department Philosophy is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($_FILES['img']['tmp_name']))
	{
		$dept_imgErr = '<font color="#bf0006">'."No file is selected.".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
		$dept_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
		$dept_imgErr = '<font color="#bf0006">'."Larger Image Size".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
		$dept_imgErr = '<font color="#bf0006">'."Similar File Exist".'</font>';
		$dept_Error = 1;
		}
	if($dept_Error==0)
	{
		$check_similar=mysqli_query($spider_tech_db, "SELECT dep_name FROM department WHERE dep_name='$dept_name' AND school = '$dept_sch'");
		$check=mysqli_num_rows($check_similar);
		if($check > 0)
		{
			$dept_error_counter='<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									 Department record exist. You cannot same record twice.
								</div>';
			}
		elseif($check==0)
		{
		foreach ($size as $w => $h) 
		{
		$files[] = resize($w, $h);
		$add_dep=mysqli_query($spider_tech_db, "INSERT INTO department (dep_name, school, dep_code, dep_email,  objectives, philosophy, dep_img) VALUES('$dept_name','$dept_sch','$dept_code','$dept_email','$dept_description','$dept_philo', '$path')");
		$dept_success_msg='<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new department has been added.
						   </div>';
		}
		}
	}//end of deplicate if 
}//end of main if

//edit department
if(isset($_POST['edit_depart']))
{
	$dept_nameErr="";
	$dept_codeErr="";
	$dept_emailErr="";
	$dept_schErr="";
	$dept_descriptionErr="";
	$dept_philoErr="";
	$dept_Error=0;
	$dept_success_msg="";
	if(isset($_FILES['img']['tmp_name']))
	{
	$dept_imgErr = "";
    }
	$dept_philo=mysqli_real_escape_string($spider_tech_db, $_POST['dept_philo']);
	$dept_name=mysqli_real_escape_string($spider_tech_db, $_POST['dept_name']);
	$dept_code=mysqli_real_escape_string($spider_tech_db, $_POST['dept_code']);
	$dept_email=mysqli_real_escape_string($spider_tech_db, $_POST['dept_email']);
	$dept_description=mysqli_real_escape_string($spider_tech_db, $_POST['dept_description']);
	$dept_sch=mysqli_real_escape_string($spider_tech_db, $_POST['dept_sch']);
	if(isset($_FILES['img']['tmp_name']))
	{
	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(360 => 250);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/resources/'.$new_name;
	}
	if(empty($dept_name))
	{
		$dept_nameErr='<font color="#FF0000">'."Department Name is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_code))
	{
		$dept_codeErr='<font color="#FF0000">'."Department Code is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_email))
	{
		$dept_emailErr='<font color="#FF0000">'."Department Email is Required".'</font>';
		$dept_Error=1;
		}
	if(!empty($dept_email) && filter_var($dept_email, FILTER_VALIDATE_EMAIL)===false)
	{
		$dept_emailErr='<font color="#FF0000">'."Invalid Email Address".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_sch))
	{
		$dept_schError='<font color="#FF0000">'."School Name is Required".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_description))
	{
		$dept_descriptionErr='<font color="#FF0000">'."About department is required.".'</font>';
		$dept_Error=1;
		}
	if(empty($dept_philo))
	{
		$dept_philoErr='<font color="#FF0000">'."Department Philosophy is Required".'</font>';
		$dept_Error=1;
		}
	if(isset($_FILES['img']['tmp_name']))
	{
	if(empty($_FILES['img']['tmp_name']))
	{
		$dept_imgErr = '<font color="#bf0006">'."No file is selected.".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
		$dept_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
		$dept_imgErr = '<font color="#bf0006">'."Larger Image Size".'</font>';
		$dept_Error = 1;
		}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
		$dept_imgErr = '<font color="#bf0006">'."Similar File Exist".'</font>';
		$dept_Error = 1;
		}
	}
	if($dept_Error==0)
	{
		if(isset($_FILES['img']['tmp_name']))
	    {
			if(!empty($_POST['dept_img']))
			{
			unlink($_POST['dept_img']);
			}
		foreach ($size as $w => $h) 
		{
		$files[] = resize($w, $h);
		$upd_dep=mysqli_query($spider_tech_db, "UPDATE department SET dep_name = '$dept_name', school = '$dept_sch', dep_code = '$dept_code', dep_email = '$dept_email',  objectives = '$dept_description', philosophy = '$dept_philo', dep_img = '$path' WHERE dep_id ='".$_SESSION['dept']."' ") or die(mysqli_error($spider_tech_db));
		$dept_success_msg='<div class="col-sm-12 col-md-12 col-lg-12">
								<button class="tstSuccess btn btn-success">Success, new department has been added.</button>
						   </div>';
		}
	    }
		if(!isset($_FILES['img']['tmp_name'])){
			$upd_dep=mysqli_query($spider_tech_db, "UPDATE department SET dep_name = '$dept_name', school = '$dept_sch', dep_code = '$dept_code', dep_email = '$dept_email',  objectives = '$dept_description', philosophy = '$dept_philo' WHERE dep_id ='".$_SESSION['dept']."' ") or die(mysqli_error($spider_tech_db));
			$dept_success_msg='<div class="col-sm-12 col-md-12 col-lg-12">
									<button class="tstSuccess btn btn-success">Success, new department has been added.</button>
							   </div>';

		}
	}//end of deplicate if 
}//end of main if

/*Manage courses*/
//add a course
if(isset($_POST['add_course']))
{
$course_nameErr="";
$course_Error=0;
$dept_nameErr="";
$course_success_msg="";
$course_error_counter = "";
$semester_Err="";
$course_codeErr="";
$level_nameErr="";
$course_statusErr="";
$prog_nameErr="";
$credit_unitErr="";
$course_categoryErr="";
$course_name=mysqli_real_escape_string($spider_tech_db, $_POST['course_name']);
$course_code=mysqli_real_escape_string($spider_tech_db, $_POST['course_code']);
$dept_name=mysqli_real_escape_string($spider_tech_db, $_POST['dept_name']);
$semester=mysqli_real_escape_string($spider_tech_db, $_POST['semester']);
$course_status=mysqli_real_escape_string($spider_tech_db, $_POST['course_status']);
$prog_name=mysqli_real_escape_string($spider_tech_db, $_POST['prog_name']);
$credit_unit=mysqli_real_escape_string($spider_tech_db, $_POST['credit_unit']);
$level_name=mysqli_real_escape_string($spider_tech_db, $_POST['level_name']);
$course_category=mysqli_real_escape_string($spider_tech_db, $_POST['course_category']);

if(empty($course_name))
{
	$course_nameErr='<font color="#FF0000">'."Course title is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_code))
{
	$course_codeErr='<font color="#FF0000">'."Course code is required.".'</font>';
	$course_Error=1;
	}
if(empty($dept_name))
{
	$dept_nameErr='<font color="#FF0000">'."Department is required.".'</font>';
	$course_Error=1;
	}
if(empty($semester))
{
	$semester_Err='<font color="#FF0000">'."Semester is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_status))
{
	$course_statusErr='<font color="#FF0000">'."Course status is required.".'</font>';
	$course_Error=1;
	}
if(empty($prog_name))
{
	$prog_nameErr='<font color="#FF0000">'."Program is required.".'</font>';
	$course_Error=1;
	}
if(empty($credit_unit))
{
	$credit_unitErr='<font color="#FF0000">'."Total credit unit is required.".'</font>';
	$course_Error=1;
	}
if(empty($level_name))
{
	$level_nameErr='<font color="#FF0000">'."Level is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_category))
{
	$course_categoryErr='<font color="#FF0000">'."Course category is required.".'</font>';
	$course_Error=1;
	}
	if($course_Error==0)
	{
		$course_query=mysqli_query($spider_tech_db, "SELECT course_name FROM courses WHERE course_name='$course_name' AND code='$course_code' AND department='$dept_name' AND students='$course_category'") or die(mysqli_error($spider_tech_db));
		$course_row=mysqli_num_rows($course_query);
		if($course_row==1)
		{
			$course_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12">
										<button class="tstError btn btn-danger">Cannot add duplicate, course already exists!</button>
									</div>'; 
			
			}
		elseif($course_row==0)
		{
			$add_course=mysqli_query($spider_tech_db, "INSERT INTO courses (course_name, department, semester, code, level, status, programme, credit_unit, students)
			                        VALUE('$course_name','$dept_name','$semester','$course_code','$level_name','$course_status','$prog_name', '$credit_unit','$course_category')") or die(mysqli_error($spider_tech_db));
			$course_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12">
										<button class="tstSuccess btn btn-success">Course successfully added.</button>
									</div>';
			}
	}//end of course error
}//end of main if

//update course details
if(isset($_POST['edit_course']))
{

$course_nameErr="";
$course_Error=0;
$dept_nameErr="";
$course_success_msg="";
$course_error_counter = "";
$semester_Err="";
$course_codeErr="";
$level_nameErr="";
$course_statusErr="";
$prog_nameErr="";
$credit_unitErr="";
$course_categoryErr="";
$course_name=mysqli_real_escape_string($spider_tech_db, $_POST['course_name']);
$course_code=mysqli_real_escape_string($spider_tech_db, $_POST['course_code']);
$dept_name=mysqli_real_escape_string($spider_tech_db, $_POST['dept_name']);
$semester=mysqli_real_escape_string($spider_tech_db, $_POST['semester']);
$course_status=mysqli_real_escape_string($spider_tech_db, $_POST['course_status']);
$prog_name=mysqli_real_escape_string($spider_tech_db, $_POST['prog_name']);
$credit_unit=mysqli_real_escape_string($spider_tech_db, $_POST['credit_unit']);
$level_name=mysqli_real_escape_string($spider_tech_db, $_POST['level_name']);
$course_category=mysqli_real_escape_string($spider_tech_db, $_POST['course_category']);

if(empty($course_name))
{
	$course_nameErr='<font color="#FF0000">'."Course title is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_code))
{
	$course_codeErr='<font color="#FF0000">'."Course code is required.".'</font>';
	$course_Error=1;
	}
if(empty($dept_name))
{
	$dept_nameErr='<font color="#FF0000">'."Department is required.".'</font>';
	$course_Error=1;
	}
if(empty($semester))
{
	$semester_Err='<font color="#FF0000">'."Semester is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_status))
{
	$course_statusErr='<font color="#FF0000">'."Course status is required.".'</font>';
	$course_Error=1;
	}
if(empty($prog_name))
{
	$prog_nameErr='<font color="#FF0000">'."Program is required.".'</font>';
	$course_Error=1;
	}
if(empty($credit_unit))
{
	$credit_unitErr='<font color="#FF0000">'."Total credit unit is required.".'</font>';
	$course_Error=1;
	}
if(empty($level_name))
{
	$level_nameErr='<font color="#FF0000">'."Level is required.".'</font>';
	$course_Error=1;
	}
if(empty($course_category))
{
	$course_categoryErr='<font color="#FF0000">'."Course category is required.".'</font>';
	$course_Error=1;
	}
	if($course_Error==0)
	{

		$update_course=mysqli_query($spider_tech_db, "UPDATE courses SET course_name='$course_name', department='$dept_name', semester='$semester', code='$course_code', level='$level_name', status='$course_status', programme='$prog_name', credit_unit='$credit_unit' WHERE course_id='".$_SESSION['course']."'") or die(mysqli_error($spider_tech_db));
		$course_success_msg =  '<div class="col-sm-12 col-md-12 col-lg-12">
										<button class="tstSuccess btn btn-success">Course successfully added.</button>
							    </div>';
	}
}//end of main if 

//Manage Events
if(isset($_POST['add_event']))
{
$event_titleErr = "";
$event_Error = 0;
$event_contentErr = "";
$event_detailErr = "";
$event_success_msg="";
$event_dateErr = "";
$event_date2Err = "";
$event_timeErr = "";
$event_statusErr = "";
$event_imgErr = "";
$event_addressErr = "";
$event_title=mysqli_real_escape_string($spider_tech_db, $_POST['event_title']);
$event_date=mysqli_real_escape_string($spider_tech_db, $_POST['event_date']);
$event_date2=mysqli_real_escape_string($spider_tech_db, $_POST['event_date2']);
$event_time=mysqli_real_escape_string($spider_tech_db, $_POST['event_time']);
$event_content=mysqli_real_escape_string($spider_tech_db, $_POST['event_content']);
$event_detail=mysqli_real_escape_string($spider_tech_db, $_POST['event_detail']);
$event_status=mysqli_real_escape_string($spider_tech_db, $_POST['event_status']);
$event_address=mysqli_real_escape_string($spider_tech_db, $_POST['event_address']);

$_SESSION['img_name'] = mt_rand(0, getrandmax());
//include image resize function
include('img_function.php');
// settings
$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
// thumbnail sizes
$size = array(700 => 750);
$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
$new_name = $_SESSION['img_name']. '.' . $ext;
$path = '../images/pictures/'.$new_name;

if(empty($event_title))
{
	$event_titleErr='<font color="#FF0000">'."Title is required.".'</font>';
	$event_Error=1;
	}
if(empty($event_date))
{
	$event_dateErr='<font color="#FF0000">'."Date is required.".'</font>';
	$event_Error=1;
	}
	if(empty($event_date2))
{
	$event_date2Err='<font color="#FF0000">'."End Date is required.".'</font>';
	$event_Error=1;
	}
if(empty($event_time))
{
	$event_timeErr='<font color="#FF0000">'."Time is required.".'</font>';
	$event_Error=1;
	}
if(empty($event_address))
{
	$event_addressErr='<font color="#FF0000">'."Address is required.".'</font>';
	$event_Error=1;
	}
if(empty($event_status))
{
	$event_statusErr='<font color="#FF0000">'."Status is required.".'</font>';
	$event_Error=1;
	}
if(empty($event_content))
{
	$event_contentErr='<font color="#FF0000">'."Body is required.".'</font>';
	$event_Error=1;
	}
	if(empty($event_content))
{
	$event_detailErr='<font color="#FF0000">'."Event details are required.".'</font>';
	$event_Error=1;
	}
if(empty($_FILES['img']['tmp_name']))
{
	$event_imgErr='<font color="#FF0000">'."No file is selected.".'</font>';
	$event_Error=1;
	}
if ((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") && ($ext != "JPG") &&  ($ext != "png") && ($ext != "PNG") && ($ext != "gif") && ($ext != "GIF") && ($ext != "jpeg") && ($ext != "JPEG")))
{
	$event_imgErr='<font color="#FF0000">'."Unsupported File Format".'</font>';
	$event_Error=1;
    }
if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 4000000))
{
    $event_imgErr='<font color="#FF0000">'."Larger Images Size".'</font>';
    $event_Error=1;
    }
if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
{
	$event_imgErr='<font color="#FF0000">'."Similar File Exist".'</font>';
	$event_Error=1;
	}
if($event_Error==0)
{
	$event_query=mysqli_query($spider_tech_db, "SELECT * FROM events WHERE event_title='$event_title' AND event_date='$event_date'") 
							or die(mysqli_error($spider_tech_db));
	$event_row=mysqli_num_rows($event_query);
		if($event_row==1)
		{
			$event_error_counter='<div class="col-sm-12 col-md-12 col-lg-12">
									<button class="tstError btn btn-danger">Event record exist. 
											You cannot add same record twice.</button>
								</div>';
			}
		elseif($event_row==0)
		{
			/* resize image */
			foreach ($size as $w => $h) 
			{
			$files[] = resize($w, $h);
			$add_event=mysqli_query($spider_tech_db, "INSERT INTO events (event_title, event_content, event_detail, event_date, event_date2, event_time, event_address,
			event_status, event_img) VALUE('$event_title','$event_content','$event_date', '$event_detail','$event_date2','$event_time', '$event_address','$event_status','$path')") 
			or die(mysqli_error($spider_tech_db));
			
			$event_success_msg='<div class="col-sm-12 col-md-12 col-lg-12">
									<button class="tstSuccess btn btn-success">Success,
									 event record has been added.</button>
							</div>';
			}
		}
		}
}//end of main if

//edit event
if(isset($_POST['edit_event'])) {
    
	$event_titleErr = "";
	$event_Error = 0;
	$event_contentErr = "";
	$event_detailErr = "";
	$event_success_msg="";
	$event_dateErr = "";
	$event_date2Err = "";
	$event_timeErr = "";
	$event_statusErr = "";
	$event_imgErr = "";
	$event_addressErr = "";
	$event_title=mysqli_real_escape_string($spider_tech_db, $_POST['event_title']);
	$event_date=mysqli_real_escape_string($spider_tech_db, $_POST['event_date']);
	$event_date2=mysqli_real_escape_string($spider_tech_db, $_POST['event_date2']);
	$event_time=mysqli_real_escape_string($spider_tech_db, $_POST['event_time']);
	$event_content=mysqli_real_escape_string($spider_tech_db, $_POST['event_content']);
	$event_detail=mysqli_real_escape_string($spider_tech_db, $_POST['event_detail']);
	$event_status=mysqli_real_escape_string($spider_tech_db, $_POST['event_status']);
	$event_address=mysqli_real_escape_string($spider_tech_db, $_POST['event_address']);
    $event_id = mysqli_real_escape_string($spider_tech_db, $_POST['event_id']);

    // Check for the existence of the file
    if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
        $_SESSION['img_name'] = mt_rand(0, getrandmax()); // Generate a unique image name
        
        // Include image resize function
        include('img_function.php');

        // Allowable file extensions
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $size = array(900 => 590); // Thumbnail sizes

        // Get file extension
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        // Generate a new name for the image
        $new_name = $_SESSION['img_name']. '.' . $ext;
        $path = '../images/pictures/'.$new_name;
        
        // Validate image format and size
        if (!in_array($ext, $valid_exts)) {
            $event_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
            $event_Error = 1;
        }
        if ($_FILES['img']['size'] > 3000000) {
            $event_imgErr = '<font color="#bf0006">'."Image Size Too Large".'</font>';
            $event_Error = 1;
        }

        // Handle old image deletion if it exists
        $old_image_query = mysqli_query($spider_tech_db, "SELECT event_img FROM events WHERE event_id = '$event_id'");
        $old_image = mysqli_fetch_assoc($old_image_query)['event_img'];
        if (!empty($old_image) && file_exists($old_image)) {
            unlink($old_image);  // Delete the old image
        }

    } else {
        // If no image is uploaded, keep the old image path in the update
        $old_image_query = mysqli_query($spider_tech_db, "SELECT event_img FROM events WHERE event_id = '$event_id'");
        $path = mysqli_fetch_assoc($old_image_query)['event_img'];
    }

    // Validate other form fields
	if(empty($event_title))
	{
		$event_titleErr='<font color="#FF0000">'."Title is required.".'</font>';
		$event_Error=1;
		}
	if(empty($event_date))
	{
		$event_dateErr='<font color="#FF0000">'."Date is required.".'</font>';
		$event_Error=1;
		}
		if(empty($event_date2))
	{
		$event_date2Err='<font color="#FF0000">'."End date is required.".'</font>';
		$event_Error=1;
		}
	if(empty($event_time))
	{
		$event_timeErr='<font color="#FF0000">'."Time is required.".'</font>';
		$event_Error=1;
		}
	if(empty($event_address))
	{
		$event_addressErr='<font color="#FF0000">'."Address is required.".'</font>';
		$event_Error=1;
		}
	if(empty($event_status))
	{
		$event_statusErr='<font color="#FF0000">'."Status is required.".'</font>';
		$event_Error=1;
		}
	if(empty($event_content))
	{
		$event_contentErr='<font color="#FF0000">'."Event description is required.".'</font>';
		$event_Error=1;
		}
		if(empty($event_detail))
	{
		$event_detailErr='<font color="#FF0000">'."Event detail is required.".'</font>';
		$event_Error=1;
		}

    // If no errors, proceed to update
    if ($event_Error == 0) {
        if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
            // Resize and save new image
            foreach ($size as $w => $h) {
                $files[] = resize($w, $h);
            }

            // Update event with new image
            $update_record = mysqli_query($spider_tech_db, "UPDATE events SET 
                event_title = '$event_title', 
                event_content = '$event_content',
				event_detail = '$event_detail',  
                event_date = '$event_date',
				event_date2 = '$event_date2', 
                event_time = '$event_time',
				event_address = '$event_address', 
				event_status = '$event_status',
                event_img = '$path'
                WHERE event_id = '$event_id'") or die(mysqli_error($spider_tech_db));
        } else {
            // Update event without changing the image
            $update_record = mysqli_query($spider_tech_db, "UPDATE events SET 
                event_title = '$event_title', 
                event_content = '$event_content', 
				event_detail = '$event_detail',
                event_date = '$event_date',
				event_date2 = '$event_date2', 
                event_time = '$event_time',
				event_address = '$event_address', 
				event_status = '$event_status'
                WHERE event_id = '$event_id'") or die(mysqli_error($spider_tech_db));
        }

        // Success message
        $event_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                    Success, record updated.
                                </div>';
    }
} // End of form submission
//end of main if



/*manage projects*/
if(isset($_POST['add_event_media']))
{
	$mediaErr = "";
	$event_media_Error = 0;
	$media_success_msg = "";
	$event_media_error_counter = "";
	$event_id = mysqli_real_escape_string($spider_tech_db, $_POST['event_id']);
	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(900 => 590);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/pictures/'.$new_name;
	
	
	if(empty($_FILES['img']['tmp_name']))
	{
	$mediaErr = '<font color="#bf0006">'."No file is selected.".'</font>';
	$event_media_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
	$mediaErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
	$event_media_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
	$mediaErr = '<font color="#bf0006">'."Larger Image Size".'</font>';
	$event_media_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
	$mediaErr = '<font color="#bf0006">'."Similar File Exist".'</font>';
	$event_media_Error = 1;
	}	
	if($event_media_Error == 0)
	{
		
		foreach ($size as $w => $h) 
		{
		$files[] = resize($w, $h);
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO events_media (event_id, event_pics_name) 
		VALUES('$event_id','$path')") or die(mysqli_error($spider_tech_db)) ;
        unset($_POST);
		$media_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, new record added.
								</div>';		
			
		}
		
	}//end of media_Error
	
}//end of first if


if(isset($_POST['edit_event_media'])) {
    // Initialize error variables
	$mediaErr = "";
    $event_media_Error = 0;
    $media_success_msg = "";


    // Sanitize inputs using prepared statements
    $event_pics_id = mysqli_real_escape_string($spider_tech_db, $_POST['event_pics_id']);

    // Check for the existence of the file
    if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
        $_SESSION['img_name'] = mt_rand(0, getrandmax()); // Generate a unique image name
        
        // Include image resize function
        include('img_function.php');

        // Allowable file extensions
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $size = array(900 => 590); // Thumbnail sizes

        // Get file extension
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        // Generate a new name for the image
        $new_name = $_SESSION['img_name']. '.' . $ext;
        $path = '../images/pictures/'.$new_name;
        
        // Validate image format and size
        if (!in_array($ext, $valid_exts)) {
            $mediaErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
            $event_media_Error = 1;
        }
        if ($_FILES['img']['size'] > 3000000) {
            $mediaErr = '<font color="#bf0006">'."Image Size Too Large".'</font>';
            $event_media_Error = 1;
        }

        // Handle old image deletion if it exists
        $old_image_query = mysqli_query($spider_tech_db, "SELECT event_pics_name FROM events_media WHERE event_pics_id = '$event_pics_id'");
        $old_image = mysqli_fetch_assoc($old_image_query)['event_pics_name'];
        if (!empty($old_image) && file_exists($old_image)) {
            unlink($old_image);  // Delete the old image
        }

    } else {
        // If no image is uploaded, keep the old image path in the update
        $old_image_query = mysqli_query($spider_tech_db, "SELECT event_pics_name FROM events_media WHERE event_pics_id = '$event_pics_id'");
        $path = mysqli_fetch_assoc($old_image_query)['event_pics_name'];
    }


    // If no errors, proceed to update
    if ($event_media_Error == 0) {
        if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
            // Resize and save new image
            foreach ($size as $w => $h) {
                $files[] = resize($w, $h);
            }

            // Update project with new image
            $update_record = mysqli_query($spider_tech_db, "UPDATE events_media SET 
                event_pics_name = '$path'
                WHERE event_pics_id = '$event_pics_id'") or die(mysqli_error($spider_tech_db));
        } 

        // Success message
        $media_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                    Success, record updated.
                                </div>';
    }
} 
// end of edit event media


/*manage services details*/
if(isset($_POST['add_service']))
{
	$service_nameErr="";
	$service_descriptionErr="";
	$service_detailsErr="";
	$service_iconErr="";
	$service_Error=0;
	$service_success_msg="";
	$service_error_counter = "";
	$service_iconErr = "";
	$service_name = mysqli_real_escape_string($spider_tech_db, $_POST['service_name']);
	$service_description = mysqli_real_escape_string($spider_tech_db, $_POST['service_description']);
	$service_details = mysqli_real_escape_string($spider_tech_db, $_POST['service_details']);
	$service_icon = mysqli_real_escape_string($spider_tech_db, $_POST['service_icon']);
	
	if(empty($service_name))
	{
		$service_nameErr='<font color="#bf0006">'."Service name is required.".'</font>';
		$service_Error=1;
		}
		if(empty($service_description))
	{
		$service_descriptionErr='<font color="#bf0006">'."Service description is required.".'</font>';
		$service_Error=1;
		}
	if(empty($service_details))
	{
		$service_detailsErr='<font color="#bf0006">'."Service details is required.".'</font>';
		$service_Error=1;
		}
	if(empty($service_icon))
	{
		$service_iconErr='<font color="#bf0006">'."Service icon is required.".'</font>';
		$service_Error=1;
		}
	if($service_Error == 0)
	{
		//check if record already exist
		$service_query=mysqli_query($spider_tech_db, "SELECT * FROM services_tb WHERE service_name='$service_name' 
		") or die(mysqli_error($spider_tech_db));
		$service_row=mysqli_num_rows($service_query);
		if($service_row > 0)
		{
			$service_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
									     Record exist. You cannot same record twice.
								  </div>';
			}
		elseif($service_row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO services_tb (service_name, service_description, service_detail, service_icon) 
		VALUES('$service_name', '$service_description', '$service_details', '$service_icon')") or die(mysqli_error($spider_tech_db)) ;
        unset($_POST);
		$service_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, new record added.
								</div>';		
		}
	}//end of service_Error
	
}//end of first if

/*edit services*/
if(isset($_POST['edit_service']))
{
	$service_nameErr="";
	$service_descriptionErr="";
	$service_detailsErr="";
	$service_iconErr="";
	$service_Error=0;
	$service_success_msg="";
	$service_error_counter = "";
	$service_imgErr = "";
	$service_name=mysqli_real_escape_string($spider_tech_db, $_POST['service_name']);
	$service_description=mysqli_real_escape_string($spider_tech_db, $_POST['service_description']);
	$service_details=mysqli_real_escape_string($spider_tech_db, $_POST['service_details']);
	$service_icon=mysqli_real_escape_string($spider_tech_db, $_POST['service_icon']);
	$service_id=mysqli_real_escape_string($spider_tech_db, $_POST['service_id']);	
	
	
	/*check for empty field*/
	if(empty($service_name))
	{
		$service_nameErr='<font color="#bf0006">'."Service name is required.".'</font>';
		$service_Error=1;
		}
	if(empty($service_description))
	{
		$service_descriptionErr='<font color="#bf0006">'."Service description is required.".'</font>';
		$service_Error=1;
		}
	if(empty($service_details))
	{
		$service_detailsErr='<font color="#bf0006">'."Service details is required.".'</font>';
		$service_Error=1;
		}
	if(empty($service_icon))
	{
		$service_iconErr='<font color="#bf0006">'."Service icon is required.".'</font>';
		$service_Error=1;
		}
	if($service_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE services_tb SET service_name = '$service_name', 
		service_description = '$service_description', service_detail = '$service_details', service_icon = '$service_icon' WHERE id = '$service_id'");
		$service_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
										Success, record updated.
									</div>';
		}		
		
}//end of first if

/*manage products details*/
// if(isset($_POST['add_more_pictures']))
// {
// 	$service_nameErr="";
// 	$products_descriptionErr="";
// 	$more_pictures_Error=0;
// 	$more_pictures_success_msg="";
// 	$more_pictures_error_counter = "";
// 	$more_pictures_imgErr = "";
// 	$service_name=mysqli_real_escape_string($spider_tech_db, $_POST['service_name']);
	
// 	$_SESSION['img_name'] = mt_rand(0, getrandmax());

// 	//include image resize function   
// 	include('img_function.php');
// 	// settings
// 	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
// 	// thumbnail sizes
// 	$size = array(900 => 590);

// 	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

// 	$new_name = $_SESSION['img_name']. '.' . $ext;
	
// 	$path = '../images/services/'.$new_name;
	
// 	/*check for empty field*/
// 	if(empty($service_name))
// 	{
// 		$service_nameErr='<font color="#bf0006">'."Service name is required.".'</font>';
// 		$more_pictures_Error=1;
// 		}
	
// 	if(empty($_FILES['img']['tmp_name']))
// 	{
// 		$more_pictures_imgErr = '<font color="#bf0006">'."No file is selected.".'</font>';
// 		$more_pictures_Error = 1;
// 		}
// 	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
// 	{
// 		$more_pictures_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
// 		$more_pictures_Error = 1;
// 		}
// 	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
// 	{
// 		$more_pictures_imgErr = '<font color="#bf0006">'."Larger Image Size".'</font>';
// 		$more_pictures_Error = 1;
// 		}
// 	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
// 	{
// 		$more_pictures_imgErr = '<font color="#bf0006">'."Similar File Exist".'</font>';
// 		$more_pictures_Error = 1;
// 		}	    
// 	if($more_pictures_Error == 0)
// 	{
		
// 		foreach ($size as $w => $h) 
// 		{
// 		$files[] = resize($w, $h);
// 		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO services_pictures (picture_name, 
// 		 service_id) 
// 		VALUES('$path', '$service_name')") or die(mysqli_error($spider_tech_db)) ;
//         unset($_POST);
// 		$more_pictures_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
// 									Success, new record added.
// 								</div>';		
// 		}
		
// 	}//end of products_Error
	
// }//end of first if

/*manage Testimonials*/
if (isset($_POST['add_testimonial'])) {
    $attestant_nameErr = "";
    $organisation_nameErr = "";
    $titleErr = "";
    $testimonialErr = "";
    $testimonial_Error = 0;
    $testimonial_success_msg = "";
    $testimonial_error_counter = "";
    $attestant_name = mysqli_real_escape_string($spider_tech_db, $_POST['attestant_name']);
    $organisation_name = mysqli_real_escape_string($spider_tech_db, $_POST['organisation_name']);
    $title = mysqli_real_escape_string($spider_tech_db, $_POST['title']);
    $testimonial = mysqli_real_escape_string($spider_tech_db, $_POST['testimonial']);
    $_SESSION['img_name'] = mt_rand(0, getrandmax());

    // Include image resize function
    include('img_function.php');
    
    // Valid file extensions and thumbnail sizes
    $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
    $size = array(900 => 590); // Example size, adjust as needed

    // Extract file extension
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

    // New file name
    $new_name = $_SESSION['img_name'] . '.' . $ext;

    // Define the path to save the image
    $path = "../images/pictures/" . $new_name;

    // Check for empty fields
    if (empty($attestant_name)) {
        $attestant_nameErr = '<font color="#bf0006">Attestant\'s name is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($title)) {
        $titleErr = '<font color="#bf0006">Title is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($organisation_name)) {
        $organisation_nameErr = '<font color="#bf0006">Company/Organisation is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($testimonial)) {
        $testimonialErr = '<font color="#bf0006">Testimonial is required.</font>';
        $testimonial_Error = 1;
    }

    // File validation
    if (empty($_FILES['img']['tmp_name'])) {
        $testimonial_imgErr = '<font color="#bf0006">No file is selected.</font>';
        $testimonial_Error = 1;
    } elseif (!in_array($ext, $valid_exts)) {
        $testimonial_imgErr = '<font color="#bf0006">Unsupported file format. Only jpg, png, gif, and jpeg are allowed.</font>';
        $testimonial_Error = 1;
    } elseif ($_FILES['img']['size'] > 3000000) {
        $testimonial_imgErr = '<font color="#bf0006">Image size is too large. Maximum allowed size is 3MB.</font>';
        $testimonial_Error = 1;
    } elseif (file_exists($path)) {
        $testimonial_imgErr = '<font color="#bf0006">A file with the same name already exists.</font>';
        $testimonial_Error = 1;
    }

    // If no errors, process the form
    if ($testimonial_Error == 0) {
        // Check if the record already exists
        $testimonial_query = mysqli_query($spider_tech_db, "SELECT * FROM testimonials_tb WHERE name = '$attestant_name' 
        AND organization = '$organisation_name' AND title = '$title'") or die(mysqli_error($spider_tech_db));

        $testimonial_row = mysqli_num_rows($testimonial_query);

        if ($testimonial_row > 0) {
            $testimonial_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
                                          Record exists. You cannot add the same record twice.
                                          </div>';
        } elseif ($testimonial_row == 0) {
            // Move the uploaded file to the correct location
            if (move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
                // Insert new record
                $insert_record = mysqli_query($spider_tech_db, "INSERT INTO testimonials_tb (name, organization, title, testimonial, image) 
                VALUES('$attestant_name', '$organisation_name', '$title', '$testimonial', '$path')") or die(mysqli_error($spider_tech_db));

                unset($_POST);
                $testimonial_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                            Success, new record added.
                                            </div>';
            } else {
                // Error moving the file
                $testimonial_imgErr = '<font color="#bf0006">Error uploading the image. Please try again.</font>';
            }
        }
    }
}//end of add testimonial

if(isset($_POST['edit_testimonial'])) {
    $attestant_nameErr = "";
    $organisation_nameErr = "";
    $titleErr = "";
    $testimonialErr = "";
    $testimonial_imgErr = "";
    $testimonial_Error = 0;
    $testimonial_success_msg = "";
    $testimonial_error_counter = "";

    // Sanitize inputs
    $attestant_name = mysqli_real_escape_string($spider_tech_db, $_POST['attestant_name']);
    $organisation_name = mysqli_real_escape_string($spider_tech_db, $_POST['organisation_name']);
    $title = mysqli_real_escape_string($spider_tech_db, $_POST['title']);
    $testimonial = mysqli_real_escape_string($spider_tech_db, $_POST['testimonial']);
    $testimonial_id = mysqli_real_escape_string($spider_tech_db, $_POST['testimonial_id']);

    // Fetch the current image path before updating
    $result = mysqli_query($spider_tech_db, "SELECT image FROM testimonials_tb WHERE id = '$testimonial_id'");
    $row = mysqli_fetch_assoc($result);
    $current_image = $row['image']; // Path to the current image

    // Check if a file is being uploaded
    if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])) {
        $_SESSION['img_name'] = mt_rand(0, getrandmax());

        // Include image resize function if necessary
        include('img_function.php');
        
        // Valid extensions
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        $new_name = $_SESSION['img_name']. '.' . $ext;
        $path = '../images/pictures/'.$new_name;

        // Validate file type and size
        if (!in_array($ext, $valid_exts)) {
            $testimonial_imgErr = '<font color="#bf0006">Unsupported File Format</font>';
            $testimonial_Error = 1;
        } elseif ($_FILES['img']['size'] > 3000000) { // Limit file size to 3MB
            $testimonial_imgErr = '<font color="#bf0006">Larger Image Size</font>';
            $testimonial_Error = 1;
        } elseif (file_exists($path)) {
            $testimonial_imgErr = '<font color="#bf0006">A file with the same name already exists</font>';
            $testimonial_Error = 1;
        } else {
            // Move the uploaded file
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
                $testimonial_imgErr = '<font color="#bf0006">Failed to upload the image</font>';
                $testimonial_Error = 1;
            } else {
                // Remove the old image from the folder
                if (file_exists($current_image)) {
                    unlink($current_image); // Delete the old image file
                }
            }
        }
    }//end of edit testimonial

    /* Check for empty fields */
    if (empty($attestant_name)) {
        $attestant_nameErr = '<font color="#bf0006">Attestant\'s name is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($title)) {
        $titleErr = '<font color="#bf0006">Title is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($organisation_name)) {
        $organisation_nameErr = '<font color="#bf0006">Company/Organisation is required.</font>';
        $testimonial_Error = 1;
    }
    if (empty($testimonial)) {
        $testimonialErr = '<font color="#bf0006">Testimonial is required.</font>';
        $testimonial_Error = 1;
    }

    /* If no errors, update the database */
    if ($testimonial_Error == 0) {
        // Check if a new image was uploaded or not
        $image_query = isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name']) ? ", image = '$path'" : '';

        // Update the testimonial record
        $update_query = "UPDATE testimonials_tb SET name = '$attestant_name', organization = '$organisation_name', 
                        title = '$title', testimonial = '$testimonial' $image_query WHERE id = '$testimonial_id'";

        $insert_record = mysqli_query($spider_tech_db, $update_query) or die(mysqli_error($spider_tech_db));
        
        $testimonial_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                        Success, record updated.
                                    </div>';
    }
}// end of edit testimonial



/*manage news*/
if(isset($_POST['add_contact_details']))
{
	$contact_addressErr = "";
	$contact_emailErr = "";
	$contact_pnoErr = "";
	$contact_Error = 0;
	$contact_success_msg = "";
	$contact_error_counter = "";
	
	$contact_address = mysqli_real_escape_string($spider_tech_db, $_POST['contact_address']);
	$contact_email = mysqli_real_escape_string($spider_tech_db, $_POST['contact_email']);
	$contact_pno = mysqli_real_escape_string($spider_tech_db, $_POST['contact_pno']);
	
	/*check for empty field*/
	if(empty($contact_address))
	{
		$contact_addressErr = '<font color="#FF0000">Address cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_address)) && (strlen($contact_address) > 200))
	{
		$contact_addressErr = '<font color="#FF0000">You cannot add more than 200 characters</font>';
		$contact_Error = 1;
		}
	if(empty($contact_email))
	{
		$contact_emailErr = '<font color="#FF0000">Email cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_email)) && (strlen($contact_email) > 50))
	{
		$contact_emailErr = '<font color="#FF0000">You cannot add more than 50 characters</font>';
		$contact_Error = 1;
		}
	if(empty($contact_pno))
	{
		$contact_pnoErr = '<font color="#FF0000">Phone number cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_pno)) && (strlen($contact_pno) > 15))
	{
		$contact_pnoErr = '<font color="#FF0000">Invalid phone number</font>';
		$contact_Error = 1;
		}
		
	if($contact_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM contact_details");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$contact_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
										News record exist. You can add the same record twice.
								  	  </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO contact_details (contact_address, contact_email, contact_pno) 
		VALUES('$contact_address', '$contact_email', '$contact_pno')") or die(mysqli_error($spider_tech_db));
        unset($_POST);
		$contact_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, new record added.
							</div>';		
		}
	}//end of news_Error
}//end of first if

/*edit news*/
if(isset($_POST['edit_contact_details']))
{
	$contact_addressErr = "";
	$contact_emailErr = "";
	$contact_pnoErr = "";
	$contact_Error = 0;
	$contact_success_msg = "";
	$contact_error_counter = "";
	
	$contact_address = mysqli_real_escape_string($spider_tech_db, $_POST['contact_address']);
	$contact_email = mysqli_real_escape_string($spider_tech_db, $_POST['contact_email']);
	$contact_pno = mysqli_real_escape_string($spider_tech_db, $_POST['contact_pno']);
	
	/*check for empty field*/
	if(empty($contact_address))
	{
		$contact_addressErr = '<font color="#FF0000">Address cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_address)) && (strlen($contact_address) > 200))
	{
		$contact_addressErr = '<font color="#FF0000">You cannot add more than 200 characters</font>';
		$contact_Error = 1;
		}
	if(empty($contact_email))
	{
		$contact_emailErr = '<font color="#FF0000">Email cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_email)) && (strlen($contact_email) > 50))
	{
		$contact_emailErr = '<font color="#FF0000">You cannot add more than 50 characters</font>';
		$contact_Error = 1;
		}
	if(empty($contact_pno))
	{
		$contact_pnoErr = '<font color="#FF0000">Phone number cannot be empty</font>';
		$contact_Error = 1;
		}
	if((!empty($contact_pno)) && (strlen($contact_pno) > 15))
	{
		$contact_pnoErr = '<font color="#FF0000">Invalid phone number</font>';
		$contact_Error = 1;
		}
		
	if($contact_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE contact_details SET contact_address = '$contact_address', contact_email = '$contact_email', 
		contact_pno = '$contact_pno'") or die(mysqli_error($spider_tech_db));
		$contact_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, record updated.
							</div>';		
	}//end of news_Error	
}//end of first if

/*manage FAQ*/
if(isset($_POST['add_faq']))
{
	$faq_questionErr = "";
	$faq_answerErr = "";
	$faq_Error = 0;
	$faq_success_msg = "";
	$faq_error_counter = "";
	
	$faq_question = mysqli_real_escape_string($spider_tech_db, $_POST['faq_question']);
	$faq_answer = mysqli_real_escape_string($spider_tech_db, $_POST['faq_answer']);
	
	/*check for empty field*/
	if(empty($faq_question))
	{
		$faq_questionErr = '<font color="#FF0000">Question cannot be empty</font>';
		$faq_Error = 1;
		}
	if((!empty($faq_question)) && (strlen($faq_question) > 400))
	{
		$faq_questionErr = '<font color="#FF0000">You cannot add more than 400 characters</font>';
		$faq_Error = 1;
		}
	if(empty($faq_answer))
	{
		$faq_answerErr = '<font color="#FF0000">Answer cannot be empty</font>';
		$faq_Error = 1;
		}
		
	if($faq_Error == 0)
	{
		//check if record already exist
		$check_duplicate = mysqli_query($spider_tech_db, "SELECT * FROM faq_tb WHERE faq_question = '$faq_question'");
		$row = mysqli_num_rows($check_duplicate);
		if($row == 1)
		{
			$faq_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
										Question exist. You can add the same record twice.
								  </div>';
			}
		elseif($row == 0)
		{
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO faq_tb (faq_question, faq_answer) 
		VALUES('$faq_question', '$faq_answer')") or die(mysqli_error($spider_tech_db));
        unset($_POST);
		$faq_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, new record added.
							</div>';		
		}
	}//end of news_Error
}//end of first if

/*edit news*/
if(isset($_POST['edit_faq']))
{
	$faq_questionErr = "";
	$faq_answerErr = "";
	$faq_Error = 0;
	$faq_success_msg = "";
	$faq_error_counter = "";
	
	$faq_question = mysqli_real_escape_string($spider_tech_db, $_POST['faq_question']);
	$faq_answer = mysqli_real_escape_string($spider_tech_db, $_POST['faq_answer']);
	$faq_id = mysqli_real_escape_string($spider_tech_db, $_POST['faq_id']);
	/*check for empty field*/
	if(empty($faq_question))
	{
		$faq_questionErr = '<font color="#FF0000">Question cannot be empty</font>';
		$faq_Error = 1;
		}
	if((!empty($faq_question)) && (strlen($faq_question) > 400))
	{
		$faq_questionErr = '<font color="#FF0000">You cannot add more than 400 characters</font>';
		$faq_Error = 1;
		}
	if(empty($faq_answer))
	{
		$faq_answerErr = '<font color="#FF0000">Answer cannot be empty</font>';
		$faq_Error = 1;
		}
		
	if($faq_Error == 0)
	{
		$update_record = mysqli_query($spider_tech_db, "UPDATE faq_tb SET faq_question = '$faq_question', faq_answer = '$faq_answer' 
		WHERE faq_id = '$faq_id'") or die(mysqli_error($spider_tech_db));
		$faq_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
								Success, record updated.
							</div>';		
	}//end of faq_Error	
}//end of first if

/*manage Trainings*/
if (isset($_POST['add_training'])) {
    $training_nameErr = "";
    $training_descriptionErr = "";
    $training_detailsErr = "";
    $training_iconErr = "";
    $training_Error = 0;
    $training_success_msg = "";
    $training_error_counter = "";
    $training_name = mysqli_real_escape_string($spider_tech_db, $_POST['training_name']);
    $training_description = mysqli_real_escape_string($spider_tech_db, $_POST['training_description']);
    $training_details = mysqli_real_escape_string($spider_tech_db, $_POST['training_details']);
    $training_icon = mysqli_real_escape_string($spider_tech_db, $_POST['training_icon']);
    $_SESSION['img_name'] = mt_rand(0, getrandmax());

    // Include image resize function
    include('img_function.php');
    
    // Valid file extensions and thumbnail sizes
    $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
    $size = array(900 => 590); // Example size, adjust as needed

    // Extract file extension
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

    // New file name
    $new_name = $_SESSION['img_name'] . '.' . $ext;

    // Define the path to save the image
    $path = "../images/pictures/" . $new_name;

    // Check for empty fields
    if (empty($training_name)) {
        $training_nameErr = '<font color="#bf0006">Training name is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_description)) {
        $training_descriptionErr = '<font color="#bf0006">Training description is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_details)) {
        $training_detailsErr = '<font color="#bf0006">Training Details is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_icon)) {
        $training_icomErr = '<font color="#bf0006">Training icon is required.</font>';
        $training_Error = 1;
    }

    // File validation
    if (empty($_FILES['img']['tmp_name'])) {
        $training_imgErr = '<font color="#bf0006">No file is selected.</font>';
        $training_Error = 1;
    } elseif (!in_array($ext, $valid_exts)) {
        $training_imgErr = '<font color="#bf0006">Unsupported file format. Only jpg, png, gif, and jpeg are allowed.</font>';
        $training_Error = 1;
    } elseif ($_FILES['img']['size'] > 3000000) {
        $training_imgErr = '<font color="#bf0006">Image size is too large. Maximum allowed size is 3MB.</font>';
        $training_Error = 1;
    } elseif (file_exists($path)) {
        $training_imgErr = '<font color="#bf0006">A file with the same name already exists.</font>';
        $training_Error = 1;
    }

    // If no errors, process the form
    if ($training_Error == 0) {
        // Check if the record already exists
        $training_query = mysqli_query($spider_tech_db, "SELECT * FROM trainings_tb WHERE training_name = '$training_name' 
        AND training_description = '$training_description' AND training_icon = '$training_icon'") or die(mysqli_error($spider_tech_db));

        $training_row = mysqli_num_rows($training_query);

        if ($training_row > 0) {
            $training_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
                                          Record exists. You cannot add the same record twice.
                                          </div>';
        } elseif ($training_row == 0) {
            // Move the uploaded file to the correct location
            if (move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
                // Insert new record
                $insert_record = mysqli_query($spider_tech_db, "INSERT INTO trainings_tb (training_name, training_description, training_details, training_icon, training_image) 
                VALUES('$training_name', '$training_description', '$training_details', '$training_icon', '$path')") or die(mysqli_error($spider_tech_db));

                unset($_POST);
                $training_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                            Success, new record added.
                                            </div>';
            } else {
                // Error moving the file
                $training_imgErr = '<font color="#bf0006">Error uploading the image. Please try again.</font>';
            }
        }
    }
}//end of add training

//edit training
if(isset($_POST['edit_training'])) {
    // Initialize error variables
    $training_nameErr = "";
    $training_descriptionErr = "";
    $training_detailsErr = "";
    $training_iconErr = "";
    $training_imgErr = "";
    $training_Error = 0;
    $training_success_msg = "";
    $training_error_counter = "";

    // Sanitize inputs
    $training_name = mysqli_real_escape_string($spider_tech_db, $_POST['training_name']);
    $training_description = mysqli_real_escape_string($spider_tech_db, $_POST['training_description']);
    $training_details = mysqli_real_escape_string($spider_tech_db, $_POST['training_details']);
    $training_icon = mysqli_real_escape_string($spider_tech_db, $_POST['training_icon']);
    $training_id = mysqli_real_escape_string($spider_tech_db, $_POST['training_id']);

    // Check for the existence of the file
    if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
        $_SESSION['img_name'] = mt_rand(0, getrandmax()); // Generate a unique image name
        
        // Include image resize function
        include('img_function.php');

        // Allowable file extensions
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $size = array(900 => 590); // Thumbnail sizes

        // Get file extension
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        // Generate a new name for the image
        $new_name = $_SESSION['img_name']. '.' . $ext;
        $path = '../images/pictures/'.$new_name;
        
        // Validate image format and size
        if (!in_array($ext, $valid_exts)) {
            $training_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
            $training_Error = 1;
        }
        if ($_FILES['img']['size'] > 3000000) {
            $training_imgErr = '<font color="#bf0006">'."Image Size Too Large".'</font>';
            $training_Error = 1;
        }

        // Handle old image deletion if it exists
        $old_image_query = mysqli_query($spider_tech_db, "SELECT training_image FROM trainings_tb WHERE id = '$training_id'");
        $old_image = mysqli_fetch_assoc($old_image_query)['training_image'];
        if (!empty($old_image) && file_exists($old_image)) {
            unlink($old_image);  // Delete the old image
        }

    } else {
        // If no image is uploaded, keep the old image path in the update
        $old_image_query = mysqli_query($spider_tech_db, "SELECT training_image FROM trainings_tb WHERE id = '$training_id'");
        $path = mysqli_fetch_assoc($old_image_query)['training_image'];
    }

    // Validate other form fields
    if (empty($training_name)) {
        $training_nameErr = '<font color="#bf0006">Training name is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_description)) {
        $training_descriptionErr = '<font color="#bf0006">Training description is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_details)) {
        $training_detailsErr = '<font color="#bf0006">Training details is required.</font>';
        $training_Error = 1;
    }
    if (empty($training_icon)) {
        $training_iconErr = '<font color="#bf0006">Training icon is required.</font>';
        $training_Error = 1;
    }

    // If no errors, proceed to update
    if ($training_Error == 0) {
        if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
            // Resize and save new image
            foreach ($size as $w => $h) {
                $files[] = resize($w, $h);
            }

            // Update training with new image
            $update_record = mysqli_query($spider_tech_db, "UPDATE trainings_tb SET 
                training_name = '$training_name', training_description = '$training_description', 
                training_details = '$training_details', training_icon = '$training_icon', 
                training_image = '$path'
                WHERE id = '$training_id'") or die(mysqli_error($spider_tech_db));
        } else {
            // Update project without changing the image
            $update_record = mysqli_query($spider_tech_db, "UPDATE trainings_tb SET 
                training_name = '$training_name', training_description = '$training_description', 
                        training_details = '$training_details', training_icon = '$training_icon'
                WHERE id = '$training_id'") or die(mysqli_error($spider_tech_db));
        }

        // Success message
        $training_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                    Success, record updated.
                                </div>';
    }
} // End of form submission// end of edit training

if(isset($_POST['enquiry']))
{
	$enquiry_statusErr="";
	$status_Error=0;
	$enquiry_status_success_msg="";
	$enquiry_status_error_counter = "";
	$enquiry_status=mysqli_real_escape_string($spider_tech_db, $_POST['enquiry_status']);
	$enquiry_id=mysqli_real_escape_string($spider_tech_db, $_POST['enquiry_id']);	
	
	
	/*check for empty field*/
	if(empty($enquiry_status))
	{
		$enquiry_statusErr='<font color="#bf0006">'."Enquiry status is required.".'</font>';
		$status_Error=1;
		}
	if($status_Error == 0)
	{
		/**update reservation record */
		$update_record = mysqli_query($spider_tech_db, "UPDATE enquiry_tb SET 
		enquiry_status = '$enquiry_status' 
		WHERE enquiry_id = '$enquiry_id'");
		$enquiry_status_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
		Success, record updated.
	</div>'; 
		
	}//end of service_category_Error	
}//end of first if


/*manage projects*/
if(isset($_POST['add_project']))
{
	$project_nameErr = "";
	$project_descriptionErr = "";
	$service_nameErr = "";
	$project_yearErr = "";
	$project_imgErr = "";
	$project_Error = 0;
	$project_success_msg = "";
	$project_error_counter = "";
	$project_name = mysqli_real_escape_string($spider_tech_db, $_POST['project_name']);
	$project_description = mysqli_real_escape_string($spider_tech_db, $_POST['project_description']);	
	$service_name = mysqli_real_escape_string($spider_tech_db, $_POST['service_name']);
	$project_year = mysqli_real_escape_string($spider_tech_db, $_POST['project_year']);
	$_SESSION['img_name'] = mt_rand(0, getrandmax());

	//include image resize function   
	include('img_function.php');
	// settings
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$size = array(900 => 590);

	$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

	$new_name = $_SESSION['img_name']. '.' . $ext;
	
	$path = '../images/pictures/'.$new_name;
	
	/*check for empty field*/
	if(empty($project_name))
	{
		$project_nameErr='<font color="#bf0006">'."Project name is required.".'</font>';
		$project_Error = 1;
		}
	if(empty($service_name))
	{
		$service_nameErr='<font color="#bf0006">'."Service is required.".'</font>';
		$project_Error = 1;
		}	
	if(empty($project_description))
	{
		$project_descriptionErr='<font color="#bf0006">'."Project description is required.".'</font>';
		$project_Error = 1;
		}
	if(empty($project_year))
	{
		$project_yearErr='<font color="#bf0006">'."Project year is required.".'</font>';
		$project_Error = 1;
		}	    
	if(empty($_FILES['img']['tmp_name']))
	{
	$project_imgErr = '<font color="#bf0006">'."No file is selected.".'</font>';
	$project_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && (($ext != "jpg") &&  ($ext != "png") && ($ext != "gif") && ($ext != "jpeg")))
	{
	$project_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
	$project_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && ($_FILES['img']['size'] > 3000000))
	{
	$project_imgErr = '<font color="#bf0006">'."Larger Image Size".'</font>';
	$project_Error = 1;
	}
	if((!empty($_FILES['img']['tmp_name'])) && (file_exists($path)))
	{
	$project_imgErr = '<font color="#bf0006">'."Similar File Exist".'</font>';
	$project_Error = 1;
	}	
	if($project_Error == 0)
	{
		//check if record already exist
		$project_query = mysqli_query($spider_tech_db, "SELECT * FROM projects_tb WHERE project_name = '$project_name' 
		AND project_description = '$project_description'") or die(mysqli_error($spider_tech_db));
		$project_row=mysqli_num_rows($project_query);
		if($project_row > 0)
		{
			$project_error_counter = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger">
											Record exist. You cannot add same record twice.
										  </div>';
			}
		elseif($project_row == 0)
		{
		
		$insert_record = mysqli_query($spider_tech_db, "INSERT INTO projects_tb (project_name, project_description, service_id, project_year, project_pic) 
		VALUES('$project_name', '$project_description', '$service_name', '$project_year', '$path')") or die(mysqli_error($spider_tech_db)) ;
        unset($_POST);
		$project_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
									Success, new record added.
								</div>';		
		}
	}//end of project_Error
	
}//end of first if


if(isset($_POST['edit_project'])) {
    // Initialize error variables
    $project_nameErr = "";
    $project_descriptionErr = "";
    $service_nameErr = "";
    $project_yearErr = "";
    $project_imgErr = "";
    $project_Error = 0;
    $project_success_msg = "";
    $project_error_counter = "";

    // Escape user inputs
    $project_name = mysqli_real_escape_string($spider_tech_db, $_POST['project_name']);
    $project_description = mysqli_real_escape_string($spider_tech_db, $_POST['project_description']);
    $service_name = mysqli_real_escape_string($spider_tech_db, $_POST['service_name']);
    $project_year = mysqli_real_escape_string($spider_tech_db, $_POST['project_year']);
    $project_id = mysqli_real_escape_string($spider_tech_db, $_POST['project_id']);

    // Check for the existence of the file
    if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
        $_SESSION['img_name'] = mt_rand(0, getrandmax()); // Generate a unique image name
        
        // Include image resize function
        include('img_function.php');

        // Allowable file extensions
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $size = array(900 => 590); // Thumbnail sizes

        // Get file extension
        $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        // Generate a new name for the image
        $new_name = $_SESSION['img_name']. '.' . $ext;
        $path = '../images/pictures/'.$new_name;
        
        // Validate image format and size
        if (!in_array($ext, $valid_exts)) {
            $project_imgErr = '<font color="#bf0006">'."Unsupported File Format".'</font>';
            $project_Error = 1;
        }
        if ($_FILES['img']['size'] > 3000000) {
            $project_imgErr = '<font color="#bf0006">'."Image Size Too Large".'</font>';
            $project_Error = 1;
        }

        // Handle old image deletion if it exists
        $old_image_query = mysqli_query($spider_tech_db, "SELECT project_pic FROM projects_tb WHERE project_id = '$project_id'");
        $old_image = mysqli_fetch_assoc($old_image_query)['project_pic'];
        if (!empty($old_image) && file_exists($old_image)) {
            unlink($old_image);  // Delete the old image
        }

    } else {
        // If no image is uploaded, keep the old image path in the update
        $old_image_query = mysqli_query($spider_tech_db, "SELECT project_pic FROM projects_tb WHERE project_id = '$project_id'");
        $path = mysqli_fetch_assoc($old_image_query)['project_pic'];
    }

    // Validate other form fields
    if (empty($project_name)) {
        $project_nameErr = '<font color="#bf0006">'."Project name is required.".'</font>';
        $project_Error = 1;
    }
    if (empty($service_name)) {
        $service_nameErr = '<font color="#bf0006">'."Service is required.".'</font>';
        $project_Error = 1;
    }
    if (empty($project_description)) {
        $project_descriptionErr = '<font color="#bf0006">'."Project description is required.".'</font>';
        $project_Error = 1;
    }
    if (empty($project_year)) {
        $project_yearErr = '<font color="#bf0006">'."Project year is required.".'</font>';
        $project_Error = 1;
    }

    // If no errors, proceed to update
    if ($project_Error == 0) {
        if (isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
            // Resize and save new image
            foreach ($size as $w => $h) {
                $files[] = resize($w, $h);
            }

            // Update project with new image
            $update_record = mysqli_query($spider_tech_db, "UPDATE projects_tb SET 
                project_name = '$project_name', 
                project_description = '$project_description', 
                service_id = '$service_name', 
                project_year = '$project_year', 
                project_pic = '$path'
                WHERE project_id = '$project_id'") or die(mysqli_error($spider_tech_db));
        } else {
            // Update project without changing the image
            $update_record = mysqli_query($spider_tech_db, "UPDATE projects_tb SET 
                project_name = '$project_name', 
                project_description = '$project_description', 
                service_id = '$service_name', 
                project_year = '$project_year'
                WHERE project_id = '$project_id'") or die(mysqli_error($spider_tech_db));
        }

        // Success message
        $project_success_msg = '<div class="col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                    Success, record updated.
                                </div>';
    }
} // End of form submission
?>
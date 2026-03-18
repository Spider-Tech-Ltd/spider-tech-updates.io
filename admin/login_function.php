<?php 
require('db_function/function.php');
if(isset($_POST['uname']) ) 
{
    
$unameError="";
$pwordError="";
$loginMSG="";
$loginError=0;

$uname = mysqli_real_escape_string($spider_tech_db, $_POST['uname']);
$pword = mysqli_real_escape_string($spider_tech_db, $_POST['pword']);
if(empty($uname))
{
	echo '<div class="alert alert-danger" role="alert">'."admin_name cannot be empty".'</div>';
	$loginError = 1;
	}
elseif(empty($pword))
	{
		echo '<div class="alert alert-danger" role="alert">'."Password cannot be empty".'</div>';
		$loginError = 1;
		}
elseif($loginError == 0)
{
//Decryping Password

$login_search = mysqli_query($spider_tech_db, "SELECT admin_name, admin_password, privilege FROM admin_tb WHERE admin_name='$uname' AND admin_password='$pword'") 
or die(mysqli_error($spider_tech_db));
$record = mysqli_num_rows($login_search);
$privilage = mysqli_fetch_assoc($login_search);
if($record == 0)
	{
	echo '<div class="alert alert-danger" role="alert">'."admin_name or password in correct.".'</div>';
	}
	elseif($record > 0)
	{
	  if($privilage['privilege'] == 'Super Admin')
	  {
          $_SESSION['s_position'] = $privilage['privilege'];
	      $update_lastlogin=mysqli_query($spider_tech_db, "UPDATE admin_tb SET lastlogin=NOW() WHERE admin_name='$uname'");
          
          echo '<script>window.location.href = "dashboard.php"</script>';
	  }
    }
}
}

?>
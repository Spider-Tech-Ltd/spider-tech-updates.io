<?php
require('../includes/connect.php');

session_start();
$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

$update_success = false; // Flag to indicate successful update

if (isset($_POST['update'])) {
    $project_name = htmlspecialchars($_POST['project_name']);
    $project_description = $_POST['project_description'];
    $service_name = htmlspecialchars($_POST['service_name']);
    $project_year = htmlspecialchars($_POST['project_year']);

    if(!empty($_FILES['image']['name'])){
    /** give random name to image */
    $image_new_name = mt_rand(0, getrandmax());
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $image = $image_new_name. '.' . $ext;
    
    //$image = htmlspecialchars($_FILES['image']['name']);
    $image_size = htmlspecialchars($_FILES['image']['size']);
    $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
    $image_folder = '../images/study-case/'.$image;
    }
    
    $project_nameError = "";
    $project_descriptionError = "";  
    $service_nameError = "";
    $project_yearError = "";
    $error=0;

    if(empty($project_name)){
        $project_nameError = "<span class='error'>Project name is required!</span>";
        $error=1;
    }

    if(empty($project_description)){
        $project_descriptionError = "<span class='error'>Project description is required!</span>";
        $error=1;
    }

    if(empty($service_name)){
        $service_nameError = "<span class='error'>Service name is required!</span>";
        $error=1;
    }

    if(empty($project_year)){
        $project_yearError = "<span class='error'>Project year is required!</span>";
        $error=1;
    }


    if ($error == 0) {
        
        $update_post = $conn->prepare("UPDATE projects_tb SET project_name=?, project_description=?, service_id=?, project_year=? WHERE project_id=?");
        $update_post->execute([$project_name, $project_description, $service_name, $project_year, $get_id]);

        if (!empty($image)) {
            $select_image = $conn->prepare("SELECT * FROM projects_tb WHERE project_pic=?");
            $select_image->execute([$image]);

            if ($select_image->rowCount() > 0 && $image != '') {
                $message .= "<span class='error'>Image name repeated!</span><br>";
            } elseif ($image_size > 2000000) {
                $message .= "<span class='error'>Image size is too large!</span><br>";
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $update_post = $conn->prepare("UPDATE projects_tb SET project_pic=? WHERE project_id=?");
                $update_post->execute([$image, $get_id]);
            }
        }


        if (empty($project_nameError && $project_descriptionError && $service_nameError && $project_yearError)) {
            $update_success = true; // Set flag to true when update is successful
        }
    }
}

if(isset($_POST['delete_image'])){
    $empty_image = "";
    $select_image = $conn->prepare("SELECT * FROM `projects_tb` WHERE project_id=?");
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['project_pic'] !=''){
        unlink('../images/study-case/'.$fetch_image['project_pic']);
    }
    $unset_image = $conn->prepare("UPDATE `projects_tb` SET project_pic=? WHERE project_id=?");
    $unset_image->execute([$empty_image, $get_id]);
    $message="<span class='green'>Image deleted!</span>";
}

$stmt = $conn->query("SELECT * FROM services_tb");
$record=$stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<!-- head section begin-->
<?php include '../includes/admin_head.php'; ?>
<!-- head section close-->

<body>

<main class="main-wrapper">
    <!-- admin sidebar begin-->
    <?php include '../includes/admin_sidebar.php'; ?>
    <!-- admin sidebar close-->

    <section class="dashboard">
        <!-- header begin-->
        <?php include '../includes/admin_header.php'; ?>
        <!-- header close-->

        <div class="content-form">
            <h2 class="heading">Update Project</h2>

            <?php
            $select_posts = $conn->prepare("SELECT * FROM projects_tb p INNER JOIN services_tb s ON  p.service_id = s.id WHERE project_id=?");
            $select_posts->execute([$get_id]);
            if ($select_posts->rowCount() > 0) {
                $fetch_project = $select_posts->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Name <span>*</span></p>
                <input type="text" name="project_name" class="box"  maxlength="1000" value="<?php echo stripslashes($fetch_project['project_name']); ?>">
                <?php if (isset($_POST['update'])) { echo $project_nameError; } ?>

                    <p class="blue"> Service Name <span>*</span></p>
                     <select name="service_name" class="box">
                        <option value="<?php echo stripslashes($fetch_project['service_id']); ?>" selected><?php echo stripslashes($fetch_project['service_name']); ?></option>
                        <?php do{?>
                        <option value="<?php echo stripslashes($record['id']); ?>" ><?php echo stripslashes($record['service_name']); ?></option>
                        <?php }while($record=$stmt->fetch(PDO::FETCH_ASSOC));?>
                     </select>
                     <?php if(isset($_POST['save'])){ echo $service_nameError;} ?>

                     <p class="blue">Description <span>*</span></p>
                     <textarea id="summernote"  name="project_description"  class="box"  maxlength="10000"
                     placeholder="project description... " ><?php echo stripslashes($fetch_project['project_description']); ?></textarea>
                     <?php if (isset($_POST['update'])) { echo $project_descriptionError; } ?>

                     <p class="blue"> Year Awarded <span>*</span></p>
                     <input type="text" id="project_year" name="project_year" value="<?php echo stripslashes($fetch_project['project_year']); ?>" class="box" placeholder="Year awarded"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $project_yearError;} ?>


                <p class="blue">Image</p>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <?php
                        if($fetch_project['project_pic'] != ''){
                     ?>
                     <img src="../images/study-case/<?= $fetch_project['project_pic'] ?>" alt="" class="image">
                     <input type="submit" value="Delete image" name="delete_image" onclick="return confirm('Are you sure you want to delete this image?');">
                     <?php
                            }
                     ?>
                

                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            } else {
                header('location:view_service.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('Project updated successfully!');
    window.location.href = 'projects.php'; // Redirect to the services view page after alert
</script>
<?php endif; ?>
<script type="text/javascript">
      $(function() {
         $( "#project_year" ).datepicker({dateFormat: 'yy'});
      });
   </script>
</body>
</html>

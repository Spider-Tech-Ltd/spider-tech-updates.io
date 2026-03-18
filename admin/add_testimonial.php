<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_POST['save'])){
        $name =htmlspecialchars($_POST['name']);
        $organization = htmlspecialchars($_POST['organization']);
        $title = htmlspecialchars($_POST['title']);
        $testimonial = htmlspecialchars($_POST['testimonial']);
        

        $image = htmlspecialchars($_FILES['image']['name']);
        $image_size = htmlspecialchars($_FILES['image']['size']);
        $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_folder = '../images/testimonial/'.$image;

        $nameError = "";  
        $organizationError = "";
        $titleError = "";
        $testimonialError = "";
        $imageError = "";
        $error=0;
        $message = "";
        $post_message = "";

        if(empty($name)){
            $nameError = "<span class='error'>Name is required!</span>";
            $error=1;
        }

        if(empty($organization)){
            $organizationError = "<span class='error'>Organization is required!</span>";
            $error=1;
        }

        if(empty($title)){
            $titleError = "<span class='error'>Title is required!</span>";
            $error=1;
        }

        if(empty($testimonial)){
            $testimonialError = "<span class='error'>Testimonial is required!</span>";
            $error=1;
        }



        if($error==0){
            $select_image = $conn->prepare("SELECT * FROM `testimonials_tb` WHERE image=?");
            $select_image->execute([$image]);

            if(isset($image)){
                if($select_image->rowcount() > 0 AND $image !=''){
                    $message = "<span class='error'>Image name repeated!</span>";
                }elseif($image_size > 2000000){
                    $message = "<span class='error'>Image size is too large!</span>";
                }else{
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
            }else{
                $image = "";
            }

            if($select_image->rowcount() > 0 AND $image !=''){
                $message = "<span class='red'>Please rename your image</span>";
            }else{
                $insert_testimonial = $conn->prepare("INSERT INTO `testimonials_tb` ( name, organization, title, testimonial, image)
                VALUES (?,?,?,?,?)");
                $insert_testimonial->execute([$name,$organization, $title, $testimonial, $image]);
                if($insert_testimonial->rowCount() > 0){
                    echo "<script>alert('Testimonial added successfully!');</script>";
                }
            }
        }
    }
    

?>

<!DOCTYPE html>
<html lang="en">
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
                <h2 class="heading">Add Testimonial</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <p class="blue">Name <span>*</span></p>
                    <input type="text" name="name" class="box" placeholder="client name"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $nameError;} ?>

                     <p class="blue">Organization <span>*</span></p>
                     <input type="text" name="organization" class="box" placeholder="client organization"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $organizationError;} ?>
                     

                     <p class="blue">Title <span>*</span></p>
                     <input type="text" name="title" class="box" placeholder="client title"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $titleError;} ?>

                     <p class="blue">Testimonial <span>*</span></p>
                     <textarea name="testimonial"  class="box"  maxlength="10000" ></textarea>
                     <?php if(isset($_POST['save'])){ echo $testimonialError;} ?>

                     <p class="blue">Image</p>
                     <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, 
                     image/webp" class="box">
                     <?php if(isset($_POST['save'])){ echo $message;} ?>
                     

                     <input type="submit" value="Save" name="save" class="darker-btn btn">

           
    </section>
</body>
</html>
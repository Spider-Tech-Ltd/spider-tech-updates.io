<?php
    require('../includes/connect.php');
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_POST['save'])){
        $event_title = htmlspecialchars($_POST['event_title']);
        $event_content = htmlspecialchars($_POST['event_content']);
        $event_detail = $_POST['event_detail'];
        $event_date = htmlspecialchars($_POST['event_date']);
        $event_time = htmlspecialchars($_POST['event_time']);
        $event_address = htmlspecialchars($_POST['event_address']);
        $event_status = htmlspecialchars(isset($_POST['event_status']) ? $_POST['event_status'] : '');
        $training_id = htmlspecialchars($_POST['training_id']);

        /** give random name to image */
        $image_new_name = mt_rand(0, getrandmax());
	    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
	    $image = $image_new_name. '.' . $ext;
	
        
        //$image = htmlspecialchars($_FILES['image']['name']);
        $image_size = htmlspecialchars($_FILES['image']['size']);
        $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_folder = '../images/events/'.$image;

        $event_titleError = "";
        $event_contentError = "";
        $event_detailError = "";
        $event_dateError = ""; 
        $event_timeError = "";
        $event_addressError = "";
        $event_statusError = "";
        $error=0;

        if(empty($event_title)){
            $event_titleError = "<span class='error'>Event title is required!</span>";
            $error=1;
        }

        if(empty($event_content)){
            $event_contentError = "<span class='error'>Event content is required!</span>";
            $error=1;
        }

        if(empty($event_detail)){
            $event_detailError = "<span class='error'>Event detail is required!</span>";
            $error=1;
        }


        if(empty($event_date)){
            $event_dateError = "<span class='error'>Event date is required!</span>";
            $error=1;
        }

        if(empty($event_time)){
            $event_timeError = "<span class='error'>Event time is required!</span>";
            $error=1;
        }

        if(empty($event_address)){
            $event_addressError = "<span class='error'>Event address is required!</span>";
            $error=1;
        }

        if(empty($event_status)){
            $event_statusError = "<span class='error'>Event status is required!</span>";
            $error=1;
        }
 

        if($error==0){
           
            $select_image = $conn->prepare("SELECT * FROM `events` WHERE event_img=?");
            $select_image->execute([$image]);

            if(isset($image)){
                if($select_image->rowcount() > 0 AND $image !=''){
                    $message = "<span class='error'>Image name repeated!</span>";
                }elseif($image_size > 2000000){
                    $message = "<span class='error'>Image size is too large!</span>";
                }else{
                    $message = "";
                }
            }else{
                $image = "";
            }

            if($select_image->rowcount() > 0 AND $image !=''){
                $message = "<span class='red'>Please rename your image</span>";
            }else{
                $select_event_title = $conn->prepare("SELECT * FROM `events` WHERE event_title=?");
                $select_event_title->execute([$event_title]);
                if($select_event_title->rowcount() > 0 ){
                    echo "<script>alert('Error occured. Event exist!');</script>";
                }
                else{
                    $insert_event = $conn->prepare("INSERT INTO `events` (event_title, event_content, event_detail, event_date, event_time,
                    event_address, event_status, training_id, event_img)
                    VALUES (?,?,?,?,?,?,?,?,?)");
                    $insert_event->execute([$event_title, $event_content, $event_detail, $event_date, $event_time,
                    $event_address, $event_status, $training_id, $image]);
                    if($insert_event->rowCount() > 0){
                        move_uploaded_file($image_tmp_name, $image_folder);
                        echo "<script>alert('Event added successfully!');</script>";
                    }
                }
            }    
        }
    }

   
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
            <div class="content">
                <h2 class="heading">Add Event</h2>
                <div class="flex-items">
                    <a href="events.php" class="add">Back to List</a>
                </div>
            </div>
            <div class="content-form">
                
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <p class="blue">Event Title <span>*</span></p>
                    <input type="text" name="event_title" class="box" placeholder="Event Title"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $event_titleError;} ?>

                     <p class="blue">Event Content <span>*</span></p>
                     <textarea  name="event_content"  class="box"
                     rows="3"  maxlength="10000" placeholder="Event content... " ></textarea>
                     <?php if(isset($_POST['save'])){ echo $event_contentError;} ?>

                     <p class="blue">Event Details <span>*</span></p>
                     <textarea id="summernote"  name="event_detail"  class="box"  maxlength="10000"
                      ></textarea>
                     <?php if (isset($_POST['save'])) { echo $event_detailError; } ?>

                     <p class="blue">Event Date <span>*</span></p>
                     <input type="date" name="event_date" class="box" placeholder="Event Date"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $event_dateError;} ?>

                     <p class="blue">Event Time <span>*</span></p>
                     <input type="time" name="event_time" class="box" placeholder="Event Time"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $event_timeError;} ?>


                     <p class="blue">Event Address <span>*</span></p>
                    <input type="text" name="event_address" class="box" placeholder="Event Address"
                     maxlength="1000" class="box" >
                     <?php if(isset($_POST['save'])){ echo $event_addressError;} ?>

                     <p class="blue">Event Status <span>*</span></p>
                     <select name="event_status" class="box" >
                        <option value="" selected disabled >--Event Status--</option>
                        <option value="Past">Past</option>
                        <option value="Upcoming">Upcoming</option>
                     </select>
                     <?php if(isset($_POST['save'])){ echo $event_statusError;} ?>

                     <!-- Training Selection Dropdown -->
                    <p class="blue">Select Training <span>*</span></p>
                    <select name="training_id" class="box">
                        <option value="" selected disabled>--Select Training--</option>
                        <?php
                        $select_trainings = $conn->prepare("SELECT * FROM `trainings_tb`");
                        $select_trainings->execute();
                        if($select_trainings->rowCount() > 0){
                        while($fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value='" . $fetch_training['id'] . "'>" . $fetch_training['training_name'] . "</option>";
                        }
                    }
                        ?>
                    </select>


                     <p class="blue">Image</p>
                     <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, 
                     image/webp" class="box">
                     

                    <input type="submit" value="Save" name="save" class="darker-btn btn">

                </form>
            </div>
        </section>
    </main>
</body>
</html>
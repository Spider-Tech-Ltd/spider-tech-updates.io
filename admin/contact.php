<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    $about_id = isset($_GET['about_id']) ? intval($_GET['about_id']) : 0;

    if(!isset($admin_id)){
        header('location:admin_login.php');
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
           
            <div class="content-form">
              <h2 class="heading">Contact Details</h2>
               
              <div class="about">
         
              <?php
                $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
                $contact_details->execute();
                $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);
                 
              ?>

              <form action="" method="post" class="box">
                <p class="contact-p">Contact Address</p>
                <div class="contact"><?= $fetch_contact['contact_address']; ?></div>

                <p class="contact-p">Contact Email</p>
                <div class="contact"><?= $fetch_contact['contact_email']; ?></div>

                <p class="contact-p">Contact Phone No.</p>
                <div class="contact"><?= $fetch_contact['contact_pno']; ?></div>

                <a href="update_contact.php?id=<?php echo stripslashes($fetch_contact['contact_id'])?>" class="view-button">Update</a>

              </form>
              
                         </div>        
                         
                      </section>
                </main>    
                </body>
              </html>
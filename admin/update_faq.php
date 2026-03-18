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
    $question = $_POST['question'];
    $answer = $_POST['answer'];


    $error = 0;
    $questionError = "";
    $answerError = "";
    

    
    if(empty($question)){
        $questionError = "<span class='error'>faq question is required!</span>";
        $error=1;
    }

    if(empty($answer)){
        $answerError = "<span class='error'>Faq answer is required!</span>";
        $error=1;
    }

    
    if ($error == 0) {
        
        $update_post = $conn->prepare("UPDATE faq_tb SET faq_question=?, faq_answer=? WHERE faq_id=?");
        $update_post->execute([$question, $answer, $get_id]);

        

        if (empty($questionError && $answerError )) {
            $update_success = true; // Set flag to true when update is successful
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

           
            <div class="content-form">
                <h2 class="heading">Add FAQ</h2>

                <?php
                $select_faq = $conn->prepare("SELECT * FROM faq_tb WHERE faq_id=?");
                $select_faq->execute([$get_id]);
                if ($select_faq->rowCount() > 0) {
                $fetch_faq = $select_faq->fetch(PDO::FETCH_ASSOC);
            ?>

                <form action="" method="post" enctype="multipart/form-data">
                    
                    <p class="blue">Question <span>*</span></p>
                    <input type="text" name="question" class="box" 
                     maxlength="1000" class="box" value="<?php echo stripslashes($fetch_faq['faq_question']); ?>">
                     <?php if(isset($_POST['update'])){ echo $questionError;} ?>

                     <p class="blue">Answer <span>*</span></p>
                     <textarea id="summernote" name="answer"  class="box"  maxlength="10000"
                      ><?php echo stripslashes($fetch_faq['faq_answer']); ?></textarea>
                     <?php if(isset($_POST['update'])){ echo $answerError;} ?>

                     

                    <input type="submit" value="Update" name="update" class="darker-btn btn">

                </form>
                <?php
            } else {
                header('location:view_faq.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('faq updated successfully!');
    window.location.href = 'faq.php'; // Redirect to the services view page after alert
</script>
<?php endif; ?>
</body>
</html>
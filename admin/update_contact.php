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
    $address = $_POST['address'];
    $email = $_POST['email'];
    $pno = $_POST['pno'];


    $error = 0;
    $addressError = "";
    $emailError = "";
    $pnoError = "";
    $message = "";

    if (empty($address)) {
        $addressError .= "<span class='error'>Address is required!</span><br>";
        $error = 1;
    }

    if (empty($email)) {
        $emailError .= "<span class='error'>Email is required!</span><br>";
        $error = 1;
    }

    if (empty($pno)) {
        $pnoError .= "<span class='error'>Phone number is required!</span><br>";
        $error = 1;
    }


    if ($error == 0) {
        $update_contact = $conn->prepare("UPDATE contact_details SET contact_address=?, contact_email=?, contact_pno=? WHERE contact_id=?");
        $update_contact->execute([$address, $email, $pno, $get_id]);

        if (empty($addressError && $emailError && $pnoError)) {
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
            <h2 class="heading">Update Contact Details</h2>

            <?php
            $select_contact = $conn->prepare("SELECT * FROM contact_details WHERE contact_id=?");
            $select_contact->execute([$get_id]);
            if ($select_contact->rowCount() > 0) {
                $fetch_contact = $select_contact->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Contact Address <span>*</span></p>
                <input type="text" name="address" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_contact['contact_address']); ?>">
                <?php if (isset($_POST['update'])) { echo $addressError; } ?>

                <p class="blue">Contact Email <span>*</span></p>
                <input type="email" name="email" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_contact['contact_email']); ?>">
                <?php if (isset($_POST['update'])) { echo $emailError; } ?>

                <p class="blue">Contact Pno <span>*</span></p>
                <input type="text" name="pno" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_contact['contact_pno']); ?>">
                <?php if (isset($_POST['update'])) { echo $pnoError; } ?>

                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            } else {
                header('location:contact.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('Contact details updated successfully!');
    window.location.href = 'contact.php'; // Redirect to the contact view page after alert
</script>
<?php endif; ?>

</body>
</html>

<?php
require('../includes/connect.php');

session_start();
$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($admin_id)) {
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

            <div class="content">
                <h2 class="heading">Event Media</h2>
                <div class="content-form read-post" id="about">
                    <?php
                    $select_event = $conn->prepare("SELECT * FROM events WHERE event_id=?");
                    $select_event->execute([$get_id]);
                    if ($select_event->rowCount() > 0) {
                        $fetch_event = $select_event->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <form action="" method="post" class="box">
                        <div class="slideshow-box">
                            <?php 
                            $select_media = $conn->prepare("SELECT * FROM events_media WHERE event_id=?");
                            $select_media->execute([$get_id]);
                            $slideIndex = 0;
                            while($fetch_media = $select_media->fetch(PDO::FETCH_ASSOC)){
                                $slideIndex++;
                            ?>
                            <div class="slides">
                                <img src="../images/events/<?= htmlspecialchars($fetch_media['event_pics_name']); ?>" alt="event media">
                            </div>
                            <?php
                            }
                            ?>
                            <!-- Next and previous buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                        <br>

                        <!-- The dots/circles -->
                        <div style="text-align:center">
                            <?php for ($i = 1; $i <= $slideIndex; $i++) { ?>
                            <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
                            <?php } ?>
                        </div>

                        <div class="title"><?= htmlspecialchars(stripslashes($fetch_event['event_title'])); ?></div>
                        <div class="flex-btn">
                            <a href="update_media.php?id=<?= stripslashes($fetch_event['event_id']); ?>" class="edit-btn btn">Update</a>
                            <a href="events.php" class="view-btn btn">Go back</a>
                        </div>
                    </form>
                    <?php
                    } else {
                        echo "<p>No media found for this event.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <script src="../js/slideshow.js"></script>
</body>
</html>

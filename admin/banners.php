<?php
require('../includes/connect.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit; // Ensure no further code execution after redirection
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
    
            <div class="content banner-slider">
                <h2 class="heading">Page Banners</h2>
            
                 <i class="fas fa-angle-left arrows prev"></i>
                 <i class="fas fa-angle-right arrows next"></i>
                 <div class="banner-wrapper box-container">
                 <?php
                    $select_banners = $conn->prepare("SELECT * FROM `banners_tb` ");
                    $select_banners->execute();
                    if ($select_banners->rowCount() > 0) {
                        while ($fetch_banner = $select_banners->fetch(PDO::FETCH_ASSOC)) {
                            
                        
                 ?>
                     <div class="banner">
                         <img src="../images/banners/<?= $fetch_banner['banner_image']; ?>" alt="" class="slider-image">
                         <div class="banner-info">
                             <div><?= $fetch_banner['banner_title']; ?></div>
                             <a href="update_banner.php?id=<?php echo stripslashes($fetch_banner['banner_id'])?>" class="view-button">Update</a>
                         </div>
                     </div>


               
               <?php
               }
            }?>
            </div>
        </section>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script type="text/javascript">
$(document).ready(function() {
    $('.banner-wrapper').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        nextArrow: $('.next'),
        prevArrow: $('.prev'),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
</script>
</body>
</html>

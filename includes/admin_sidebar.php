<section class="admin-sidebar active">
    

    <a href="dashboard.php" class="sidebar-title">Admin <span>Panel</span></a>

    <div class="profile">
        <?php
           $select_profile =$conn->prepare("SELECT*FROM `admin_tb` WHERE admin_id=?");
           $select_profile->execute([$admin_id]);
           $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p><?= $fetch_profile['admin_name']; ?></p>
        <a href="update_profile.php" class="btn">Update Profile</a>
    </div>
    
    <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
        <a href="../admin/services.php"><i class="fas fa-laptop-code"></i><span>Services</span></a>
        <a href="../admin/about.php"><i class="fas fa-info-circle"></i><span>About</span></a>
        <a href="../admin/banners.php"><i class="fas fa-image"></i><span>Page banners</span></a>
        <a href="../admin/projects.php"><i class="fas fa-folder"></i><span>Projects</span></a>
        <a href="../admin/events.php"><i class="fas fa-calendar"></i><span>Events</span></a>
        <a href="../admin/trainings.php"><i class="fas fa-users"></i><span>Trainings</span></a>
        <a href="../admin/testimonials.php"><i class="fas fa-comment"></i><span>Testimonials</span></a>
        <a href="../admin/faq.php"><i class="fas fa-question-circle"></i><span>FAQ</span></a>
        <a href="../admin/contact.php"><i class="fas fa-phone"></i><span>Contact</span></a>
        <a href="../admin/messages.php"><i class="fas fa-envelope"></i><span>Messages</span></a>
        <a href="../admin/admin_accounts.php"><i class="fas fa-user"></i><span>Accounts</span></a>
        <a href="admin_login.php" ><i class="fas fa-sign-in-alt"></i><span>Login</span></a>
        <a href="register_admin.php"><i class="fas fa-user-plus"></i><span>Register</span></a>
        <a href="../includes/admin_logout.php"  onclick="return confirm('logout from the website');">
            <i class="fas fa-sign-out-alt color-red"></i><span class="color-red">Logout</span>
        </a>
    </nav>


</section>
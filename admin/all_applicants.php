<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Query applicants
$applicants_query = mysqli_query($spider_tech_db, "SELECT * FROM dse_application ORDER BY id DESC") or die(mysqli_error($spider_tech_db));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head-section.html'); ?>
</head>

<body class="<?php require('body-tag-css.html'); ?>">
    <div class="page-wrapper">
        <!-- Header -->
        <?php require('header-section.php'); ?>

        <div class="page-container">
            <!-- Sidebar -->
            <?php require('side-menu-section.php'); ?>

            <!-- Page Content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    
                    <div class="page-bar">
                        <h1 class="page-title">Digital Skills &amp; Entrepreneurship Applicants</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_trainings.php">Trainings</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">DSE Applicants</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Registered Program Candidates</header>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40px;">#</th>
                                                    <th>Candidate Name</th>
                                                    <th>Contact Information</th>
                                                    <th>Demographics</th>
                                                    <th>Business / Enterprise</th>
                                                    <th>Sector</th>
                                                    <th>Registration / CAC</th>
                                                    <th>Applied On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($applicants_query && mysqli_num_rows($applicants_query) > 0): ?>
                                                    <?php 
                                                    $no = 1;
                                                    while ($row = mysqli_fetch_assoc($applicants_query)): 
                                                        $fullName = trim($row['firstname'] . ' ' . ($row['middlename'] ? $row['middlename'] . ' ' : '') . $row['lastname']);
                                                    ?>
                                                        <tr>
                                                            <td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $no++; ?></td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($fullName); ?></strong>
                                                            </td>
                                                            <td>
                                                                <div><a href="mailto:<?= htmlspecialchars($row['email']); ?>" style="color: var(--admin-primary);"><?= htmlspecialchars($row['email']); ?></a></div>
                                                                <small class="text-muted"><i class="fa fa-phone"></i> <?= htmlspecialchars($row['phone_no']); ?></small>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill table-pill-slate"><?= htmlspecialchars($row['gender'] ?? 'N/A'); ?> (<?= htmlspecialchars($row['age'] ?? 'Age'); ?>)</span>
                                                            </td>
                                                            <td>
                                                                <strong style="color: #334155;"><?= htmlspecialchars($row['business_name'] ?? 'Individual'); ?></strong>
                                                                <?php if (!empty($row['business_location'])): ?>
                                                                    <div class="text-muted" style="font-size: 0.78rem;"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($row['business_location']); ?></div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill table-pill-orange"><?= htmlspecialchars($row['business_sector'] ?? 'General'); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; font-size: 0.84rem;"><?= htmlspecialchars($row['cac_no'] ?: 'SMEDAN: ' . ($row['smedan'] ?: 'Pending')); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; color: #64748b; font-size: 0.84rem;"><?= htmlspecialchars($row['apply_date']); ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Page Content -->
        </div>

        <!-- Footer -->
        <?php require('footer-section.html'); ?>
    </div>

    <!-- JS includes -->
    <?php require('js-section.html'); ?>
</body>
</html>

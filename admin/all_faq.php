<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Handle delete
if (isset($_GET['delete_faq'])) {
    $faq_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_faq']);
    $delete_query = mysqli_query($spider_tech_db, "DELETE FROM faq_tb WHERE faq_id='$faq_id' LIMIT 1");

    if ($delete_query) {
        header('Location: all_faq.php?success=' . urlencode('FAQ deleted successfully.'));
        exit();
    } else {
        header('Location: all_faq.php?error=' . urlencode('Failed to delete FAQ.'));
        exit();
    }
}

// Query FAQs
$faq_query = mysqli_query($spider_tech_db, "SELECT * FROM faq_tb ORDER BY faq_id DESC") or die(mysqli_error($spider_tech_db));

// Redirect to edit
if (isset($_GET['faq'])) {
    $faq_id = mysqli_real_escape_string($spider_tech_db, $_GET['faq']);
    $_SESSION['faq_id'] = $faq_id;
    header('location:edit_faq.php');
    exit();
}
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
                        <h1 class="page-title">Frequently Asked Questions</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_faq.php">FAQ</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">FAQ List</li>
                        </ol>
                    </div>

                    <!-- Alerts -->
                    <?php if ($success_message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;">
                            <i class="fa fa-check-circle m-r-10"></i> <?= htmlspecialchars($success_message); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php elseif ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">
                            <i class="fa fa-exclamation-circle m-r-10"></i> <?= htmlspecialchars($error_message); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Published Knowledge Base</header>
                                    <div class="tools">
                                        <a href="add_faq.php" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add New FAQ
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th>Question</th>
                                                    <th>Answer Summary</th>
                                                    <th class="text-right" style="width: 170px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($faq_query && mysqli_num_rows($faq_query) > 0): ?>
                                                    <?php 
                                                    $no = 1;
                                                    while ($row = mysqli_fetch_assoc($faq_query)): 
                                                        $fId = (int)$row['faq_id'];
                                                        $fQ = stripslashes($row['faq_question']);
                                                        $fA = strip_tags(stripslashes($row['faq_answer'] ?? ''));
                                                        $fAShort = mb_strimwidth($fA, 0, 60, '...');
                                                    ?>
                                                        <tr>
                                                            <td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $no++; ?></td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($fQ); ?></strong>
                                                            </td>
                                                            <td>
                                                                <span title="<?= htmlspecialchars($fA); ?>" style="color: #64748b; font-size: 0.85rem;">
                                                                    <?= htmlspecialchars($fAShort); ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="table-action-group">
                                                                    <a href="all_faq.php?faq=<?= $fId; ?>" class="btn-action-edit" title="Edit FAQ">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <a href="#" 
                                                                       data-delete-url="all_faq.php?delete_faq=<?= $fId; ?>" 
                                                                       data-item-name="<?= htmlspecialchars($fQ); ?>" 
                                                                       class="btn-action-delete trigger-delete-modal" 
                                                                       title="Delete FAQ">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </a>
                                                                </div>
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

<?php
require('../../includes/connect.php');
require('../../home_functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>
    
    <!-- Google Fonts for Forum styling & Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
      /* Hide top header for the forum */
      .header-top {
          display: none !important;
      }
      
      /* Hero Section Styles */
      .forum-hero-heading {
          font-family: 'Poppins', sans-serif; 
          color: #111111; 
          font-size: 3.5rem; 
          line-height: 1.2;
          font-weight: 800; 
      }
      .forum-hero-subtext {
          font-family: 'Open Sans', sans-serif; 
          color: #555555; 
          font-size: 1.25rem;
      }
      @media (max-width: 768px) {
          .forum-hero-heading { font-size: 2.5rem; }
          .forum-hero-subtext { font-size: 1rem; }
      }
      .forum-search-container {
         background-color: #ffffff; 
         border: 1px solid #e9ecef; 
         box-shadow: 0 4px 12px rgba(0,0,0,0.05);
         border-radius: 50px; 
         padding: 8px;
      }
      .forum-input-group {
         background-color: #f4f4f4; 
         border-radius: 50px; 
         border: 2px solid transparent;
         transition: all 0.3s ease;
      }
      .forum-input-group:focus-within {
         background-color: #ffffff;
         border-color: #f48221;
         box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.15);
      }
      .forum-search-input {
         height: 56px; 
         font-size: 1.1rem; 
         color: #262626;
         border-radius: 50px; 
         outline: none;
      }
      .forum-search-input:focus {
         background-color: transparent;
         box-shadow: none;
         outline: none;
      }
      .forum-btn-primary {
         background-color: #f48221; 
         color: #ffffff; 
         height: 56px; 
         padding: 0 24px; /* Reduced width */
         border-radius: 50px; 
         font-size: 1.05rem; /* Shrunk slightly */
         white-space: nowrap;
         border: none;
         transition: background-color 0.3s;
      }
      .forum-btn-primary:hover {
         background-color: #e6751c;
         color: #ffffff;
      }

      /* Category Grid Styles */
      .forum-category-card {
         background-color: #f8f9fa; /* slate-50 */
         border: 1px solid transparent;
         border-radius: 20px;
         transition: all 0.3s ease;
      }
      .forum-category-card:hover {
         border-color: rgba(244, 130, 33, 0.3);
         box-shadow: 0 10px 25px rgba(0,0,0,0.1);
         transform: translateY(-5px);
      }
      .forum-icon-wrapper {
         width: 56px;
         height: 56px;
         background-color: rgba(244, 130, 33, 0.1);
         color: #f48221;
         border-radius: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .forum-icon-wrapper .material-symbols-outlined {
         font-size: 32px;
      }
      .forum-topic-badge {
         background-color: #ffffff;
         color: #797979;
         padding: 6px 16px;
         border-radius: 50px;
         font-size: 0.85rem;
         font-weight: 600;
         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
      }
      .forum-view-link {
         color: #f48221;
         text-decoration: none;
         transition: all 0.3s;
      }
      .forum-view-link:hover {
         color: #e6751c;
         text-decoration: none;
      }
      .forum-view-link .material-symbols-outlined {
         font-size: 18px;
         vertical-align: middle;
         transition: margin-left 0.3s;
      }
      .forum-category-card:hover .forum-view-link .material-symbols-outlined {
         margin-left: 5px;
      }
    </style>
</head>
<body class="bg-white">
    <!-- ====== Preloader ====== -->
    <?php require('../../includes/preloader.html'); ?>

    <div class="wraper">
        <!-- ====== Header Starts ====== -->
        <?php require('../../header-section.php'); ?>  
        <!-- ====== Header End ====== --> 
        
        <!-- Inject Forum Hero Component -->
        <?php include('includes/hero.php'); ?>

        <!-- Inject Forum Categories Grid Component -->
        <?php include('includes/categories.php'); ?>

        <!-- Main Content Section: Feed + Sidebar -->
        <section class="forum-main-content py-5">
            <div class="container">
                <div class="row">
                    <!-- Left Column: Discussion Feed -->
                    <div class="col-lg-8">
                        <?php include('includes/feed.php'); ?>
                    </div>
                    
                    <!-- Right Column: Sidebar Widgets -->
                    <div class="col-lg-4">
                        <?php include('includes/sidebar.php'); ?>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- ====== Wraper End ====== --> 

    <!-- ====== Footer Start ====== -->
    <?php require('../../footer-section.php'); ?>
    <!-- ====== Footer End ====== --> 
    
    <?php require('../../javascript-section.html'); ?>
</body>
</html>

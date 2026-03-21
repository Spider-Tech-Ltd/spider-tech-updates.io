<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../../includes/connect.php');
require('../../home_functions.php');
?>
<!doctype html>
<html lang="en">

<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>
    <title>Spider Tech | Insights & Research Hub</title>

    <!-- Material Symbols for Blog UI -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary-orange: #f48221;
            --primary-dark: #262626;
            --bg-light: #f9fafb;
        }

        /* Standard Project Wrapper */
        .wraper {
            position: relative;
            background-color: var(--bg-light);
            display: block;
            width: 100%;
        }

        .blog-wrapper {
            background-color: var(--bg-light);
            padding-top: 150px;
            padding-bottom: 100px;
            display: block;
            width: 100%;
            clear: both;
        }

        /* Hero Section Refinement */
        .blog-hero {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
        }

        .hero-eyebrow-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 18px;
            border-radius: 50px;
            background-color: rgba(244, 130, 33, 0.12);
            border: 1px solid rgba(244, 130, 33, 0.25);
            font-family: 'Poppins', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #f48221;
            margin-bottom: 25px;
        }

        .hero-eyebrow-pill .material-symbols-outlined {
            font-size: 16px;
        }

        .blog-hero h1 {
            font-size: 56px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .blog-hero h1 span {
            color: var(--primary-orange);
        }

        .blog-hero p {
            font-size: 18px;
            max-width: 720px;
            margin: 0 auto;
            color: #797979;
            line-height: 1.7;
        }

        /* Filter Pills */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .filter-pill {
            padding: 10px 28px;
            border-radius: 50px;
            background: #fff;
            border: 1px solid #eee;
            font-weight: 600;
            font-size: 13px;
            color: #797979;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-pill.active,
        .filter-pill:hover {
            background: var(--primary-orange);
            color: #fff;
            border-color: var(--primary-orange);
            box-shadow: 0 4px 14px rgba(244, 130, 33, 0.2);
        }

        /* Research Card Grid Spacing */
        .research-card-col {
            margin-bottom: 50px !important;
        }

        /* Synchronized Research Card */
        .research-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #eee;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .research-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border-color: rgba(244, 130, 33, 0.1);
        }

        .card-img-wrap {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #262626;
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .research-card:hover .card-img-wrap img {
            transform: scale(1.08);
        }

        .card-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(17, 24, 39, 0.7), transparent);
        }

        .card-category {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            z-index: 2;
        }

        .card-body-content {
            padding: 35px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body-content h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
            line-height: 1.3;
            transition: color 0.3s;
        }

        .research-card:hover h3 {
            color: var(--primary-orange);
        }

        .card-body-content p {
            font-size: 14px;
            color: #797979;
            line-height: 1.6;
            margin-bottom: 30px;
            flex-grow: 1;
        }

        .read-link {
            color: var(--primary-orange);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none !important;
        }

        .read-link i {
            font-size: 18px;
            transition: transform 0.3s;
        }

        .research-card:hover .read-link i {
            transform: translateX(5px);
        }

        /* Red Diagnostic Border to find the footer */
        .debug-footer-anchor {
            border: 2px solid red;
            background: #fff;
            padding: 10px;
            text-align: center;
            font-weight: 800;
            color: red;
            margin-top: 50px;
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

        <main class="blog-wrapper">
            <div class="container">

                <!-- Hero Section -->
                <div class="blog-hero">
                    <span class="hero-eyebrow-pill">
                        <span class="material-symbols-outlined">auto_awesome</span>
                        Industrial Knowledge Base
                    </span>
                    <h1>Technical Intelligence & <br><span>Global Impact</span></h1>
                    <p>Exploring the industrial frontier through rigorous technical research, engineering analysis, and data-driven case studies.</p>
                </div>

                <!-- Filter Navigation -->
                <div class="filter-container">
                    <div class="filter-pill active">All Research</div>
                    <div class="filter-pill">AI & Data</div>
                    <div class="filter-pill">Cybersecurity</div>
                    <div class="filter-pill">Engineering</div>
                    <div class="filter-pill">Cloud</div>
                    <div class="filter-pill">Robotics</div>
                </div>

                <!-- Research Grid -->
                <div class="row">

                    <!-- Card 1 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop" alt="Security">
                                <div class="card-category">[ Security ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Quantum-Resistant Encryption Protocols</h3>
                                <p>An analysis of post-quantum cryptographic standards and their integration into existing industrial infrastructure.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1558494949-ef0109124b24?q=80&w=2031&auto=format&fit=crop" alt="Engineering">
                                <div class="card-category">[ Engineering ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Industrial Edge Computing Paradigms</h3>
                                <p>Reducing latency in manufacturing plants through decentralized processing units and real-time data orchestration.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop" alt="Logistics">
                                <div class="card-category">[ AI & Data ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Predictive Supply Chain 4.0</h3>
                                <p>Utilizing neural networks to forecast global logistics disruptions and optimize multi-modal freight routes.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=2070&auto=format&fit=crop" alt="Energy">
                                <div class="card-category">[ Energy ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Automated Grid Resilience Systems</h3>
                                <p>Self-healing microgrid technologies for high-density urban environments and industrial complexes.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=2070&auto=format&fit=crop" alt="Networking">
                                <div class="card-category">[ AI & Data ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Neural Network Optimization</h3>
                                <p>Techniques for pruning and quantizing large language models for deployment on resource-constrained hardware.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="col-lg-4 col-md-6 research-card-col">
                        <div class="research-card">
                            <div class="card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1531746790731-6c087fecd65a?q=80&w=2006&auto=format&fit=crop" alt="Robotics">
                                <div class="card-category">[ Robotics ]</div>
                            </div>
                            <div class="card-body-content">
                                <h3>Subsurface Robotics Research</h3>
                                <p>Autonomous navigation and sensory fusion in zero-visibility environments for deep-sea and mining operations.</p>
                                <a href="pages/blog/article-detail.php" class="read-link">
                                    Read Insight <i class="material-symbols-outlined">trending_flat</i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <!-- ====== Footer Start ====== -->
    <?php require('../../footer-section.php'); ?>
    <!-- ====== Footer End ====== -->

    <?php require('../../javascript-section.html'); ?>
</body>

</html>
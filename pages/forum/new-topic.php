<?php
/**
 * Start Discussion Page — Phase 7
 * Page for members to compose and publish new topics.
 * Architecture: Bootstrap 4 + Vanilla CSS.
 */
require('../../includes/connect.php');
require('../../home_functions.php');

// Simulated member data
$member = [
    'name'       => 'James Harrison',
    'initials'   => 'JH',
    'role'       => 'Verified Member',
];
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Open+Sans:wght@400;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <title>Start a New Discussion — Spider Tech Forum</title>

    <style>
      /* ============================
         BASE & LAYOUT
         ============================ */
      body { background-color: #f8f9fa; }
      .header-top { display: none !important; }
      .new-topic-wrapper { 
        padding-top: 160px; 
        padding-bottom: 120px; 
        display: block;
        min-height: 80vh;
        background-color: #f8f9fa;
      } 

      /* ============================
         COMPOSITION HEADER
         ============================ */
      .comp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
      }
      .comp-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.8rem;
        color: #111111;
        margin-bottom: 0;
      }
      .btn-discard {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #555555;
        background-color: #f1f3f5;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s;
      }
      .btn-discard:hover {
        background-color: #e9ecef;
        color: #111111;
      }

      /* ============================
         EDITOR CARD
         ============================ */
      .editor-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
      }

      /* Title Input */
      .topic-title-input {
        width: 100%;
        border: none;
        border-bottom: 2px solid #f1f3f5;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        padding: 10px 0;
        margin-bottom: 24px;
        color: #111111;
        transition: border-color 0.3s ease;
      }
      .topic-title-input:focus {
        outline: none;
        border-color: #f48221;
      }
      .topic-title-input::placeholder { color: #ced4da; }

      /* Field Label */
      .field-label {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        color: #111111;
        margin-bottom: 12px;
        display: block;
      }

      /* Category Pills */
      .cat-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 32px;
      }
      .cat-pill {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 6px 16px;
        border-radius: 50px;
        border: 1.5px solid #e9ecef;
        background: #f8f9fa;
        color: #555555;
        cursor: pointer;
        transition: all 0.2s;
      }
      .cat-pill:hover { border-color: #f48221; color: #f48221; }
      .cat-pill.active {
        background-color: #f48221;
        border-color: #f48221;
        color: #ffffff;
      }

      /* Rich Text Editor Placeholder */
      .editor-area-wrapper {
        background: #f8f9fa;
        border-radius: 12px;
        border: 1.5px solid #e9ecef;
        overflow: hidden;
        margin-bottom: 24px;
      }
      .editor-toolbar {
        background: #ffffff;
        padding: 10px 15px;
        border-bottom: 1.5px solid #e9ecef;
        display: flex;
        gap: 15px;
      }
      .tool-btn {
        background: none;
        border: none;
        color: #5f5e5e;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: background 0.2s;
      }
      .tool-btn:hover { background: #f1f3f5; color: #f48221; }
      .tool-btn .material-symbols-outlined { font-size: 20px; }

      .editor-textarea {
        width: 100%;
        min-height: 300px;
        padding: 20px;
        background: transparent;
        border: none;
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
        line-height: 1.6;
        color: #333333;
        resize: vertical;
      }
      .editor-textarea:focus { outline: none; }

      /* Tags Input */
      .tags-input-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8f9fa;
        border: 1.5px solid #e9ecef;
        padding: 8px 15px;
        border-radius: 50px;
      }
      .tags-input-wrapper input {
        border: none;
        background: transparent;
        flex: 1;
        font-size: 0.85rem;
      }
      .tags-input-wrapper input:focus { outline: none; }

      /* ============================
         SIDEBAR WIDGETS
         ============================ */
      .sidebar-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 24px;
      }
      .sidebar-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        color: #111111;
        margin-bottom: 16px;
      }
      .guidelines-list {
        padding-left: 0;
        list-style: none;
        margin-bottom: 0;
      }
      .guidelines-list li {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.85rem;
        color: #555555;
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
      }
      .guidelines-list li .material-symbols-outlined {
        font-size: 16px;
        color: #f48221;
        flex-shrink: 0;
      }

      /* Action Section */
      .action-card {
        background: #fffbf7;
        border: 1px dashed #f48221;
      }
      .btn-post {
        width: 100%;
        background-color: #f48221;
        color: #ffffff;
        border: none;
        padding: 14px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(244, 130, 33, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 15px;
      }
      .btn-post:hover {
        background-color: #db7015;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(244, 130, 33, 0.35);
      }

      .visibility-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-top: 1px solid #f1f3f5;
      }
      .visibility-label {
        font-size: 0.8rem;
        color: #797979;
        font-weight: 600;
      }

      /* Toggle Switch */
      .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
      }
      .switch input { opacity: 0; width: 0; height: 0; }
      .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #e9ecef;
        transition: .4s;
        border-radius: 34px;
      }
      .slider:before {
        position: absolute;
        content: "";
        height: 18px; width: 18px;
        left: 3px; bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
      }
      input:checked + .slider { background-color: #f48221; }
      input:checked + .slider:before { transform: translateX(20px); }

      /* Responsive */
      @media (max-width: 991px) {
        .new-topic-wrapper { padding-top: 80px; }
        .comp-title { font-size: 1.5rem; }
        .editor-card { padding: 25px; }
      }
    </style>
</head>
<body>
    <!-- ====== Preloader ====== -->
    <?php require('../../includes/preloader.html'); ?>

    <div class="wraper">
        <!-- ====== Global Header ====== -->
        <?php require('../../header-section.php'); ?>

        <div class="new-topic-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Composition Header -->
                        <div class="comp-header">
                            <h1 class="comp-title">Start a New Discussion</h1>
                            <button class="btn-discard">Discard Draft</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Main Editor Column -->
                    <div class="col-lg-8">
                        <section class="editor-card">
                            <!-- Title Input -->
                            <input type="text" class="topic-title-input" placeholder="Discussion Title..." autofocus>

                            <!-- Category Selection -->
                            <label class="field-label">Select Category</label>
                            <div class="cat-pill-group">
                                <div class="cat-pill active">Manufacturing</div>
                                <div class="cat-pill">Automation</div>
                                <div class="cat-pill">Energy</div>
                                <div class="cat-pill">AI & Robotics</div>
                                <div class="cat-pill">Infrastructure</div>
                            </div>

                            <!-- Rich Text Editor Placeholder -->
                            <label class="field-label">Discussion Content</label>
                            <div class="editor-area-wrapper">
                                <div class="editor-toolbar">
                                    <button class="tool-btn" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                                    <button class="tool-btn" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
                                    <button class="tool-btn" title="Link"><span class="material-symbols-outlined">link</span></button>
                                    <button class="tool-btn" title="Code"><span class="material-symbols-outlined">code</span></button>
                                    <button class="tool-btn" title="Image"><span class="material-symbols-outlined">image</span></button>
                                </div>
                                <textarea class="editor-textarea" placeholder="Describe your industrial challenge or update here..."></textarea>
                            </div>

                            <!-- Tags -->
                            <label class="field-label">Tags (Optional)</label>
                            <div class="tags-input-wrapper">
                                <span class="material-symbols-outlined" style="font-size:18px; color:#adb5bd;">label</span>
                                <input type="text" placeholder="Add up to 3 technical tags (e.g. SCADA, IoT, Solar)">
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar Column -->
                    <div class="col-lg-4">
                        <!-- Action Card -->
                        <div class="sidebar-card action-card">
                            <button class="btn-post">
                                <span class="material-symbols-outlined">send</span>
                                Post Discussion
                            </button>
                            <div class="visibility-toggle">
                                <span class="visibility-label">Public visibility</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <p style="font-size: 0.75rem; color: #797979; margin-top: 10px; margin-bottom: 0;">
                                Your topic will be visible to all members and indexed in search results.
                            </p>
                        </div>

                        <!-- Community Guidelines -->
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">Community Guidelines</h3>
                            <ul class="guidelines-list">
                                <li>
                                    <span class="material-symbols-outlined">check_circle</span>
                                    <span>Search before posting to avoid duplicates.</span>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined">check_circle</span>
                                    <span>Use descriptive titles that summarize the core challenge.</span>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined">check_circle</span>
                                    <span>Keep discussions professional and technical.</span>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined">check_circle</span>
                                    <span>Be respectful and helpful to other engineers.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ====== Footer ====== -->
    <?php require('../../footer-section.php'); ?>

    <?php require('../../javascript-section.html'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Pill Toggle
            const pills = document.querySelectorAll('.cat-pill');
            pills.forEach(pill => {
                pill.addEventListener('click', function() {
                    pills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Discard Prompt
            document.querySelector('.btn-discard').addEventListener('click', function() {
                if(confirm('Are you sure you want to discard this draft? Your progress will be lost.')) {
                    window.location.href = 'pages/forum/feed.php';
                }
            });

            // Post Discussion Simulation
            document.querySelector('.btn-post').addEventListener('click', function() {
                alert('Success! Your discussion has been posted to the community.');
                window.location.href = 'pages/forum/feed.php';
            });
        });
    </script>
</body>
</html>

<?php
/**
 * Forum Categories Section — Phase 2 Redesign
 * Generated via Stitch MCP (screen: c2148b30758c437eaf290c0b1b25405e)
 * Translated to Bootstrap 4 + Vanilla CSS
 */
?>

<style>
  /* ====== Explore Categories Styles ====== */
  .forum-categories-section {
    background-color: #f8f9fa;
    padding: 80px 0;
  }

  .section-header-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 40px;
    gap: 16px;
  }

  .section-title-group {
    flex: 1;
  }

  .section-heading {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.8rem;
    color: #111111;
    margin-bottom: 8px;
    line-height: 1.2;
  }

  .section-subtitle {
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    color: #555555;
    margin-bottom: 0;
  }

  .view-all-link {
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
    color: #f48221;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s ease;
    white-space: nowrap;
    margin-bottom: 6px; /* align with baselineish of heading */
  }

  .view-all-link:hover {
    opacity: 0.8;
    color: #f48221;
    text-decoration: none;
  }

  /* Category Card */
  .category-card {
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none !important;
  }

  .category-card:hover {
    transform: translateY(-5px);
    border-color: #f48221;
    box-shadow: 0 10px 20px rgba(244, 130, 33, 0.1);
  }

  /* Icon Wrapper */
  .category-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background-color: rgba(244, 130, 33, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    transition: background-color 0.3s ease;
  }

  .category-icon-wrap .material-symbols-outlined {
    color: #f48221;
    font-size: 24px;
    transition: color 0.3s ease;
  }

  .category-card:hover .category-icon-wrap {
    background-color: #f48221;
  }

  .category-card:hover .category-icon-wrap .material-symbols-outlined {
    color: #ffffff;
  }

  .category-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    color: #111111;
    margin-bottom: 12px;
  }

  .category-desc {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.9rem;
    color: #555555;
    line-height: 1.6;
    margin-bottom: 24px;
    flex-grow: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Card Footer */
  .category-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid #f1f1f1;
  }

  .topic-count-badge {
    background-color: #f1f1f1;
    color: #555555;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
  }

  .view-topics-btn {
    color: #f48221;
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    transition: text-decoration 0.2s;
  }

  .category-card:hover .view-topics-btn {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .section-header-row {
      flex-direction: column;
      align-items: flex-start;
      margin-bottom: 32px;
    }
    .view-all-link { margin-top: 12px; }
    .forum-categories-section { padding: 56px 0; }
  }
</style>

<section class="forum-categories-section">
  <div class="container">
    
    <!-- Section Header -->
    <div class="section-header-row">
      <div class="section-title-group">
        <h2 class="section-heading">Explore Categories</h2>
        <p class="section-subtitle">Browse discussions by topic and find your community.</p>
      </div>
      <a href="#" class="view-all-link">
        View All <span class="material-symbols-outlined">arrow_forward</span>
      </a>
    </div>

    <!-- Categories Grid -->
    <div class="row">
      <!-- Category 1: Startup Advice -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">rocket_launch</span>
          </div>
          <h3 class="category-name">Startup Advice</h3>
          <p class="category-desc">Expert tips for scaling your business, fundraising, and product-market fit.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">1.2k Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>

      <!-- Category 2: Developer Hub -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">terminal</span>
          </div>
          <h3 class="category-name">Developer Hub</h3>
          <p class="category-desc">Coding, system architecture, API design, and modern framework debates.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">850 Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>

      <!-- Category 3: General Tech -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">dynamic_feed</span>
          </div>
          <h3 class="category-name">General Tech</h3>
          <p class="category-desc">Latest tech trends, global innovations, and industry shifts.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">2.1k Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>

      <!-- Category 4: Introductions -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">waving_hand</span>
          </div>
          <h3 class="category-name">Introductions</h3>
          <p class="category-desc">New here? Meet and greet the Spider Tech community.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">340 Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>

      <!-- Category 5: Hardware Review -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">memory</span>
          </div>
          <h3 class="category-name">Hardware Review</h3>
          <p class="category-desc">Deep dives into the latest gadgets, custom builds, and enterprise servers.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">620 Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>

      <!-- Category 6: Industry News -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="#" class="category-card">
          <div class="category-icon-wrap">
            <span class="material-symbols-outlined">newspaper</span>
          </div>
          <h3 class="category-name">Industry News</h3>
          <p class="category-desc">Global industry movements, mergers, acquisitions, and policy changes.</p>
          <div class="category-card-footer">
            <span class="topic-count-badge">970 Topics</span>
            <span class="view-topics-btn">View Topics →</span>
          </div>
        </a>
      </div>
    </div>

  </div>
</section>

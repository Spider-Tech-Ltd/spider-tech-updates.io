<?php
/**
 * Member Feed — Discussion Cards (Phase 2)
 * Full interactive feed with upvote, reply, bookmark.
 * Uses the approved Stitch "Forge & Filament" visual language.
 */
?>

<style>
  /* ============================
     MEMBER FEED
     ============================ */
  .member-feed-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
  }

  .member-feed-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.4rem;
    color: #111111;
    margin-bottom: 0;
  }

  .feed-count-badge {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.78rem;
    color: #797979;
    background-color: #f1f3f5;
    padding: 4px 12px;
    border-radius: 50px;
  }

  /* ============================
     DISCUSSION CARDS
     ============================ */
  .discussion-card-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .discussion-card {
    background-color: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(17, 17, 17, 0.05);
    border: 1px solid transparent;
    transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
    text-decoration: none !important;
    color: inherit;
    display: block;
  }

  .discussion-card:hover {
    border-color: rgba(244, 130, 33, 0.25);
    box-shadow: 0 8px 24px rgba(244, 130, 33, 0.08);
    transform: translateY(-3px);
    color: inherit;
    text-decoration: none !important;
  }

  /* Hot card highlight */
  .discussion-card.is-hot {
    border-left: 3px solid #e11d48;
  }

  /* Pinned card */
  .discussion-card.is-pinned {
    border-left: 3px solid #f48221;
    background-color: #fffbf7;
  }

  /* --- Card Top Row --- */
  .card-top-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    flex-wrap: wrap;
  }

  .category-badge {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background-color: #f48221;
    color: #ffffff;
    padding: 3px 12px;
    border-radius: 50px;
    white-space: nowrap;
  }

  .category-badge.cat-energy     { background-color: #ca8a04; }
  .category-badge.cat-automation { background-color: #0284c7; }
  .category-badge.cat-ai         { background-color: #7c3aed; }
  .category-badge.cat-logistics  { background-color: #059669; }
  .category-badge.cat-infra      { background-color: #374151; }

  .badge-hot-label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background-color: #fff0f3;
    color: #e11d48;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    padding: 3px 10px;
    border-radius: 50px;
  }

  .badge-hot-label .material-symbols-outlined {
    font-size: 13px;
    font-variation-settings: 'FILL' 1;
  }

  .badge-pinned-label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  /* --- Card Title --- */
  .card-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.05rem;
    color: #111111;
    line-height: 1.45;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
  }

  .discussion-card:hover .card-title {
    color: #f48221;
  }

  /* --- Card Excerpt --- */
  .card-excerpt {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.875rem;
    color: #555555;
    line-height: 1.6;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* --- Author Row --- */
  .card-author-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
  }

  .author-avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }

  .author-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #111111;
  }

  .author-time {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.78rem;
    color: #797979;
    margin-left: auto;
  }

  /* --- Interaction Bar --- */
  .card-interaction-bar {
    display: flex;
    align-items: center;
    gap: 4px;
    padding-top: 16px;
    border-top: 1px solid #f1f3f5;
  }

  .btn-interact {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    color: #797979;
    background: none;
    border: none;
    padding: 6px 12px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none !important;
  }

  .btn-interact .material-symbols-outlined {
    font-size: 17px;
    transition: font-variation-settings 0.2s;
  }

  .btn-interact:hover {
    background-color: rgba(244, 130, 33, 0.08);
    color: #f48221;
  }

  /* Upvote Interaction */
  .btn-upvote:hover {
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.08);
  }
  .btn-upvote.active {
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.1);
  }
  .btn-upvote.active .material-symbols-outlined {
    font-variation-settings: 'FILL' 1;
    transform: scale(1.2);
    transition: transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  /* Reply Interaction */
  .btn-reply:hover {
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.08);
  }
  .btn-reply:hover span:not(.material-symbols-outlined) {
    text-decoration: underline;
    text-decoration-color: #f48221;
  }

  /* Bookmark Interaction */
  .btn-bookmark:hover {
    color: #f59e0b;
    background-color: rgba(245, 158, 11, 0.08);
  }
  .btn-bookmark.bookmarked {
    color: #f59e0b;
  }
  .btn-bookmark.bookmarked .material-symbols-outlined {
    font-variation-settings: 'FILL' 1;
    transform: scale(1.1);
    transition: transform 0.1s ease;
  }

  /* spacer pushes bookmark to far right */
  .interact-spacer { flex: 1; }

  /* ============================
     PHASE 6: INLINE REPLY THREADS
     ============================ */
  .reply-thread-wrapper {
    display: none;
    margin-top: 16px;
    padding: 16px 20px;
    background-color: #f3f4f5; /* surface-container-low */
    border-radius: 12px;
    border-left: 2px solid #e9ecef;
    animation: fadeIn 0.3s ease;
  }
  
  .discussion-card.expanded .reply-thread-wrapper {
    display: block;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .reply-card {
    padding-bottom: 12px;
    margin-bottom: 12px;
    border-bottom: 1px solid #e1e3e4;
  }
  
  .reply-card:last-of-type {
    border-bottom: none;
    margin-bottom: 16px;
    padding-bottom: 0;
  }

  .reply-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
  }
  
  .reply-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .reply-author {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    color: #111111;
  }
  
  .reply-time {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.7rem;
    color: #797979;
  }

  .reply-body {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #555555;
    line-height: 1.5;
    padding-left: 32px; /* indent past avatar */
  }

  .reply-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-left: 32px;
    margin-top: 8px;
  }

  .btn-mini-interact {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.7rem;
    color: #797979;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.2s;
    padding: 0;
  }
  .btn-mini-interact:hover { color: #f48221; }
  .btn-mini-interact .material-symbols-outlined { font-size: 15px; }

  /* Write Reply Input */
  .reply-input-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 12px;
    position: relative;
  }
  
  .reply-input-row img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #e1e3e4;
  }

  .reply-input-field {
    flex: 1;
    background-color: #ffffff;
    border: 1px solid #e1e3e4;
    border-radius: 50px;
    padding: 10px 48px 10px 16px;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #111111;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  
  .reply-input-field:focus {
    outline: none;
    border-color: #f48221;
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
  }

  .btn-submit-reply {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    background-color: #f48221;
    color: #ffffff;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.1s;
  }
  .btn-submit-reply:hover { background-color: #db7015; }
  .btn-submit-reply:active { transform: translateY(-50%) scale(0.95); }
  .btn-submit-reply .material-symbols-outlined { font-size: 16px; }

  /* ============================
     MOBILE FAB
     ============================ */
  .member-fab-mobile {
    display: none; /* hidden on desktop */
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    background-color: #f48221; /* Primary Orange */
    color: #ffffff;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(244, 130, 33, 0.4);
    z-index: 1000;
  }
  .member-fab-mobile .material-symbols-outlined { font-size: 24px; }
  
  .member-fab-pulse-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid #f48221;
    animation: fabPulse 5s infinite cubic-bezier(0.25, 0.8, 0.25, 1);
  }
  
  @keyframes fabPulse {
    0% { transform: scale(1); opacity: 0.8; }
    20%, 100% { transform: scale(1.6); opacity: 0; }
  }

  /* ============================
     PAGINATION
     ============================ */
  .member-feed-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 40px;
  }

  .pag-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #f48221;
    background: none;
    border: 1.5px solid #f48221;
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.2s ease;
    text-decoration: none !important;
  }

  .pag-btn:hover {
    background-color: #f48221;
    color: #ffffff;
  }

  .pag-info {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #797979;
  }

  @media (max-width: 576px) {
    .discussion-card { padding: 18px; }
    .card-title { font-size: 0.95rem; }
    
    /* Give buttons more breathing room on mobile */
    .card-interaction-bar { gap: 16px; }
    
    /* Convert stat counts to badges on mobile */
    .btn-interact {
      position: relative;
      padding: 6px;
      margin-right: 12px;
    }
    .btn-interact span:not(.material-symbols-outlined) {
      display: flex;
      position: absolute;
      top: -4px;
      right: -14px;
      background-color: #f48221; /* primary orange */
      color: #ffffff;
      font-size: 0.6rem;
      padding: 2px 5px;
      border-radius: 20px;
      font-weight: 700;
      line-height: 1;
      border: 2px solid #ffffff;
      align-items: center;
      justify-content: center;
      min-width: 12px;
    }
    
    .btn-interact:hover span:not(.material-symbols-outlined),
    .btn-upvote.active span:not(.material-symbols-outlined) {
      background-color: #db7015; /* darker orange for active/hover */
    }

    .author-time { display: none; }
    .member-fab-mobile { display: flex; }
  }
</style>


<!-- Feed Header -->
<div class="member-feed-header">
  <h2 class="member-feed-title">Latest Discussions</h2>
  <span class="feed-count-badge">1,430 threads</span>
</div>

<!-- Discussion Cards -->
<div class="discussion-card-list" id="discussionFeed">

  <!-- Card 1: Manufacturing (Pinned) -->
  <a href="#" class="discussion-card is-pinned">
    <div class="card-top-row">
      <span class="category-badge">⚙️ Manufacturing</span>
      <span class="badge-pinned-label">
        <span class="material-symbols-outlined" style="font-size:13px; font-variation-settings:'FILL' 1;">push_pin</span>
        Pinned
      </span>
    </div>
    <h3 class="card-title">Community Guidelines &amp; Industrial Discussion Standards — Please Read Before Posting</h3>
    <p class="card-excerpt">Welcome to the Spider Tech Forum. This thread covers the ground rules for professional discussions, quality standards, and how to get the best out of our community of 5,200+ industry professionals.</p>
    <div class="card-author-row">
      <img src="https://ui-avatars.com/api/?name=Spider+Admin&background=f48221&color=fff&size=32" class="author-avatar-sm" alt="Admin">
      <span class="author-name">Spider Tech Admin</span>
      <span class="material-symbols-outlined" style="font-size:14px; color:#f48221; font-variation-settings:'FILL' 1;">verified</span>
      <span class="author-time">Always pinned</span>
    </div>
    <div class="card-interaction-bar">
      <button class="btn-interact btn-upvote" title="Upvote">
        <span class="material-symbols-outlined">thumb_up</span>
        <span class="vote-count">204</span>
      </button>
      <button class="btn-interact btn-reply" title="Replies">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span>58</span>
      </button>
      <div class="interact-spacer"></div>
      <button class="btn-interact btn-bookmark" title="Bookmark">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>
  </a>

  <!-- Card 2: AI & Robotics (HOT) -->
  <a href="#" class="discussion-card is-hot expanded">
    <div class="card-top-row">
      <span class="category-badge cat-ai">🧠 AI &amp; Robotics</span>
      <span class="badge-hot-label">
        <span class="material-symbols-outlined">local_fire_department</span> HOT
      </span>
    </div>
    <h3 class="card-title">How AI-Powered Predictive Maintenance Is Cutting Downtime by 40% in Heavy Manufacturing</h3>
    <p class="card-excerpt">Recent implementations across three major steel plants in South Africa have shown that ML-based anomaly detection on sensor data can pre-empt equipment failures days in advance — at a fraction of traditional inspection costs.</p>
    <div class="card-author-row">
      <img src="https://ui-avatars.com/api/?name=James+Harrison&background=f48221&color=fff&size=32" class="author-avatar-sm" alt="JH">
      <span class="author-name">James Harrison</span>
      <span class="author-time">2 hours ago</span>
    </div>
    <div class="card-interaction-bar">
      <button class="btn-interact btn-upvote" title="Upvote">
        <span class="material-symbols-outlined">thumb_up</span>
        <span class="vote-count">147</span>
      </button>
      <button class="btn-interact btn-reply" title="Replies">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span>63</span>
      </button>
      <div class="interact-spacer"></div>
      <button class="btn-interact btn-bookmark" title="Bookmark">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>

    <!-- PHASE 6: COLLAPSIBLE REPLY THREAD -->
    <div class="reply-thread-wrapper" onclick="event.preventDefault(); event.stopPropagation();">
      
      <!-- Thread Parent Reply 1 -->
      <div class="reply-card">
        <div class="reply-header">
          <img src="https://ui-avatars.com/api/?name=Sarah+B&background=7c3aed&color=fff&size=24" class="reply-avatar" alt="SB">
          <span class="reply-author">Sarah Boateng</span>
          <span class="reply-time">1 hour ago</span>
        </div>
        <div class="reply-body">
          This is exactly what we saw at the Durban facility. The hardest part wasn't the ML models, it was integrating the legacy SCADA outputs to feed the data lake in real-time.
        </div>
        <div class="reply-actions">
          <button class="btn-mini-interact"><span class="material-symbols-outlined">thumb_up</span> 12</button>
          <button class="btn-mini-interact"><span class="material-symbols-outlined">reply</span> Reply</button>
        </div>
      </div>

      <!-- Thread Parent Reply 2 -->
      <div class="reply-card">
        <div class="reply-header">
          <img src="https://ui-avatars.com/api/?name=David+M&background=059669&color=fff&size=24" class="reply-avatar" alt="DM">
          <span class="reply-author">David M.</span>
          <span class="reply-time">45 mins ago</span>
        </div>
        <div class="reply-body">
          What sensor brands are you using for vibration analysis? We're looking at upgrading our rotary kiln sensors next quarter and need high-frequency output.
        </div>
        <div class="reply-actions">
          <button class="btn-mini-interact"><span class="material-symbols-outlined">thumb_up</span> 5</button>
          <button class="btn-mini-interact"><span class="material-symbols-outlined">reply</span> Reply</button>
        </div>
      </div>

      <!-- Inline Reply Input -->
      <div class="reply-input-row">
        <img src="https://ui-avatars.com/api/?name=You&background=f48221&color=fff&size=32" alt="Me">
        <input type="text" class="reply-input-field" placeholder="Write a reply...">
        <button class="btn-submit-reply" title="Post Reply">
          <span class="material-symbols-outlined">arrow_upward</span>
        </button>
      </div>

    </div>
    <!-- /reply-thread-wrapper -->
  </a>

  <!-- Card 3: Automation -->
  <a href="#" class="discussion-card">
    <div class="card-top-row">
      <span class="category-badge cat-automation">🤖 Automation</span>
    </div>
    <h3 class="card-title">Comparing SCADA Systems for Mid-Scale Industrial Operations — 2026 Roundup</h3>
    <p class="card-excerpt">After evaluating Siemens WinCC, Ignition SCADA, and Wonderware, here are the key differentiators that matter for operations under 500 nodes. Cost, scalability, and OT/IT convergence support rated.</p>
    <div class="card-author-row">
      <img src="https://ui-avatars.com/api/?name=Alice+Mensah&background=0284c7&color=fff&size=32" class="author-avatar-sm" alt="AM">
      <span class="author-name">Alice Mensah</span>
      <span class="author-time">5 hours ago</span>
    </div>
    <div class="card-interaction-bar">
      <button class="btn-interact btn-upvote" title="Upvote">
        <span class="material-symbols-outlined">thumb_up</span>
        <span class="vote-count">89</span>
      </button>
      <button class="btn-interact btn-reply" title="Replies">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span>34</span>
      </button>
      <div class="interact-spacer"></div>
      <button class="btn-interact btn-bookmark" title="Bookmark">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>
  </a>

  <!-- Card 4: Energy -->
  <a href="#" class="discussion-card">
    <div class="card-top-row">
      <span class="category-badge cat-energy">⚡ Energy</span>
    </div>
    <h3 class="card-title">Solar-Diesel Hybrid Systems: Real Case Studies from Sub-Saharan Africa Industrial Sites</h3>
    <p class="card-excerpt">Three facilities share their 12-month operational data after switching from pure diesel to hybrid solar configurations. Energy cost savings ranged from 28% to 41% depending on load profiles.</p>
    <div class="card-author-row">
      <img src="https://ui-avatars.com/api/?name=Chris+Osei&background=059669&color=fff&size=32" class="author-avatar-sm" alt="CO">
      <span class="author-name">Chris Osei</span>
      <span class="author-time">Yesterday</span>
    </div>
    <div class="card-interaction-bar">
      <button class="btn-interact btn-upvote" title="Upvote">
        <span class="material-symbols-outlined">thumb_up</span>
        <span class="vote-count">72</span>
      </button>
      <button class="btn-interact btn-reply" title="Replies">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span>28</span>
      </button>
      <div class="interact-spacer"></div>
      <button class="btn-interact btn-bookmark" title="Bookmark">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>
  </a>

  <!-- Card 5: Logistics -->
  <a href="#" class="discussion-card">
    <div class="card-top-row">
      <span class="category-badge cat-logistics">🚚 Logistics</span>
    </div>
    <h3 class="card-title">Fleet Telematics ROI: When Does Real-Time GPS Tracking Actually Pay Off?</h3>
    <p class="card-excerpt">For fleets under 20 vehicles, the break-even is typically 7–14 months. For large operations, the equation changes significantly. A breakdown of hardware costs, software subscriptions, and measurable fuel savings.</p>
    <div class="card-author-row">
      <img src="https://ui-avatars.com/api/?name=Sarah+Boateng&background=7c3aed&color=fff&size=32" class="author-avatar-sm" alt="SB">
      <span class="author-name">Sarah Boateng</span>
      <span class="author-time">2 days ago</span>
    </div>
    <div class="card-interaction-bar">
      <button class="btn-interact btn-upvote" title="Upvote">
        <span class="material-symbols-outlined">thumb_up</span>
        <span class="vote-count">54</span>
      </button>
      <button class="btn-interact btn-reply" title="Replies">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span>19</span>
      </button>
      <div class="interact-spacer"></div>
      <button class="btn-interact btn-bookmark" title="Bookmark">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>
  </a>

</div>
<!-- /discussion-card-list -->

<!-- Pagination -->
<div class="member-feed-pagination">
  <a href="#" class="pag-btn">
    <span class="material-symbols-outlined">chevron_left</span> Previous
  </a>
  <span class="pag-info">Page 1 of 12</span>
  <a href="#" class="pag-btn">
    Next <span class="material-symbols-outlined">chevron_right</span>
  </a>
</div>

<!-- Mobile FAB -->
<a href="pages/forum/new-topic.php" class="member-fab-mobile">
  <span class="member-fab-pulse-ring"></span>
  <span class="material-symbols-outlined">edit</span>
</a>

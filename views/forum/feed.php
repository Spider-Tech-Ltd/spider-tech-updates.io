<?php
/**
 * Member Feed View
 */
?>
<!-- Google Fonts for Forum styling & Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

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
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    position: relative;
  }

  .read-full-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.75rem;
    color: #f48221;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    cursor: pointer;
    transition: color 0.2s;
    text-decoration: none !important;
  }
  .read-full-link:hover { color: #db7015; }
  .read-full-link .material-symbols-outlined { font-size: 14px; }

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

  /* Like Interaction */
  .btn-like:hover {
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.08);
  }
  .btn-like.active {
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.1);
  }
  .btn-like.active .material-symbols-outlined {
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

/* ============================
     PREMIUM THREADED REPLIES
     ============================ */
.replies-container {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #f1f3f5;
}

.reply-card-wrapper {
  position: relative;
  margin-bottom: 4px;
  transition: all 0.2s ease;
}

/* Vertical Thread Line */
.reply-nested::before {
  content: '';
  position: absolute;
  left: -14px;
  top: -12px; /* Connects to previous */
  bottom: 12px;
  width: 2px;
  background: #e9ecef;
  border-radius: 4px;
  transition: background 0.2s ease;
}

.reply-card-wrapper:hover > .reply-nested::before {
  background: #f48221; /* Highlight current branch */
}

.reply-card {
  padding: 10px 0 10px 12px;
  border-radius: 8px;
  transition: background 0.2s ease;
  background: transparent;
}

.reply-card:hover {
  background: rgba(244, 130, 33, 0.02);
}

.reply-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 4px;
}

.reply-avatar {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  border: 1.5px solid #ffffff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.reply-author {
  font-weight: 700;
  font-size: 0.82rem;
  color: #2d3436;
}

.reply-time {
  font-size: 0.75rem;
  color: #a0a0a0;
  font-weight: 400;
}

.reply-body {
  font-size: 0.9rem;
  line-height: 1.5;
  color: #4a4a4a;
  margin-left: 36px;
  margin-bottom: 6px;
}

.reply-actions {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-left: 36px;
}

.btn-mini-interact {
  background: none;
  border: none;
  padding: 0;
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.75rem;
  font-weight: 600;
  color: #8c8c8c;
  cursor: pointer;
  transition: color 0.2s;
}

.btn-mini-interact:hover {
  color: #f48221;
}

.btn-mini-interact .material-symbols-outlined {
  font-size: 16px;
  transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Like Bump Animation */
@keyframes like-bump {
  0% { transform: scale(1); }
  50% { transform: scale(1.4) translateY(-3px); }
  100% { transform: scale(1); }
}

.btn-interact.liked .material-symbols-outlined,
.btn-mini-interact.liked .material-symbols-outlined {
  animation: like-bump 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  color: #f48221 !important;
  font-variation-settings: 'FILL' 1;
}

.btn-mini-interact:hover .material-symbols-outlined {
  transform: scale(1.1);
}

.reply-input-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 16px;
  padding-top: 12px;
  border-top: 1px dashed #f1f3f5;
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

  .reply-to-tag {
    position: absolute;
    top: -24px;
    left: 44px;
    background-color: #fff7ed;
    color: #f48221;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 4px;
    border: 1px solid rgba(244, 130, 33, 0.2);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    z-index: 5;
    transition: all 0.3s ease;
  }

  .btn-submit-reply {
    position: absolute;
    right: 8px;
    top: calc(50% + 6px); /* Adjusted to account for container padding-top: 12px */
    transform: translateY(-50%);
    background-color: #f48221;
    color: #ffffff;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-submit-reply:hover { background-color: #db7015; transform: translateY(-50%) scale(1.05); }
  .btn-submit-reply:disabled { opacity: 0.5; cursor: not-allowed; }
  .btn-submit-reply .material-symbols-outlined { font-size: 18px; }

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

    .btn-interact:hover span:not(.material-symbols-outlined) {
      background-color: #db7015; /* darker orange for active/hover */
    }

    .author-time { display: none; }
    .member-fab-mobile { display: flex; }
  }

  /* ============================
     INLINE REPLIES UI
     ============================ */
  .reply-card-wrapper {
    position: relative;
    margin-top: 4px;
    margin-bottom: 4px;
  }
  .reply-nested::before {
    content: '';
    position: absolute;
    left: -14px;
    top: -12px;
    bottom: 12px;
    width: 2px;
    background: #e9ecef;
    border-radius: 4px;
    transition: background 0.2s ease;
  }
  .reply-card-wrapper:hover > .reply-nested::before {
    background: var(--spider-orange);
  }

  .reply-card {
    padding: 10px 0 10px 12px;
    border-radius: 8px;
    transition: background 0.2s ease;
    background: transparent;
  }
  .reply-card:hover { background: rgba(244, 130, 33, 0.02); }

  .reply-header { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
  .reply-avatar { width: 26px; height: 26px; border-radius: 50%; border: 1.5px solid #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
  .reply-author { font-weight: 700; font-size: 0.82rem; color: var(--spider-dark); }
  .reply-time { font-size: 0.75rem; color: #a0a0a0; }
  .reply-body { font-size: 0.9rem; line-height: 1.5; color: #4a4a4a; margin-left: 36px; margin-bottom: 6px; }
  .reply-actions { display: flex; align-items: center; gap: 16px; margin-left: 36px; }
  .btn-mini-interact { background: none; border: none; padding: 0; display: flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 600; color: #8c8c8c; cursor: pointer; transition: color 0.2s; }
  .btn-mini-interact:hover { color: var(--spider-orange); }

  /* Input Area */
  .reply-input-row { display: flex; align-items: center; gap: 12px; margin-top: 16px; padding-top: 16px; }
  .reply-field-container { position: relative; flex-grow: 1; }
  .reply-field { width: 100%; background-color: #f1f3f5; border: 1px solid transparent; border-radius: 50px; padding: 10px 50px 10px 18px; font-family: 'Open Sans', sans-serif; font-size: 0.875rem; }
  .reply-field:focus { outline: none; background-color: #ffffff; border-color: var(--spider-orange); }
  .btn-submit-pill { position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 32px; height: 32px; background-color: var(--spider-orange); color: #ffffff; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
  .btn-submit-pill:hover { background-color: #e6751c; transform: translateY(-50%) scale(1.05); }
  .btn-submit-pill:disabled { background-color: #d6d6d6; cursor: not-allowed; }
  .reply-to-tag { display: inline-flex; align-items: center; gap: 6px; background-color: #fffbf7; color: var(--spider-orange); font-family: 'Poppins'; font-weight: 700; font-size: 0.7rem; padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(244,130,33,0.1); margin-bottom: 8px; }

</style>

<?php include ROOT_PATH . '/views/forum/includes/feed-banner.php'; ?>

<!-- Filter Bar -->
<?php include ROOT_PATH . '/views/forum/includes/feed-filter-bar.php'; ?>

<section class="member-feed-section py-5" x-data="forumFeed()">
  <div class="container">
    <div class="row">
      <!-- Left Column: Discussion Feed -->
      <div class="col-lg-8">
        <!-- Feed Header -->
        <div class="member-feed-header">
          <h2 class="member-feed-title">Latest Discussions</h2>
          <span class="feed-count-badge" x-text="`${discussions.length} threads`"><?= count($feeds ?? []); ?> threads</span>
        </div>

        <!-- Discussion Cards -->
        <div class="discussion-card-list" id="discussionFeed">
          <div x-show="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading discussions...</p>
          </div>
          
          <template x-if="!loading && discussions.length === 0">
            <p class="text-center py-5 text-muted">No discussions found.</p>
          </template>

          <template x-for="feed in discussions" :key="feed.uuid">
            <div class="discussion-card" 
                 :class="{ 'is-pinned': feed.is_pinned, 'is-hot': feed.is_hot, 'expanded': expanded }"
                 x-data="feedCard(feed.uuid, feed.upvotes, feed.is_liked, feed.replies)">
              <div class="card-top-row">
                <span class="category-badge" x-text="feed.category_name"></span>
                <span class="badge-pinned-label" x-show="feed.is_pinned">
                  <span class="material-symbols-outlined" style="font-size:13px; font-variation-settings:'FILL' 1;">push_pin</span>
                  Pinned
                </span>
                <span class="badge-hot-label" x-show="feed.is_hot">
                  <span class="material-symbols-outlined">local_fire_department</span> HOT
                </span>
              </div>
              <a :href="`<?= BASE_URL ?>/forum/discussion?uuid=${feed.uuid}`" class="text-decoration-none">
                <h3 class="card-title" x-text="feed.title"></h3>
              </a>
              <div class="card-excerpt shadow-none border-0 p-0" x-html="feed.content"></div>
              <a :href="`<?= BASE_URL ?>/forum/discussion?uuid=${feed.uuid}`" class="read-full-link">
                Read Full Story <span class="material-symbols-outlined">arrow_forward</span>
              </a>
              <div class="card-author-row">
                <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(feed.author_name)}&background=f48221&color=fff&size=32`" class="author-avatar-sm" alt="Author">
                <span class="author-name" x-text="feed.author_name"></span>
                <span class="author-time" x-text="formatDate(feed.created_at)"></span>
              </div>
              <div class="card-interaction-bar">
                <button class="btn-interact btn-like" 
                        :class="{ 'liked': isLiked }" 
                        title="Like" 
                        @click="toggleLike()">
                  <span class="material-symbols-outlined" :style="isLiked ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                  <span class="vote-count" x-text="likes"></span>
                </button>
                <button class="btn-interact btn-reply" title="Replies" @click.prevent="expanded = !expanded">
                  <span class="material-symbols-outlined">chat_bubble</span>
                  <span class="reply-count" x-text="replies.length"></span>
                </button>
                <div class="interact-spacer"></div>
                <button class="btn-interact btn-bookmark" title="Bookmark">
                  <span class="material-symbols-outlined">bookmark</span>
                </button>
              </div>

              <!-- Collapsible Replies Area -->
              <div x-show="expanded" x-collapse class="replies-inline-container mt-3 pt-3 border-top">
                 <div class="replies-list pb-2">
                     <template x-for="reply in threadedReplies" :key="reply.uuid">
                         <div class="reply-card-wrapper" 
                              :style="`margin-left: ${Math.min(reply.depth * 32, 160)}px`"
                              :class="reply.depth > 0 ? 'reply-nested' : ''">
                             <div class="reply-card">
                                 <div class="reply-header">
                                     <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(reply.author_name)}&background=f48221&color=fff&size=26`" class="reply-avatar" alt="Avatar">
                                     <span class="reply-author" x-text="reply.author_name"></span>
                                     <span class="reply-time" x-text="formatTime(reply.created_at)"></span>
                                 </div>
                                 <div class="reply-body" x-text="reply.content"></div>
                                 <div class="reply-actions">
                                     <button class="btn-mini-interact" @click="toggleReplyLike(reply)" :class="{ 'liked': reply.is_liked }">
                                         <span class="material-symbols-outlined">thumb_up</span>
                                         <span x-text="reply.likes || 0"></span>
                                     </button>
                                     <button class="btn-mini-interact" @click="setReplyTo(reply.uuid, reply.author_name)">
                                         <span class="material-symbols-outlined">reply</span> Reply
                                     </button>
                                 </div>
                             </div>
                         </div>
                     </template>
                 </div>
                 
                 <!-- Input Row -->
                 <div class="reply-entry-area">
                    <div class="reply-to-tag" x-show="replyingToName" x-transition>
                        <span>Replying to <em x-text="replyingToName"></em></span>
                        <span class="material-symbols-outlined" style="font-size:12px; cursor:pointer;" @click="cancelReplyTo()">close</span>
                    </div>
                    <div class="reply-input-row border-0 pt-0 mt-0">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['member_name'] ?? 'Me') ?>&background=f48221&color=fff&size=32" style="width:32px; height:32px; border-radius:50%;" alt="Me">
                        <div class="reply-field-container">
                            <input type="text" 
                                   class="reply-field reply-input-field" 
                                   :placeholder="replyingToName ? `Write a reply...` : 'Share your thought...'"
                                   x-model="newReplyContent"
                                   @keydown.enter="submitReply()">
                            <button class="btn-submit-pill" @click="submitReply()" :disabled="submitting">
                                <span x-show="!submitting" class="material-symbols-outlined" style="font-size:18px;">arrow_upward</span>
                                <span x-show="submitting" class="spinner-border spinner-border-sm" role="status"></span>
                            </button>
                        </div>
                    </div>
                 </div>
              </div>

            </div>
          </template>
        </div>

        <!-- Pagination -->
        <div class="member-feed-pagination" x-show="totalPages > 1">
          <button class="pag-btn" @click="prevPage()" :disabled="currentPage <= 1" :style="currentPage <= 1 ? 'opacity:0.5; cursor:not-allowed;' : ''">
            <span class="material-symbols-outlined">chevron_left</span> Previous
          </button>
          <span class="pag-info">Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span></span>
          <button class="pag-btn" @click="nextPage()" :disabled="currentPage >= totalPages" :style="currentPage >= totalPages ? 'opacity:0.5; cursor:not-allowed;' : ''">
            Next <span class="material-symbols-outlined">chevron_right</span>
          </button>
        </div>
      </div>

      <!-- Right Column: Sidebar -->
      <div class="col-lg-4">
        <?php include ROOT_PATH . '/views/forum/includes/members-sidebar.php'; ?>
      </div>
    </div>
  </div>
</section>

<!-- Mobile FAB -->
<a href="<?= BASE_URL ?>/forum/new-topic" class="member-fab-mobile">
  <span class="member-fab-pulse-ring"></span>
  <span class="material-symbols-outlined">edit</span>
</a>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('forumFeed', () => ({
        discussions: [],
        loading: false,
        currentCategory: 'all',
        currentSort: 'latest',
        currentPage: <?= $current_page ?? 1 ?>,
        totalPages: <?= $total_pages ?? 1 ?>,

        init() {
            this.fetchDiscussions();
            
            // Listen for filter updates from the filter bar
            window.addEventListener('filter-changed', (e) => {
                if (e.detail.category !== undefined) this.currentCategory = e.detail.category;
                if (e.detail.sort !== undefined) this.currentSort = e.detail.sort;
                this.currentPage = 1; // Reset to page 1 on filter change
                this.fetchDiscussions();
            });
        },

        async fetchDiscussions() {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    category: this.currentCategory,
                    sort: this.currentSort,
                    page: this.currentPage
                });
                const response = await fetch(`<?= BASE_URL ?>/forum/feed/fetch?${params.toString()}`);
                const data = await response.json();
                if (data.success) {
                    this.discussions = data.feeds;
                    if (data.total_pages !== undefined) this.totalPages = data.total_pages;
                }
            } catch (error) {
                console.error('Error fetching discussions:', error);
            } finally {
                this.loading = false;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchDiscussions();
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchDiscussions();
            }
        },

        formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
        }
    }));

    Alpine.data('feedCard', (uuid, initialLikes, initialIsLiked, initialReplies) => ({
        uuid: uuid,
        likes: initialLikes,
        isLiked: initialIsLiked,
        replies: initialReplies,
        expanded: false,
        newReplyContent: '',
        parent_uuid: null,
        replyingToName: '',
        submitting: false,

        get threadedReplies() {
            const list = [];
            const map = {};
            
            this.replies.forEach(r => {
                const pid = r.parent_uuid || 'root';
                if (!map[pid]) map[pid] = [];
                map[pid].push(r);
            });

            const flatten = (pid, depth) => {
                if (!map[pid]) return;
                map[pid].sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                map[pid].forEach(child => {
                    list.push({ ...child, depth: depth });
                    flatten(child.uuid, depth + 1);
                });
            };

            flatten('root', 0);
            return list;
        },

        setReplyTo(replyUuid, authorName) {
            this.parent_uuid = replyUuid;
            this.replyingToName = authorName;
            this.expanded = true;
            this.$nextTick(() => {
                const input = this.$el.querySelector('.reply-input-field');
                if (input) input.focus();
            });
        },

        cancelReplyTo() {
            this.parent_uuid = null;
            this.replyingToName = '';
        },

        async toggleReplyLike(reply) {
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/like-reply', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        reply_uuid: reply.uuid,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    reply.likes = data.likes;
                    reply.is_liked = data.is_liked;
                } else {
                    alert(data.message);
                    if (data.message.includes('sign in')) window.location.href = '<?= BASE_URL ?>/forum/sign-in';
                }
            } catch (error) {
                console.error('Error toggling reply like:', error);
            }
        },

        async toggleLike() {
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/like', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        feed_uuid: this.uuid,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    this.likes = data.likes;
                    this.isLiked = data.is_liked;
                } else {
                    alert(data.message);
                    if (data.message.includes('sign in')) window.location.href = '<?= BASE_URL ?>/forum/sign-in';
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        },

        async submitReply() {
            if (!this.newReplyContent.trim() || this.submitting) return;
            this.submitting = true;
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/reply', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        feed_uuid: this.uuid,
                        content: this.newReplyContent,
                        parent_uuid: this.parent_uuid || '',
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    // Update reply list with full data
                    const newReply = {
                        ...data.reply,
                        likes: 0,
                        is_liked: false
                    };
                    this.replies.push(newReply);
                    this.newReplyContent = '';
                    this.cancelReplyTo();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error submitting reply:', error);
            } finally {
                this.submitting = false;
            }
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const parts = dateStr.split(' ');
            if (parts.length > 1) return parts[1].substring(0, 5);
            return dateStr;
        }
    }));
});
</script>

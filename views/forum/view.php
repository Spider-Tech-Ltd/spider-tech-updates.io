<?php
/**
 * Single Discussion View
 */
?>
<!-- Google Fonts for Forum styling & Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<style>
  body { background-color: #f8f9fa; }
  .view-wrapper { padding-top: 100px; padding-bottom: 80px; }
  
  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #f48221;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    margin-bottom: 24px;
    transition: transform 0.2s;
  }
  .back-link:hover { transform: translateX(-5px); color: #db7015; }

  .topic-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
  }

  .topic-header { margin-bottom: 24px; }
  .topic-category {
    display: inline-block;
    background: #f48221;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 50px;
    margin-bottom: 12px;
  }
  .topic-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 2rem;
    color: #111;
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .author-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 24px;
    border-bottom: 1px solid #f1f3f5;
    margin-bottom: 24px;
  }
  .author-avatar { width: 40px; height: 40px; border-radius: 50%; }
  .author-info { display: flex; flex-direction: column; }
  .author-name { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 0.95rem; color: #111; }
  .post-date { font-size: 0.8rem; color: #797979; }

  .topic-content {
    font-family: 'Open Sans', sans-serif;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #333;
  }
  .topic-content img { max-width: 100%; border-radius: 16px; margin: 20px 0; }

  /* Replies Section */
  .replies-section { margin-top: 40px; }
  .replies-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.2rem; margin-bottom: 24px; }
  
  .reply-thread-wrapper {
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
  }

  /* Same styles as feed.php for consistency */
</style>

<div class="view-wrapper" x-data="discussionView()">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <a href="<?= BASE_URL ?>/forum/feed" class="back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Feed
                </a>

                <article class="topic-card">
                    <header class="topic-header">
                        <span class="topic-category"><?= htmlspecialchars($topic['category_name']) ?></span>
                        <h1 class="topic-title"><?= htmlspecialchars($topic['title']) ?></h1>
                        <div class="author-meta">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($topic['author_name']) ?>&background=f48221&color=fff" class="author-avatar" alt="Avatar">
                            <div class="author-info">
                                <span class="author-name"><?= htmlspecialchars($topic['author_name']) ?></span>
                                <span class="post-date">Posted on <?= date('M j, Y', strtotime($topic['created_at'])) ?></span>
                            </div>
                        </div>
                    </header>

                    <div class="topic-content">
                        <?= $topic['content'] ?>
                    </div>

                    <!-- Interaction Bar -->
                    <div class="card-interaction-bar mt-4 pt-3 border-top d-flex gap-3">
                        <button class="btn-interact btn-upvote" @click="toggleUpvote()">
                            <span class="material-symbols-outlined" :style="isLiked ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                            <span x-text="upvotes"></span>
                        </button>
                        <button class="btn-interact btn-reply" @click="scrollToReply()">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <span>Comment</span>
                        </button>
                    </div>
                </article>

                <section class="replies-section">
                    <h2 class="replies-title">Replies (<?= count($topic['replies']) ?>)</h2>
                    <div class="reply-list">
                        <?php foreach ($topic['replies'] as $reply): ?>
                            <div class="reply-thread-wrapper">
                                <div class="reply-header d-flex align-items-center gap-2 mb-2">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($reply['author_name']) ?>&background=f48221&color=fff&size=26" class="reply-avatar-sm" style="width:26px; height:26px; border-radius:50%;" alt="Avatar">
                                    <span class="reply-author font-weight-bold" style="font-size:0.85rem;"><?= htmlspecialchars($reply['author_name']) ?></span>
                                    <span class="reply-time text-muted" style="font-size:0.75rem;"><?= date('H:i', strtotime($reply['created_at'])) ?></span>
                                </div>
                                <div class="reply-body" style="font-size:0.9rem; padding-left:34px;"><?= htmlspecialchars($reply['content']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- New Reply Input -->
                    <div class="reply-input-card topic-card mt-4 p-3">
                        <div class="d-flex gap-2">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['member_name'] ?? 'You') ?>&background=f48221&color=fff" style="width:32px; height:32px; border-radius:50%;" alt="Me">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" 
                                       class="form-control rounded-pill px-3" 
                                       placeholder="Add to the discussion..." 
                                       x-model="newReply"
                                       @keydown.enter="submitReply()">
                                <button class="btn btn-primary rounded-circle position-absolute" 
                                        style="right:5px; top:50%; transform:translateY(-50%); width:32px; height:32px; padding:0; background:#f48221; border:none;"
                                        @click="submitReply()">
                                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_upward</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
function discussionView() {
    return {
        uuid: '<?= $topic['uuid'] ?>',
        upvotes: <?= (int)$topic['upvotes'] ?>,
        isLiked: <?= $topic['is_liked'] ? 'true' : 'false' ?>,
        newReply: '',

        async toggleUpvote() {
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
                    this.upvotes = data.upvotes;
                    this.isLiked = data.is_liked;
                }
            } catch (e) { console.error(e); }
        },

        async submitReply() {
            if (!this.newReply.trim()) return;
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/reply', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        feed_uuid: this.uuid,
                        content: this.newReply,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    location.reload(); // Refresh to show new reply
                }
            } catch (e) { console.error(e); }
        },

        scrollToReply() {
            document.querySelector('.reply-input-card').scrollIntoView({ behavior: 'smooth' });
        }
    }
}
</script>

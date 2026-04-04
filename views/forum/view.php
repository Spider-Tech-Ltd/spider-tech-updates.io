<?php
/**
 * Single Discussion View - High Fidelity Detail Alignment & Sidebar Polish
 */
?>
<!-- Google Fonts for Forum styling -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
<!-- Material Symbols for icons -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<style>
  :root {
    --spider-orange: #f48221;
    --spider-dark: #111111;
    --spider-gray: #797979;
    --spider-bg: #f8f9fa;
  }

  body { background-color: var(--spider-bg); }
  
  .view-wrapper { 
    padding-top: 40px; 
    padding-bottom: 80px; 
    min-height: 100vh;
  }
  
  /* --- Navigation --- */
  .detail-nav { margin-bottom: 24px; }
  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--spider-gray);
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
  }
  .back-link:hover { color: var(--spider-orange); transform: translateX(-4px); }

  /* --- Article Minimal (Primary Discussion) --- */
  .article-minimal {
    margin-bottom: 32px;
  }
  .article-featured-media {
    margin-bottom: 28px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
  }

  .topic-category {
    display: inline-block;
    background-color: var(--spider-orange);
    color: #ffffff;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 3px 12px;
    border-radius: 50px;
    margin-bottom: 14px;
    font-family: 'Poppins', sans-serif;
  }

  .topic-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.6rem;
    color: var(--spider-dark);
    line-height: 1.3;
    margin-bottom: 16px;
  }

  .author-meta-premium {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f3f5;
  }

  .author-avatar-lg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }

  .topic-content-rich {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.95rem;
    line-height: 1.7;
    color: #4a4a4a;
    margin-bottom: 24px;
  }
  .topic-content-rich p { margin-bottom: 16px; }
  .topic-content-rich img { 
    max-width: 100%; 
    border-radius: 16px; 
    margin: 20px 0;
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
  .btn-interact .material-symbols-outlined { font-size: 17px; }
  .btn-interact:hover { background-color: rgba(244, 130, 33, 0.08); color: var(--spider-orange); }

  /* ============================
     PREMIUM THREADED REPLIES
     ============================ */
  .replies-container {
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f1f3f5;
  }

  .reply-card-wrapper {
    position: relative;
    margin-bottom: 4px;
    transition: all 0.2s ease;
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

  /* --- Input Area --- */
  .reply-input-row { display: flex; align-items: center; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f3f5; }
  .reply-field-container { position: relative; flex-grow: 1; }
  .reply-field { width: 100%; background-color: #f1f3f5; border: 1px solid transparent; border-radius: 50px; padding: 10px 50px 10px 18px; font-family: 'Open Sans', sans-serif; font-size: 0.875rem; }
  .reply-field:focus { outline: none; background-color: #ffffff; border-color: var(--spider-orange); }
  .btn-submit-pill { position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 32px; height: 32px; background-color: var(--spider-orange); color: #ffffff; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
  .reply-to-tag { display: inline-flex; align-items: center; gap: 6px; background-color: #fffbf7; color: var(--spider-orange); font-family: 'Poppins'; font-weight: 700; font-size: 0.7rem; padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(244,130,33,0.1); margin-bottom: 8px; }
</style>

<div class="view-wrapper" x-data="discussionDetail()">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <nav class="detail-nav">
                    <a href="<?= BASE_URL ?>/forum/feed" class="back-link">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Back to Feed
                    </a>
                </nav>

                <!-- Primary Discussion Minimal -->
                <?php
                $content = $topic['content'];
                $featured_image_html = '';

                if (preg_match('/<img[^>]+>/i', $content, $matches)) {
                    if (preg_match('/src=["\']([^"\']+)["\']/i', $matches[0], $srcMatches)) {
                        $featured_image_url = $srcMatches[1];
                        $featured_image_html = '<div class="article-featured-media"><img src="' . htmlspecialchars($featured_image_url) . '" alt="Featured Media" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;"></div>';
                        
                        // Strip the first occurrence of this image from the content body so it's not duplicated
                        $content = preg_replace(
                            ['/<p>\s*<img[^>]+src=["\']' . preg_quote($featured_image_url, '/') . '["\'][^>]*>\s*<\/p>/i', '/<img[^>]+src=["\']' . preg_quote($featured_image_url, '/') . '["\'][^>]*>/i'], 
                            ['', ''], 
                            $content, 
                            1
                        );
                    }
                }
                ?>
                <article class="article-minimal">
                    <?= $featured_image_html ?>
                    
                    <span class="topic-category <?= $featured_image_html ? 'mt-3' : '' ?>"><?= htmlspecialchars($topic['category_name']) ?></span>
                    <h1 class="topic-title" style="font-size: 2.2rem; letter-spacing: -0.02em;"><?= htmlspecialchars($topic['title']) ?></h1>
                    
                    <?php 
                        $view_author = trim($topic['author_name']);
                        if (empty($view_author)) $view_author = 'Anonymous';
                    ?>
                    <div class="author-meta-premium border-0 pb-0 mb-4 mt-3">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($view_author) ?>&background=f48221&color=fff&size=48" class="author-avatar-lg" style="width:48px; height:48px;" alt="Avatar">
                        <div class="author-info-group">
                            <span style="font-family:'Poppins'; font-weight:700; font-size:1.1rem; color:#111;"><?= htmlspecialchars($view_author) ?></span>
                            <span style="font-size:0.85rem; color:#797979;">Published on <?= date('F j, Y', strtotime($topic['created_at'])) ?></span>
                        </div>
                    </div>

                    <div class="topic-content-rich mt-4">
                        <?= $content ?>
                    </div>

                    <div class="card-interaction-bar mt-5 pt-3 border-top d-flex gap-2">
                        <button class="btn-interact" :class="{ 'liked': isLiked }" @click="toggleLike()">
                            <span class="material-symbols-outlined" :style="isLiked ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                            <span x-text="likes"></span>
                        </button>
                        <button class="btn-interact" @click="scrollToReply()">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <span x-text="replies.length"></span>
                        </button>
                    </div>
                </article>

                <!-- Threaded Replies Section -->
                <section class="replies-container">
                    <h2 style="font-family:'Poppins'; font-weight:700; font-size:1.15rem; margin-bottom:24px; color:#111;">Discussion (<span x-text="replies.length"></span>)</h2>
                    
                    <div class="replies-list">
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

                    <div class="reply-entry-area mt-5">
                       <div class="reply-to-tag" x-show="replyingToName" x-transition>
                           <span>Replying to <em x-text="replyingToName"></em></span>
                           <span class="material-symbols-outlined" style="font-size:12px; cursor:pointer;" @click="cancelReply()">close</span>
                       </div>
                       <div class="reply-input-row border-0 pt-0 mt-0">
                           <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['member_name'] ?? 'Me') ?>&background=f48221&color=fff&size=32" style="width:32px; height:32px; border-radius:50%;" alt="Me">
                           <div class="reply-field-container">
                               <input type="text" 
                                      class="reply-field" 
                                      :placeholder="replyingToName ? `Write a reply...` : 'Share your thought...'"
                                      x-model="newReply"
                                      @keydown.enter="submitReply()">
                               <button class="btn-submit-pill" @click="submitReply()" :disabled="submitting">
                                   <span x-show="!submitting" class="material-symbols-outlined" style="font-size:18px;">arrow_upward</span>
                               </button>
                           </div>
                       </div>
                    </div>
                </section>
            </div>

            <!-- Unified Sidebar column -->
            <div class="col-lg-4">
                <!-- Support Metrics (Context-specific to this topic) -->
                <div class="sidebar-widget">
                    <div class="widget-header-premium">
                        <div class="widget-icon-box">
                            <span class="material-symbols-outlined">insights</span>
                        </div>
                        <h3 class="widget-title-premium">Topic Insight 📈</h3>
                    </div>
                    
                    <div class="metric-row-premium">
                        <div class="metric-label-group">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <span class="metric-label">Community Reply</span>
                        </div>
                        <span class="metric-value-badge" x-text="`${replies.length} entries`"><?= count($topic['replies']) ?> entries</span>
                    </div>
                    
                    <div class="metric-row-premium">
                        <div class="metric-label-group">
                            <span class="material-symbols-outlined">thumb_up</span>
                            <span class="metric-label">Active Support</span>
                        </div>
                        <span class="metric-value-badge" x-text="`${likes} votes`"><?= $topic['likes'] ?> votes</span>
                    </div>
                </div>

                <!-- Synchronized Global Widgets (User Dashboard, Active Now, Trending) -->
                <?php include ROOT_PATH . '/views/forum/includes/members-sidebar.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Strict Fallbacks & Security Sanitization ahead of Javascript
$safe_uuid = $topic['uuid'] ?? '';
$safe_likes = isset($topic['likes']) ? (int)$topic['likes'] : 0;
$safe_isLiked = !empty($topic['is_liked']) ? 'true' : 'false';
$safe_replies = (isset($topic['replies']) && is_array($topic['replies'])) ? $topic['replies'] : [];

// JSON_HEX_TAG prevents </script> injection. JSON_INVALID_UTF8_SUBSTITUTE prevents silent empty output.
// NOTE: JSON_HEX_QUOT/APOS are intentionally EXCLUDED — they encode structural JSON quotes as \u0022
// which breaks JavaScript object literal parsing in <script> blocks (SyntaxError on \u0022 in identifier position).
$safe_replies_json = json_encode($safe_replies, JSON_HEX_TAG | JSON_INVALID_UTF8_SUBSTITUTE);
// Final check: if json_encode failed entirely, fallback to empty array safely.
if ($safe_replies_json === false) { $safe_replies_json = '[]'; }
?>
<script>
function discussionDetail() {
    return {
        uuid: <?= json_encode($safe_uuid) ?>,
        likes: <?= $safe_likes ?>,
        isLiked: <?= $safe_isLiked ?>,
        replies: <?= $safe_replies_json ?>,
        newReply: '',
        parent_uuid: null,
        replyingToName: '',
        submitting: false,

        get threadedReplies() {
            if (!Array.isArray(this.replies)) return [];
            
            const map = {};
            const roots = [];
            
            this.replies.forEach(r => { 
                map[r.uuid] = { ...r, children: [] }; 
            });
            
            this.replies.forEach(r => {
                if (r.parent_uuid && map[r.parent_uuid]) { 
                    map[r.parent_uuid].children.push(map[r.uuid]); 
                } else { 
                    roots.push(map[r.uuid]); 
                }
            });
            
            // Sort roots DESCENDING (Latest to Oldest) as requested
            roots.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            const flatten = (nodes, depth = 0) => {
                let result = [];
                // Sort children Ascending (Oldest reply first inside the thread context usually works better for readability)
                nodes.forEach(node => {
                    node.children.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    
                    const safeAuthor = (node.author_name && node.author_name.trim() !== '') ? node.author_name : 'Anonymous';
                    result.push({ ...node, author_name: safeAuthor, depth });
                    
                    if (node.children.length > 0) { 
                        result = [...result, ...flatten(node.children, depth + 1)]; 
                    }
                });
                return result;
            };
            
            return flatten(roots);
        },

        async toggleLike() {
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/like', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ feed_uuid: this.uuid, csrf_token: '<?= CSRF::generateToken() ?>' })
                });
                const data = await response.json();
                if (data.success) { this.likes = data.likes; this.isLiked = data.is_liked; }
            } catch (e) { console.error(e); }
        },

        async toggleReplyLike(reply) {
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/like-reply', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ reply_uuid: reply.uuid, csrf_token: '<?= CSRF::generateToken() ?>' })
                });
                const data = await response.json();
                if (data.success) {
                    const r = this.replies.find(x => x.uuid === reply.uuid);
                    if (r) { r.likes = data.likes; r.is_liked = data.is_liked; }
                }
            } catch (e) { console.error(e); }
        },

        setReplyTo(uuid, name) {
            this.parent_uuid = uuid;
            this.replyingToName = name ? name : 'Anonymous';
            this.scrollToReply();
        },

        cancelReply() { this.parent_uuid = null; this.replyingToName = ''; },

        async submitReply() {
            if (!this.newReply.trim()) return;
            this.submitting = true;
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/reply', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        feed_uuid: this.uuid,
                        content: this.newReply,
                        parent_uuid: this.parent_uuid || '',
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    this.replies.push(data.reply);
                    this.newReply = '';
                    this.cancelReply();
                }
            } catch (e) { console.error(e); } finally { this.submitting = false; }
        },

        scrollToReply() { 
            const field = document.querySelector('.reply-field');
            if(field) {
                field.focus();
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },
        formatTime(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    };
}
</script>

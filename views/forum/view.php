<?php

/**
 * Single Discussion View - Polished High Fidelity Detail Alignment & Sidebar Polish
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-view.css?v=<?= filemtime(ROOT_PATH . '/css/forum-view.css') ?>" />

<?php
// PHP logic to handle featured image extraction from content
$content = $topic['content'];
$featured_image_html = '';
if (preg_match('/<img[^>]+>/i', $content, $matches)) {
    if (preg_match('/src=["\']([^"\']+)["\']/i', $matches[0], $srcMatches)) {
        $featured_image_url = $srcMatches[1];
        $featured_image_html = '<div class="article-featured-media"><img src="' . htmlspecialchars($featured_image_url) . '" alt="Featured Media" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;"></div>';
        $content = preg_replace(
            ['/<p>\s*<img[^>]+src=["\']' . preg_quote($featured_image_url, '/') . '["\'][^>]*>\s*<\/p>/i', '/<img[^>]+src=["\']' . preg_quote($featured_image_url, '/') . '["\'][^>]*>/i'],
            ['', ''],
            $content,
            1
        );
    }
}

// Security sanitization for Alpine.js hydration
$safe_uuid = $topic['uuid'] ?? '';
$safe_likes = isset($topic['likes']) ? (int)$topic['likes'] : 0;
$safe_isLiked = !empty($topic['is_liked']) ? 'true' : 'false';
$safe_replies = (isset($topic['replies']) && is_array($topic['replies'])) ? $topic['replies'] : [];
$safe_replies_json = json_encode($safe_replies, JSON_HEX_TAG | JSON_INVALID_UTF8_SUBSTITUTE);
if ($safe_replies_json === false) {
    $safe_replies_json = '[]';
}

$view_author = trim($topic['author_name'] ?? '');
if (empty($view_author)) $view_author = 'Anonymous';
?>

<div class="view-wrapper" x-data="discussionDetail()">
    <div class="container">
        <div class="row">
            <!-- Left Column: Discussion & Replies -->
            <div class="col-lg-8">
                <nav class="detail-nav">
                    <a href="<?= BASE_URL ?>/forum/feed" class="back-link">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Back to Community Feed</span>
                    </a>
                </nav>

                <!-- Primary Discussion Card -->
                <article class="discussion-main-card">
                    <?= $featured_image_html ?>

                    <div class="card-meta-header">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="topic-category-chip"><?= htmlspecialchars($topic['category_name']) ?></span>
                            <?php if (!empty($topic['is_pinned'])): ?>
                                <span class="topic-badge-pinned">
                                    <span class="material-symbols-outlined">push_pin</span>
                                    <span>Pinned</span>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($topic['is_hot'])): ?>
                                <span class="topic-badge-hot">
                                    <span class="material-symbols-outlined">local_fire_department</span>
                                    <span>Trending</span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <span class="topic-thread-id">#THREAD-<?= strtoupper(substr($safe_uuid, 0, 8)) ?></span>
                    </div>

                    <h1 class="topic-main-title"><?= htmlspecialchars($topic['title']) ?></h1>

                    <div class="author-meta-premium">
                        <div class="position-relative">
                            <img src="<?= !empty($topic['author_avatar']) ? BASE_URL . $topic['author_avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($view_author) . "&background=f48221&color=fff&size=48" ?>" class="author-avatar-lg" alt="Avatar">
                            <span class="author-status-dot"></span>
                        </div>
                        <div class="author-info-group">
                            <div class="d-flex align-items-center gap-2">
                                <span class="author-display-name"><?= htmlspecialchars($view_author) ?></span>
                                <span class="author-verified-tag">Verified Member</span>
                            </div>
                            <div class="author-publish-meta">
                                <span class="material-symbols-outlined">calendar_today</span>
                                <span>Published on <?= date('F j, Y', strtotime($topic['created_at'])) ?></span>
                                <span class="meta-dot-divider">•</span>
                                <span class="material-symbols-outlined">schedule</span>
                                <span><?= date('H:i', strtotime($topic['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="topic-content-rich">
                        <?= $content ?>
                    </div>

                    <!-- Interaction Bar -->
                    <div class="card-interaction-bar">
                        <button type="button" class="btn-interact" :class="{ 'liked': isLiked }" @click="toggleLike()" title="Support this discussion">
                            <span class="material-symbols-outlined" :style="isLiked ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                            <span>Support Topic</span>
                            <span class="badge-count" x-text="likes"></span>
                        </button>
                        <button type="button" class="btn-interact" @click="scrollToReply()" title="Jump to comments">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <span>Discussion</span>
                            <span class="badge-count" x-text="replies.length"></span>
                        </button>
                        <div class="ms-auto">
                            <button type="button" class="btn-interact btn-bookmark-prominent" @click="triggerBrowserBookmark()" title="Bookmark this thread in your browser">
                                <span class="material-symbols-outlined">bookmark_add</span>
                                <span>Bookmark</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Threaded Responses Section -->
                <section class="replies-container">
                    <div class="replies-header-strip">
                        <div class="replies-heading-wrap">
                            <span class="material-symbols-outlined replies-heading-icon">forum</span>
                            <h2 class="replies-heading">Community Responses</h2>
                            <span class="replies-count-badge" x-text="`${replies.length} replies`"><?= count($topic['replies'] ?? []) ?> replies</span>
                        </div>
                        <button type="button" class="btn-jump-reply" @click="scrollToReply()">
                            <span class="material-symbols-outlined">add_comment</span>
                            <span>Write Response</span>
                        </button>
                    </div>

                    <!-- Empty replies state -->
                    <template x-if="threadedReplies.length === 0">
                        <div class="replies-empty-state">
                            <span class="material-symbols-outlined empty-bubble-icon">chat</span>
                            <h4 class="empty-reply-title">No replies yet</h4>
                            <p class="empty-reply-subtext">Be the first engineer to share your thoughts or provide a solution.</p>
                        </div>
                    </template>

                    <!-- Replies List -->
                    <div class="replies-list" x-show="threadedReplies.length > 0">
                        <template x-for="reply in threadedReplies" :key="reply.uuid">
                            <div class="reply-card-wrapper"
                                :style="`margin-left: ${Math.min(reply.depth * 28, 140)}px`"
                                :class="reply.depth > 0 ? 'reply-nested' : ''">
                                <div class="reply-card">
                                    <div class="reply-header">
                                        <div class="d-flex align-items-center gap-2">
                                            <img :src="reply.author_avatar ? '<?= BASE_URL ?>' + reply.author_avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(reply.author_name)}&background=f48221&color=fff&size=28`" class="reply-avatar" alt="Avatar">
                                            <span class="reply-author" x-text="reply.author_name"></span>
                                            <span class="reply-badge-pill" x-show="reply.depth > 0">Nested</span>
                                        </div>
                                        <span class="reply-time">
                                            <span class="material-symbols-outlined" style="font-size:12px;">schedule</span>
                                            <span x-text="formatTime(reply.created_at)"></span>
                                        </span>
                                    </div>
                                    <div class="reply-body" x-text="reply.content"></div>
                                    <div class="reply-actions">
                                        <button type="button" class="btn-mini-interact" @click="toggleReplyLike(reply)" :class="{ 'liked': reply.is_liked == 1 }">
                                            <span class="material-symbols-outlined" :style="reply.is_liked == 1 ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                                            <span x-text="reply.likes || 0"></span>
                                        </button>
                                        <button type="button" class="btn-mini-interact" @click="setReplyTo(reply.uuid, reply.author_name)">
                                            <span class="material-symbols-outlined">reply</span>
                                            <span>Reply</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Reply Entry Area -->
                    <div class="reply-entry-card" id="reply-box-anchor">
                        <div class="reply-entry-header">
                            <span class="material-symbols-outlined">edit_note</span>
                            <span>Share Your Technical Insight</span>
                        </div>
                        <div class="reply-to-tag" x-show="replyingToName" x-transition>
                            <span>Replying to <strong x-text="replyingToName"></strong></span>
                            <button type="button" class="btn-cancel-reply" @click="cancelReply()" title="Cancel reply target">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="reply-input-row">
                            <img src="<?= !empty($_SESSION['member_avatar']) ? BASE_URL . $_SESSION['member_avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['member_name'] ?? 'Me') . "&background=f48221&color=fff&size=36" ?>" class="reply-user-avatar" alt="Me">
                            <div class="reply-field-container">
                                <input type="text" id="reply-input"
                                    class="reply-field"
                                    :placeholder="replyingToName ? `Write your reply to ${replyingToName}...` : 'Share your engineering insight or feedback...'"
                                    x-model="newReply"
                                    @keydown.enter="submitReply()">
                                <button type="button" class="btn-submit-pill" @click="submitReply()" :disabled="submitting || !newReply.trim()" title="Send reply">
                                    <span x-show="!submitting" class="material-symbols-outlined">send</span>
                                    <span x-show="submitting" class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Topic Insight & Sidebar -->
            <div class="col-lg-4">
                <div class="topic-insight-widget">
                    <div class="widget-header-premium">
                        <div class="widget-icon-box"><span class="material-symbols-outlined">insights</span></div>
                        <h3 class="widget-title-premium">Topic Telemetry</h3>
                    </div>
                    <div class="metric-row-premium">
                        <div class="metric-label-group">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <span class="metric-label">Community Replies</span>
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
                    <div class="metric-row-premium">
                        <div class="metric-label-group">
                            <span class="material-symbols-outlined">sensors</span>
                            <span class="metric-label">Thread Status</span>
                        </div>
                        <span class="metric-value-badge" style="color: #16a34a;">Active</span>
                    </div>
                </div>

                <?php include ROOT_PATH . '/views/forum/includes/members-sidebar.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function discussionDetail() {
        return {
            // Hydrate from PHP strictly
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
                    map[r.uuid] = {
                        ...r,
                        children: []
                    };
                });
                this.replies.forEach(r => {
                    if (r.parent_uuid && map[r.parent_uuid]) {
                        map[r.parent_uuid].children.push(map[r.uuid]);
                    } else {
                        roots.push(map[r.uuid]);
                    }
                });

                roots.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                const flatten = (nodes, depth = 0) => {
                    let result = [];
                    nodes.forEach(node => {
                        node.children.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                        const safeAuthor = (node.author_name && node.author_name.trim() !== '') ? node.author_name : 'Anonymous';
                        result.push({
                            ...node,
                            author_name: safeAuthor,
                            depth
                        });
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
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            feed_uuid: this.uuid,
                            csrf_token: '<?= CSRF::generateToken() ?>'
                        })
                    });
                    const data = await response.json();
                    if (data.success) {
                        this.likes = data.likes;
                        this.isLiked = data.is_liked;
                    }
                } catch (e) {
                    console.error(e);
                }
            },

            async toggleReplyLike(reply) {
                try {
                    const response = await fetch('<?= BASE_URL ?>/forum/feed/like-reply', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            reply_uuid: reply.uuid,
                            csrf_token: '<?= CSRF::generateToken() ?>'
                        })
                    });
                    const data = await response.json();
                    if (data.success) {
                        const r = this.replies.find(x => x.uuid === reply.uuid);
                        if (r) {
                            r.likes = data.likes;
                            r.is_liked = data.is_liked;
                        }
                    }
                } catch (e) {
                    console.error(e);
                }
            },

            setReplyTo(uuid, name) {
                this.parent_uuid = uuid;
                this.replyingToName = name || 'Anonymous';
                this.scrollToReply();
            },

            cancelReply() {
                this.parent_uuid = null;
                this.replyingToName = '';
            },

            async submitReply() {
                if (!this.newReply.trim() || this.submitting) return;
                this.submitting = true;
                try {
                    const response = await fetch('<?= BASE_URL ?>/forum/feed/reply', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
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
                } catch (e) {
                    console.error(e);
                } finally {
                    this.submitting = false;
                }
            },

            scrollToReply() {
                const field = document.getElementById('reply-input');
                if (field) {
                    field.focus();
                    field.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            },

            triggerBrowserBookmark() {
                const isMac = (navigator.platform.toUpperCase().indexOf('MAC') >= 0);
                const shortcut = isMac ? 'Cmd + D' : 'Ctrl + D';
                alert(`To bookmark this discussion in your browser, please press ${shortcut} on your keyboard.`);
            },

            formatTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString(undefined, {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        };
    }
</script>

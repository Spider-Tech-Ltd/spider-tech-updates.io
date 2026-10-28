<?php
/**
 * Member Feed View
 */
?>






<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed.css') ?>" />

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
              <div class="card-author-row">
                <img :src="feed.author_avatar ? '<?= BASE_URL ?>' + feed.author_avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(feed.author_name)}&background=f48221&color=fff&size=32`" class="author-avatar-sm" alt="Author">
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
                <a :href="`<?= BASE_URL ?>/forum/discussion?uuid=${feed.uuid}#discussion`" class="btn-interact btn-reply" title="Replies">
                  <span class="material-symbols-outlined">chat_bubble</span>
                  <span class="reply-count" x-text="replies.length"></span>
                </a>
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

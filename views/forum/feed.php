<?php
/**
 * Member Feed View — Synchronized with Forum Landing Anti-Scroll Engineering Rows & Progressive Show More
 */
$initialFeedsJson = json_encode($feeds ?? [], JSON_HEX_TAG | JSON_INVALID_UTF8_SUBSTITUTE);
if ($initialFeedsJson === false) { $initialFeedsJson = '[]'; }
$initialTotalPages = (int)($total_pages ?? 1);
$initialCurrentPage = (int)($current_page ?? 1);
$initialCategory = json_encode($category_filter ?? 'all');
$initialSort = json_encode($_GET['sort'] ?? 'latest');
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-guest-feed.css?v=<?= filemtime(ROOT_PATH . '/css/forum-guest-feed.css') ?>" />
<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed.css') ?>" />

<?php include ROOT_PATH . '/views/forum/includes/feed-banner.php'; ?>

<!-- Filter Bar -->
<?php include ROOT_PATH . '/views/forum/includes/feed-filter-bar.php'; ?>

<section class="member-feed-section py-5" x-data="forumFeedController()">
  <div class="container">
    <div class="row">
      <!-- Left Column: Discussion Feed -->
      <div class="col-lg-8">
        
        <!-- Feed Section Header -->
        <div class="feed-header-wrap mb-4">
          <div class="feed-header-meta">
            <div class="feed-eyebrow">
              <span class="eyebrow-accent">|–</span>
              <span>ENGINEERING THREADS</span>
              <span class="eyebrow-accent">–|</span>
            </div>
            <h2 class="feed-title">Latest Discussions</h2>
            <p class="feed-subtitle">
              Showing <span class="feed-count-highlight" x-text="Math.min(visibleCount, discussions.length)"><?= min(6, count($feeds ?? [])) ?></span> of <span x-text="discussions.length"><?= count($feeds ?? []) ?></span> discussions in current view
            </p>
          </div>

          <div class="feed-header-actions">
            <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-new-topic">
              <span class="material-symbols-outlined">add_circle</span>
              <span>Start Topic</span>
            </a>
          </div>
        </div>

        <!-- Discussion Cards (Streamlined Anti-Scroll Engineering Rows) -->
        <div class="discussion-feed-list" id="discussionFeed" role="feed" aria-label="Community discussions">
          <!-- Loading State -->
          <div x-show="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted" style="font-family:'Poppins', sans-serif; font-size:0.88rem;">Loading discussions...</p>
          </div>

          <!-- Empty State -->
          <template x-if="!loading && discussions.length === 0">
            <div class="discussion-empty-card text-center py-5">
              <span class="material-symbols-outlined empty-icon" style="font-size: 48px; color: #cbd5e1;">forum</span>
              <h4 class="empty-title mt-2" style="font-family:'Poppins', sans-serif; font-weight:700; color:#1e293b;">No Discussions in This Category Yet</h4>
              <p class="empty-subtext text-muted" style="font-size:0.88rem;">Be the first engineer to start a conversation in this topic hub.</p>
              <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-new-topic mt-3">
                <span class="material-symbols-outlined">add_circle</span>
                <span>Start First Discussion</span>
              </a>
            </div>
          </template>

          <!-- Streamlined Row Cards (Matching Forum Landing Page) with Progressive Reveal -->
          <template x-for="(feed, index) in discussions" :key="feed.uuid">
            <div class="discussion-item-wrap feed-item-fade-in" x-show="!loading && index < visibleCount">
              <a :href="`<?= BASE_URL ?>/forum/discussion?uuid=${feed.uuid}`"
                 class="discussion-row-card"
                 :class="{ 'is-pinned': feed.is_pinned, 'is-hot': feed.is_hot }"
                 role="article"
                 :aria-label="feed.title">

                <!-- Left: Stat Counters (Upvotes & Replies in compact dual-pill) -->
                <div class="row-stats-box" :aria-label="`${feed.likes || feed.upvotes || 0} upvotes, ${feed.replies_count || (feed.replies ? feed.replies.length : 0)} replies`">
                  <button type="button"
                          class="row-stat-col row-stat-like-btn"
                          :class="{ 'is-liked': feed.is_liked }"
                          title="Support topic"
                          @click.prevent.stop="toggleLike(feed)">
                    <span class="material-symbols-outlined row-stat-icon" :style="feed.is_liked ? 'font-variation-settings: \'FILL\' 1;' : ''">thumb_up</span>
                    <span class="row-stat-num" x-text="feed.likes !== undefined ? feed.likes : (feed.upvotes || 0)"></span>
                  </button>
                  <div class="row-stat-divider"></div>
                  <div class="row-stat-col" :class="{ 'has-replies': ((feed.replies_count || (feed.replies ? feed.replies.length : 0)) > 0) }" title="Discussion replies">
                    <span class="material-symbols-outlined row-stat-icon">chat_bubble</span>
                    <span class="row-stat-num" x-text="feed.replies_count !== undefined ? feed.replies_count : (feed.replies ? feed.replies.length : 0)"></span>
                  </div>
                </div>

                <!-- Center: Topic Content -->
                <div class="row-content-body">
                  <!-- Top Inline Meta: Badges + Time -->
                  <div class="row-meta-inline">
                    <span class="row-category-chip" x-text="feed.category_name || 'General'"></span>
                    <template x-if="feed.is_pinned">
                      <span class="row-badge-pinned">
                        <span class="material-symbols-outlined">push_pin</span>
                        <span>Pinned</span>
                      </span>
                    </template>
                    <template x-if="feed.is_hot">
                      <span class="row-badge-hot">
                        <span class="material-symbols-outlined">local_fire_department</span>
                        <span>Trending</span>
                      </span>
                    </template>
                    <span class="row-meta-separator">•</span>
                    <span class="row-time-ago">
                      <span class="material-symbols-outlined">schedule</span>
                      <span x-text="formatDate(feed.created_at)"></span>
                    </span>
                  </div>

                  <!-- Title -->
                  <h3 class="row-topic-title" x-text="feed.title"></h3>

                  <!-- Compact Excerpt Preview -->
                  <p class="row-topic-excerpt" x-text="cleanExcerpt(feed.content)"></p>

                  <!-- Author Meta Line -->
                  <div class="row-author-meta">
                    <img :src="feed.author_avatar ? '<?= BASE_URL ?>' + feed.author_avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(feed.author_name || 'Member')}&background=f48221&color=fff&size=24`"
                         class="row-author-avatar"
                         :alt="feed.author_name || 'Member'"
                         loading="lazy">
                    <span class="row-author-name" x-text="feed.author_name || 'Member'"></span>
                    <span class="row-author-role">Member</span>
                  </div>
                </div>

                <!-- Right: Action Arrow -->
                <div class="row-arrow-box" aria-hidden="true">
                  <span class="material-symbols-outlined row-arrow-icon">arrow_forward</span>
                </div>

              </a>
            </div>
          </template>
        </div>

        <!-- Progressive Reveal: Show More / Show Less Button (Anti-Scroll Control) -->
        <div class="feed-more-actions" x-show="!loading && discussions.length > 6">
          <button type="button" 
                  class="feed-show-more-btn"
                  @click="toggleFeedRows()"
                  :aria-expanded="(visibleCount >= discussions.length).toString()">
            <span x-text="visibleCount >= discussions.length ? 'Show Less' : 'Show More Discussions'">Show More Discussions</span>
            <span class="material-symbols-outlined toggle-chevron" :class="{ 'is-rotated': visibleCount >= discussions.length }">expand_more</span>
          </button>
        </div>

        <!-- Pagination -->
        <div class="member-feed-pagination" x-show="totalPages > 1">
          <button class="pag-btn" @click="prevPage()" :disabled="currentPage <= 1">
            <span class="material-symbols-outlined">chevron_left</span>
            <span>Previous</span>
          </button>
          <span class="pag-info">
            Page <strong x-text="currentPage"></strong> of <strong x-text="totalPages"></strong>
          </span>
          <button class="pag-btn" @click="nextPage()" :disabled="currentPage >= totalPages">
            <span>Next</span>
            <span class="material-symbols-outlined">chevron_right</span>
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
<a href="<?= BASE_URL ?>/forum/new-topic" class="member-fab-mobile" title="Start a Topic">
  <span class="member-fab-pulse-ring"></span>
  <span class="material-symbols-outlined">edit</span>
</a>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('forumFeedController', () => ({
        discussions: <?= $initialFeedsJson ?>,
        loading: false,
        currentCategory: <?= $initialCategory ?>,
        currentSort: <?= $initialSort ?>,
        currentPage: <?= $initialCurrentPage ?>,
        totalPages: <?= $initialTotalPages ?>,
        visibleCount: 6,
        step: 6,

        init() {
            // Listen for filter updates from the filter bar
            window.addEventListener('filter-changed', (e) => {
                if (e.detail.category !== undefined) this.currentCategory = e.detail.category;
                if (e.detail.sort !== undefined) this.currentSort = e.detail.sort;
                this.currentPage = 1;
                this.visibleCount = 6;
                this.fetchDiscussions();
            });
        },

        toggleFeedRows() {
            if (this.visibleCount >= this.discussions.length) {
                this.visibleCount = 6;
                const feedEl = document.getElementById('discussionFeed') || document.getElementById('feedSection');
                if (feedEl) {
                    feedEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                this.visibleCount = Math.min(this.visibleCount + this.step, this.discussions.length);
            }
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
                    this.visibleCount = 6;
                    if (data.total_pages !== undefined) this.totalPages = data.total_pages;
                }
            } catch (error) {
                console.error('Error fetching discussions:', error);
            } finally {
                this.loading = false;
                const feedEl = document.getElementById('feedSection') || document.getElementById('discussionFeed');
                if (feedEl) {
                    feedEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        },

        async toggleLike(feed) {
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/like', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        feed_uuid: feed.uuid,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    feed.likes = data.likes;
                    feed.upvotes = data.likes;
                    feed.is_liked = data.is_liked;
                } else if (data.message && data.message.includes('sign in')) {
                    window.location.href = '<?= BASE_URL ?>/forum/sign-in';
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.visibleCount = 6;
                this.fetchDiscussions();
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.visibleCount = 6;
                this.fetchDiscussions();
            }
        },

        formatDate(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        cleanExcerpt(html) {
            if (!html) return '';
            const tmp = document.createElement('div');
            tmp.innerHTML = html;
            const text = tmp.textContent || tmp.innerText || '';
            const trimmed = text.trim();
            if (trimmed.length > 135) {
                return trimmed.substring(0, 135) + '...';
            }
            return trimmed;
        }
    }));
});
</script>

<?php
/**
 * Feed Category Tab Switcher (Matching Events Page Design)
 * Displays unified capsule tab switcher with category badges, interactive horizontal scroll nav, and custom sort dropdown
 */
$currentCat = $_GET['category'] ?? 'all';
$currentSort = $_GET['sort'] ?? 'latest';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed-filter-bar.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed-filter-bar.css') ?>" />

<div class="forum-tabs-section" id="feedSection">
  <div class="container">
    <div class="forum-tabs-bar-inner">

      <!-- Category Tab Switcher with Interactive Accessible Horizontal Scroll -->
      <div class="forum-tab-switcher-wrap" x-data="categoryScrollNav()" x-init="initScrollNav()">
        
        <!-- Left Blur Fade Gradient Overlay -->
        <div class="tab-scroll-blur left" 
             x-show="canScrollLeft" 
             x-transition.opacity.duration.250ms
             aria-hidden="true" 
             style="display: none;"></div>

        <!-- Left Inward Scroll Arrow Button -->
        <button type="button" 
                class="tab-scroll-arrow-btn prev" 
                x-show="canScrollLeft" 
                x-transition.opacity.duration.200ms
                @click="scrollLeft()" 
                aria-label="Scroll categories left"
                style="display: none;">
          <span class="material-symbols-outlined">chevron_left</span>
        </button>

        <!-- Scrollable Capsule Container -->
        <div class="forum-tab-switcher" 
             x-ref="switcher" 
             @scroll.passive="updateScrollArrows()"
             @wheel="handleWheel($event)"
             role="tablist" 
             aria-label="Discussion Categories">

          <a href="<?= BASE_URL ?>/forum?category=all&sort=<?= urlencode($currentSort) ?>#feedSection"
             class="forum-tab-btn <?= ($currentCat === 'all' || empty($currentCat)) ? 'active' : '' ?>">
            <span class="material-symbols-outlined tab-icon">grid_view</span>
            <span>All Topics</span>
            <span class="tab-badge"><?= $global_stats['total_discussions'] ?? count($feeds ?? []) ?></span>
          </a>

          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
              <?php $catKey = $cat['slug'] ?? $cat['uuid']; ?>
              <?php $isActive = ($currentCat === $catKey); ?>
              <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($catKey) ?>&sort=<?= urlencode($currentSort) ?>#feedSection"
                 class="forum-tab-btn <?= $isActive ? 'active' : '' ?>">
                <span class="material-symbols-outlined tab-icon"><?= htmlspecialchars($cat['icon'] ?? 'label') ?></span>
                <span><?= htmlspecialchars($cat['name']) ?></span>
                <span class="tab-badge"><?= $cat['topic_count'] ?? '0' ?></span>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>

          <!-- End Spacer to guarantee the rightmost tab ("Tech") is fully visible with buffer -->
          <span class="tab-scroll-end-spacer" aria-hidden="true"></span>
        </div>

        <!-- Right Blur Fade Gradient Overlay -->
        <div class="tab-scroll-blur right" 
             x-show="canScrollRight" 
             x-transition.opacity.duration.250ms
             aria-hidden="true" 
             style="display: none;"></div>

        <!-- Right Inward Scroll Arrow Button -->
        <button type="button" 
                class="tab-scroll-arrow-btn next" 
                x-show="canScrollRight" 
                x-transition.opacity.duration.200ms
                @click="scrollRight()" 
                aria-label="Scroll categories right"
                style="display: none;">
          <span class="material-symbols-outlined">chevron_right</span>
        </button>

      </div>

      <!-- Custom Sort Filter Dropdown (Replaces default OS browser select) -->
      <div class="forum-sort-pill-wrap" x-data="{ sortOpen: false }" @click.outside="sortOpen = false">
        <span class="forum-sort-label">Sort By:</span>
        <div class="custom-sort-dropdown">
          <button type="button" 
                  class="custom-sort-btn" 
                  @click="sortOpen = !sortOpen" 
                  :aria-expanded="sortOpen.toString()" 
                  aria-label="Sort discussions">
            <span class="material-symbols-outlined sort-icon">sort</span>
            <span><?= ($currentSort === 'hottest') ? 'Trending / Hot' : 'Latest First' ?></span>
            <span class="material-symbols-outlined chevron-icon" :class="{ 'is-rotated': sortOpen }">expand_more</span>
          </button>

          <div class="custom-sort-menu" x-show="sortOpen" x-transition.origin.top.right x-cloak style="display: none;">
            <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=latest#feedSection"
               class="custom-sort-item <?= ($currentSort === 'latest') ? 'active' : '' ?>">
              <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined item-icon">schedule</span>
                <span>Latest First</span>
              </div>
              <?php if ($currentSort === 'latest'): ?>
                <span class="material-symbols-outlined check-mark">check</span>
              <?php endif; ?>
            </a>

            <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=hottest#feedSection"
               class="custom-sort-item <?= ($currentSort === 'hottest') ? 'active' : '' ?>">
              <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined item-icon">local_fire_department</span>
                <span>Trending / Hot</span>
              </div>
              <?php if ($currentSort === 'hottest'): ?>
                <span class="material-symbols-outlined check-mark">check</span>
              <?php endif; ?>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  function categoryScrollNav() {
    return {
      canScrollLeft: false,
      canScrollRight: false,

      initScrollNav() {
        this.$nextTick(() => {
          this.updateScrollArrows();
          // Automatically scroll active tab into view if it was clipped on load
          const switcher = this.$refs.switcher;
          if (switcher) {
            const activeTab = switcher.querySelector('.forum-tab-btn.active');
            if (activeTab) {
              activeTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
          }
        });
        window.addEventListener('resize', () => this.updateScrollArrows(), { passive: true });
      },

      updateScrollArrows() {
        const el = this.$refs.switcher;
        if (!el) return;
        this.canScrollLeft = el.scrollLeft > 6;
        this.canScrollRight = (el.scrollLeft + el.clientWidth) < (el.scrollWidth - 8);
      },

      scrollLeft() {
        const el = this.$refs.switcher;
        if (el) {
          el.scrollBy({ left: -220, behavior: 'smooth' });
          setTimeout(() => this.updateScrollArrows(), 320);
        }
      },

      scrollRight() {
        const el = this.$refs.switcher;
        if (el) {
          el.scrollBy({ left: 220, behavior: 'smooth' });
          setTimeout(() => this.updateScrollArrows(), 320);
        }
      },

      handleWheel(e) {
        const el = this.$refs.switcher;
        if (!el) return;
        if (el.scrollWidth > el.clientWidth && Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
          e.preventDefault();
          el.scrollLeft += e.deltaY;
          this.updateScrollArrows();
        }
      }
    };
  }
</script>

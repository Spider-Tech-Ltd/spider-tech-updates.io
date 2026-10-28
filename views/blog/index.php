<link rel="stylesheet" href="<?= BASE_URL ?>/css/blog.css?v=<?= filemtime(ROOT_PATH . '/css/blog.css') ?>" />

<div id="progress-bar" class="reading-progress"></div>
<main class="blog-wrapper" x-data="blogManager()" @popstate.window="handlePopState($event)" @scroll.window.passive="updateProgress()">
    
    <!-- Professional Page Header -->
    <section class="page-header" x-show="view === 'index'" x-cloak>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-title">Technical Intelligence & <span>Global Impact</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item-custom">
                                <a href="<?= BASE_URL ?>/">Home</a>
                            </li>
                            <li class="breadcrumb-item-custom active" aria-current="page">
                                Research &amp; Insights
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="blog-content" x-show="view === 'index'" x-cloak>
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        </svg>
                        <span class="eyebrow-label-text">Research &amp; Insights</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <br>
                    <h2 class="section-title">Industrial <span>Knowledge Base</span></h2>
                    <p class="section-subtitle">Exploring the engineering frontier through technical research, system architecture analysis, and data-driven case studies.</p>
                </div>
            </div>

            <!-- Filter Navigation -->
            <div class="filter-container">
                <button type="button" class="filter-pill" :class="{ 'active': currentCategory === 'all' }" @click="setCategory('all')">
                    All Research
                </button>
                <?php foreach ($categories as $category): ?>
                    <button type="button" class="filter-pill" :class="{ 'active': currentCategory === '<?= $category['slug'] ?>' }" @click="setCategory('<?= $category['slug'] ?>')">
                        <?= htmlspecialchars($category['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Research Grid -->
            <div class="row g-4" x-show="!loading">
                <template x-for="blog in blogs" :key="blog.uuid">
                    <div class="col-lg-4 col-md-6 mb-4 d-flex">
                        <article class="research-card" @click="loadArticle(blog.slug)">
                            <div class="card-img-wrap">
                                <span class="card-category" x-text="blog.category_name"></span>
                                <img :src="blog.image_path" :alt="blog.title" loading="lazy" decoding="async" @error="$event.target.style.display='none'; $event.target.nextElementSibling.style.display='flex';">
                                <div class="blog-img-fallback" style="display: none;" aria-hidden="true">
                                    <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                        <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                                    </svg>
                                    <span class="fallback-label">Spider Tech Insight</span>
                                </div>
                            </div>
                            <div class="card-body-content">
                                <h3 x-text="blog.title" :title="blog.title"></h3>
                                <p x-text="blog.summary"></p>
                                <span class="read-link">
                                    <span>Read Insight</span>
                                    <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                                </span>
                            </div>
                        </article>
                    </div>
                </template>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Loading research insights...</p>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && blogs.length === 0" class="text-center py-5">
                <div class="empty-state">
                    <span class="material-symbols-outlined">menu_book</span>
                    <h4>No Articles Found</h4>
                    <p>No research insights found in this category. Select another topic above.</p>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Detail View Container (AJAX SPA) -->
    <div id="article-detail-container" class="article-main" x-show="view === 'detail'" x-cloak>
        <div x-html="detailContent"></div>
    </div>
</main>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('blogManager', () => ({
            view: '<?= isset($blog) ? 'detail' : 'index' ?>',
            currentCategory: 'all',
            blogs: <?= json_encode($blogs) ?>,
            loading: false,
            detailContent: '',

            init() {
                if (this.view === 'detail') {
                    // Handled if direct SSR
                }
            },

            async setCategory(slug) {
                this.currentCategory = slug;
                this.loading = true;
                try {
                    const response = await fetch(`<?= BASE_URL ?>/blog?category=${slug}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        this.blogs = data.blogs;
                    }
                } catch (error) {
                    console.error('Error fetching blogs:', error);
                } finally {
                    this.loading = false;
                }
            },

            async loadArticle(slug) {
                this.loading = true;
                try {
                    const response = await fetch(`<?= BASE_URL ?>/blog/${slug}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const html = await response.text();
                    this.detailContent = html;
                    this.view = 'detail';
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    history.pushState({
                        view: 'detail',
                        slug: slug
                    }, '', `<?= BASE_URL ?>/blog/${slug}`);
                } catch (error) {
                    console.error('Error loading article:', error);
                } finally {
                    this.loading = false;
                }
            },

            handlePopState(event) {
                if (event.state && event.state.view === 'detail') {
                    this.loadArticle(event.state.slug);
                } else {
                    this.view = 'index';
                    this.detailContent = '';
                    history.replaceState({
                        view: 'index'
                    }, '', `<?= BASE_URL ?>/blog`);
                }
            },

            updateProgress() {
                if (this.view !== 'detail') return;
                const h = document.documentElement,
                    b = document.body,
                    st = 'scrollTop',
                    sh = 'scrollHeight';
                const percent = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
                const progressBar = document.getElementById('progress-bar');
                if (progressBar) progressBar.style.width = Math.min(100, Math.max(0, percent)) + '%';
            },

        }));
    });
</script>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>

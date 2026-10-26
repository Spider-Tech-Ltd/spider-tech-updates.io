<!-- Material Symbols for Blog UI -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/blog.css" />

<div id="progress-bar" class="reading-progress"></div>
<main class="blog-wrapper" x-data="blogManager()" @popstate.window="handlePopState($event)" @scroll.window.passive="updateProgress()">
    
    <!-- Professional Page Header -->
    <section class="page-header" x-show="view === 'index'" x-cloak>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="tag-eyebrow" style="background: rgba(244,130,33,0.15); color: #f48221; margin-bottom: 20px; display: inline-flex; align-items: center; border: 1px solid rgba(244,130,33,0.3); padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                        <span class="material-symbols-outlined" style="font-size: 16px; margin-right: 6px;">auto_awesome</span>
                        Industrial Knowledge Base
                    </span>
                    <h1 class="page-title">Technical Intelligence & <br><span>Global Impact</span></h1>
                    <p style="color: rgba(255,255,255,0.7); font-size: 1.05rem; max-width: 650px; line-height: 1.6; margin-bottom: 20px;">Exploring the industrial frontier through rigorous technical research, engineering analysis, and data-driven case studies.</p>
                    <div class="breadcrumb-custom">
                        <div class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/home"> Home</a>
                        </div>
                        <div class="breadcrumb-separator"></div>
                        <div class="breadcrumb-item-custom active">
                            Research & Insights
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="blog-content" x-show="view === 'index'" x-cloak>
        <div class="container">
            <!-- Filter Navigation -->
            <div class="filter-container">
            <div class="filter-pill" :class="{ 'active': currentCategory === 'all' }" @click="setCategory('all')">All Research</div>
            <?php foreach ($categories as $category): ?>
                <div class="filter-pill" :class="{ 'active': currentCategory === '<?= $category['slug'] ?>' }" @click="setCategory('<?= $category['slug'] ?>')"><?= htmlspecialchars($category['name']) ?></div>
            <?php endforeach; ?>
        </div>

        <!-- Research Grid -->
        <div class="row" x-show="!loading">
            <template x-for="blog in blogs" :key="blog.uuid">
                <div class="col-lg-4 col-md-6 research-card-col">
                    <div class="research-card" @click="loadArticle(blog.slug)">
                        <div class="card-img-wrap">
                            <img :src="blog.image_path" :alt="blog.title">
                            <div class="card-category" x-text="`[ ${blog.category_name} ]` "></div>
                        </div>
                        <div class="card-body-content">
                            <h3 x-text="blog.title"></h3>
                            <p x-text="blog.summary"></p>
                            <span class="read-link">
                                Read Insight <i class="material-symbols-outlined">trending_flat</i>
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading insights...</p>
        </div>

        <div x-show="!loading && blogs.length === 0" class="text-center py-5">
            <p class="text-muted">No research articles found in this category.</p>
        </div>
        
        </div> <!-- End container -->
    </div> <!-- End blog-content -->

    <!-- Detail View Container -->
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
                    // If we started on a detail page (SSR), we'll need to handle it
                    // but for now, we assume it's already rendered by PHP in the detail view.
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
                if (progressBar) progressBar.style.width = percent + '%';
            },

        }));
    });
</script>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
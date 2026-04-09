<!-- Material Symbols for Blog UI -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    :root {
        --primary-orange: #f48221;
        --primary-dark: #262626;
        --bg-light: #f9fafb;
    }

    /* Standard Project Wrapper */
    .wraper {
        position: relative;
        background-color: var(--bg-light);
        display: block;
        width: 100%;
    }

    .blog-wrapper {
        background-color: var(--bg-light);
        padding-top: 150px;
        padding-bottom: 100px;
        display: block;
        width: 100%;
        clear: both;
    }

    /* Hero Section Refinement */
    .blog-hero {
        text-align: center;
        margin-bottom: 80px;
        position: relative;
    }

    .hero-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 18px;
        border-radius: 50px;
        background-color: rgba(244, 130, 33, 0.12);
        border: 1px solid rgba(244, 130, 33, 0.25);
        font-family: 'Poppins', sans-serif;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #f48221;
        margin-bottom: 25px;
    }

    .hero-eyebrow-pill .material-symbols-outlined {
        font-size: 16px;
    }

    .blog-hero h1 {
        font-size: 56px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 25px;
        line-height: 1.1;
    }

    .blog-hero h1 span {
        color: var(--primary-orange);
    }

    .blog-hero p {
        font-size: 18px;
        max-width: 720px;
        margin: 0 auto;
        color: #797979;
        line-height: 1.7;
    }

    /* Filter Pills */
    .filter-container {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 10px 28px;
        border-radius: 50px;
        background: #fff;
        border: 1px solid #eee;
        font-weight: 600;
        font-size: 13px;
        color: #797979;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none !important;
    }

    .filter-pill.active,
    .filter-pill:hover {
        background: var(--primary-orange);
        color: #fff;
        border-color: var(--primary-orange);
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.2);
    }

    /* Research Card Grid Spacing */
    .research-card-col {
        margin-bottom: 50px !important;
    }

    /* Synchronized Research Card */
    .research-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eee;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        cursor: pointer;
    }

    .research-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.1);
    }

    .card-img-wrap {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: #262626;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .research-card:hover .card-img-wrap img {
        transform: scale(1.08);
    }

    .card-img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17, 24, 39, 0.7), transparent);
    }

    .card-category {
        position: absolute;
        bottom: 20px;
        left: 20px;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        z-index: 2;
    }

    .card-body-content {
        padding: 35px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-body-content h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 15px;
        line-height: 1.3;
        transition: color 0.3s;
    }

    .research-card:hover h3 {
        color: var(--primary-orange);
    }

    .card-body-content p {
        font-size: 14px;
        color: #797979;
        line-height: 1.6;
        margin-bottom: 30px;
        flex-grow: 1;
    }

    .read-link {
        color: var(--primary-orange);
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
    }

    .read-link i {
        font-size: 18px;
        transition: transform 0.3s;
    }

    .research-card:hover .read-link i {
        transform: translateX(5px);
    }

    /* Detail View Styling */
    .reading-progress {
        height: 4px;
        background: var(--primary-orange);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        width: 0%;
        transition: width 0.1s ease-out;
    }

    .article-main {
        padding-top: 120px;
        padding-bottom: 100px;
    }

    .hero-wrap {
        position: relative;
        height: 450px;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .hero-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,24,39,0.9), transparent);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    .hero-overlay h1 {
        color: #fff;
        font-size: 48px;
        font-weight: 700;
        line-height: 1.2;
        max-width: 900px;
    }
    .hero-overlay .badge {
        background: var(--primary-orange);
        color: #fff;
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        width: fit-content;
        margin-bottom: 20px;
    }

    .reading-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 50px;
    }
    .author-box {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .author-icon {
        width: 45px;
        height: 45px;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-orange);
    }
    .author-info h6 {
        margin: 0;
        font-weight: 700;
        font-size: 14px;
    }
    .author-info span {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
    }
    .meta-stats {
        display: flex;
        gap: 30px;
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .article-content {
        font-size: 18px;
        line-height: 1.8;
        color: #374151;
    }
    .article-content p {
        margin-bottom: 25px;
    }
    .article-content h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-top: 50px;
        margin-bottom: 20px;
    }
    .abstract {
        font-size: 20px;
        color: #4b5563;
        font-style: italic;
        border-left: 4px solid #eee;
        padding-left: 25px;
        margin-bottom: 40px;
        font-weight: 300;
    }
    .callout {
        background: #fffcf9;
        border-left: 4px solid var(--primary-orange);
        padding: 35px;
        border-radius: 0 15px 15px 0;
        margin: 40px 0;
    }
    .callout h5 {
        color: var(--primary-orange);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    .article-img {
        width: 100%;
        border-radius: 20px;
        margin: 40px 0;
    }

    .related-section {
        margin-top: 80px;
        padding-top: 60px;
        border-top: 1px solid #eee;
    }
    .related-section h4 {
        margin-bottom: 30px;
        font-weight: 700;
    }
    .related-card {
        border: 1px solid #eee;
        padding: 30px;
        border-radius: 20px;
        transition: all 0.3s;
        height: 100%;
        display: block;
        text-decoration: none !important;
    }
    .related-card:hover {
        border-color: rgba(244,130,33,0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transform: translateY(-5px);
    }
    .related-card .tag {
        color: var(--primary-orange);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 12px;
        display: block;
    }
    .related-card h5 {
        font-size: 18px;
        color: var(--primary-dark);
        font-weight: 700;
    }

    [x-cloak] { display: none !important; }
</style>

<div id="progress-bar" class="reading-progress"></div>
<main class="blog-wrapper" x-data="blogManager()" @popstate.window="handlePopState($event)" @scroll.window.passive="updateProgress()">
    <div class="container" x-show="view === 'index'" x-cloak>

        <!-- Hero Section -->
        <div class="blog-hero">
            <span class="hero-eyebrow-pill">
                <span class="material-symbols-outlined">auto_awesome</span>
                Industrial Knowledge Base
            </span>
            <h1>Technical Intelligence & <br><span>Global Impact</span></h1>
            <p>Exploring the industrial frontier through rigorous technical research, engineering analysis, and data-driven case studies.</p>
        </div>

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
    </div>

    <!-- Detail View Container -->
    <div id="article-detail-container" x-show="view === 'detail'" x-cloak>
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
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                this.detailContent = html;
                this.view = 'detail';
                window.scrollTo({ top: 0, behavior: 'smooth' });
                history.pushState({ view: 'detail', slug: slug }, '', `<?= BASE_URL ?>/blog/${slug}`);
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
                history.replaceState({ view: 'index' }, '', `<?= BASE_URL ?>/blog`);
            }
        },

        updateProgress() {
            if (this.view !== 'detail') return;
            const h = document.documentElement,
                  b = document.body,
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            const percent = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
            const progressBar = document.getElementById('progress-bar');
            if (progressBar) progressBar.style.width = percent + '%';
        },

    }));
});
</script>

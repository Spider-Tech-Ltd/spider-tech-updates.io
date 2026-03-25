<section class="forum-hero py-5" style="background: #f8f9fa;">
    <div class="container text-center">
        <h1 class="forum-hero-heading">Welcome to the Community</h1>
        <p class="forum-hero-subtext">Find answers, ask questions, and connect with experts.</p>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="forum-search-container">
                    <form action="" class="forum-input-group d-flex align-items-center">
                        <input type="text" class="forum-search-input" placeholder="Search discussions...">
                        <button class="forum-btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="forum-categories py-5">
    <div class="container">
        <div class="row">
            <?php if(!empty($categories)): ?>
                <?php foreach($categories as $category): ?>
                <div class="col-md-4">
                    <div class="forum-category-card">
                        <h5><?= $category['category_name']; ?></h5>
                        <p><?= $category['category_description'] ?? 'Join the conversation.'; ?></p>
                        <a href="<?= BASE_URL ?>/forum?category=<?= $category['category_uuid']; ?>" class="forum-view-link">View Discussions</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No categories found.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
/**
 * Start Discussion Page — MVC View
 * This view is rendered by ForumController::newTopic()
 */
?>




<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-new-topic.css?v=<?= filemtime(ROOT_PATH . '/css/forum-new-topic.css') ?>" />

<div class="new-topic-wrapper" x-data="newTopicForm()">
    <!-- Success Celebration Overlay -->
    <template x-if="showSuccess">
        <div class="success-overlay" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="success-circle">
                <span class="material-symbols-outlined" style="font-size: 48px;">check</span>
            </div>
            <h2 class="success-title">Topic Published!</h2>
            <p class="success-subtitle">Your industrial discussion is now live.</p>
            <div class="success-actions">
                <a :href="newPostUrl" class="btn-view-post">View Post</a>
                <a href="feed" class="btn-back-feed">Back to Feed</a>
            </div>
        </div>
    </template>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Composition Header -->
                <div class="comp-header">
                    <div>
                        <h1 class="comp-title">Start a New Discussion</h1>
                        <p class="text-muted" x-show="draftRecovered" x-transition style="font-size: 0.8rem; margin-top: -5px;">
                            <span class="material-symbols-outlined" style="font-size:12px; vertical-align:middle;">history</span> Draft restored from your last session.
                        </p>
                    </div>
                    <button class="btn-discard" @click="discard()">Discard Draft</button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Editor Column -->
            <div class="col-lg-8">
                <section class="editor-card">
                    <!-- Title Input -->
                    <div class="mb-4" :class="{ 'has-error': errors.title }">
                        <label class="field-label">Discussion Title</label>
                        <input type="text" 
                               class="topic-title-input" 
                               placeholder="What's on your mind?..." 
                               x-model="title" 
                               maxlength="100"
                               @input="errors.title = false"
                               autofocus>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="field-error-text" x-show="errors.title">Please provide a descriptive title (min. 5 chars).</span>
                            <div class="ml-auto">
                                <small :class="title.length >= 90 ? 'text-danger' : 'text-muted'" style="font-size: 0.7rem;">
                                    <span x-text="title.length"></span>/100
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Category Selection -->
                    <div class="mb-4" :class="{ 'has-error': errors.category }">
                        <label class="field-label">Select Category</label>
                        <div class="cat-pill-group mb-2">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <button type="button" class="cat-pill" 
                                         :class="{ 'active': category_id === '<?= $cat['uuid'] ?>' }"
                                         @click="category_id = '<?= $cat['uuid'] ?>'; errors.category = false">
                                        <span class="material-symbols-outlined" style="font-size: 14px;"><?= htmlspecialchars($cat['icon'] ?? 'label') ?></span>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <span class="field-error-text" x-show="errors.category">Please select a category for your topic.</span>
                    </div>

                    <!-- Rich Text Editor -->
                    <div :class="{ 'has-error': errors.content }">
                        <div class="editor-area-wrapper">
                            <div class="editor-toolbar">
                                <button type="button" class="tool-btn" title="Bold" @click="formatText('bold')" :class="{ 'active': activeStates.bold }">
                                    <span class="material-symbols-outlined">format_bold</span>
                                </button>
                                <button type="button" class="tool-btn" title="Italic" @click="formatText('italic')" :class="{ 'active': activeStates.italic }">
                                    <span class="material-symbols-outlined">format_italic</span>
                                </button>
                                <button type="button" class="tool-btn" title="Link" @click="addLink()" :class="{ 'active': activeStates.link }">
                                    <span class="material-symbols-outlined">link</span>
                                </button>
                                <button type="button" class="tool-btn" title="Code" @click="formatText('formatBlock', 'PRE')" :class="{ 'active': activeStates.code }">
                                    <span class="material-symbols-outlined">code</span>
                                </button>
                                <button type="button" class="tool-btn" title="Attach Image" @click="$refs.imageInput.click()" :disabled="uploading">
                                    <span class="material-symbols-outlined" x-show="!uploading">image</span>
                                    <div class="spinner-border spinner-border-sm" x-show="uploading"></div>
                                </button>
                                <input type="file" x-ref="imageInput" class="d-none" accept="image/*" @change="handleImageUpload($event)">
                            </div>
                            <div class="editor-contenteditable" 
                                 contenteditable="true"
                                 placeholder="Describe your topic in detail..." 
                                 x-ref="editor"
                                 @input="content = $el.innerHTML; errors.content = false"
                                 @blur="saveDraft()"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="field-error-text" x-show="errors.content">Content is too short. Please elaborate.</span>
                            <div class="ml-auto">
                                <small :class="content.length >= 1900 ? 'text-danger' : 'text-muted'" style="font-size: 0.7rem;">
                                    <span x-text="content.length"></span>/2000 characters
                                </small>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Action Card -->
                <div class="sidebar-card" style="background: #fffbf7; border: 1px dashed #f48221;">
                    <button class="btn-post" @click="submitTopic()" :disabled="submitting">
                        <span class="material-symbols-outlined" x-show="!submitting">send</span>
                        <span x-text="submitting ? 'Posting...' : 'Post Discussion'"></span>
                    </button>
                    <p style="font-size: 0.75rem; color: #797979; margin-top: 15px; margin-bottom: 0; text-align:center;">
                        Your topic will be visible to the community instantly.
                    </p>
                </div>

                <!-- Community Guidelines -->
                <div class="sidebar-card">
                    <h3 style="font-family:'Poppins'; font-weight:700; font-size:1rem; margin-bottom:16px; color:#111;">Guidelines</h3>
                    <ul class="guidelines-list">
                        <li>
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>Search before posting to avoid duplicates.</span>
                        </li>
                        <li>
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>Keep discussions professional and technical.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function newTopicForm() {
    return {
        title: '',
        content: '',
        category_id: '',
        submitting: false,
        uploading: false,
        draftRecovered: false,
        showSuccess: false,
        newPostUrl: '',
        errors: {
            title: false,
            content: false,
            category: false
        },
        activeStates: {
            bold: false,
            italic: false,
            link: false,
            code: false
        },
        
        // Keep mapping for URL inheritance
        categoryMap: <?= json_encode(array_column($categories ?? [], 'uuid', 'slug')) ?>,
        categorySlugMap: <?= json_encode(array_column($categories ?? [], 'slug', 'uuid')) ?>,

        init() {
            // 1. Recover Draft
            const savedDraft = localStorage.getItem('spider_forum_draft');
            if (savedDraft) {
                try {
                    const draft = JSON.parse(savedDraft);
                    if (draft.title || draft.content) {
                        this.title = draft.title || '';
                        this.content = draft.content || '';
                        this.$nextTick(() => { this.$refs.editor.innerHTML = this.content; });
                        this.category_id = draft.category_id || '';
                        this.draftRecovered = true;
                        setTimeout(() => this.draftRecovered = false, 5000);
                    }
                } catch (e) {
                    console.warn('Draft corrupted, cleared.');
                    localStorage.removeItem('spider_forum_draft');
                }
            }

            // 2. Override with URL context if present (High Priority)
            const urlParams = new URLSearchParams(window.location.search);
            const catSlug = urlParams.get('category');
            if (catSlug && this.categoryMap[catSlug]) {
                this.category_id = this.categoryMap[catSlug];
            }

            // 3. Auto-save watcher
            this.$watch('title', () => this.saveDraft());
            this.$watch('content', () => this.saveDraft());
            this.$watch('category_id', (id) => {
                this.saveDraft();
                this.syncUrl(id);
            });

            // 4. Update active states on selection
            document.addEventListener('selectionchange', () => {
                const sel = window.getSelection();
                if (sel.rangeCount > 0 && this.$refs.editor.contains(sel.anchorNode)) {
                    this.updateActiveStates();
                }
            });
        },

        updateActiveStates() {
            this.activeStates.bold = document.queryCommandState('bold');
            this.activeStates.italic = document.queryCommandState('italic');
            this.activeStates.link = document.queryCommandState('createLink');
            
            // Check for PRE block (code)
            const parent = window.getSelection().anchorNode?.parentElement;
            this.activeStates.code = parent && (parent.tagName === 'PRE' || parent.closest('pre'));
        },

        saveDraft() {
            localStorage.setItem('spider_forum_draft', JSON.stringify({
                title: this.title,
                content: this.content,
                category_id: this.category_id,
                timestamp: Date.now()
            }));
        },

        syncUrl(id) {
            const slug = this.categorySlugMap[id];
            if (slug) {
                const url = new URL(window.location.href);
                url.searchParams.set('category', slug);
                window.history.replaceState({}, '', url);
            }
        },

        formatText(command, value = null) {
            this.$refs.editor.focus();
            document.execCommand(command, false, value);
            this.content = this.$refs.editor.innerHTML;
            this.saveDraft();
        },

        addLink() {
            this.$refs.editor.focus();
            const url = prompt('Enter the industrial link (e.g., https://...):');
            if (url) {
                document.execCommand('createLink', false, url);
                this.content = this.$refs.editor.innerHTML;
                this.saveDraft();
            }
        },

        async handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploading = true;
            const formData = new FormData();
            formData.append('image', file);
            formData.append('csrf_token', '<?= CSRF::generateToken() ?>');

            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/upload', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    this.$refs.editor.focus();
                    const imgHtml = `<img src="${result.url}" alt="Industrial Technical Image">`;
                    document.execCommand('insertHTML', false, imgHtml);
                    this.content = this.$refs.editor.innerHTML;
                    this.errors.content = false;
                    this.saveDraft();
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error('Upload error:', error);
            } finally {
                this.uploading = false;
                event.target.value = '';
            }
        },

        async submitTopic() {
            // Reset Errors
            this.errors = { title: false, content: false, category: false };

            // Validate
            let hasErrors = false;
            if (this.title.trim().length < 5) { this.errors.title = true; hasErrors = true; }
            if (!this.category_id) { this.errors.category = true; hasErrors = true; }
            if (this.content.trim().length < 10) { this.errors.content = true; hasErrors = true; }

            if (hasErrors) return;

            this.submitting = true;
            try {
                // Fix pathing: Page is at 'forum/new-topic', endpoint is 'forum/feed/store'
                // Relative to 'forum/', the path is 'feed/store'.
                const response = await fetch('<?= BASE_URL ?>/forum/feed/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        title: this.title,
                        content: this.content,
                        category_uuid: this.category_id,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });

                const result = await response.json();
                if (result.success) {
                    localStorage.removeItem('spider_forum_draft');
                    this.newPostUrl = result.view_url;
                    this.showSuccess = true;
                } else {
                    alert(result.message || 'Error publishing discussion.');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.submitting = false;
            }
        },

        discard() {
            if (confirm('Are you sure you want to discard this draft? This cannot be undone.')) {
                localStorage.removeItem('spider_forum_draft');
                this.title = '';
                this.content = '';
                this.$refs.editor.innerHTML = '';
                window.location.href = 'feed';
            }
        }
    }
}
</script>

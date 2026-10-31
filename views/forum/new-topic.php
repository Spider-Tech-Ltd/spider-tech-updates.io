<?php
/**
 * Start Discussion Page — MVC View
 * This view is rendered by ForumController::newTopic()
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-new-topic.css?v=<?= filemtime(ROOT_PATH . '/css/forum-new-topic.css') ?>" />

<div class="new-topic-wrapper" x-data="newTopicForm()">
    <!-- Success Celebration Modal Overlay -->
    <template x-if="showSuccess">
        <div class="success-overlay" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="success-modal-card">
                <div class="success-circle">
                    <span class="material-symbols-outlined">check</span>
                </div>
                <h2 class="success-title">Topic Published!</h2>
                <p class="success-subtitle">Your discussion is now live and visible to the technical community.</p>
                <div class="success-actions">
                    <a :href="newPostUrl" class="btn-view-post">
                        <span>View Discussion</span>
                    </a>
                    <a href="feed" class="btn-back-feed">
                        <span>Back to Feed</span>
                    </a>
                </div>
            </div>
        </div>
    </template>

    <!-- Custom Branded Discard Confirmation Modal -->
    <template x-if="showDiscardModal">
        <div class="modal-backdrop-blur" 
             x-transition:enter="transition ease-out duration-250" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="showDiscardModal = false"
             @keydown.escape.window="showDiscardModal = false"
             tabindex="-1">
            <div class="discard-modal-card" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-90 translate-y-3" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-90 translate-y-3">
                <div class="discard-circle">
                    <span class="material-symbols-outlined">delete_forever</span>
                </div>
                <h2 class="discard-modal-title">Discard Discussion Draft?</h2>
                <p class="discard-modal-subtitle">
                    Are you sure you want to discard this draft? All unsaved title, content, and category selections will be permanently cleared.
                </p>
                <div class="discard-modal-actions">
                    <button type="button" class="btn-modal-cancel" @click="showDiscardModal = false">
                        <span class="material-symbols-outlined">edit</span>
                        <span>Keep Editing</span>
                    </button>
                    <button type="button" class="btn-modal-discard" @click="confirmDiscard()">
                        <span class="material-symbols-outlined">delete</span>
                        <span>Discard &amp; Exit</span>
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Top Banner Section (Soft Light Orange Grid) -->
    <section class="new-topic-banner">
        <div class="container">
            <!-- Back Navigation -->
            <div class="detail-nav">
                <a href="feed" class="back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Back to Feed</span>
                </a>
            </div>

            <!-- Composition Header -->
            <div class="comp-header">
                <div class="comp-header-meta">
                    <div class="comp-eyebrow">
                        <span class="material-symbols-outlined" style="font-size:13px;">terminal</span>
                        <span>Discussion Composition</span>
                    </div>
                    <h1 class="comp-title">Start a New Discussion</h1>
                    <p class="comp-subtitle" x-show="!draftRecovered">Share technical challenges, insights, or project inquiries with the community.</p>
                    <p class="text-success" x-show="draftRecovered" x-transition style="font-size: 0.82rem; margin: 4px 0 0 0; font-family:'Poppins', sans-serif; font-weight:600;">
                        <span class="material-symbols-outlined" style="font-size:14px; vertical-align:middle;">history</span> Draft restored from your previous session.
                    </p>
                </div>
                <button type="button" class="btn-discard" @click="discard()">
                    <span class="material-symbols-outlined">delete_outline</span>
                    <span>Discard Draft</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="new-topic-content-section">
        <div class="container">
            <div class="row">
                <!-- Main Editor Column -->
                <div class="col-lg-8">
                    <section class="editor-card">
                        <!-- Title Input -->
                        <div class="mb-4" :class="{ 'has-error': errors.title }">
                            <label class="field-label">
                                <span>Discussion Title</span>
                                <span class="field-label-desc">— Keep it clear and descriptive</span>
                            </label>
                            <input type="text" 
                                   class="topic-title-input" 
                                   placeholder="e.g. Optimizing embedded edge telemetry via MQTT and ESP32..." 
                                   x-model="title" 
                                   maxlength="100"
                                   @input="errors.title = false"
                                   autofocus>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="field-error-text" x-show="errors.title">
                                    <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                    Please provide a descriptive title (min. 5 chars).
                                </span>
                                <div class="ml-auto">
                                    <small :class="title.length >= 90 ? 'text-danger fw-bold' : 'text-muted'" style="font-size: 0.72rem; font-family:'Chakra Petch', monospace;">
                                        <span x-text="title.length"></span>/100
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Category Selection with Accessible Horizontal Scroll -->
                        <div class="mb-4" :class="{ 'has-error': errors.category }">
                            <label class="field-label">
                                <span>Select Category</span>
                                <span class="field-label-desc">— Assign your topic to the most relevant field</span>
                            </label>

                            <div class="form-category-switcher-wrap" x-ref="catSwitcherWrap">
                                <!-- Left Blur Fade Overlay -->
                                <div class="cat-scroll-blur left" 
                                     x-show="canScrollLeft" 
                                     x-transition.opacity.duration.250ms
                                     aria-hidden="true" 
                                     style="display: none;"></div>

                                <!-- Left Inward Arrow Button -->
                                <button type="button" 
                                        class="cat-scroll-arrow-btn prev" 
                                        x-show="canScrollLeft" 
                                        x-transition.opacity.duration.200ms
                                        @click="scrollCatLeft()" 
                                        aria-label="Scroll categories left"
                                        style="display: none;">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>

                                <!-- Scrollable Capsule Container -->
                                <div class="form-category-switcher" 
                                     x-ref="catSwitcher" 
                                     @scroll.passive="updateCatScrollArrows()"
                                     @wheel="handleCatWheel($event)"
                                     role="tablist" 
                                     aria-label="Topic Categories">
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <button type="button" 
                                                    class="form-category-btn" 
                                                    :class="{ 'active': category_id === '<?= $cat['uuid'] ?>' }"
                                                    @click="selectCategory('<?= $cat['uuid'] ?>', $el)"
                                                    role="tab"
                                                    :aria-selected="(category_id === '<?= $cat['uuid'] ?>').toString()">
                                                <span class="material-symbols-outlined cat-btn-icon"><?= htmlspecialchars($cat['icon'] ?? 'label') ?></span>
                                                <span class="cat-btn-name"><?= htmlspecialchars($cat['name']) ?></span>
                                                <?php if (isset($cat['topic_count'])): ?>
                                                    <span class="cat-btn-badge"><?= $cat['topic_count'] ?></span>
                                                <?php endif; ?>
                                            </button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <!-- End Spacer so rightmost tab never clips -->
                                    <span class="cat-scroll-end-spacer" aria-hidden="true"></span>
                                </div>

                                <!-- Right Blur Fade Overlay -->
                                <div class="cat-scroll-blur right" 
                                     x-show="canScrollRight" 
                                     x-transition.opacity.duration.250ms
                                     aria-hidden="true" 
                                     style="display: none;"></div>

                                <!-- Right Inward Arrow Button -->
                                <button type="button" 
                                        class="cat-scroll-arrow-btn next" 
                                        x-show="canScrollRight" 
                                        x-transition.opacity.duration.200ms
                                        @click="scrollCatRight()" 
                                        aria-label="Scroll categories right"
                                        style="display: none;">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>

                            <span class="field-error-text" x-show="errors.category">
                                <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                Please select a category for your topic.
                            </span>
                        </div>

                        <!-- Rich Text Editor -->
                        <div :class="{ 'has-error': errors.content }">
                            <label class="field-label">
                                <span>Discussion Content</span>
                                <span class="field-label-desc">— Technical details, code, and schematics</span>
                            </label>
                            <div class="editor-area-wrapper">
                                <div class="editor-toolbar">
                                    <button type="button" class="tool-btn" title="Bold" @click="formatText('bold')" :class="{ 'active': activeStates.bold }">
                                        <span class="material-symbols-outlined">format_bold</span>
                                    </button>
                                    <button type="button" class="tool-btn" title="Italic" @click="formatText('italic')" :class="{ 'active': activeStates.italic }">
                                        <span class="material-symbols-outlined">format_italic</span>
                                    </button>
                                    <button type="button" class="tool-btn" title="Insert Link" @click="addLink()" :class="{ 'active': activeStates.link }">
                                        <span class="material-symbols-outlined">link</span>
                                    </button>
                                    <button type="button" class="tool-btn" title="Code Block" @click="formatText('formatBlock', 'PRE')" :class="{ 'active': activeStates.code }">
                                        <span class="material-symbols-outlined">code</span>
                                    </button>
                                    <div class="tool-divider"></div>
                                    <button type="button" class="tool-btn" title="Attach Technical Image" @click="$refs.imageInput.click()" :disabled="uploading">
                                        <span class="material-symbols-outlined" x-show="!uploading">image</span>
                                        <div class="spinner-border spinner-border-sm" x-show="uploading"></div>
                                    </button>
                                    <input type="file" x-ref="imageInput" class="d-none" accept="image/*" @change="handleImageUpload($event)">
                                </div>
                                <div class="editor-contenteditable" 
                                     contenteditable="true"
                                     placeholder="Describe your technical challenge, implementation findings, system architecture, or questions in detail..." 
                                     x-ref="editor"
                                     @input="content = $el.innerHTML; errors.content = false"
                                     @blur="saveDraft()"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="field-error-text" x-show="errors.content">
                                    <span class="material-symbols-outlined" style="font-size:14px;">error</span>
                                    Content is too short. Please elaborate with sufficient details (min. 10 chars).
                                </span>
                                <div class="ml-auto">
                                    <small :class="content.length >= 1900 ? 'text-danger fw-bold' : 'text-muted'" style="font-size: 0.72rem; font-family:'Chakra Petch', monospace;">
                                        <span x-text="content.length"></span>/2000 characters
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions Footer (Notice Above, Balanced Buttons Below) -->
                        <div class="form-actions-footer">
                            <!-- Full-Width Notice (Unbroken single line) -->
                            <div class="form-publish-notice">
                                <span class="material-symbols-outlined">info</span>
                                <span>Your topic will be indexed and visible immediately across the technical feed.</span>
                            </div>

                            <!-- Balanced Action Buttons -->
                            <div class="form-publish-buttons">
                                <button type="button" class="btn-discard" @click="discard()">
                                    <span class="material-symbols-outlined">delete_outline</span>
                                    <span>Discard Draft</span>
                                </button>
                                <button type="button" class="btn-post" @click="submitTopic()" :disabled="submitting">
                                    <span class="material-symbols-outlined" x-show="!submitting">send</span>
                                    <span class="spinner-border spinner-border-sm" x-show="submitting" role="status" aria-hidden="true"></span>
                                    <span x-text="submitting ? 'Publishing Discussion...' : 'Publish Discussion'"></span>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar Column (Lifted & Aligned to Form Top) -->
                <div class="col-lg-4">
                    <!-- Community Guidelines -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-card-title">
                            <span class="material-symbols-outlined">verified</span>
                            <span>Posting Guidelines</span>
                        </h3>
                        <ul class="guidelines-list">
                            <li>
                                <span class="material-symbols-outlined">check_circle</span>
                                <span>Search existing discussions before posting to prevent duplicate inquiries.</span>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">check_circle</span>
                                <span>Provide specific hardware versions, firmware builds, or error traces when asking questions.</span>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">check_circle</span>
                                <span>Maintain professional, collaborative, and constructive communication.</span>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">check_circle</span>
                                <span>Format code and configuration blocks cleanly using the code tool.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Formatting Tips -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-card-title">
                            <span class="material-symbols-outlined">lightbulb</span>
                            <span>Formatting Tips</span>
                        </h3>
                        <ul class="guidelines-list">
                            <li>
                                <span class="material-symbols-outlined">code</span>
                                <span>Use the code tool to cleanly present scripts, logs, or API payloads.</span>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">image</span>
                                <span>Upload wiring schematics or diagnostic screenshots to clarify edge issues.</span>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">save</span>
                                <span>Drafts automatically persist in your local browser storage if interrupted.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        showDiscardModal: false,
        newPostUrl: '',
        canScrollLeft: false,
        canScrollRight: false,
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

            // 3. Initialize Category Scroll Nav
            this.initCatScrollNav();

            // 4. Auto-save watcher
            this.$watch('title', () => this.saveDraft());
            this.$watch('content', () => this.saveDraft());
            this.$watch('category_id', (id) => {
                this.saveDraft();
                this.syncUrl(id);
            });

            // 5. Update active states on selection
            document.addEventListener('selectionchange', () => {
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0 && this.$refs.editor && this.$refs.editor.contains(sel.anchorNode)) {
                    this.updateActiveStates();
                }
            });
        },

        initCatScrollNav() {
            this.$nextTick(() => {
                this.updateCatScrollArrows();
                const switcher = this.$refs.catSwitcher;
                if (switcher) {
                    const activeTab = switcher.querySelector('.form-category-btn.active');
                    if (activeTab) {
                        activeTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    }
                }
            });
            window.addEventListener('resize', () => this.updateCatScrollArrows(), { passive: true });
        },

        updateCatScrollArrows() {
            const el = this.$refs.catSwitcher;
            if (!el) return;
            this.canScrollLeft = el.scrollLeft > 6;
            this.canScrollRight = (el.scrollLeft + el.clientWidth) < (el.scrollWidth - 8);
        },

        scrollCatLeft() {
            const el = this.$refs.catSwitcher;
            if (el) {
                el.scrollBy({ left: -220, behavior: 'smooth' });
                setTimeout(() => this.updateCatScrollArrows(), 320);
            }
        },

        scrollCatRight() {
            const el = this.$refs.catSwitcher;
            if (el) {
                el.scrollBy({ left: 220, behavior: 'smooth' });
                setTimeout(() => this.updateCatScrollArrows(), 320);
            }
        },

        handleCatWheel(e) {
            const el = this.$refs.catSwitcher;
            if (!el) return;
            if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
            if (el.scrollWidth > el.clientWidth) {
                e.preventDefault();
                el.scrollLeft += e.deltaY;
                this.updateCatScrollArrows();
            }
        },

        selectCategory(uuid, element) {
            this.category_id = uuid;
            this.errors.category = false;
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
            setTimeout(() => this.updateCatScrollArrows(), 300);
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
            this.showDiscardModal = true;
        },

        confirmDiscard() {
            localStorage.removeItem('spider_forum_draft');
            this.title = '';
            this.content = '';
            if (this.$refs.editor) {
                this.$refs.editor.innerHTML = '';
            }
            this.showDiscardModal = false;
            window.location.href = 'feed';
        }
    }
}
</script>

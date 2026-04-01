<?php
/**
 * Start Discussion Page — MVC View
 * This view is rendered by ForumController::newTopic()
 */
?>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

<style>
  /* ============================
     BASE & LAYOUT
     ============================ */
  body { background-color: #f8f9fa; }
  .header-top { display: none !important; }
  .new-topic-wrapper { 
    padding-top: 100px; 
    padding-bottom: 80px; 
  } 

  /* ============================
     COMPOSITION HEADER
     ============================ */
  .comp-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
  }
  .comp-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.8rem;
    color: #111111;
  }
  .btn-discard {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    color: #555555;
    background-color: #f1f3f5;
    border: none;
    padding: 8px 20px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-discard:hover {
    background-color: #e9ecef;
    color: #111111;
  }

  /* ============================
     EDITOR CARD
     ============================ */
  .editor-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
  }

  .topic-title-input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #f1f3f5;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    padding: 10px 0;
    margin-bottom: 24px;
    color: #111111;
    transition: border-color 0.3s ease;
  }
  .topic-title-input:focus {
    outline: none;
    border-color: #f48221;
  }
  .topic-title-input::placeholder { color: #ced4da; }

  .field-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    color: #111111;
    margin-bottom: 12px;
    display: block;
  }

  /* Category Pills */
  .cat-pill-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 32px;
  }
  .cat-pill {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 6px 16px;
    border-radius: 50px;
    border: 1.5px solid #e9ecef;
    background: #f8f9fa;
    color: #555555;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .cat-pill:hover { border-color: #f48221; color: #f48221; transform: translateY(-1px); }
  .cat-pill:active { transform: scale(0.95); }
  .cat-pill.active {
    background-color: #f48221;
    border-color: #f48221;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(244, 130, 33, 0.3);
    font-weight: 700;
  }
  .cat-pill.active .material-symbols-outlined { color: #fff; }

  /* Rich Text Editor Placeholder */
  .editor-area-wrapper {
    background: #f8f9fa;
    border-radius: 12px;
    border: 1.5px solid #e9ecef;
    overflow: hidden;
    margin-bottom: 24px;
  }
  .editor-toolbar {
    background: #ffffff;
    padding: 10px 15px;
    border-bottom: 1.5px solid #e9ecef;
    display: flex;
    gap: 15px;
  }
  .tool-btn {
    background: none;
    border: none;
    color: #5f5e5e;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background 0.2s;
  }
  .tool-btn:hover { background: #f1f3f5; color: #f48221; }
  .tool-btn.active { background: #fdf2e9; color: #f48221; border: 1px solid rgba(244, 130, 33, 0.2); }

  .editor-textarea {
    width: 100%;
    min-height: 300px;
    padding: 20px;
    background: transparent;
    border: none;
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    line-height: 1.6;
    color: #333333;
    resize: vertical;
  }
  .editor-textarea:focus { outline: none; }

  /* ============================
     SIDEBAR WIDGETS
     ============================ */
  .sidebar-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    margin-bottom: 24px;
  }

  .btn-post {
    width: 100%;
    background-color: #f48221;
    color: #ffffff;
    border: none;
    padding: 14px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(244, 130, 33, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .btn-post:hover {
    background-color: #db7015;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(244, 130, 33, 0.35);
  }
  .btn-post:disabled {
    opacity: 0.7;
    cursor: wait;
    transform: none;
  }

  .guidelines-list {
    padding-left: 0;
    list-style: none;
    margin-bottom: 0;
  }
  .guidelines-list li {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #555555;
    margin-bottom: 10px;
    display: flex;
    gap: 10px;
  }
  .guidelines-list li .material-symbols-outlined {
    font-size: 16px;
    color: #f48221;
    flex-shrink: 0;
  }

  /* ============================
     UX & POLISH: ERRORS & SUCCESS
     ============================ */
  .field-error-text {
    color: #dc3545;
    font-size: 0.72rem;
    font-weight: 600;
    margin-top: 4px;
    display: block;
  }

  .cat-pill-group {
    transition: all 0.3s ease;
    border: 1.5px solid transparent;
    border-radius: 12px;
    padding: 10px;
  }

  .has-error .topic-title-input,
  .has-error .editor-area-wrapper,
  .has-error .cat-pill-group {
    border-color: #dc3545 !important;
    background-color: rgba(220, 53, 69, 0.02);
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
  }

  /* Success Celebration Overlay */
  .success-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
  }

  .success-circle {
    width: 80px;
    height: 80px;
    background: #4caf50;
    border-radius: 50%;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3);
  }

  .success-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    color: #111;
    margin-bottom: 5px;
  }

  .success-subtitle {
    color: #666;
    font-size: 1rem;
    margin-bottom: 20px;
  }

  .success-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
  }

  .btn-view-post {
    background-color: #f48221;
    color: #fff;
    padding: 10px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-family: 'Poppins';
    font-weight: 600;
    transition: all 0.3s;
  }

  .btn-view-post:hover {
    background-color: #db7015;
    transform: translateY(-2px);
    color: #fff;
  }

  .btn-back-feed {
    background-color: #f1f3f5;
    color: #555;
    padding: 10px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-family: 'Poppins';
    font-weight: 600;
    transition: all 0.3s;
  }

  /* RCT Editor Improvements */
  .editor-contenteditable {
    width: 100%;
    min-height: 300px;
    padding: 20px;
    background: transparent;
    border: none;
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    line-height: 1.6;
    color: #333333;
    outline: none;
  }
  .editor-contenteditable:empty:before {
    content: attr(placeholder);
    color: #ced4da;
    cursor: text;
  }
  .editor-contenteditable img {
    max-width: 100%;
    border-radius: 12px;
    margin: 10px 0;
    display: block;
  }
  .editor-contenteditable pre {
    background: #2d2d2d;
    color: #f8f8f2;
    padding: 15px;
    border-radius: 8px;
    font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    font-size: 0.9rem;
    overflow-x: auto;
    margin: 15px 0;
  }
  .editor-contenteditable code {
    background: #f1f3f5;
    padding: 2px 5px;
    border-radius: 4px;
    font-family: 'Consolas', 'Monaco', monospace;
    color: #e83e8c;
  }
</style>

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

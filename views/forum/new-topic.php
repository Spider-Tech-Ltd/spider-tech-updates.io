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
    transition: all 0.2s;
  }
  .cat-pill:hover { border-color: #f48221; color: #f48221; }
  .cat-pill.active {
    background-color: #f48221;
    border-color: #f48221;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(244, 130, 33, 0.2);
  }

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
</style>

<div class="new-topic-wrapper" x-data="newTopicForm()">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Composition Header -->
                <div class="comp-header">
                    <h1 class="comp-title">Start a New Discussion</h1>
                    <button class="btn-discard" @click="discard()">Discard Draft</button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Editor Column -->
            <div class="col-lg-8">
                <section class="editor-card">
                    <!-- Title Input -->
                    <input type="text" class="topic-title-input" placeholder="Discussion Title..." x-model="title" autofocus>

                    <!-- Category Selection -->
                    <label class="field-label">Select Category</label>
                    <div class="cat-pill-group">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <button type="button" class="cat-pill" 
                                     :class="{ 'active': category_uuid === '<?= $cat['uuid'] ?>' }"
                                     @click="category_uuid = '<?= $cat['uuid'] ?>'">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Editor Area -->
                    <label class="field-label">Discussion Content</label>
                    <div class="editor-area-wrapper">
                        <div class="editor-toolbar">
                            <button class="tool-btn" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                            <button class="tool-btn" title="Link"><span class="material-symbols-outlined">link</span></button>
                            <button class="tool-btn" title="Code"><span class="material-symbols-outlined">code</span></button>
                        </div>
                        <textarea class="editor-textarea" placeholder="Describe your industrial challenge or update here..." x-model="content"></textarea>
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
        category_uuid: '<?= $categories[0]['uuid'] ?? "" ?>',
        submitting: false,

        discard() {
            if(confirm('Are you sure you want to discard this draft?')) {
                window.location.href = '<?= BASE_URL ?>/forum/feed';
            }
        },

        async submitTopic() {
            if (!this.title.trim() || !this.content.trim() || !this.category_uuid) {
                alert('Please fill in all required fields.');
                return;
            }

            this.submitting = true;
            try {
                const response = await fetch('<?= BASE_URL ?>/forum/feed/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        title: this.title,
                        content: this.content,
                        category_uuid: this.category_uuid,
                        csrf_token: '<?= CSRF::generateToken() ?>'
                    })
                });
                const data = await response.json();
                if (data.success) {
                    window.location.href = '<?= BASE_URL ?>/forum/feed';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Connection error. Please try again.');
            } finally {
                this.submitting = false;
            }
        }
    }
}
</script>

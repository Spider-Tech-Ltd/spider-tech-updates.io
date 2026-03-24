<?php
/**
 * Dynamic Forum Feed Component
 * Enhanced with Likes and Replies integration.
 */
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../auth/FeedActions.php';

$feedActions = new FeedActions($conn);
$categoryFilter = $_GET['category'] ?? 'all';
$currentMemberId = $_SESSION['member_id'] ?? null;

try {
    $sql = "
        SELECT f.*, m.username as member_name, c.name as category_name, c.slug as category_slug
        FROM feeds f
        JOIN members m ON f.member_id = m.id
        JOIN categories c ON f.category_uuid = c.uuid
        WHERE f.status = 'published'
    ";

    $params = [];
    if ($categoryFilter !== 'all') {
        $sql .= " AND c.slug = ?";
        $params[] = $categoryFilter;
    }

    $sql .= " ORDER BY f.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $feeds = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Feed Fetch Error: " . $e->getMessage());
    $feeds = [];
}

if (!function_exists('time_ago')) {
    function time_ago($timestamp) {
        $time = strtotime($timestamp);
        $diff = time() - $time;
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return round($diff / 60) . ' mins ago';
        if ($diff < 86400) return round($diff / 3600) . ' hours ago';
        if ($diff < 604800) return round($diff / 86400) . ' days ago';
        return date('M j, Y', $time);
    }
}
?>

<style>
  /* ====== Discussion Card List Styles ====== */
  .discussion-card-list { display: flex; flex-direction: column; gap: 20px; }

  .discussion-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    display: block;
    text-decoration: none !important;
    transition: all 0.2s ease;
    position: relative;
  }
  .discussion-card:hover { border-color: #f48221; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

  .category-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 16px;
    background: #f1f5f9; color: #64748b;
  }

  .card-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.35rem; color: #1e293b; margin-bottom: 12px; }
  .card-excerpt { font-family: 'Open Sans', sans-serif; color: #64748b; line-height: 1.6; margin-bottom: 20px; }

  .card-author-row { display: flex; align-items: center; gap: 12px; }
  .author-avatar-sm { width: 32px; height: 32px; border-radius: 50%; }
  .author-name { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem; color: #1e293b; }
  .author-time { font-family: 'Open Sans', sans-serif; font-size: 0.8rem; color: #94a3b8; margin-left: auto; }

  .card-interaction-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
  }
  .btn-interact {
    background: none;
    border: none;
    display: flex;
    align-items: center;
    gap: 6px;
    color: #94a3b8;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 6px 14px;
    border-radius: 50px;
  }
  .btn-interact:hover { background-color: rgba(244, 130, 33, 0.08); color: #f48221; }
  .btn-interact.active { color: #f48221; background-color: rgba(244, 130, 33, 0.1); }
  .btn-interact .material-symbols-outlined { font-size: 18px; }
  .interact-spacer { flex: 1; }

  /* Reply Section Styles */
  .reply-section {
    display: none;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px dashed #e2e8f0;
  }
  .reply-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }
  .reply-item { background: #f8fafc; padding: 12px 16px; border-radius: 12px; font-size: 0.9rem; }
  .reply-author { font-weight: 700; color: #1e293b; margin-right: 8px; }
  .reply-content { color: #475569; }

  .reply-input-group { display: flex; gap: 10px; }
  .reply-input { flex: 1; height: 40px; border-radius: 20px; border: 1px solid #e2e8f0; padding: 0 16px; font-size: 0.85rem; outline: none; }
  .reply-input:focus { border-color: #f48221; }
  .btn-post-reply { width: 40px; height: 40px; border-radius: 50%; background: #f48221; color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; }

  .member-feed-pagination { display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 40px; }
  .pag-btn { display: inline-flex; align-items: center; gap: 4px; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.85rem; color: #f48221; background: none; border: 1.5px solid #f48221; padding: 8px 18px; border-radius: 50px; transition: all 0.2s ease; text-decoration: none !important; }
  .pag-btn:hover { background-color: #f48221; color: #ffffff; }
</style>

<div class="discussion-card-list">

  <?php if (empty($feeds)): ?>
    <div class="empty-feed">
        <span class="material-symbols-outlined empty-icon" style="font-size:48px; color:#cbd5e1; display:block; margin-bottom:16px;">forum</span>
        <p class="text-muted">No discussions found.</p>
    </div>
  <?php else: ?>
      <?php foreach ($feeds as $f):
          $likes = $feedActions->getLikesCount($f['uuid']);
          $repliesCount = $feedActions->getRepliesCount($f['uuid']);
          $hasLiked = $currentMemberId ? $feedActions->hasMemberLiked($f['uuid'], $currentMemberId) : false;
          $allReplies = $feedActions->getReplies($f['uuid']);
      ?>
      <div class="discussion-card" id="feed-<?php echo $f['uuid']; ?>">
        <div class="card-top-row">
          <span class="category-badge"><?php echo htmlspecialchars($f['category_name']); ?></span>
        </div>

        <h3 class="card-title"><?php echo htmlspecialchars($f['title']); ?></h3>
        <p class="card-excerpt"><?php echo nl2br(htmlspecialchars($f['content'])); ?></p>

        <div class="card-author-row">
          <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($f['member_name']); ?>&background=f48221&color=fff" class="author-avatar-sm" alt="Avatar">
          <span class="author-name"><?php echo htmlspecialchars($f['member_name']); ?></span>
          <span class="author-time"><?php echo time_ago($f['created_at']); ?></span>
        </div>

        <div class="card-interaction-bar">
          <button class="btn-interact btn-like <?php echo $hasLiked ? 'active' : ''; ?>" data-uuid="<?php echo $f['uuid']; ?>">
            <span class="material-symbols-outlined" style="<?php echo $hasLiked ? "font-variation-settings: 'FILL' 1" : ""; ?>">thumb_up</span>
            <span class="count"><?php echo $likes; ?></span>
          </button>

          <button class="btn-interact btn-toggle-replies" data-uuid="<?php echo $f['uuid']; ?>">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span class="count"><?php echo $repliesCount; ?></span>
          </button>

          <div class="interact-spacer"></div>

          <button class="btn-interact">
            <span class="material-symbols-outlined">bookmark</span>
          </button>
        </div>

        <!-- Collapsible Reply Section -->
        <div class="reply-section" id="replies-<?php echo $f['uuid']; ?>">
            <div class="reply-list">
                <?php foreach ($allReplies as $r): ?>
                    <div class="reply-item">
                        <span class="reply-author"><?php echo htmlspecialchars($r['username']); ?></span>
                        <span class="reply-content"><?php echo htmlspecialchars($r['content']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="reply-input-group">
                <input type="text" class="reply-input" placeholder="Write a reply..." data-uuid="<?php echo $f['uuid']; ?>">
                <button class="btn-post-reply" data-uuid="<?php echo $f['uuid']; ?>">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </div>
        </div>
      </div>
      <?php endforeach; ?>
  <?php endif; ?>

</div>

<!-- Pagination -->
<div class="member-feed-pagination">
  <a href="#" class="pag-btn">
    <span class="material-symbols-outlined">chevron_left</span> Previous
  </a>
  <span class="pag-info" style="font-family:'Open Sans',sans-serif;font-size:0.85rem;color:#797979;">Page 1 of 1</span>
  <a href="#" class="pag-btn">
    Next <span class="material-symbols-outlined">chevron_right</span>
  </a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Toggle Like
    $('.btn-like').on('click', function(e) {
        e.preventDefault();
        const btn = $(this);
        const uuid = btn.data('uuid');

        $.post('pages/forum/ajax-actions.php', {
            action: 'toggle_like',
            feed_uuid: uuid
        }, function(res) {
            if (res.status === 'success') {
                btn.toggleClass('active');
                btn.find('.count').text(res.count);
                const icon = btn.find('.material-symbols-outlined');
                if (res.action === 'liked') {
                    icon.css('font-variation-settings', "'FILL' 1");
                } else {
                    icon.css('font-variation-settings', "'FILL' 0");
                }
            }
        });
    });

    // Toggle Replies Section
    $('.btn-toggle-replies').on('click', function() {
        const uuid = $(this).data('uuid');
        $(`#replies-${uuid}`).slideToggle(200);
    });

    // Post Reply
    $('.btn-post-reply').on('click', function() {
        const uuid = $(this).data('uuid');
        const input = $(`.reply-input[data-uuid="${uuid}"]`);
        const content = input.val();

        if (!content.trim()) return;

        $.post('pages/forum/ajax-actions.php', {
            action: 'add_reply',
            feed_uuid: uuid,
            content: content
        }, function(res) {
            if (res.status === 'success') {
                input.val('');
                const list = $(`#replies-${uuid} .reply-list`);
                list.append(`
                    <div class="reply-item" style="display:none;">
                        <span class="reply-author">You</span>
                        <span class="reply-content">${res.reply.content}</span>
                    </div>
                `);
                list.find('.reply-item:last').fadeIn();
                $(`.btn-toggle-replies[data-uuid="${uuid}"] .count`).text(res.count);
            }
        });
    });

    // Allow Enter key to submit reply
    $('.reply-input').on('keypress', function(e) {
        if (e.which === 13) {
            const uuid = $(this).data('uuid');
            $(`.btn-post-reply[data-uuid="${uuid}"]`).click();
        }
    });
});
</script>

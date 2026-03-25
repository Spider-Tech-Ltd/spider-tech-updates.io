<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2><?= $title ?? 'Events' ?></h2>
        <div class="separator left-align"><ul><li></li><li></li><li></li></ul></div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Events</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<section id="blog_post" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="row">
        <?php if(!empty($events)): ?>
            <?php foreach($events as $event): ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="item blog_card">
                <div class="post-img"> <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="Post" /><div class="posted_on"> <span class="date"><?= stripslashes($event['event_date']); ?></span></div></div>
                <div class="post-detail">
                <h5><a href="<?= BASE_URL ?>/events/detail?id=<?= stripslashes($event['event_id']); ?>"><?= stripslashes($event['event_title']); ?></a></h5>
                <div class="post-status"><ul><li><i class="flat flaticon-check"></i> <span><?= stripslashes($event['event_status']); ?></span></li></ul></div>
                <div class="description"><p><?= stripslashes($event['event_content']); ?></p><a href="<?= BASE_URL ?>/events/detail?id=<?= stripslashes($event['event_id']); ?>" class="view_more" title="View More">View More</a> </div>
                </div>
                <div class="clearfix"></div>
            </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12"><p class="empty">No events found!</p></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

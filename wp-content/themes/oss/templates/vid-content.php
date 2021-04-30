<div class="modal-header">
  <h5 class="modal-title"><?php the_title(); ?></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <video id="modal--video" poster="<?php the_field('video_cover'); ?>" preload="auto" autoplay="" controls="">
    <source src="<?php the_field('video_mp4'); ?>" type="video/mp4">
    <?php if (get_field('video_webm')) : ?>
      <source src="<?php the_field('video_webm'); ?>" type="video/webm">
    <?php endif; ?>
  </video>
</div>
<div class="row">
  <div class="<?php if (get_field('has_video')) { echo 'col-lg-6'; } else { echo 'col-12'; } ?> wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
    <h1 class="sol--single-title font-30"><?php the_title(); ?></h1>
    <div class="clearfix">
      <div class="gray-sep"></div>
    </div>
    <div class="content--sol-single">
      <?php the_field('content_sol'); ?>
      <?php if (get_field('read_more_url')) : ?>
        <a href="<?php the_field('read_more_url'); ?>" class="green--btn read-more-sol"><?php _e('Read more', 'nma-string'); ?></a>
      <?php endif; ?>
    </div>
  </div>
  <?php if (get_field('has_video')) : ?>
    <div class="col-lg-5 offset-lg-1 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('video_text_sol')) : ?>
        <p class="sol-vid-text"><?php the_field('video_text_sol'); ?></p>
      <?php endif; ?>
      <?php 
        $post_object = get_field('video_sol');
        $post = $post_object;
        setup_postdata( $post );
      ?>
      <div class="video-sol-container">
        <div class="grad-50"></div>
        <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
        <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play_alt.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play_alt@2x.png'); ?> 2x" /></a>
      </div>
      <?php wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>
</div>
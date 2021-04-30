<div class="blog-post-flex wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
  <?php if (has_post_thumbnail()) : ?>
    <div class="bp-ft-img-container" style="background-image: url('<?php the_post_thumbnail_url('large'); ?>');"></div>
  <?php endif; ?>
  <div class="bp-blog-container">
    <h2 class="bp--title font-30"><?php the_title(); ?></h2>
    <p class="post-meta"><?php echo get_the_date('F d, Y'); ?></p>
    <div class="bp-blog-excerpt">
      <?php the_excerpt(); ?>
    </div>
    <a class="green--btn" href="<?php the_permalink(); ?>"><?php _e('Read More', 'nma-string'); ?></a>
  </div>
</div>
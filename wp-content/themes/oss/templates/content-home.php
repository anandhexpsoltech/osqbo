<div class="col-lg-4 wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
  <article <?php post_class('bp--container'); ?>>
    <div class="bp--fix">
      <div class="featured-img-container">
        <?php the_post_thumbnail('blog-tumb'); ?>
        <div class="date-container">
          <p><?php echo get_the_date('M'); ?></p>
          <h6 class="font-40"><?php echo get_the_date('d'); ?></h6>
          <p><?php echo get_the_date('Y'); ?></p>
        </div>
      </div>
      <div class="bp--content-container">
        <h2 class="bp--title font-30"><?php the_title(); ?></h2>
        <p class="post-meta"><?php comments_number('', '1 comment / ', '% comments / ' ); _e('By'); echo ' ' . get_the_author(); ?></p>
        <div class="bp--excerpt">
          <?php the_excerpt(); ?>
        </div>
        <a class="green--btn" href="<?php the_permalink(); ?>"><?php _e('Read More', 'nma-string'); ?></a>
      </div>
    </div>
  </article>
</div>
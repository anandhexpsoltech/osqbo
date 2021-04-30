<div class="col-lg-6">
  <div class="rel-bp-container">
    <?php if (has_post_thumbnail()) : ?>
      <a href="<?php the_permalink(); ?>" class="img--link"><?php the_post_thumbnail('rel-tumb'); ?></a>
    <?php endif; ?>
    <h2 class="bp--title font-24"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="post-meta"><?php echo get_the_date('F d, Y'); ?></p>
  </div>
</div>
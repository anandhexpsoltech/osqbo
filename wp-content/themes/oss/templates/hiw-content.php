<section class="hiw--content">
  <div class="container">
    <?php if (have_rows('hiw_blocks')) : ?>
      <?php $c = 0; while (have_rows('hiw_blocks')) : the_row(); ?>
        <div <?php if (get_sub_field('title')) : ?>id="section-<?php echo sanitize_title(get_sub_field('title')); ?>" <?php endif; ?>class="row <?php echo 'row-hiw-' . $c % 2; ?> wow fadeInDown" data-wow-offset="150" data-wow-duration="1s">
          <div class="col-lg-6">
            <div class="hiw-block-content">
              <?php if (get_sub_field('title')) : ?>
                <h1 class="title-hiw font-30"><?php the_sub_field('title'); ?></h1>
              <?php endif; ?>
              <?php if (get_sub_field('subtitle')) : ?>
                <h6 class="subtitle-hiw"><?php the_sub_field('subtitle'); ?></h6>
              <?php endif; ?>
              <div class="clearfix">
                <!-- <div class="gray-sep"></div> -->
              </div>
              <?php if (get_sub_field('content')) : ?>
                <div class="hiw-b-content-inner">
                  <?php the_sub_field('content'); ?>
                </div>
              <?php endif; ?>
              <?php if (get_sub_field('read_more_solution')) : 
                $post_object = get_sub_field('read_more_solution');
                $post = $post_object;
                setup_postdata( $post ); ?>
                <a href="<?php echo get_the_permalink(18) . '?solution=' . $post->post_name; ?>" class="green--btn read-more-sol"><?php _e('Read more', 'nma-string'); ?></a>
              <?php wp_reset_postdata(); endif; ?>
            </div>
          </div>
          <div class="col-lg-6">
            <?php if (get_sub_field('image')) : ?>
              <div class="hiw-block-img">
                <?php echo wp_get_attachment_image(get_sub_field('image'), 'large'); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <!-- <div class="gray--line"></div> -->
      <?php ++$c; endwhile; ?>
    <?php endif; ?>
  </div>
</section>
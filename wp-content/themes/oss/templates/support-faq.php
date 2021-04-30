<section id="faq" class="faq-section">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_31')) : ?>
        <h3 class="heading--1"><?php the_field('heading_31'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_32')) : ?>
        <h2 class="heading--2"><?php the_field('heading_32'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <?php if (have_rows('faqs')) : ?>
      <?php $c = 0; while (have_rows('faqs')) : the_row(); ?>
        <?php $post_object = get_sub_field('faq');
          $post = $post_object;
          setup_postdata( $post );
        ?>
        <div id="<?php echo $post->post_name; ?>" class="q-and-a-container wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
          <a href="#" class="faq-header"><span></span><?php the_title(); ?></a>
          <div class="content--faq-single">
            <?php the_content(); ?>
          </div>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
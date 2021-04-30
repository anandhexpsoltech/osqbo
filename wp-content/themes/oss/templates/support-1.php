<section id="#support-tools" class="support--1st">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_11')) : ?>
        <h3 class="heading--1"><?php the_field('heading_11'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_12')) : ?>
        <h2 class="heading--2"><?php the_field('heading_12'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="row">
      <?php $c = 0; while (have_rows('support_blocks')) : the_row(); ?>
        <div class="col-lg-4">
          <div class="support-block-outer wow fadeIn" data-wow-offset="150" data-wow-duration="1s" data-wow-delay="<?php echo ($c % 3)*0.2; ?>s">
            <div class="support-block-inner">
              <?php echo wp_get_attachment_image(get_sub_field('image'), 'blog-tumb'); ?>
              <h1 class="font-20 supp-b-title"><?php the_sub_field('title'); ?></h1>
              <div class="clearfix">
                <div class="purple-sep"></div>
              </div>
              <p class="supp-b-content"><?php the_sub_field('content'); ?></p>
              <a href="#" class="call-c-modal green--btn"><?php the_sub_field('btn_text'); ?></a>
            </div>
          </div>
        </div>
      <?php ++$c; endwhile; ?>
    </div>
    <div class="gray--line"></div>
  </div>
</section>
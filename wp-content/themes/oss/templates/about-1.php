<section class="about--1">
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
      <div class="col-lg-6 wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
        <div class="about-1-content">
          <?php if (get_field('left_side_title_1')) : ?>
            <h3 class="font-30 about-1-title"><?php the_field('left_side_title_1'); ?></h3>
            <div class="clearfix">
              <div class="gray-sep"></div>
            </div>
          <?php endif; ?>
          <?php the_field('left_side_content_1'); ?>
        </div>
      </div>
      <div class="col-lg-6 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
        <div class="about-1-content">
          <?php if (get_field('right_side_title_1')) : ?>
            <h3 class="font-30 about-1-title"><?php the_field('right_side_title_1'); ?></h3>
            <div class="clearfix">
              <div class="gray-sep"></div>
            </div>
          <?php endif; ?>
          <?php the_field('right_side_content_1'); ?>
        </div>
      </div>
    </div>
    <div class="gray--line"></div>
  </div>
</section>
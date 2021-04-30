<section class="about--2">
  <div class="container">
    <?php if (get_field('section_title_2')) : ?>
      <div class="row wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
        <div class="col-lg-6">
          <h3 class="font-30 about-1-title"><?php the_field('section_title_2'); ?></h3>
          <div class="clearfix">
            <div class="gray-sep"></div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-6 wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
        <div class="about-1-content lg--right-pad">
          <?php the_field('left_side_content_2'); ?>
        </div>
      </div>
      <div class="col-lg-6 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
        <div class="about-1-content">
          <?php the_field('right_side_content_2'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $front_id = get_option('page_on_front'); ?>
<section class="get-started how-to-gs">
  <div class="h-top-gradient"></div>
  <div class="h-top-gradient-100"></div>
  <div class="container">
    <div class="section-header wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
      <h2 class="heading--2"><?php _e('How to Get Up and Running Quickly!', 'nma-string'); ?></h2>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
    <?php if (have_rows('steps')) : ?>
      <div class="row">
        <?php $c = 1; while (have_rows('steps')) : the_row(); ?>
          <div class="col-lg-4">
            <div class="step--container wow fadeInRight" data-wow-offset="150" data-wow-delay="<?php echo $c * 0.15; ?>s" data-wow-duration="1s">
              <h1 class="step--counter"><?php echo $c; ?></h1>
              <div class="clearfix">
                <div class="circle-10"></div>
              </div>
              <p class="step-content font-20"><?php the_sub_field('info'); ?></p>
              <?php if (get_sub_field('extra_info')) : ?>
                <p class="step-extra"><?php the_sub_field('extra_info'); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php ++$c; endwhile; ?>
      </div>
    <?php endif; ?>
    <div class="start-now-btn-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
      <a href="https://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=true" class="green--btn" target="_blank"><?php _e('Start Your Free Trial', 'nma-string'); ?></a>
    </div>
  </div>
</section>
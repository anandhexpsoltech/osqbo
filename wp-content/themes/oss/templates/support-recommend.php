<section id="we-recommend" class="support-recommend-section">
  <div class="container">
    <div class="section-header">
      <?php if (get_field('heading_51')) : ?>
        <h3 class="heading--1"><?php the_field('heading_51'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_52')) : ?>
        <h2 class="heading--2"><?php the_field('heading_52'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="support-bottom-content">
          <?php the_field('content_left_support'); ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="support-bottom-content">
          <?php the_field('content_right_support'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contact-form-section">
  <div class="grad-80"></div>
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_21')) : ?>
        <h3 class="heading--1"><?php the_field('heading_21'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_22')) : ?>
        <h2 class="heading--2"><?php the_field('heading_22'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
    <div class="wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
      <?php gravity_form(3, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true); ?>
    </div>
  </div>
</section>
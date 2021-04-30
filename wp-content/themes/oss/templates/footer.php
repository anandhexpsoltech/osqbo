<footer class="content-info">
  <div class="footer-top wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <a class="footer--logo" href="<?= esc_url(home_url('/')); ?>"><img src="<?php Roots\Sage\Extras\echo_img('logo_final_2.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('logo_final_2@2x.png'); ?> 2x" /></a>
        </div>
        <div class="col-lg-3">
          <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
        <div class="col-lg-4 offset-lg-1">
          <?php dynamic_sidebar('sidebar-footer2'); ?>
          <p class="footer-phone-email"><img src="<?php Roots\Sage\Extras\echo_img('phone.png'); ?>" /> <?php echo get_theme_mod('sales_phone_number'); ?><br><img src="<?php Roots\Sage\Extras\echo_img('email.png'); ?>" /> <?php echo get_theme_mod('footer_email'); ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <p><?php if (get_theme_mod('copyright_left')) { echo get_theme_mod('copyright_left'); } ?></p>
        </div>
        <div class="col-lg-4">
          <p><?php if (get_theme_mod('copyright_right')) { echo get_theme_mod('copyright_right'); } ?></p>
        </div>
      </div>
    </div>
  </div>
</footer>

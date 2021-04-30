<header class="banner">
  <div class="banner-v-top clearfix">
    <div class="container">
      <div class="v-top-content">
        <p><?php if (get_theme_mod('sales_phone_number')) : echo __('Sales', 'nma-string') . ' ' . get_theme_mod('sales_phone_number') . ' '; endif; ?></p>
        <?php
          if (has_nav_menu('top_navigation')) :
            wp_nav_menu(['theme_location' => 'top_navigation', 'container_class' => 'top--nav-container', 'menu_class' => 'top--nav']);
          endif;
        ?>
      </div>
    </div>
  </div>
  <div class="banner-bottom">
    <div class="container">
      <a class="brand--logo" href="<?= esc_url(home_url('/')); ?>"><img src="<?php Roots\Sage\Extras\echo_img('logo_final_2.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('logo_final_2@2x.png'); ?> 2x" /></a>
      <div class="header-bottom-flex">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(['theme_location' => 'primary_navigation', 'container_class' => 'main--nav-container', 'menu_class' => 'main--nav']);
          endif;
        ?>
        <a href="#" class="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </a>
        <?php if (get_theme_mod('login_link')) : ?>
          <a href="<?php echo get_theme_mod('login_link'); ?>" class="login--btn"><?php _e('Login', 'nma-string'); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
<section id="start-now-form" class="demo--form">
  <div class="h-top-gradient"></div>
  <div class="container">
    <a href="#" class="close--demo-form">x</a>
    <div class="section-header">
      <h3 class="heading--1"><?php _e('Start now', 'nma-string'); ?></h3>
      <h2 class="heading--2"><?php _e('Schedule a demo', 'nma-string'); ?></h2>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
    <?php gravity_form(1, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true); ?>
  </div>
</section>
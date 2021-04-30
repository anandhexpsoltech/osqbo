<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
    ?>
    <div class="doc-wrap" role="document">
      <?php 
        get_template_part('templates/header');
        include Wrapper\template_path();
        do_action('get_footer');
        get_template_part('templates/footer');
        get_template_part('templates/footer-modals');
      ?>
      <a href="#" class="menu--overlay"></a>
    </div><!-- /.doc-wrap -->
    <?php
      wp_footer();
    ?>
    <?php if (is_single()) : ?>
      <script>
      var a2a_config = a2a_config || {};
        a2a_config.locale = "en";
        a2a_config.color_main = "undefined";
        a2a_config.color_border = "undefined";
        a2a_config.color_link_text = "undefined";
        a2a_config.color_link_text_hover = "undefined";
        a2a_config.color_bg = "undefined";
        a2a_config.color_arrow = "undefined";
        a2a_config.color_arrow_hover = "undefined";
      </script>
      <script async src="https://static.addtoany.com/menu/page.js"></script>
    <?php endif; ?>
  </body>
</html>

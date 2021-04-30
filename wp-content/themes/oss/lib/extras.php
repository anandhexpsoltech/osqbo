<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

function custom_excerpt_length( $length ) {
  return 21;
}

add_filter( 'excerpt_length', __NAMESPACE__ . '\\custom_excerpt_length', 999 );

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip;';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function echo_img($file) {
  echo get_template_directory_uri() . '/dist/images/' . $file;
}

add_action('wp_head', __NAMESPACE__ . '\\add_ajaxurl');

function add_ajaxurl() {
  ?>
  <script type="text/javascript">
  var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
  </script>
  <?php
}

function ajax_get_posts() {
  
  // BLOG POSTS

  $posts_page = $_POST['posts_page'];
  $posts_per_page = get_option('posts_per_page');
  
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged' => $posts_page,  
    'order' => 'DESC',
    'orderby' => 'date'
  );
  
  $query = new \WP_Query($args);

  if ($query->have_posts()) :

    $c = 0; while ($query->have_posts()) : $query->the_post();

      get_template_part('templates/content');

    ++$c; endwhile;

    if ($query->found_posts <= $posts_per_page*$posts_page) {
      echo '<div class="no-more-posts"></div>';
    }

    wp_reset_postdata();
    
  endif;

  die();
}

add_action('wp_ajax_get_posts', __NAMESPACE__ . '\\ajax_get_posts');
add_action('wp_ajax_nopriv_get_posts', __NAMESPACE__ . '\\ajax_get_posts');

function ajax_get_video() {
  
  // BLOG POSTS

  $vid_id = $_POST['vid_id'];
  
  $args = array(
    'post_type' => 'training-video',
    'post_status' => 'publish',
    'p' => $vid_id,
  );
  
  $query = new \WP_Query($args);

  if ($query->have_posts()) :

    $c = 0; while ($query->have_posts()) : $query->the_post();

      get_template_part('templates/vid-content');

    ++$c; endwhile;

    if ($query->found_posts <= $posts_per_page*$posts_page) {
      echo '<div class="no-more-posts"></div>';
    }

    wp_reset_postdata();
    
  endif;

  die();
}

add_action('wp_ajax_get_video', __NAMESPACE__ . '\\ajax_get_video');
add_action('wp_ajax_nopriv_get_video', __NAMESPACE__ . '\\ajax_get_video');

function ajax_get_sol() {
  
  // BLOG POSTS

  $sol_id = $_POST['sol_id'];
  
  $args = array(
    'post_type' => 'solution',
    'post_status' => 'publish',
    'p' => $sol_id,
  );
  
  $query = new \WP_Query($args);

  if ($query->have_posts()) :

    $c = 0; while ($query->have_posts()) : $query->the_post();

      get_template_part('templates/sol-content');

    ++$c; endwhile;

    if ($query->found_posts <= $posts_per_page*$posts_page) {
      echo '<div class="no-more-posts"></div>';
    }

    wp_reset_postdata();
    
  endif;

  die();
}

add_action('wp_ajax_get_sol', __NAMESPACE__ . '\\ajax_get_sol');
add_action('wp_ajax_nopriv_get_sol', __NAMESPACE__ . '\\ajax_get_sol');

function roots_customize_theme($wp_customize){
  $wp_customize->add_section('roots_customize_1', array(
    'title'    => __('Header section', 'nma-string'),
    'priority' => 30
  ));

  $wp_customize->add_setting('sales_phone_number', array('default' => ''));
  
  $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'sales_phone_number', array(
    'label'    => __('Sales phone number', 'nma-string'),
    'section'  => 'roots_customize_1',
    'settings' => 'sales_phone_number',
    'type' => 'text'
  )));

  $wp_customize->add_setting('login_link', array('default' => ''));
  
  $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'login_link', array(
    'label'    => __('Login link (URL)', 'nma-string'),
    'section'  => 'roots_customize_1',
    'settings' => 'login_link',
    'type' => 'text'
  )));

  $wp_customize->add_section('roots_customize_2', array(
    'title'    => __('Footer section', 'nma-string'),
    'priority' => 30
  ));

  $wp_customize->add_setting('footer_email', array('default' => ''));
  
  $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'footer_email', array(
    'label'    => __('Footer email', 'nma-string'),
    'section'  => 'roots_customize_2',
    'settings' => 'footer_email',
    'type' => 'text'
  )));

  $wp_customize->add_setting('copyright_left', array('default' => ''));
  
  $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'copyright_left', array(
    'label'    => __('Footer copyright left side', 'nma-string'),
    'section'  => 'roots_customize_2',
    'settings' => 'copyright_left',
    'type' => 'text'
  )));

  $wp_customize->add_setting('copyright_right', array('default' => ''));
  
  $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'copyright_right', array(
    'label'    => __('Footer copyright right side', 'nma-string'),
    'section'  => 'roots_customize_2',
    'settings' => 'copyright_right',
    'type' => 'text'
  )));
}

add_action('customize_register', __NAMESPACE__ . '\\roots_customize_theme');

function royalslider_change_image_size($sizes) { 
  $sizes['large'] = 'full'; 
  return $sizes; 
}

add_filter( 'new_rs_image_sizes', __NAMESPACE__ . '\\royalslider_change_image_size' );

// Populate ACF select field using filter for Royal Slider
function acf_select_royalslider( $field ) {
  global $wpdb;
  $results = $wpdb->get_results( "SELECT * FROM kps_new_royalsliders", OBJECT );
  foreach($results as $slider){
    $field['choices'][$slider->id] = "#$slider->id $slider->name";
  }
  return $field;
}

add_filter('acf/load_field/name=rs_id', __NAMESPACE__ . '\\acf_select_royalslider');
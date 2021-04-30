<?php while (have_posts()) : the_post(); ?>
  <?php
$home_1st= get_field('slider_section_order_number');
$home_1st= !empty($home_1st)?$home_1st:0;
$home_logos= get_field('logos_section_order_number');
$home_logos=!empty($home_logos)?$home_logos:0;
$home_solutions=get_field('solutions_section_order_number');
$home_solutions=!empty($home_solutions)?$home_solutions:0;
$home_testimonials= get_field('testimonials_section_order_number');
$home_testimonials=!empty($home_testimonials)?$home_testimonials:0;
$home_5th = get_field('5th_section_order_number');
$home_5th=!empty($home_5th)?$home_5th:0;
$home_training_videos= get_field('training_videos_section_order_number');
$home_training_videos=!empty($home_training_videos)?$home_training_videos:0;
$home_connect = get_field('connect_and_support_order_number');
$home_connect=!empty($home_connect)?$home_connect:0;
$newsletter = get_field('newsletter_order_number');
$newsletter=!empty($newsletter)?$newsletter:0;
$blog = get_field('blog_order_number');
$blog=!empty($blog)?$blog:0;
$get_started = get_field('get_started_order_number');
$get_started=!empty($get_started)?$get_started:0;

$tab_loop=array();
$tab_loop['1st']=$home_1st;
$tab_loop['logos']=$home_logos;
$tab_loop['solutions']=$home_solutions;
$tab_loop['testimonials']=$home_testimonials;
$tab_loop['5th']=$home_5th;
$tab_loop['training-videos']=$home_training_videos;
$tab_loop['connect']=$home_connect;
$tab_loop['section']=$newsletter;
$tab_loop['news']=$blog;
$tab_loop['started']=$get_started;

asort($tab_loop);
foreach ($tab_loop as $key => $value) {
  if ($key == 'section') {
    get_template_part('templates/newsletter', $key);
  } elseif ($key == 'started') {
    get_template_part('templates/get', $key);
  } else {
    get_template_part('templates/home', $key);
  }
  
}
?>
  <?php// get_template_part('templates/home', '1st'); ?>
  <?php //get_template_part('templates/home', 'logos'); ?>
  <?php //get_template_part('templates/home', 'solutions'); ?>
  <?php //get_template_part('templates/home', 'testimonials'); ?> 
  <?php //get_template_part('templates/home', '5th'); ?>
  <?php //get_template_part('templates/home', 'training-videos'); ?>
  <?php ////get_template_part('templates/newsletter', 'section'); ?>
  <?php ////get_template_part('templates/home', 'news'); ?>
  <?php //get_template_part('templates/home', 'connect'); ?>
  <?php ////get_template_part('templates/get', 'started'); ?>
<?php endwhile; ?>
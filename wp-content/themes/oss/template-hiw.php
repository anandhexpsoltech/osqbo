<?php
/**
 * Template Name: How it Works Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/hiw', 'content'); ?>
<?php endwhile; ?>

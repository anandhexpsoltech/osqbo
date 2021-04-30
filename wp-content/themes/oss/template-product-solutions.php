<?php
/**
 * Template Name: Product Solutions Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/prod-sol', 'content'); ?>
  <?php get_template_part('templates/three', 'steps'); ?>
<?php endwhile; ?>

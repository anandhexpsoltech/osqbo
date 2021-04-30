<?php
/**
 * Template Name: About Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/about', '1'); ?>
  <?php get_template_part('templates/about', '2'); ?>
  <?php get_template_part('templates/about', '3'); ?>
  <?php get_template_part('templates/about', 'team'); ?>
  <?php get_template_part('templates/about', 'form'); ?> 

<?php endwhile; ?>

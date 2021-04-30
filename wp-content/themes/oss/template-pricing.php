<?php
/**
 * Template Name: Pricing Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/pricing', '1'); ?>
  <?php get_template_part('templates/get', 'started'); ?>
<?php endwhile; ?>

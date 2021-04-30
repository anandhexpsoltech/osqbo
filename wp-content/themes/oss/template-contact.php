<?php
/**
 * Template Name: Contact Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/contact', '1'); ?>
  <?php get_template_part('templates/contact', '2'); ?>
<?php endwhile; ?>

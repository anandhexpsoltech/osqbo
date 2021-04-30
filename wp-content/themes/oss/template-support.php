<?php
/**
 * Template Name: Support and FAQ Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/custom', 'header'); ?>
  <?php get_template_part('templates/support', '1'); ?>
  <?php get_template_part('templates/support', '2'); ?>
  <?php get_template_part('templates/support', 'faq'); ?>
  <?php get_template_part('templates/support', 'recommend'); ?>
<?php endwhile; ?>

<?php 
   $blog_section = get_field('disable_blog_section');
   if($blog_section){
   $blog_check= $blog_section;
   }else{
   $blog_check=array('no');
   }
   if(!in_array('yes', $blog_check)){ ?>
<section class="home-news">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <h3 class="heading--1"><?php _e('Stay up to date', 'nma-string'); ?></h3>
      <h2 class="heading--2"><?php _e('Feeds, news & blogging', 'nma-string'); ?></h2>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <?php 
      $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'order' => 'DESC',
        'orderby' => 'date'
      );

      $query = new WP_Query($args);
    ?>
    <?php if ($query->have_posts()) : ?>
      <div class="row all-bp-row">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <?php get_template_part('templates/content-home'); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    <?php endif; ?>
    <div class="gray--line"></div>
  </div>
</section>
 <?php }
   ?>
<?php 
   $logos_section = get_field('disable_logos_section');
   if($logos_section){
   $logos_check= $logos_section;
   }else{
   $logos_check=array('no');
   }
   if(!in_array('yes', $logos_check)){ ?>
   
<section class="logos-section wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
  <div class="container">
    <div class="section-header">
      <?php if (get_field('heading_11')) : ?>
        <h3 class="heading--1"><?php the_field('heading_11'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_12')) : ?>
        <h2 class="heading--2"><?php the_field('heading_12'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <?php if (have_rows('logos')) : ?>
      <div class="all-logos--container">
        <?php while (have_rows('logos')) : the_row(); ?>
          <div class="single-logo--container">
            <?php echo wp_get_attachment_image(get_sub_field('logo'), 'medium'); ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
   <?php
   }
   ?>



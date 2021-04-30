<?php $front_id = get_option('page_on_front'); ?>

<?php 
   $get_started_section = get_field('disable_get_started_section');
   if($get_started_section){
   $get_started_check= $get_started_section;
   }else{
   $get_started_check=array('no');
   }
   if(!in_array('yes', $get_started_check)){ ?>
<section class="get-started">
  <div class="h-top-gradient"></div>
  <div class="container">
    <div class="section-header wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_71', $front_id)) : ?>
        <h3 class="heading--1"><?php the_field('heading_71', $front_id); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_72', $front_id)) : ?>
        <h2 class="heading--2"><?php the_field('heading_72', $front_id); ?></h2>
      <?php endif; ?>
    </div>
    <div class="two--btns wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
      <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=false" class="white-btn-1" target="_blank"><?php _e('Start', 'nma-string'); ?></a>
      <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=true" class="white-btn-2" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>
    </div>
  </div>
</section>
 <?php }
   ?>
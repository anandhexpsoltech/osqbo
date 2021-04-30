<?php 
   $slider_section = get_field('disable_slider_section');
   if($slider_section){
   $slider_check= $slider_section;
   }else{
   $slider_check=array('no');
   }
   if(!in_array('yes', $slider_check)){
   ?>
   <section class="homepage-top-section">
  <div class="h-top-container">
    <div class="h-top-gradient"></div>
    <div class="h-top-overlay">
      <div class="container">
        <?php if (get_field('heading_01')) : ?>
          <h6 class="h-top-h1 font-20"><?php the_field('heading_01'); ?></h6>
        <?php endif; ?>
        <?php if (get_field('heading_02')) : ?>
          <h1 class="h-top-h2 font-70"><?php the_field('heading_02'); ?></h1>
        <?php endif; ?>
        <div class="two--btns">
          <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>
          <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>
        </div>
      </div>
    </div>
    <?php echo get_new_royalslider(1); ?>
  </div>
</section>
   <?php
   }
   ?>


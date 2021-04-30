<?php 
   $fifth_section = get_field('disable_5th_section');
   if($fifth_section){
   $fifth_check= $fifth_section;
   }else{
   $fifth_check=array('no');
   }
   if(!in_array('yes', $fifth_check)){ ?>
  <section class="home-5th">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_41')) : ?>
        <h3 class="heading--1"><?php the_field('heading_41'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_42')) : ?>
        <h2 class="heading--2"><?php the_field('heading_42'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
        <div class="h-s-content-container">
          <?php if (get_field('content_title_4')) : ?>
            <h3 class="h-s-title font-30"><?php the_field('content_title_4'); ?></h3>
            <div class="clearfix">
              <div class="gray-sep"></div>
            </div>
          <?php endif; ?>
          <?php if (get_field('content_4')) : ?>
            <p class="h-s-content"><?php the_field('content_4'); ?></p>
          <?php endif; ?>
          <?php if (get_field('more_url_4')) : ?>
            <a href="<?php the_field('more_url_4'); ?>" class="green--btn"><?php _e('Read more', 'nma-string'); ?></a>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-7 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
        <img class="overflow--img" src="<?php the_field('image_4'); ?>" />
      </div>
    </div>
    <div class="gray--line"></div>
  </div>
</section>
  
  <?php }
   ?>


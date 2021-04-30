<?php 
   $connect_and_support = get_field('disable_connect_and_support');
   if($connect_and_support){
   $connect_and_support_check= $connect_and_support;
   }else{
   $connect_and_support_check=array('no');
   }
   if(!in_array('yes', $connect_and_support_check)){ ?>
<section class="connect-support-section">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_61')) : ?>
        <h3 class="heading--1"><?php the_field('heading_61'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_62')) : ?>
        <h2 class="heading--2"><?php the_field('heading_62'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="link-blocks">
      <?php if (have_rows('left_block_links')) : ?>
        <div class="left-block-container links-block-outer wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
          <div class="white-border"></div>
          <div class="rel-block">
            <p class="links-block-title"><?php the_field('left_block_title_6'); ?></p>
            <div class="clearfix">
              <div class="white-sep"></div>
            </div>
            <?php while (have_rows('left_block_links')) : the_row(); ?>
              <a href="<?php the_sub_field('link_url'); ?>"><?php the_sub_field('link_text'); ?></a>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if (have_rows('right_block_links')) : ?>
        <div class="right-block-container links-block-outer wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
          <div class="white-border"></div>
          <div class="rel-block">
            <p class="links-block-title"><?php the_field('right_block_title_6'); ?></p>
            <div class="clearfix">
              <div class="white-sep"></div>
            </div>
            <?php while (have_rows('right_block_links')) : the_row(); ?>
              <a href="<?php the_sub_field('link_url'); ?>"><?php the_sub_field('link_text'); ?></a>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
   <?php }
   ?> 


<?php 
   $training_videos_section = get_field('disable_training_videos_section');
   if($training_videos_section){
   $training_videos_check= $training_videos_section;
   }else{
   $training_videos_check=array('no');
   }
   if(!in_array('yes', $training_videos_check)){ ?>
   <section class="training-videos-section">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <h3 class="heading--1"><?php _e('Included', 'nma-string'); ?></h3>
      <h2 class="heading--2"><?php _e('Training videos', 'nma-string'); ?></h2>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <?php if (have_rows('training_videos')) : ?>
      <div id="carousel--training-videos" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <?php $c = 0; while (have_rows('training_videos')) : the_row(); ?>
            <div class="carousel-item<?php if ($c == 0) { echo ' active'; } ?>">
              <?php if (get_sub_field('training_video_1')) : ?>
                <?php $post_object = get_sub_field('training_video_1');
                  $post = $post_object;
                  setup_postdata( $post );
                ?>
                <div class="video-single-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
                  <div class="img-container">
                    <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
                    <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play@2x.png'); ?> 2x" /></a>
                  </div>
                  <h1 class="video-title"><?php the_title(); ?></h1>
                </div>
              <?php wp_reset_postdata(); endif; ?>
              <?php if (get_sub_field('training_video_2')) : ?>
                <?php $post_object = get_sub_field('training_video_2');
                  $post = $post_object;
                  setup_postdata( $post );
                ?>
                <div class="video-single-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
                  <div class="img-container">
                    <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
                    <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play@2x.png'); ?> 2x" /></a>
                  </div>
                  <h1 class="video-title"><?php the_title(); ?></h1>
                </div>
              <?php wp_reset_postdata(); endif; ?>
              <?php if (get_sub_field('training_video_3')) : ?>
                <?php $post_object = get_sub_field('training_video_3');
                  $post = $post_object;
                  setup_postdata( $post );
                ?>
                <div class="video-single-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
                  <div class="img-container">
                    <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
                    <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play@2x.png'); ?> 2x" /></a>
                  </div>
                  <h1 class="video-title"><?php the_title(); ?></h1>
                </div>
              <?php wp_reset_postdata(); endif; ?>
              <?php if (get_sub_field('training_video_4')) : ?>
                <?php $post_object = get_sub_field('training_video_4');
                  $post = $post_object;
                  setup_postdata( $post );
                ?>
                <div class="video-single-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
                  <div class="img-container">
                    <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
                    <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play@2x.png'); ?> 2x" /></a>
                  </div>
                  <h1 class="video-title"><?php the_title(); ?></h1>
                </div>
              <?php wp_reset_postdata(); endif; ?>
              <?php if (get_sub_field('training_video_5')) : ?>
                <?php $post_object = get_sub_field('training_video_5');
                  $post = $post_object;
                  setup_postdata( $post );
                ?>
                <div class="video-single-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
                  <div class="img-container">
                    <img src="<?php the_field('video_cover'); ?>" class="single-vid-cover" />
                    <a href="#" class="play--vid" data-video="<?php echo $post->ID; ?>"><img src="<?php Roots\Sage\Extras\echo_img('play.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('play@2x.png'); ?> 2x" /></a>
                  </div>
                  <h1 class="video-title"><?php the_title(); ?></h1>
                </div>
              <?php wp_reset_postdata(); endif; ?>
            </div>
          <?php ++$c; endwhile; ?>
        </div>
      </div>
      <div class="testimonials-controls-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
        <?php $c = 0; while (have_rows('training_videos')) : the_row(); ?>
          <a href="#" id="train-nav--<?php echo $c; ?>" class="nav--train<?php if ($c == 0) { echo ' active'; } ?>" data-target="#carousel--training-videos" data-slide-to="<?php echo $c; ?>"><span></span></a>
        <?php ++$c; endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
   <?php
   }
   ?> 



<?php 
   $solutions_section = get_field('disable_solutions_section');
   if($solutions_section){
   $solutions_check= $solutions_section;
   }else{
   $solutions_check=array('no');
   }
   if(!in_array('yes', $solutions_check)){ ?>
<section class="home-solutions">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
        <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
          <?php if (get_field('heading_21')) : ?>
            <h3 class="heading--1"><?php the_field('heading_21'); ?></h3>
          <?php endif; ?>
          <?php if (get_field('heading_22')) : ?>
            <h2 class="heading--2"><?php the_field('heading_22'); ?></h2>
          <?php endif; ?>
          <div class="clearfix">
            <div class="gray-sep"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
        <div class="h-s-content-container">
          <?php if (get_field('content_title_2')) : ?>
            <h3 class="h-s-title font-30"><?php the_field('content_title_2'); ?></h3>
            <div class="clearfix">
              <div class="gray-sep"></div>
            </div>
          <?php endif; ?>
          <?php if (get_field('content_2')) : ?>
            <p class="h-s-content"><?php the_field('content_2'); ?></p>
          <?php endif; ?>
          <a href="#" class="call-c-modal green--btn"><?php _e('Start now', 'nma-string'); ?></a>
        </div>
      </div>
      <div class="col-lg-6 offset-lg-1 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
        <?php if (have_rows('solutions_rep')) : ?>
          <div id="carousel--sol" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <?php $c = 0; while (have_rows('solutions_rep')) : the_row(); ?>
                <div class="carousel-item<?php if ($c == 0) { echo ' active'; } ?>">
                  <div class="col-6">
                    <?php if (get_sub_field('solution_1')) : 
                      $post_object = get_sub_field('solution_1');
                      $post = $post_object;
                      setup_postdata( $post ); ?>
                      <a href="<?php echo get_the_permalink(18) . '?solution=' . $post->post_name; ?>" class="sol-single-home" style="background-image: url('<?php the_post_thumbnail_url('sol-tumb'); ?>');">
                        <div class="border-hov"></div>
                        <h2 class="sol-home-title"><?php the_title(); ?></h2>
                      </a>
                    <?php wp_reset_postdata(); endif; ?>
                  </div>
                  <div class="col-6">
                    <?php if (get_sub_field('solution_2')) : 
                      $post_object = get_sub_field('solution_2');
                      $post = $post_object;
                      setup_postdata( $post ); ?>
                      <a href="<?php echo get_the_permalink(18) . '?solution=' . $post->post_name; ?>" class="sol-single-home" style="background-image: url('<?php the_post_thumbnail_url('sol-tumb'); ?>');">
                        <div class="border-hov"></div>
                        <h2 class="sol-home-title"><?php the_title(); ?></h2>
                      </a>
                    <?php wp_reset_postdata(); endif; ?>
                  </div>
                  <div class="col-6">
                    <?php if (get_sub_field('solution_3')) : 
                      $post_object = get_sub_field('solution_3');
                      $post = $post_object;
                      setup_postdata( $post ); ?>
                      <a href="<?php echo get_the_permalink(18) . '?solution=' . $post->post_name; ?>" class="sol-single-home" style="background-image: url('<?php the_post_thumbnail_url('sol-tumb'); ?>');">
                        <div class="border-hov"></div>
                        <h2 class="sol-home-title"><?php the_title(); ?></h2>
                      </a>
                    <?php wp_reset_postdata(); endif; ?>
                  </div>
                  <div class="col-6">
                    <?php if (get_sub_field('solution_4')) : 
                      $post_object = get_sub_field('solution_4');
                      $post = $post_object;
                      setup_postdata( $post ); ?>
                      <a href="<?php echo get_the_permalink(18) . '?solution=' . $post->post_name; ?>" class="sol-single-home" style="background-image: url('<?php the_post_thumbnail_url('sol-tumb'); ?>');">
                        <div class="border-hov"></div>
                        <h2 class="sol-home-title"><?php the_title(); ?></h2>
                      </a>
                    <?php wp_reset_postdata(); endif; ?>
                  </div>
                </div>
              <?php ++$c; endwhile; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php if (have_rows('solutions_rep')) : ?>
      <div class="carousel-controls-container wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">
        <a href="#carousel--sol" class="prev--sol" data-slide="prev"><img src="<?php Roots\Sage\Extras\echo_img('prev.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('prev@2x.png'); ?> 2x" /></a>
        <?php $c = 0; while (have_rows('solutions_rep')) : the_row(); ?>
          <a href="#" id="sol-nav--<?php echo $c; ?>" class="nav--sol<?php if ($c == 0) { echo ' active'; } ?>" data-target="#carousel--sol" data-slide-to="<?php echo $c; ?>"><?php echo $c + 1; ?></a>
        <?php ++$c; endwhile; ?>
        <a href="#carousel--sol" class="next--sol" data-slide="next"><img src="<?php Roots\Sage\Extras\echo_img('next.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('next@2x.png'); ?> 2x" /></a>
      </div>
    <?php endif; ?>
  </div>
</section>
    
   <?php
   }
   ?>

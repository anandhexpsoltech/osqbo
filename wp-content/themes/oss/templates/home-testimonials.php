<?php 
   $testimonials_section = get_field('disable_testimonials_section');
   if($testimonials_section){
   $testimonials_check= $testimonials_section;
   }else{
   $testimonials_check=array('no');
   }
   if(!in_array('yes', $testimonials_check)){ ?>
   
   <section class="testimonials-section">
  <div class="h-top-gradient"></div>
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_31')) : ?>
        <h3 class="heading--1"><?php the_field('heading_31'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_32')) : ?>
        <h2 class="heading--2"><?php the_field('heading_32'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
    <?php if (have_rows('testimonials_rep')) : ?>
      <div id="carousel--testimonials" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <?php $c = 0; while (have_rows('testimonials_rep')) : the_row(); ?>
            <?php if (get_sub_field('testimonial')) : ?>
              <div class="carousel-item<?php if ($c == 0) { echo ' active'; } ?>">
                <div class="row">
                  <?php $post_object = get_sub_field('testimonial');
                    $post = $post_object;
                    setup_postdata( $post );
                  ?>
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="col-lg-5 wow fadeInLeft" data-wow-offset="150" data-wow-duration="1s">
                      <div class="testimonial-img-container">
                        <div class="white-square"></div>
                        <div class="green-square"></div>
                        <div class="testim-img-inner-container">
                          <div class="white-border-block"></div>
                          <?php the_post_thumbnail('full', array('class'=>'testim--thumb')); ?>
                        </div>
                        <img class="quotes" src="<?php Roots\Sage\Extras\echo_img('quotes.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('quotes@2x.png'); ?> 2x" />
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="col-lg-6 offset-lg-1 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
                    <div class="testimonial-content">
                      <p class="full--name"><?php the_field('full_name'); ?></p>
                      <h2 class="testim--title font-30"><?php the_title(); ?></h2>
                      <div class="clearfix">
                        <div class="white-sep"></div>
                      </div>
                      <h3 class="testim-text font-24"><?php the_field('testimonial_text'); ?></h3>
                    </div>
                  </div>
                </div>
              </div>
            <?php wp_reset_postdata(); endif; ?>
          <?php ++$c; endwhile; ?>
        </div>
      </div>
      <div class="testimonials-controls-container">
        <?php $c = 0; while (have_rows('testimonials_rep')) : the_row(); ?>
          <a href="#" id="testim-nav--<?php echo $c; ?>" class="nav--testim<?php if ($c == 0) { echo ' active'; } ?>" data-target="#carousel--testimonials" data-slide-to="<?php echo $c; ?>"><span></span></a>
        <?php ++$c; endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
   <?php 
    }
   ?>


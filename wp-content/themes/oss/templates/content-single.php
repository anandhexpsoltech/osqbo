<?php while (have_posts()) : the_post(); ?>
  <?php $blogID = get_option('page_for_posts'); ?>
  <section class="custom-header">
    <div class="grad-80"></div>
    <?php echo get_new_royalslider(get_field('rs_id', $blogID)); ?>
    <div class="cust-header-overlay">
      <div class="container">
        <?php if (get_field('title_cust', $blogID)) : ?>
          <h1 class="font-70 cust-header-h"><?php the_field('title_cust', $blogID); ?></h1>
          <div class="clearfix">
            <div class="white-sep"></div>
          </div>
        <?php endif; ?>
        <?php if (get_field('content_cust', $blogID)) : ?>
          <p class="cust-content"><?php the_field('content_cust', $blogID); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <section class="blog--main">
    <div class="container">
      <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
        <?php if (get_field('heading_11', $blogID)) : ?>
          <h3 class="heading--1"><?php the_field('heading_11', $blogID); ?></h3>
        <?php endif; ?>
        <?php if (get_field('heading_12', $blogID)) : ?>
          <h2 class="heading--2"><?php the_field('heading_12', $blogID); ?></h2>
        <?php endif; ?>
        <div class="clearfix">
          <div class="gray-sep"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-9">
          <div class="bp-single--full-content">
            <div class="bp-single--header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
              <h2 class="bp--title font-40"><?php the_title(); ?></h2>
              <p class="post-meta"><?php echo get_the_date('F d, Y'); ?></p>
            </div>
            <?php if (has_post_thumbnail()) : ?>
              <div class="bp-single-feat-img wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
                <?php the_post_thumbnail('large'); ?>
              </div>
            <?php endif; ?>
            <div class="bp-single--entry-content">
              <!-- AddToAny BEGIN -->
              <ul class="a2a_kit a2a_kit_size_32 a2a_default_style" wow fadeIn" data-wow-offset="150" data-wow-duration="1s"">
                <li><a class="a2a_button_linkedin"><img src="<?php Roots\Sage\Extras\echo_img('linked.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('linked@2x.png'); ?> 2x" /></a></li>
                <li><a class="a2a_button_facebook"><img src="<?php Roots\Sage\Extras\echo_img('fb.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('fb@2x.png'); ?> 2x" /></a></li>
                <li><a class="a2a_button_google_plus"><img src="<?php Roots\Sage\Extras\echo_img('gplus.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('gplus@2x.png'); ?> 2x" /></a></li>
                <li><a class="a2a_button_twitter"><img src="<?php Roots\Sage\Extras\echo_img('twitter.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('twitter@2x.png'); ?> 2x" /></a></li>
                <li><a class="a2a_button_pinterest"><img src="<?php Roots\Sage\Extras\echo_img('pinterest.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('pinterest@2x.png'); ?> 2x" /></a></li>
              </ul>
              <!-- AddToAny END -->
              <div class="bp-single-content-c wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
                <?php the_content(); ?>
              </div>
              <div class="prev-next-posts-container wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
                <?php $prev_post = get_previous_post(); if (!empty( $prev_post )) : ?>
                  <a href="<?php echo get_the_permalink($prev_post->ID); ?>" class="prev-post-link"><img src="<?php Roots\Sage\Extras\echo_img('prev_p.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('prev_p@2x.png'); ?> 2x" /><?php _e('Previous post', 'nma-string'); ?></a>
                <?php endif; ?>
                <?php $next_post = get_next_post(); if (!empty( $next_post )) : ?>
                  <a href="<?php echo get_the_permalink($next_post->ID); ?>" class="next-post-link"><?php _e('Next post', 'nma-string'); ?><img src="<?php Roots\Sage\Extras\echo_img('next_p.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('next_p@2x.png'); ?> 2x" /></a>
                <?php endif; ?>
              </div>
              <div class="related-posts-container wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
                <?php 
                  $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => 2,
                    'order' => 'DESC',
                    'orderby' => 'date'
                  );

                  $query = new WP_Query($args);
                ?>
                <?php if ($query->have_posts()) : ?>
                  <h3 class="rel-posts-title font-30"><?php _e('Related Posts', 'nma-string'); ?></h3>
                  <div class="row bp-related-row">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                      <?php get_template_part('templates/content-related'); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php comments_template('/templates/comments.php'); ?>
        </div>
        <div class="col-lg-3 sidebar-container">
          <div class="wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
            <form method="get" id="searchform" class="search-form-container" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <div class="input-group">
                <input type="text" class="field" name="s" id="s" placeholder="<?php _e( 'Search', 'nma-string' ); ?>" value="<?php echo get_search_query(); ?>" />
                <button type="submit" class="search-btn" id="searchsubmit"><img src="<?php Roots\Sage\Extras\echo_img('search.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('search@2x.png'); ?> 2x" /></button>
              </div>
            </form>
            <?php dynamic_sidebar('sidebar-primary'); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endwhile; ?>
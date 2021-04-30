<?php $blogID = get_option('page_for_posts'); ?>
<section class="custom-header">
  <div class="grad-80"></div>
  <?php echo get_new_royalslider(get_field('rs_id', $blogID)); ?>
  <div class="cust-header-overlay">
    <div class="container">
      <?php if (is_home()) : ?>
        <?php if (get_field('title_cust', $blogID)) : ?>
          <h1 class="font-70 cust-header-h"><?php the_field('title_cust', $blogID); ?></h1>
          <div class="clearfix">
            <div class="white-sep"></div>
          </div>
        <?php endif; ?>
        <?php if (get_field('content_cust', $blogID)) : ?>
          <p class="cust-content"><?php the_field('content_cust', $blogID); ?></p>
        <?php endif; ?>
      <?php else : ?>
        <h1 class="font-70 cust-header-h"><?php echo Roots\Sage\Titles\title(); ?></h1>
        <div class="clearfix">
          <div class="white-sep"></div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<section class="blog--main">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (is_home()) : ?>
        <?php if (get_field('heading_11', $blogID)) : ?>
          <h3 class="heading--1"><?php the_field('heading_11', $blogID); ?></h3>
        <?php endif; ?>
        <?php if (get_field('heading_12', $blogID)) : ?>
          <h2 class="heading--2"><?php the_field('heading_12', $blogID); ?></h2>
        <?php endif; ?>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <?php if (have_posts()) : ?>
          <div class="all-bp-load-container">
            <?php while (have_posts()) : the_post(); ?>
              <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
            <?php endwhile; ?>
          </div>
          <?php if (is_home() && $wp_query->found_posts > get_option('posts_per_page')) : ?>
            <div class="loading-container">
              <div class="sk-circle">
                <div class="sk-circle1 sk-child"></div>
                <div class="sk-circle2 sk-child"></div>
                <div class="sk-circle3 sk-child"></div>
                <div class="sk-circle4 sk-child"></div>
                <div class="sk-circle5 sk-child"></div>
                <div class="sk-circle6 sk-child"></div>
                <div class="sk-circle7 sk-child"></div>
                <div class="sk-circle8 sk-child"></div>
                <div class="sk-circle9 sk-child"></div>
                <div class="sk-circle10 sk-child"></div>
                <div class="sk-circle11 sk-child"></div>
                <div class="sk-circle12 sk-child"></div>
              </div>
            </div>
            <div class="load-more-posts-btn-container wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
              <a href="#" class="load-more-posts" data-ppp="<?php echo get_option('posts_per_page'); ?>"><?php _e('See more news', 'nma-string'); ?></a>
            </div>
          <?php endif; ?>
        <?php else : ?>
          <div class="alert alert-warning">
            <?php _e('Sorry, no results were found.', 'sage'); ?>
          </div>
          <form method="get" id="searchform" class="search-form-container" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="input-group">
              <input type="text" class="field" name="s" id="s" placeholder="<?php _e( 'Search', 'nma-string' ); ?>" value="<?php echo get_search_query(); ?>" />
              <button type="submit" class="search-btn" id="searchsubmit"><img src="<?php Roots\Sage\Extras\echo_img('search.png'); ?>" srcset="<?php Roots\Sage\Extras\echo_img('search@2x.png'); ?> 2x" /></button>
            </div>
          </form>
        <?php endif; ?>
        <?php if (!is_home()) : ?>
          <div class="wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
            <?php the_posts_navigation(); ?>
          </div>
        <?php endif; ?>
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
  <div class="blog-bottom-bg"></div>
</section>
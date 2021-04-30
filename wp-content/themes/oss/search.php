<?php $blogID = get_option('page_for_posts'); ?>
<section class="custom-header">
  <div class="grad-80"></div>
  <?php echo get_new_royalslider(get_field('rs_id', $blogID)); ?>
  <div class="cust-header-overlay">
    <div class="container">
      <h1 class="font-70 cust-header-h"><?php echo Roots\Sage\Titles\title(); ?></h1>
      <div class="clearfix">
        <div class="white-sep"></div>
      </div>
    </div>
  </div>
</section>
<section class="blog--main">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
          <?php endwhile; ?>
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
        <div class="wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
          <?php the_posts_navigation(); ?>
        </div>
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
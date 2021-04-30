<section class="contact-map">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_11')) : ?>
        <h3 class="heading--1"><?php the_field('heading_11'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_12')) : ?>
        <h2 class="heading--2"><?php the_field('heading_12'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="container-map">
          <img src="<?php Roots\Sage\Extras\echo_img('map_container.png'); ?>" class="map-bg-img" />
          <div class="map-canvas-outer">
            <div id="map-canvas" data-lat="<?php $loc = get_field('location'); echo $loc['lat']; ?>"
            data-lng="<?php echo $loc['lng']; ?>" data-address="<?php echo $loc['address']; ?>"></div>
            <div class="map-overlay-1"></div>
            <div class="map-overlay-2"></div>
            <div class="map-overlay-3"></div>
            <div class="map-overlay-4"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="contact-content-1 wow fadeInRight" data-wow-offset="150" data-wow-duration="1s">
          <?php if (get_field('content_title_1')) : ?>
            <h3 class="font-30 content-title-x"><?php the_field('content_title_1'); ?></h3>
            <div class="clearfix">
              <div class="gray-sep"></div>
            </div>
          <?php endif; ?>
          <div class="contact-content-inner">
            <?php the_field('content_1'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
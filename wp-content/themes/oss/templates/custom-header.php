<section class="custom-header">
  <div class="grad-80"></div>
  <?php echo get_new_royalslider(get_field('rs_id')); ?>
  <div class="cust-header-overlay">
    <div class="container">
      <?php if (get_field('title_cust')) : ?>
        <h1 class="font-70 cust-header-h"><?php the_field('title_cust'); ?></h1>
        <div class="clearfix">
          <div class="white-sep"></div>
        </div>
      <?php endif; ?>
      <?php if (get_field('content_cust')) : ?>
        <p class="cust-content"><?php the_field('content_cust'); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
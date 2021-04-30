<section id="product-solutions" class="prod-sol-content">
  <div class="section-slider-top">
    <div class="container wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (have_rows('product_solutions_rep')) : ?>
        <div class="bx-slider-outer">
          <ul class="bxslider">
            <?php while (have_rows('product_solutions_rep')) : the_row(); $sol_single = get_sub_field('product_solution'); ?>
			<li><a href="#" class="sol--load" data-sol="<?php echo $sol_single->ID; ?>">
                <div class="sol--load-ic">
                  <?php echo wp_get_attachment_image(get_field('icon_sol', $sol_single->ID), 'thumbnail'); ?>
                </div>
                <p class="sol--tile"><?php echo $sol_single->post_title; ?></p>
              </a></li>
            <?php endwhile; ?>
          </ul>
          <div class="previous-bx-slide"></div>
          <div class="next-bx-slide"></div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="prod-sol-main">
    <div class="container">
      <div id="main-sol-container">
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
    </div>
  </div>
</section>


<?php if (isset($_GET['solution'])) : 
  global $wpdb;
  $sol_name = $_GET['solution'];
  $sol = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='solution'", $sol_name ));
  if (!empty($sol)) : ?>
<script type="text/javascript">var show_sol = <?php echo $sol; ?>;</script>
<?php else : ?>
<script type="text/javascript">var show_sol = 0;</script>
<?php
  endif;
?>
<?php else : ?>
<script type="text/javascript">var show_sol = 0;</script>
<?php endif; ?>
<section class="about-team">
  <div class="container">
    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">
      <?php if (get_field('heading_41')) : ?>
        <h3 class="heading--1"><?php the_field('heading_41'); ?></h3>
      <?php endif; ?>
      <?php if (get_field('heading_42')) : ?>
        <h2 class="heading--2"><?php the_field('heading_42'); ?></h2>
      <?php endif; ?>
      <div class="clearfix">
        <div class="gray-sep"></div>
      </div>
    </div>
    <?php if (have_rows('team_members')) : ?>
      <div class="row all--team-members-row">
        <?php $c = 0; while (have_rows('team_members')) : the_row(); ?>
          <div class="col-sm-6 col-md-4 col-xl-3 team--member-single-container wow fadeIn" data-wow-offset="150" data-wow-delay="<?php echo ($c % 4)*0.2; ?>s" data-wow-duration="1s">
            <div class="team-img-container">
              <?php echo wp_get_attachment_image(get_sub_field('image'), 'thumbnail'); ?>
            </div>
            <h3 class="font-20 team-m-name"><?php the_sub_field('full_name'); ?></h3>
            <?php if (get_sub_field('about_team_member')) : ?>
              <div class="team-excerpt"><?php echo wp_trim_words( get_sub_field('about_team_member'), 15, '... <div class="read-more-team"><a href="#" class="read-more-team-link">Read more</a></div>'); ?></div>
              <div class="team-full-content">
                <?php the_sub_field('about_team_member'); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php ++$c; endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
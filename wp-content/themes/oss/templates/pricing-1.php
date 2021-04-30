<section class="about--1">

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

    <?php if (have_rows('plans')) : ?>

      <table class="pricing-table-mobile">

        <tbody>

          <tr class="no--bot-border">

            <th colspan="2"><?php the_field('plan_1_title'); ?></th>

          </tr>

          <?php if (get_field('promotion_text_1')) : ?>

            <tr class="no--bot-border promotion-tr">

              <th colspan="2"><?php the_field('promotion_text_1'); ?></th>

            </tr>

          <?php endif; ?>

          <tr class="no--bot-border btns--tr">

            <th colspan="2">

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

          </tr>

          <?php while (have_rows('plans')) : the_row(); ?>

            <tr>

              <td><?php the_sub_field('title'); ?></td>

              <?php if (get_sub_field('plan_1') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_1'); ?></td>

              <?php endif; ?>

            </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

      <table class="pricing-table-mobile">

        <tbody>

          <tr class="no--bot-border">

            <th colspan="2"><?php the_field('plan_2_title'); ?></th>

          </tr>

          <?php if (get_field('promotion_text_2')) : ?>

            <tr class="no--bot-border promotion-tr">

              <th colspan="2"><?php the_field('promotion_text_2'); ?></th>

            </tr>

          <?php endif; ?>

          <tr class="no--bot-border btns--tr">

            <th colspan="2">

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=2&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=2&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

          </tr>

          <?php while (have_rows('plans')) : the_row(); ?>

            <tr>

              <td><?php the_sub_field('title'); ?></td>

              <?php if (get_sub_field('plan_2') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_2'); ?></td>

              <?php endif; ?>

            </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

      <table class="pricing-table-mobile">

        <tbody>

          <tr class="no--bot-border">

            <th colspan="2"><?php the_field('plan_3_title'); ?></th>

          </tr>

          <?php if (get_field('promotion_text_3')) : ?>

            <tr class="no--bot-border promotion-tr">

              <th colspan="2"><?php the_field('promotion_text_3'); ?></th>

            </tr>

          <?php endif; ?>

          <tr class="no--bot-border btns--tr">

            <th colspan="2">

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=3&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=3&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

          </tr>

          <?php while (have_rows('plans')) : the_row(); ?>

            <tr>

              <td><?php the_sub_field('title'); ?></td>

              <?php if (get_sub_field('plan_3') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_3'); ?></td>

              <?php endif; ?>

            </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

      <table class="pricing-table-desktops wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">

        <tbody>

          <tr class="no--bot-border">

            <th class="blank"></th>

            <th><?php the_field('plan_1_title'); ?></th>

            <th class="empty--sep"></th>

            <th><?php the_field('plan_2_title'); ?></th>

            <th class="empty--sep"></th>

            <th><?php the_field('plan_3_title'); ?></th>

          </tr>

          <?php if (get_field('promotion_text_1') || get_field('promotion_text_2') || get_field('promotion_text_3')) : ?>

            <tr class="no--bot-border promotion-tr">

              <th class="blank"></th>

              <th><?php the_field('promotion_text_1'); ?></th>

              <th class="empty--sep"></th>

              <th><?php the_field('promotion_text_2'); ?></th>

              <th class="empty--sep"></th>

              <th><?php the_field('promotion_text_3'); ?></th>

            </tr>

          <?php endif; ?>

          <tr class="no--bot-border btns--tr">

            <th class="blank"></th>

            <th>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=1&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

            <th class="empty--sep"></th>

            <th>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=2&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=2&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

            <th class="empty--sep"></th>

            <th>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=3&IsTrail=false" class="btn-h-top h-top-green" target="_blank"><?php _e('Start', 'nma-string'); ?></a>

              <a href="http://www.osqbo.com/Home/SignUp?PricingType=3&IsTrail=true" class="btn-h-top h-top-prpl" target="_blank"><?php _e('Free Trial', 'nma-string'); ?></a>

            </th>

          </tr>

          <?php while (have_rows('plans')) : the_row(); ?>

            <tr>

              <td><?php the_sub_field('title'); ?></td>

              <?php if (get_sub_field('plan_1') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_1'); ?></td>

              <?php endif; ?>

              <td class="empty--sep"></td>

              <?php if (get_sub_field('plan_2') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_2'); ?></td>

              <?php endif; ?>

              <td class="empty--sep"></td>

              <?php if (get_sub_field('plan_3') == 'x') : ?>

                <td class="checked--td"><span></span></td>

              <?php else : ?>

                <td><?php the_sub_field('plan_3'); ?></td>

              <?php endif; ?>

            </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

    <?php endif; ?>

    <div class="gray--line"></div>

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

    <div class="row">

      <div class="col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">

        <?php if (have_rows('table_2')) : ?>

          <table class="table--bottom wow fadeInUp" data-wow-offset="150" data-wow-duration="1s">

            <tbody>

              <?php while (have_rows('table_2')) : the_row(); ?>

                <tr>

                  <td><?php the_sub_field('title'); ?></td>

                  <?php if (get_sub_field('value') == 'x') : ?>

                    <td class="checked--td"><span></span></td>

                  <?php else : ?>

                    <td><?php the_sub_field('value'); ?></td>

                  <?php endif; ?>

                </tr>

              <?php endwhile; ?>

            </tbody>

          </table>

        <?php endif; ?>

      </div>

    </div>

  </div>

</section>
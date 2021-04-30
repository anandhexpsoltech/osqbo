<?php 
   $newsletter_section = get_field('disable_newsletter_section');
   if($newsletter_section){
   $newsletter_check= $newsletter_section;
   }else{
   $newsletter_check=array('no');
   }
   if(!in_array('yes', $newsletter_check)){ ?>
<section class="newsletter-section">

  <div class="h-top-gradient"></div>

  <div class="container">

    <div class="section-header wow fadeIn" data-wow-offset="150" data-wow-duration="1s">

      <h3 class="heading--1"><?php _e('Subscribe to', 'nma-string'); ?></h3>

      <h2 class="heading--2"><?php _e('Our newsletter', 'nma-string'); ?></h2>

      <div class="clearfix">

        <div class="white-sep"></div>

      </div>

    </div>

    <div class="row">

      <div class="col-lg-10 offset-lg-1 col-xl-8 offset-lg-2 wow fadeIn" data-wow-offset="150" data-wow-duration="1s">

        <div id="mc_embed_signup">

          <form action="//company.us9.list-manage.com/subscribe/post?u=1bd49050e9167715812f9a5dd&amp;id=1615866310" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

            <div id="mc_embed_signup_scroll">

              <div class="row row-20">

                <div class="col-lg-4">

                  <div class="mc-field-group">

                    <input type="text" value="" name="NAME" class="" id="mce-NAME" placeholder="Full Name">

                  </div>

                </div>

                <div class="col-lg-4">

                  <div class="mc-field-group size1of2">

                    <input type="text" name="PHONE" class="" value="" id="mce-PHONE" placeholder="Phone Number">

                  </div>

                </div>

                <div class="col-lg-4">

                  <div class="mc-field-group">

                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email">

                  </div>

                </div>

              </div>

              <div class="mc-field-group">

                <input type="text" value="" name="ADDRESS" class="" id="mce-ADDRESS" placeholder="Address">

              </div>

              <div id="mce-responses" class="clear">

                <div class="response" id="mce-error-response" style="display:none"></div>

                <div class="response" id="mce-success-response" style="display:none"></div>

              </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1bd49050e9167715812f9a5dd_1615866310" tabindex="-1" value=""></div>

              <div class="clear text-center">

                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button green--btn">

              </div>

            </div>

          </form>

        </div>

        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[1]='NAME';ftypes[1]='text';fnames[4]='PHONE';ftypes[4]='phone';fnames[0]='EMAIL';ftypes[0]='email';fnames[3]='ADDRESS';ftypes[3]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>

        <!--End mc_embed_signup-->

      </div>

    </div>

  </div>

</section>
  <?php }
   ?>


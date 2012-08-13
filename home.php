<?php get_header(); ?>
    <div class="span19"> <!-- contains all content except right most column -->
      <div class="row border7">
        <div class="span7 content-list narrow borders" id="top-three">
        <?php
          global $post;
          global $ydn_suppress_thumbnails;
          $ydn_suppress_thumbnails = true; // ugly hack, but necessary to pass variables to template

          $top_three = ydn_get_home_page_content(3);
          foreach ($top_three as $post): 
            setup_postdata($post);
            $format = get_post_format();
            if (false == $format) {
               $format = "standard";
            }
            get_template_part('list', $format);
          endforeach;
        ?>
              
        </div> <!-- #top-three -->
        <div class="span12" id="slideshow-multimedia"> 
          <?php new YDN_Carousel( ydn_get_home_page_content(4), "home-carousel" ); ?>
        </div><!-- #sldieshow-multimedia -->
      </div>
    </div> <!-- end all content except right most column -->

    <div class="span5"> <!-- right most column -->
      <div id="cross-campus" class="widget">
        <a href="#"><h1>Cross Campus</h1></a>
        <div class="content-list borders">
          <div class="item">
            <div class="section">University</div>
            <a class="headline" href="#"><h3>This is a headline</h3></a>
            <div class="datetime">10:37PM</div>
            <div class="teaser">One two three four five.  <a href="#">››</a></div>
          </div>
          <div class="item">
            <div class="section">University</div>
            <a class="headline" href="#"><h3>This is a headline</h3></a>
            <div class="datetime">10:37PM</div>
            <div class="teaser">One two three four five.  <a href="#">››</a></div>
          </div>

        </div>
      </div> <!-- end #cross campus -->
    </div> <!-- end right most column -->
<?php get_footer(); ?>


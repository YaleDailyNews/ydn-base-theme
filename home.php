<?php
  /* grab the content for the page */
  $top_three_content = z_get_posts_in_zone("homepage-top-three");
  $slideshow_content = z_get_posts_in_zone("homepage-slideshow");
  $print_section_content = new YDN_homepage_content($slideshow_content, $top_three_content, z_get_posts_in_zone('homepage-featured-stories') );
?>
<?php get_header(); ?>
    <div class="span19"> <!-- contains all content except right most column -->
      <div class="row border7">
        <div class="span7 content-list narrow borders" id="top-three">
        <?php
          global $post;
          global $ydn_suppress_thumbnails;
          $ydn_suppress_thumbnails = true; // ugly hack, but necessary to pass variables to template

          foreach ($top_three_content as $post): 
            setup_postdata($post);

            get_template_part('list', ydn_get_post_format());
          endforeach;
        ?>
              
        </div> <!-- #top-three -->
        <div class="span12" id="slideshow-multimedia"> 
          <?php new YDN_Carousel( $slideshow_content, "home-carousel" ); ?>
        </div><!-- #sldieshow-multimedia -->
      </div>
      <!-- starting the most-read/opinion section -->
      <div class="double-border"></div>

      <div class="row border6">
        <div class="span6">
          <!-- most popular/most viewed -->
          Most popular/viewed posts will go here
        </div>

        <div class="span13 print-section">
          <!-- opinion -->
          <h1>Opinion</h1>
          <div class="content-list">
            <?php
              foreach ($print_section_content->get_post_list("opinion") as $post):
                setup_postdata($post);
            ?>
            <div class="item">
              <a class="headline" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
              <span class="meta">&bull; <span class="bylines"><?php coauthors_posts_links(); ?></span> &bull; <?php ydn_comment_count(); ?> </span>
            </div>
            <?php endforeach;  ?>
          </div>
        </div>
      </div> <!-- end row.border6 -->

      <div class="double-border"></div>

      <!-- starting individual news sections on bottom of page -->
      <div class="row border6">
        <div class="span6">
          <!-- column with sports/weekend/today's paper -->
          sports/weekend/today
        </div>

        <div class="span13">
          <!-- column with content for most of the sections of the paper -->
          <?php ydn_home_print_section($print_section_content, "university"); ?>
          <div class="double-border"></div>
          <?php ydn_home_print_section($print_section_content, "culture"); ?>
          <div class="double-border"></div>
          <?php ydn_home_print_section($print_section_content, "city"); ?>
          <div class="double-border"></div>
          <?php ydn_home_print_section($print_section_content, "sci-tech"); ?>
        </div>

      </div><!-- end row.border6 -->

    </div> <!-- end all content except right most column -->

    <div class="span5"> <!-- right most column -->
      <div id="cross-campus" class="widget">
        <?php switch_to_blog(XC_BLOG_ID); ?>
        <a href="<?php echo get_bloginfo('url'); ?>"><h1>Cross Campus</h1></a>
        <div class="content-list borders">
          <?php 
            $xc_posts = get_posts( array('numberposts' => 4 ) );
            foreach ($xc_posts as $post):
              setup_postdata($post);
              get_template_part('list','xc');
            endforeach;
          ?>
        </div>
        <a class="more" href="<?php echo get_bloginfo('url'); ?>">More from the blogs</a>
        <?php restore_current_blog(); ?>
      </div> <!-- end #cross campus -->
      <div class="sidebar-widgets">
        <?php dynamic_sidebar('home-advertisements'); ?>
      </div>
    </div> <!-- end right most column -->
<?php get_footer(); ?>


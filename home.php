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

            get_template_part('list', ydn_get_post_format());
          endforeach;
        ?>
              
        </div> <!-- #top-three -->
        <div class="span12" id="slideshow-multimedia"> 
          <?php new YDN_Carousel( z_get_posts_in_zone("homepage-slideshow"), "home-carousel" ); ?>
        </div><!-- #sldieshow-multimedia -->
      </div>
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


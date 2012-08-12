<div class="item standard">
  <?php if (!( isset($GLOBALS['ydn_suppress_thumbnails']) &&  $GLOBALS['ydn_suppress_thumbnails']) && has_post_thumbnail() ): ?><div class="thumbnail  span2"><?php the_post_thumbnail('thumbnail'); ?></div><?php endif ?>
  <div class="section"><?php echo ydn_get_top_level_cat(); ?></div>
  <a class="headline" href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
  <div class="meta">
    <span class="bylines">By <?php coauthors_posts_links(); ?></span>
    <span class="datetime"><?php echo get_the_date(); ?> &bull; <a href="<?php echo get_permalink();?>#comments-title" class="comment-count">(<?php echo $post->comment_count; ?>)</a> </span>
  </div>
  <div class="teaser"><?php echo get_the_excerpt(); ?> <a href="<?php echo get_permalink(); ?>">››</a></div>
</div> 

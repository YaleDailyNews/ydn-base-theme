<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ydn
 * @since ydn 1.0
 */

if ( ! function_exists( 'ydn_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since ydn 1.0
 */
function ydn_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'ydn' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'ydn' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'ydn' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'ydn' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'ydn' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // ydn_content_nav

if ( ! function_exists( 'ydn_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since ydn 1.0
 */
function ydn_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'ydn' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', '_s' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s:', 'ydn' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'ydn' ); ?></em>
					<br />
				<?php endif; ?>
			</header>

			<div class="comment-content"><?php comment_text(); ?></div>
      <footer class="clearfix">
        <a class="pull-left" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( 'Posted on %1$s at %2$s', 'ydn' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>

        <span class="reply pull-right">
          <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </span><!-- .reply -->
      </footer>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for ydn_comment()

if ( ! function_exists( 'ydn_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since ydn 1.0
 */
function ydn_posted_on() {
	printf( __( '%1$s', 'ydn' ),
		esc_html( get_the_date('l, F j, Y') )
	);
}
endif;

/**
 * Returns a div with the post's featured image and associated metadata (e.g. caption, authors..)
 * meant to be used within the loop. uses global $post
 */
if (! function_exists( 'ydn_get_featured_image') ):
function ydn_get_featured_image() {
  global $post;
  if(  has_post_thumbnail() ):
    $featured_image_id = get_post_thumbnail_id( $post->ID );
    $featured_image_obj = get_posts( array( 'numberposts' => 1,
                                            'include' => $featured_image_id,
                                            'post_type' => 'attachment',
                                            'post_parent' => $post->ID ) );
    $featured_image_obj = $featured_image_obj[0];

    ?>
    <div class="entry-featured-image">
      <?php  the_post_thumbnail('entry-featured-image'); ?>
      <?php if($featured_image_obj): ?>
        <div class="image-meta">
          <?php if( $featured_image_obj->post_excerpt): ?>
            <span class="caption"> <?php echo esc_html( $featured_image_obj->post_excerpt ); ?> </span> 
          <?php endif; ?>
          <?php
            $attribution_text = get_media_credit_html($featured_image_obj);
            if(trim($attribution_text) != ''  ): ?>
              <span class="attribution">Photo by <?php echo $attribution_text; ?>.</span>
          <?php endif; ?>
        </div>
      <?php endif; //end featured_image_obj check ?>
    </div>
    <?php endif; //end has_post_thumbnail condition
}
endif; // end function_exists condition


/**
 * Returns formatted author bylines with  the reporter type if available (e.g. staff reporters, contributing reporters)
 * meant to be used within the loop. uses global $post
 */
if (! function_exists('ydn_authors_with_type') ):
  function ydn_authors_with_type() {
    global  $post;
    $reporter_type = get_post_custom_values("reporter_type");
    if (!empty($reporter_type) ) {
       $reporter_type = $reporter_type[0]; //there should only be one key associated with this value
       $reporter_type = '<br>' . $reporter_type;
    } else {
      $reporter_type = '';
    }

    coauthors_posts_links(); //this prints its own output
    echo $reporter_type;
  }
endif; //edn function_exists condition

/**
 * outputs a twitter/facebook share links
 */
if (!function_exists('ydn_facebook_link') ):
  function ydn_facebook_link() {
    global $post;
    $fb_options = get_option('fb_options');
    if (empty($fb_options)) {
      $fb_app = '';
    } else {
      $fb_app = $fb_options["app_id"];
    }
    $fb_params = array( "app_id" => $fb_app,
                        "link" => get_permalink(),
                        "name" => get_the_title(),
                        "description" => get_the_excerpt(),
                        "redirect_uri" => get_permalink() );
    $fb_share_url = "https://www.facebook.com/dialog/feed?" . http_build_query($fb_params);
    printf('<a href="%1$s" target="_blank">Share</a>',$fb_share_url);
 }
endif;

if (!function_exists('ydn_twitter_link') ):
  function ydn_twitter_link() {
    global $post;
    $twitter_params = array( "url" => get_permalink(),
                        "text" => 'Checkout "' . get_the_title() . '"! ' . get_permalink(),
                        "related" => "yaledailynews" );
    $twitter_share_url = "https://twitter.com/share?" . http_build_query($twitter_params);
    printf('<a href="%1$s" target="_blank">Tweet</a>',$twitter_share_url);
 }
endif;
/**
 * Returns true if a blog has more than 1 category
 *
 * @since ydn 1.0
 */
function ydn_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so ydn_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so ydn_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in ydn_categorized_blog
 *
 * @since ydn 1.0
 */
function ydn_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'ydn_category_transient_flusher' );
add_action( 'save_post', 'ydn_category_transient_flusher' );

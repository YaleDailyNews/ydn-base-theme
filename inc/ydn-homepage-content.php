<?php
class YDN_homepage_content { 
  /* This class is used to pull content for the category-specific boxes on the homepage */
  function __construct($slideshow_content, $top_three_content, $featured_content) {
    /* initializes the class to start returning values */

    /* anything included in slideshow/top_three should be excluded from the category specific boxes */
    $this->excluded_ids = array();
    foreach ($slideshow_content as $post) {
      $this->excluded_ids[] =  $post->id;
    }
    foreach ($top_three_content as $post) {
      $this->excluded_ids[] =  $post->id;
    }

    /* we need to know the category for content in $featured_content so that we can use them when appropriate */
    /* we build a 2D array: $featured_content_by_cat[cat_slug] = an array of posts in that cat */
    $this->featured_content_by_cat = array();
    foreach ($featured_content as $post) {
      $categories = get_the_category($post->ID);
      foreach ($categories as $category) {
        if ( array_key_exists($category->slug, $this->featured_content_by_cat) ) {
          /* we've never encountered this category before,
           * so we need to build a new array in that bin and add the post to it */
          $this->featured_content_by_cat[$category->slug] = array($post);
        } else {
          /* we've encountered this category before, so add it to the list */
          $this->featured_content_by_cat[$category->slug][] = $post;
        }
      }
    }

  }

  function get_content_for_cat($cat_slug, $n_list = 5) {
    /* takes in a category name and returns home page content for it
     * also takes an optional parameter which specifies the number of posts to return in the list field */
    /* returns an array with two values:
          [featured] => 1) check if something in $featured_content is in the category, has a photo, and is not marked for exclusion. retrun post if found
                        2) return the most recent post in the category that has a photo and is not excluded
                        [list]     => return the most recent stories that are not [featured]
       returns null if there's a problem 
    */

    $output = array();

    /* first we find the featured post */
    if ( array_key_exists( $cat_slug, $this->featured_content_by_cat ) &&
         !empty($this->featured_content_by_cat[$cat_slug])  ) {
        /* we have featured content from this category, so as long as it has a photo we're golden */
        $output["featured"] = $this->featured_content_by_cat[$cat_slug][0];
    } else {
        /* we don't have any featured content for this category. we need to pull the latest post
         * that's not in excluded_ids, has a photo, and is in this cat */
        $query_params = array( 'posts_per_page' => 1,
                               'meta_query' => array( array('key' => '_thumbnail_id') ), //this checks for thumb
                               'post__not_in' => $this->excluded_ids,
                               'category_name' => $cat_slug, //this param is named poorly, slug is correct
                             );
        $query = new WP_Query($query_params);
        if ( empty($query->posts) ) {
          /* we weren't able to find any matching posts, so return null and go no further */
          /* error state */
          return null;
        } else {
          /* set our featured post for this category to be the query response */
          $output["featured"] = $query->posts[0];
        }
    }

    /* now that we have featured post, we pull the list of stories that should accompany it */
    $query_params = array( 'posts_per_page' => $n_list,
                           'category_name' => $cat_slug,
                           'post__not_in' => array($output["featured"]->ID)  //we don't want to show the featured story 2x
                         );
    $query = new WP_Query($query_params);
    if ( empty($query->posts) ) {
          /* we weren't able to find any matching posts, so return null and go no further */
          /* error state */
          return null;
    } else {
          /* set our list to all the posts from query response */
          $output["list"] = $query->posts;
    }


    return $output;


  }

}
?>

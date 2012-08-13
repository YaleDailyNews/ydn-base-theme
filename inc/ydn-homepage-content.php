<?php
class YDN_homepage_content { 

  public __construct() {
    $this->categories_for_content = array();

  public function set_slideshow_content($content_in) {
    $this->slideshow_content = $content_in;
    $this->get_categories_for_content($this->slideshow_content);
  }

  public function set_top_three_content($content_in) {
    $this->top_three_content = $content_in;
    $this->get_categories_for_content($this->top_three_content);
  }

  public function set_featured_section_content($content_in) {
    $this->featured_section_content = $content_in;
  }

  /* takes a category ID and returns an array of 1) the featured story 2) the list of most recent stories
   * featured story selection:
   *    if a story in $featured_category_content belongs to $category, use it
   *    otherwise, pick the most recent story that has a picture AND is not in $top_three_content or $slide_show_content
   * most recent stories selection:
   *    pick the most recent stories belonging to $category that aren't the featured story from the previous step */ 
  public function content_for_category($category) {
    $featured_story = NULL;
    foreach ( $content as $story ) {
      if ( in_array( $category, $story["categories"] ) )

  }
  private $top_three_content;
  private $slideshow_content;
  private $content; /* an associative array mapping content IDs to 1) arrays that hold all of the categories for that content 2) the content itself */
  private $featured_category_content; /* these are stories to be given priority in the bottom sections (news/sports/etc) of the homepage */
  
  /* takes an array of content and populates $categories_for_content */
  private function add_content($input) {
    foreach ($input as $story) {
      $content[$story->ID] = Array("categories" => wp_get_post_categories($story->ID),
                                   "object" => $story );
    }
  }

}
?>

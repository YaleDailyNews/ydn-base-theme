(function($) {

  var YDN = window.YDN || (window.YDN = {});

  function initialize() {
    var $body = $('body');
    //run the scripts for a single-post
    if ( $body.hasClass('single-post') ) {
      attach_social_handlers();
    }

   if ( $body.hasClass('home') ) {
     homepage_carousel_init();
   }
  };

  /* social share buttons on story pages should launch popups
   * that are centered on the page and that provide appropriate
   * data about the object */
  function attach_social_handlers() {
    var $social_share = $('.social-share');
  
    /* generate the share parameters on page load, use them when the handlers fire */
    var fb_object = { 'method': 'feed',
                      'link': extract_metadata_for_key('url'),
                      'picture': extract_metadata_for_key('image'),
                      'name': extract_metadata_for_key('title'),
                      'description': extract_metadata_for_key('description') };

    var twitter_object = { 'text': 'Checkout "'+ extract_metadata_for_key('title') + '"! ' + extract_metadata_for_key('url'),
                           'related': 'yaledailynews' };
                      
    /* bind the event handlers */
    $social_share.find('.facebook').click( function() {
       FB.ui( fb_object );
       return false;
    } );


    $social_share.find('.twitter').click( function() {
      var D=550,A=450,C=screen.height,B=screen.width,H=Math.round((B/2)-(D/2)),G=0,F=document,E;if(C>A){G=Math.round((C/2)-(A/2))}
      window.open('http://twitter.com/share?' + $.param(twitter_object),'','left='+H+',top='+G+',width='+D+',height='+A+',personalbar=0,toolbar=0,scrollbars=1,resizable=1');
      return false;
    } );

  };

  /* extract metadata from the DOM for use in JS */
  function extract_metadata_for_key(key) {
    var $el = $('meta[property$=' + key + ']');
    if ( $el ) {
      $el = $el[0];
      return $el.content;
    } else {
      return '';
   }
  };

  /**
   * replace the no-javascript HTML markup with the javascript-enabled markup that gets rendered
   * into a <script> tag on the bottom of the page. then initialize the rotation.
   */
  function homepage_carousel_init() {
    var $home_carousel = $('#home-carousel');
    var $home_carousel_template = $('#home-carousel-template');
    var $navlist, nav_height, $items;

    $home_carousel.removeClass('no-js').html( $home_carousel_template.html() );
    $home_carousel.carousel();

    $navlist = $home_carousel.find('.navlist'); 
    nav_height = $navlist.height();

    $items = $home_carousel.find('.item');
    /* this loop is pretty messy, but it's doing the job.
     * it 1) makes sure the captions for each picture are tall enough to hold the nav list
     *    2) binds the mouse over events for the navigation */
   
    $items.addClass('force-display'); //the items need to be visible so that the height calculations will work
    $items.find('.carousel-caption').each(function(item_index, item_obj) {
      var $item_obj = $(item_obj);

      console.log($item_obj.height());
      if (nav_height > $item_obj.height() ) {
        $item_obj.height(nav_height);
      }

      $item_obj.find('.navlist li').each(function(li_index, li_obj) {
        $li_obj = $(li_obj);
        if (!$li_obj.hasClass('arrow')) {
          $li_obj.mouseenter( function() { $home_carousel.removeClass('slide').carousel(li_index).addClass('slide'); return false; } );
        }
      });
    });
    $items.removeClass('force-display'); //allow the carousel styling to take over again

  };

  $(document).ready( initialize );

} (jQuery) );

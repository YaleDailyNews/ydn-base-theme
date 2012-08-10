(function($) {

  var YDN = window.YDN || (window.YDN = {});

  function initialize() {

    //run the scripts for a single-post
    if ( $('body.single-post') ) {
      attach_social_handlers();
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

  $(document).ready( initialize );

} (jQuery) );

<?php
/*
Plugin Name: Pinterest Pin It button for images
Plugin URI: http://www.xcake.com.br
Description: Displays a Pin It button directly over your images
Author: xCakeBlogs
Author URI: http://www.xcake.com.br
Version: 0.1
*/

define("XCPIN_PATH", WP_PLUGIN_URL . "/" . plugin_basename( dirname(__FILE__) ) . "/" );
define("XCPIN_NAME", "Pinterest Pin It button for images");
define("XCPIN_VERSION", "0.1");

wp_enqueue_style('xc_pinterest', XCPIN_PATH.'xc_pinterest.css'); 

/* 
Special thanks:

David Cowgill for the regex:
http://docs.appthemes.com/tutorials/automatically-add-rel-attribute-to-wordpress-images/

Thiago Galesi (@dsracoon) and Joao Ricardo (@JoaoRicardo_RM) for the help with regex
*/


function xcake_pinterest($content) {
	global $post;
	$posturl = urlencode(get_permalink()); //Get the post URL
	$pindiv = '<div class="xc_pinterest">';
	$pinurl = '<a href="http://pinterest.com/pin/create/button/?url='.$posturl.'&media=';
	$pindescription = '&description='.urlencode(get_the_title());
	$pinfinish = '" class="xc_pin"></a>';
	$pinend = '</div>';
	$pattern = '/<img(.*?)src="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?) \/>/i';
  	$replacement = $pindiv.$pinurl.'$2.$3'.$pindescription.$pinfinish.'<img$1src="$2.$3" $4 />'.$pinend;
  	
	$content = preg_replace( $pattern, $replacement, $content );
	return $content;
	
	
}
add_filter('the_content', 'xcake_pinterest');

?>
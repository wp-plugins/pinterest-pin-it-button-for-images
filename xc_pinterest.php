<?php
/*
Plugin Name: Pinterest Pin It Button For Images
Plugin URI: http://www.canha.net
Description: Displays a Pin It button directly over your images
Author: Canha
Author URI: http://www.canha.net
Version: 0.3.1
*/
define("XCPIN_PATH", WP_PLUGIN_URL . "/" . plugin_basename( dirname(__FILE__) ) . "/" );
define("XCPIN_NAME", "Pinterest Pin It button for images");
define("XCPIN_VERSION", "0.3.1");

/* 
	Special thanks:

	David Cowgill for the regex:
http://docs.appthemes.com/tutorials/automatically-add-rel-attribute-to-wordpress-images/

	Thiago Galesi (@dsracoon) and Joao Ricardo (@JoaoRicardo_RM) for the help with regex

*/



function xcake_pinterest_run($content) {
	global $post;

	$posturl = urlencode(get_permalink()); //Get the post URL
	$pattern = '/<img(.*?)src="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?) \/>/i';
  	
  	//New - working:
  	$replacement = '<div class="xc_pinterest"><a href="#" onClick=\'window.open("http://pinterest.com/pin/create/button/?url='.$posturl.'&media=$2.$3&description='.urlencode(get_the_title()).'","Pinterest","scrollbars=no,menubar=no,width=600,height=380,resizable=yes,toolbar=no,location=no,status=no")\' class="xc_pin"></a><img$1src="$2.$3" $4 /></div>';
  	
	$content = preg_replace( $pattern, $replacement, $content );
	
	//Fix the link problem
	$newpattern = '/<a(.*?)><div class="xc_pinterest"><a(.*?)><\/a><img(.*?)\/><\/div><\/a>/i';
	$replacement = '<div class="xc_pinterest"><a$2></a><a$1><img$3\/></a></div>';

	$content = preg_replace( $newpattern, $replacement, $content );
	return $content;
}


if (!is_admin()) {
	wp_enqueue_style('xc_pinterest_style', XCPIN_PATH.'xc_pinterest.css'); 
	add_filter('the_content', 'xcake_pinterest_run');
}

?>
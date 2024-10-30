<?php
/*
Plugin Name: ChronoFlo Calendar Shortcode
Plugin URI: http://wordpress.org/plugins/chronoflo-calendar-shortcode/
Description: The Official Wordpress Plugin for beautiful ChronoFlo Calendars. It enables a shortcode that you can enter into your posts to embed a calendar created on www.chronoflocalendar.com. For example: [chronoflo_calendar embedkey="68-1662695519" width="100%" height="500"]
Version: 1.0
Author: Webalon Ltd
Author URI: http://www.webalon.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
*/

if (!defined('ABSPATH')) {
	die();
}

define('CHRONOFLO_CALENDAR_PLUGIN_VERSION', '1.0');

function chronoflo_calendar_plugin_generate_embed_code($attributes) {

	$embedKey = (isset($attributes["embedkey"])) ? $attributes["embedkey"] : "error";
	$width = (isset($attributes["width"])) ? $attributes["width"] : "100%";
	$height = (isset($attributes["height"])) ? $attributes["height"] : "500";
	$class = (isset($attributes["class"])) ? $attributes["class"] : "";
	$id = (isset($attributes["id"])) ? $attributes["id"] : "chronoflo_calendar_embed_iframe";
	
	if (!$embedKey || $embedKey == "error") {
		return "\n<h4>Invalid embedKey for ChronoFlo Calendar. See https://www.chronoflocalendar.com/wordpress/</h4><br /><br />\n";
	}

	//$embedUrl = "https://www.chronoflocalendar.com/calendar/embed/".str_replace("-","/",$embedKey)."/";
	$embedUrl = "http://calendar/calendar/embed/".str_replace("-","/",$embedKey)."/";
	
	$iH = "\n".'<div id="'.$id.'-countainer" style="width:'.$width.'px;height='.$height.'px;"><iframe id="'.$id.'" class="'.$class.'" width="'.$width.'" height="'.$height.'" src="'.$embedUrl.'" frameborder="0" style="border-width:0;"></iframe>';
	
	$iH .= "\n".'<script type="text/javascript">';
	$iH .= '(function() {'."\n";
	$iH .= 'if (window.postMessage) {'."\n";
	$iH .= 'var cdrMouseupFunc = function() {'."\n";
	$iH .= 'var cdrIFrame = document.getElementById("'+$id+'");'."\n";
	$iH .= 'if (cdrIFrame.contentWindow && cdrIFrame.contentWindow.postMessage) {'."\n";
	$iH .= 'cdrIFrame.contentWindow.postMessage("mouseup","*");'."\n";
	$iH .= '}'."\n";
	$iH .= '}'."\n";
	$iH .= 'if (typeof window.addEventListener != "undefined") {'."\n";
	$iH .= 'window.addEventListener("mouseup", cdrMouseupFunc, false);'."\n";
	$iH .= '}'."\n";
	$iH .= 'else if (typeof window.attachEvent != "undefined") {'."\n";
	$iH .= 'window.attachEvent("onmouseup", cdrMouseupFunc);'."\n";
	$iH .= '}'."\n";
	$iH .= '}'."\n";
	$iH .= '})()'."\n";
	$iH .= '</script>'."\n";

	return $iH;
}
add_shortcode("chronoflo_calendar", "chronoflo_calendar_plugin_generate_embed_code");


function chronoflo_calendar_plugin_row_meta($links, $file) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$row_meta = array(
			'support' => '<a href="https://www.chronoflocalendar.com/wordpress/" target="_blank"><span class="dashicons dashicons-editor-help"></span> Support</a>',
			'chronoflo_website' => '<a href="https://www.chronoflocalendar.com/" target="_blank"><span class="dashicons dashicons-star-filled"></span> ChronoFlo Calendar website</a>',
		);
		$links = array_merge( $links, $row_meta );
	}
	return (array) $links;
}
add_filter( 'plugin_row_meta', 'chronoflo_calendar_plugin_row_meta', 10, 2 );

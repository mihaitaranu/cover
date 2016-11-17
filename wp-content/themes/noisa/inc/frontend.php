<?php
/**
 * Plugin Name: 	Crow
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			frontend.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	GOOGLE FONTS
/* ---------------------------------------------------------------------- */
function noisa_google_fonts() {
	global $noisa_opts;

	if ( $noisa_opts->get_option( 'use_google_fonts' ) == 'on' ) {
	    if ( $noisa_opts->get_option( 'google_fonts' ) ) {
		    foreach ( $noisa_opts->get_option( 'google_fonts' ) as $font ) {
		    	$temp_font = str_replace( ',', '%2C', $font['font_link'] );
				$noisa_opts->e_esc( $temp_font );
			}
			if ( $noisa_opts->get_option( 'google_code' ) ) {
			   echo '<style type="text/css" media="screen">' . "\n";
			   $noisa_opts->e_get_option( 'google_code' );
			   echo '</style>' . "\n";
			}
		}
	}
}

add_action( 'wp_head', 'noisa_google_fonts' );


/* ----------------------------------------------------------------------
	CUSTOMIZER
/* ---------------------------------------------------------------------- */
function noisa_customizer() {
	global $noisa_opts;

	function _noisa_hex_to_rgb($hex) {
		list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
		return "$r, $g, $b";
	}

	// Accent Color
	echo "\n" . '<style type="text/css" media="screen">' . "\n";
	$accent_color = get_theme_mod( 'accent_color', '#e82561' );
	$accent_color_rgb = _noisa_hex_to_rgb($accent_color);
	if ( '#e82561' !== $accent_color ) {
		
		echo "
		/* Customizer Styles */

		/* -------------> Accent Color */

		/* Selection */
		::-moz-selection { background: $accent_color; }
		::selection { background: $accent_color; }

		/* -----> Color */
		a, a > *,
		blockquote cite a,
		blockquote cite a:hover,
		#searchform #searchsubmit i:hover,
		.color,
		#slidebar header a:hover, #slidebar header a:hover span,
		.format-quote .quote-text cite, .format-quote .quote-text cite a
		.more-link, .more-link-excerpt,
		.grid-cats a:hover,
		.grid-share-buttons a:hover .icon,
		.thumb-event .event-day,
		.logged-in-as a:hover,
		#footer-note p a:hover,
		.widget a:hover,
		.widget-title a:hover,
		.widget table#wp-calendar #next a:hover, .widget table#wp-calendar #prev a:hover,
		.tweets-widget li a:hover:before,
		.tweets-widget li .date a,
		.widget_noisa_recent_posts .rp-caption .rp-date,
		.sp-time-elapsed,
		#scamp_player.sp-show-list .sp-buttons-container a.sp-queue-button:before,
		.circle-button:hover i.icon,
		.track-button:hover,
		.track-button:hover i.icon,
		.icon_column .text-holder a:hover,
		.icon_column:hover .icon_column_title, .icon_column:hover .icon
		{
    		color: $accent_color;
    	}
		
		/* -----> Background */
		.spinner,
		#nav ul ul a:hover, #nav ul ul .hover > a, #nav ul ul .current > a, 
		#nav ul ul .current > a:hover, #nav ul ul a.selected,
		.post-navigation a:hover,
		.meta-cats a,
		.meta-col .meta-comments a,
		.meta-tags a:hover,
		.masonry-list .event-li.selected .date,
		.masonry-list .event-li:hover .date,
		.grid-content:after,
		.section-title:after,
		.comment .reply a:hover,
		#scroll-button:hover,
		.widget button, .widget .button, .widget input[type='button'], .widget input[type='reset'], .widget input[type='submit'],
		.widget_tag_cloud .tagcloud a:hover,
		.tweets-widget li:hover:before,
		.badge.color,
		.badge.soundcloud,
		input[type='submit'], button, .btn, .widget .btn,
		.pill-btn,
		.sp-progress .sp-position,
		#scamp_player.paused .sp-position,
		.sp-progress .sp-position:after,
		.sp-volume-position,
		.sp-volume-position:after,
		.tweets li:hover:before,
		ol.tracklist.simple li .simple-track.sp-play,
		ol.tracklist.simple li .simple-track.sp-pause,
		ol.tracklist.simple li .simple-track.sp-loading,
		ol.tracklist.simple li .simple-track:hover,
		#icon-nav #shop-link .shop-items-count 
		{
    		background-color: $accent_color;
    	}
		
		/* -----> Border */
		.meta-col .meta-comments a:after,
		.intro-tabs-wrap a:hover,
		.intro-tabs-wrap.intro-tabs-before-init a:first-child,
		.intro-tabs-wrap a.active,
		.direction-l .flag:before,
		.direction-r .flag:before,
		.price-table-inner.important-price
		{
    		border-color: $accent_color;
    	}
		";
		
	}

	// Headings Color
	$headings_color = get_theme_mod( 'headings_color', '#ffffff' );
	if ( '#ffffff' !== $headings_color ) {
		
		echo "
		/* -------------> Headings Color */
		h1, h2, h3, h4, h5, h6,
		.widget .widget-title,
		#reply-title,
		.article-title, .article-title a
		
		 {
    		color: $headings_color;
    	} 
    	";
	}

	// Body BG Color
	$body_bg_color = get_theme_mod( 'body_bg_color', '#0b0b0c' );
	if ( '#0b0b0c' !== $body_bg_color ) {
		
		echo "
		/* -------------> Body BG Color */
		body,
		.masonry-item,
		.masonry-anim .masonry-item:after {
    		background: $body_bg_color;
    	} 
    	";
	}

	// Text Color
	$text_color = get_theme_mod( 'text_color', '#eeeeee' );
	if ( '#eeeeee' !== $text_color ) {
		
		echo "
		/* -------------> Text Color */
		body {
    		color: $text_color;
    	} 
    	";
    }


	echo '</style>' . "\n";
	
}

add_action( 'wp_head', 'noisa_customizer' );


/* ----------------------------------------------------------------------
	QUICK CSS
/* ---------------------------------------------------------------------- */
function noisa_quick_css() {
	global $noisa_opts;
	
    if ( $noisa_opts->get_option( 'custom_css' ) &&  $noisa_opts->get_option( 'custom_css' ) != ''  ) {
	  
		echo '<style type="text/css" media="screen" id="custom_css_">' . "\n";
		$noisa_opts->e_get_option( 'custom_css' );
		echo '</style>' . "\n";
	}
	
}

add_action( 'wp_head', 'noisa_quick_css' );


/* ----------------------------------------------------------------------
	QUICK JS
/* ---------------------------------------------------------------------- */
function noisa_quick_js() {
	global $noisa_opts;
	
    if ( $noisa_opts->get_option( 'custom_js' ) &&  $noisa_opts->get_option( 'custom_js' ) != ''  ) {
	  
		echo '<script type="text/javascript" id="custom_javascripts_">' . "\n";
		$noisa_opts->e_get_option( 'custom_js' );
		echo '</script>' . "\n";
	}
	
}
add_action( 'wp_head', 'noisa_quick_js' );
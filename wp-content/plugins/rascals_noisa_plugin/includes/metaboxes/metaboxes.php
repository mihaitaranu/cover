<?php
/**
 * Plugin Name: 	NOISA Plugin
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			metaboxes.php
 * =========================================================================================================================================
 *
 * @package noisa-plugin
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	INIT CLASS
/* ---------------------------------------------------------------------- */
$panel_options = get_option( 'noisa_panel_opts' );

if ( ! class_exists( 'MuttleyBox' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'classes/MuttleyBox.php' );
}

global $wpdb;


/* ----------------------------------------------------------------------
	HELPERS
/* ---------------------------------------------------------------------- */

/* Get post/page data */
if ( isset( $_GET['post'] ) ) { 
	$template_name = get_post_meta( $_GET['post'], '_wp_page_template', true );
	$post_type = get_post_type( $_GET['post'] );
	$post_format = get_post_format( $_GET['post'] );
} else { 
	$template_name = '';
	$post_type = '';
	$post_format = '';
}

/* Post per page */
$pp = get_option( 'posts_per_page' );

// Header Slider
$intro_slider = array( array( 'name' => __( 'Select slider...', 'noisa_plugin' ), 'value' => 'none' ) );
$slider_post_type = 'noisa_slider';
$slider_query = $wpdb->prepare(
	"
    SELECT
		{$wpdb->posts}.id,
		{$wpdb->posts}.post_title
  	FROM 
		{$wpdb->posts}
  	WHERE
		{$wpdb->posts}.post_type = %s
	AND 
		{$wpdb->posts}.post_status = 'publish'
	",
	$slider_post_type
);

$sql_slider = $wpdb->get_results( $slider_query );
  
if ( $sql_slider ) {
	$count = 1;
	foreach( $sql_slider as $slider_post ) {
		$intro_slider[$count]['name'] = $slider_post->post_title;
		$intro_slider[$count]['value'] = $slider_post->id;
		$count++;
	}
}


// Revslider Slider
$intro_revslider = array( array( 'name' => __( 'Select slider...', 'noisa_plugin' ), 'value' => 'none' ) );
$revslider_post_type = $wpdb->prefix . 'revslider_sliders';
$slides = $wpdb->get_results("SELECT title as name ,id as value FROM $revslider_post_type", ARRAY_A);
$sql_revslider = $wpdb->get_results( 
   	$wpdb->prepare( 
       "
       SELECT
       		title as %s,
       		id as value
       FROM
       		{$revslider_post_type}
       ", "name"
    ), ARRAY_A );
if ( $sql_revslider ) {
	array_splice( $sql_revslider, 0, 0, $intro_revslider);
}

/* Get Audio Tracks  */
$tracks = array( array( 'name' => __( 'Select tracks...', 'noisa_plugin' ), 'value' => 'none' ) );
$tracks_post_type = 'noisa_tracks';
$tracks_query = $wpdb->prepare(
	"
    SELECT
		{$wpdb->posts}.id,
		{$wpdb->posts}.post_title
  	FROM 
		{$wpdb->posts}
  	WHERE
		{$wpdb->posts}.post_type = %s
	AND 
		{$wpdb->posts}.post_status = 'publish'
	",
	$tracks_post_type
);

$sql_tracks = $wpdb->get_results( $tracks_query );
  
if ( $sql_tracks ) {
	$count = 1;
	foreach( $sql_tracks as $track_post ) {
		$tracks[$count]['name'] = $track_post->post_title;
		$tracks[$count]['value'] = $track_post->id;
		$count++;
	}
}


/* ----------------------------------------------------------------------
	INTRO HEADER
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Intro Header Options', 'noisa_plugin' ), 
	'id' =>'r_intro_options', 
	'page' => array(
		'post',
		'page',
		'noisa_artists',
		'noisa_releases',
		'noisa_gallery',
		'noisa_events'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post', 
		'default',
		'page-templates/artists.php',
		'page-templates/releases.php',
		'page-templates/blog.php',
		'page-templates/blog-grid.php',
		'page-templates/gallery.php',
		'page-templates/fullscreen.php',
		'page-templates/events-grid.php',
		'page-templates/events-list.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);	

// Header type
$intro_type = array(
	array( 'name' => __( 'Page Title', 'noisa_plugin' ), 'value' => 'intro_page_title' ),
	array( 'name' => __( 'Content', 'noisa_plugin' ), 'value' => 'intro_content' ),
	array( 'name' => __( 'Full Screen Image', 'noisa_plugin' ), 'value' => 'intro_full_image' ),
	array( 'name' => __( 'Full Screen Image with Content', 'noisa_plugin' ), 'value' => 'intro_full_image_content' ),
	array( 'name' => __( 'Image', 'noisa_plugin' ), 'value' => 'intro_image' ),
	array( 'name' => __( 'Image Zoom Out', 'noisa_plugin' ), 'value' => 'intro_image_zoom_out' ),
	array( 'name' => __( 'Full Screen Slider', 'noisa_plugin' ), 'value' => 'intro_full_slider' ),
	array( 'name' => __( 'Slider', 'noisa_plugin' ), 'value' => 'intro_slider' ),
	array( 'name' => __( 'YouTube Background', 'noisa_plugin' ), 'value' => 'intro_youtube' ),
	array( 'name' => __( 'Full Screen YouTube Background', 'noisa_plugin' ), 'value' => 'intro_youtube_fullscreen' ),
	array( 'name' => __( 'Google Map', 'noisa_plugin' ), 'value' => 'gmap' ),
	array( 'name' => __( 'Disabled', 'noisa_plugin' ), 'value' => 'disabled' )
);
/* Special options only for page templates and post types */
if ( $template_name == 'page-templates/fullscreen.php' ) {
	$intro_type = array(
		array( 'name' => __( 'Full Screen Image', 'noisa_plugin' ), 'value' => 'intro_full_image' ),
		array( 'name' => __( 'Full Screen Image with Content', 'noisa_plugin' ), 'value' => 'intro_full_image_content' ),
		array( 'name' => __( 'Full Screen Slider', 'noisa_plugin' ), 'value' => 'intro_full_slider' ),
		array( 'name' => __( 'Full Screen YouTube Background', 'noisa_plugin' ), 'value' => 'intro_youtube_fullscreen' )
	);
}

if ( $template_name == 'page-templates/blog-grid.php' || $template_name == 'page-templates/blog.php') {

	array_unshift( $intro_type , array( 'name' => __( 'Featured Post', 'noisa_plugin' ), 'value' => 'featured_post' ) );

}

if ( $post_type == 'noisa_artists' ) {
	array_unshift( $intro_type , array( 'name' => __( 'Artist Profile', 'noisa_plugin' ), 'value' => 'artist_profile' ) );
}

if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	array_unshift( $intro_type , array( 'name' => __( 'Revolution Slider', 'noisa_plugin' ), 'value' => 'revslider' ) );
}



/* Meta options */
$meta_options = array(
	array(
		'name' => __( 'Intro Header Type', 'noisa_plugin' ),
		'id' => '_intro_type',
		'type' => 'select',
		'std' => 'intro_page_title',
	  	'options' => $intro_type,
		'group' => 'intro_type',
		'desc' => __( 'Select intro.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Background Image', 'noisa_plugin' ),
		'id' => array(
			array( 'id' => '_intro_image', 'std' => '')
		),
		'type' => 'add_image',
		'source' => 'media_libary', // all, media_libary, external_link
		'desc' => __( 'Header image.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_full_image', 'intro_image', 'intro_full_image_content', 'intro_image_zoom_out', 'intro_page_title', 'intro_youtube', 'intro_youtube_fullscreen', 'artist_profile' )
	),
	array(
		'name' => __( 'Height', 'noisa_plugin' ),
		'id' => '_min_height',
		'type' => 'range',
		'min' => 100,
		'max' => 1200,
		'unit' => __( 'px', 'noisa_plugin' ),
		'std' => '500',
		'desc' => __( 'Header section min. height.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_image', 'intro_youtube', 'intro_image_zoom_out' )
	),
	array(
		'name' => __( 'Overlay', 'noisa_plugin' ),
		'id' => '_overlay',
		'type' => 'select',
		'std' => 'disabled',
		'options' => array(
			array( 'name' => __( 'Disabled', 'noisa_plugin' ), 'value' => 'disabled' ),
			array( 'name' => __( 'Gradient', 'noisa_plugin' ), 'value' => 'gradient' ),
			array( 'name' => __( 'Grid', 'noisa_plugin' ), 'value' => 'grid' ),
			array( 'name' => __( 'Animated Noise', 'noisa_plugin' ), 'value' => 'noise' ),
			array( 'name' => __( 'Dots', 'noisa_plugin' ), 'value' => 'dots' )
		),
		'desc' => __( 'Select overlay type.', 'noisa_plugin' ),
		'group' => 'intro_overlay',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_image', 'intro_full_image', 'intro_full_slider', 'intro_full_image_content', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out', 'intro_page_title', 'artist_profile', 'featured_post' )
	),
	array(
		'name' => __( 'Graident', 'noisa_plugin' ),
		'id' => array(
			array( 'id' => '_from', 'std' => '#171719'),
			array( 'id' => '_to', 'std' => 'rgba(23,23,25,0.2)'),
			array( 'id' => '_direction', 'std' => '0'),
		),
		'type' => 'gradient',
		'desc' => '',
		'main_group' => 'intro_overlay',
		'group_name' => array( 'gradient' )
	),
	array(
		'name' => __( 'Image Effect', 'noisa_plugin' ),
		'id' => '_image_effect',
		'type' => 'select',
		'std' => 'disabled',
		'options' => array(
			array( 'name' => __( 'Disabled', 'noisa_plugin' ), 'value' => 'disabled' ),
			array( 'name' => __( 'Zoom', 'noisa_plugin' ), 'value' => 'zoom' ),
			array( 'name' => __( 'Parallax', 'noisa_plugin' ), 'value' => 'parallax' )
		),
		'desc' => __( 'Select Image effect.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_full_image_content', 'intro_page_title', 'artist_profile' )
	),
	array(
		'name' => __( 'Animated', 'noisa_plugin' ),
		'id' => '_animated',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => __( 'Enable animated effects.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_full_slider', 'intro_image', 'intro_full_image', 'intro_full_image_content', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out' )
	),
	array(
		'name' => __( 'Zoom Effect', 'noisa_plugin' ),
		'id' => '_zoom_effect',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => __( 'If this opion is on, you should see zoom effect on intro section.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_full_slider' )
	),
	array(
		'name' => __( 'Scroll Icon', 'noisa_plugin' ),
		'id' => '_scroll_icon',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => __( 'If this opion is on, you should see scroll icon on intro section.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array(  'intro_full_image', 'intro_youtube_fullscreen' )
	),
	array(
		'name' => __( 'Header Title', 'noisa_plugin' ),
		'id' => '_intro_title',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => __( 'Add intro title.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out' )
	),
	array(
		'name' => __( 'Header Subtitle', 'noisa_plugin' ),
		'id' => '_intro_subtitle',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => __( 'Add intro subtitle.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out' )
	),
	array(
		'name' => __( 'Captions Align', 'noisa_plugin' ),
		'id' => '_captions_align',
		'type' => 'select',
		'std' => 'left',
		'options' => array(
			array( 'name' => __( 'Left', 'noisa_plugin' ), 'value' => 'left' ),
			array( 'name' => __( 'Center', 'noisa_plugin' ), 'value' => 'center' )
		),
		'desc' => __( 'Caption Align.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array(  'intro_full_image', 'intro_youtube_fullscreen', 'intro_full_slider' )
	),

	array(
		'name' => __( 'Extra Classes', 'noisa_plugin' ),
		'id' => '_caption_classes',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => __( 'Style intro captions - add a class name and refer to it in custom CSS.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out' )
	),

	// Slider
	array(
		'name' => __( 'Slider', 'noisa_plugin' ),
		'id' => '_slider_id',
		'type' => 'select_array',
		'options' => $intro_slider,
		'std' => '',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_full_slider', 'intro_slider' ),
		'desc' => __( 'Select your slider; images min width must be 1920. If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left.', 'noisa_plugin' )
	),

	// Rev Slider
	array(
		'name' => __( 'Revolution Slider', 'noisa_plugin' ),
		'id' => '_revslider_id',
		'type' => 'select_array',
		'options' => $sql_revslider,
		'std' => '',
		'main_group' => 'intro_type',
		'group_name' => array(  'revslider' ),
		'desc' => __( 'Select your Revo Slider.', 'noisa_plugin' )
	),

	// Background
	array(
		'name' => __( 'Background', 'noisa_plugin' ),
		'id' => '_intro_bg',
		'type' => 'bg_generator',
		'std' => '',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_content' ),
		'desc' => __( 'Generate intro background.', 'noisa_plugin' )
	),

	// Content
	array(
		'name' => __( 'Header Content', 'noisa_plugin' ),
		'id' => '_intro_content',
		'type' => 'textarea',
		'tinymce' => 'true',
		'height' => '200',
		'std' => '',
		'height' => '100',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_content', 'intro_full_image_content' ),
		'desc' => __( 'Add text to the intro section below the title.', 'noisa_plugin' )
	),

	// Map
	array(
		'name' => __( 'Address', 'noisa_plugin' ),
		'id' => '_map_address',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
		'height' => '40',
		'desc' => __( 'Add address to Google Map.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'gmap' )
	),

	// YouTube
	array(
		'name' => __( 'YouTube ID', 'noisa_plugin' ),
		'id' => '_yt_id',
		'type' => 'video',
		'video_type' => 'youtube',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => '',
		'desc' => __( 'Add YouTube movie ID e.g. BsekcY04xvQ.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_youtube', 'intro_youtube_fullscreen', 'artist_profile', 'intro_page_title' )
	),

	// TABS
	array(
		'name' => __( 'Intro Tabs', 'noisa_plugin' ),
		'id' => '_intro_tabs',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Add intro tabs: ROW_ID|Title. ROW_ID must correspond with Visual Composer ROW ID (must be the same). ex:', 'noisa_plugin' ) . '<br><pre><code>bio|Biography
releases|My Releases
gallery|Gallery
podcasts|Podcasts</code></pre>',
		'main_group' => 'intro_type',
		'group_name' => array( 'artist_profile' )
	),

	// Artist profile
	array(
		'name' => __( 'Artist Image', 'noisa_plugin' ),
		'id' => array(
			array( 'id' => '_artist_image', 'std' => '')
		),
		'type' => 'add_image',
		'source' => 'media_libary', // all, media_libary, external_link
		'desc' => __( 'Artist profile image.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'artist_profile' )
	),
	array(
		'name' => __( 'Social Buttons', 'noisa_plugin' ),
		'id' => '_social_links',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Add social button: icon_name|http://yourlink. ex:', 'noisa_plugin' ) . '<br><pre><code>twitter|http://twitter.com
facebook|http://facebook.com
googleplus|http://google.com
soundcloud|http://soundcloud.com</code></pre>',
		'main_group' => 'intro_type',
		'group_name' => array( 'artist_profile' )
	),
	array(
		'name' => __( 'Play Music Button', 'noisa_plugin' ),
		'id' => '_intro_tracks_id',
		'type' => 'select_array',
		'options' => $tracks,
		'std' => '',
		'desc' => __( 'Select your tracks, then "Play" button will be visible. If there are no tracks available, then you can add a audio tracks using TRACKS custom posts menu on the left.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'artist_profile' )
	),
	array(
		'name' => __( 'Play Music Button Title', 'noisa_plugin' ),
		'id' => '_intro_play_button_title',
		'type' => 'text',
		'std' => 'Play my tracks',
		'desc' => __( 'Button title.', 'noisa_plugin' ),
		'main_group' => 'intro_type',
		'group_name' => array( 'artist_profile' )
	),

	// Buttons
	array(
		'name' => __( 'Buttons', 'noisa_plugin' ),
		'id' => '_intro_buttons',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Add custom button: title|http://yourlink|target. ex:', 'noisa_plugin' ) . '<br><pre><code>New Window|http://google.com|_blank
About US|http://link.com|_self</code></pre>',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube', 'intro_youtube_fullscreen', 'intro_image_zoom_out', 'artist_profile' )
	)

);

/* Add class instance */
$intro_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	LAYOUT
/* ---------------------------------------------------------------------- */

/* Sidebars Array */
if ( isset( $panel_options[ 'custom_sidebars' ] ) ) {
	$s_list = $panel_options[ 'custom_sidebars' ];
} else {
	$s_list = null;
}

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Layout Options', 'noisa_plugin' ), 
	'id' =>'r_layout_options', 
	'page' => array(
		'post',
		'page',
		'noisa_artists',
		'noisa_releases',
		'noisa_events'
	), 
	'context' => 'side', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'default',
		'page-templates/blog.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array(
		'name' => __( 'Layout', 'noisa_plugin' ),
		'id' => '_layout',
		'type' => 'select_image',
		'std' => 'wide',
		'images' => array(
			array( 'id' => 'thin', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/thin.png'),
			array( 'id' => 'main-right', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/sidebar_left.png'),
			array( 'id' => 'main-left', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/sidebar_right.png'),
			array( 'id' => 'wide', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/wide.png'),
			array( 'id' => 'vc', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/vc.png')
		),
		'group' => 'layout',
		'desc' => __( 'Choose the page layout.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Custom Sidebar', 'noisa_plugin' ),
		'id' => '_custom_sidebar',
		'type' => 'select_array',
		'array' => $s_list,
		'key' => 'name',
		'options' => array(
			array( 'value' => '_default', 'name' => __( 'Primary Sidebar', 'noisa_plugin' ) )
		),
		'desc' => __( 'Select custom or primary sidebar.', 'noisa_plugin' ),
		'main_group' => 'layout',
		'group_name' => array( 'main-left', 'main-right' ),
	)
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	BLOG GRID
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Blog Options', 'noisa_plugin' ), 
	'id' =>'r_blog_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/blog-grid.php',
		'page-templates/blog.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);	


/* Meta options */
$meta_options = array(
	// Limit
	array(
		'name' => __( 'Blog Posts Per Page', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => __( 'items', 'noisa_plugin' ),
		'std' => '8',
		'desc' => __( 'Number of blog posts visible on page.', 'noisa_plugin' )
	),

	// Grid Layout
	array(
		'name' => __( 'Blog Grid Layout', 'noisa_plugin' ),
		'id' => '_blog_layout',
		'type' => 'select',
		'std' => 'boxed',
	  	'options' => array(
			array( 'name' => __( 'Boxed', 'noisa_plugin' ), 'value' => 'boxed' ),
			array( 'name' => __( 'Full width', 'noisa_plugin' ), 'value' => 'full-width' )
		),
		'desc' => __( 'Select blog grid layout.', 'noisa_plugin' )
	),
);

/* Add class instance */
$blog_grid_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	BLOG - POST FORMATS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Post Format Options', 'noisa_plugin' ), 
	'id' =>'r_post_format_options', 
	'page' => array(
		'post'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'default'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array(
		'name' => __( 'Post Format', 'noisa_plugin' ),
		'id' => '_post_format',
		'std' => 'content',
		'type' => 'select',
		'options' => array(
			array( 'name' => __( 'Standard', 'noisa_plugin' ), 'value' => 'pf_standard' ),
			array( 'name' => __( 'Image', 'noisa_plugin' ), 'value' => 'pf_image' ),
			array( 'name' => __( 'Gallery', 'noisa_plugin' ), 'value' => 'pf_gallery' ),
			array( 'name' => __( 'Video', 'noisa_plugin' ), 'value' => 'pf_video' ),
			array( 'name' => __( 'Quote', 'noisa_plugin' ), 'value' => 'pf_quote' ),
			array( 'name' => __( 'Link', 'noisa_plugin' ), 'value' => 'pf_link' ),
			array( 'name' => __( 'Audio - Soundcloud', 'noisa_plugin' ), 'value' => 'pf_audio_sc' ),
			array( 'name' => __( 'Audio - Album', 'noisa_plugin' ), 'value' => 'pf_audio_album' ),
			array( 'name' => __( 'Link', 'noisa_plugin' ), 'value' => 'pf_link' )
		),
		'group' => 'post_format',
		'desc' => __( 'Select post format type.', 'noisa_plugin' )
	),

	// Gallery 
	array(
		'name' => __( 'Gallery Slider', 'noisa_plugin' ),
		'id' => '_gallery_slider_id',
		'type' => 'select_array',
		'options' => $intro_slider,
		'std' => '',
		'desc' => __( 'Select slider; If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left. Select your slider. If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left. NOTE: Only working with GALLERY post format.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_gallery' )
	),

	// YouTube
	array(
		'name' => __( 'Video YouTube', 'noisa_plugin' ),
		'id' => '_video_yt_id',
		'type' => 'video',
		'video_type' => 'youtube',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => '',
		'desc' => __( 'Add YouTube movie ID. NOTE: Only working with VIDEO post format.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_video' )
	),

	// Vimeo
	array(
		'name' => __( 'Video Vimeo', 'noisa_plugin' ),
		'id' => '_video_vimeo_id',
		'type' => 'video',
		'video_type' => 'vimeo',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => '',
		'desc' => __( 'Add Vimeo movie ID. NOTE: Only working with VIDEO post format.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_video' )
		
	),

	// Audio Soundcloud
	array(
		'name' => __( 'Soundcloud Audio', 'noisa_plugin' ),
		'id' => '_sc_iframe',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Paste iframe code from soundcloud track. NOTE: Only working with AUDIO post format.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_sc' )
	),

	// Audio Single Album
	array(
		'name' => __( 'Audio Album', 'noisa_plugin' ),
		'id' => '_pf_tracks_id',
		'type' => 'select_array',
		'options' => $tracks,
		'std' => '',
		'desc' => __( 'Select your tracks; If there are no tracks available, then you can add a audio tracks using TRACKS custom posts menu on the left.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_album' )
	),
	array(
		'name' => __( 'Title', 'noisa_plugin' ),
		'id' => '_album_title',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Album title.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_album' )
	),
	array(
		'name' => __( 'Artists', 'noisa_plugin' ),
		'id' => '_album_artists',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Album Artists.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_album' )
	),
	array(
		'name' => __( 'Album Image', 'noisa_plugin' ),
		'id' => array(
			array( 'id' => '_album_image', 'std' => '')
		),
		'type' => 'add_image',
		'source' => 'media_libary', // all, media_libary, external_link
		'desc' => __( 'Album cover.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_album' )
	),

	// Quote
	array(
		'name' => __( 'Quote Text', 'noisa_plugin' ),
		'id' => '_quote_text',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Quote text.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_quote' )
	),
	array(
		'name' => __( 'Quote Author', 'noisa_plugin' ),
		'id' => '_quote_author',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Quote text.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_quote' )
	),
	array(
		'name' => __( 'Quote Link', 'noisa_plugin' ),
		'id' => '_quote_link',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Quote link.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_quote' )
	),

	// Link
	array(
		'name' => __( 'Link Title', 'noisa_plugin' ),
		'id' => '_link_title',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Link title.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_link' )
	),
	array(
		'name' => __( 'Link URL', 'noisa_plugin' ),
		'id' => '_link_url',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'Link URL.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_link' )
	),
	array(
		'name' => __( 'Open in New Window?', 'noisa_plugin' ),
		'id' => '_link_new_window',
		'type' => 'switch_button',
		'std' => '',
		'desc' => __( 'Open link in new window.', 'noisa_plugin' ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_link' )
	)
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	ARTISTS - TEMPLATE OPTIONS 
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Artists Options', 'noisa_plugin' ), 
	'id' =>'r_artists_options', 
	'page' => array(
		'noisa_artists',
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/artists.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	// Limit
	array(
		'name' => __( 'Artists Per Page', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => __( 'items', 'noisa_plugin' ),
		'std' => '8',
		'desc' => __( 'Number of artists visible on page.', 'noisa_plugin' )
	),

	// Gap
	array(
		'name' => __( 'Thumbnails Gap', 'noisa_plugin' ),
		'id' => '_gap',
		'type' => 'select',
		'std' => 'no-gap',
		'options' => array(
			array( 'name' => __( 'Small Gap', 'noisa_plugin' ), 'value' => 'no-gap' ),
			array( 'name' => __( 'Medium gap', 'noisa_plugin' ), 'value' => 'medium-gap' )
		),
		'desc' => __( 'Display gap between thumbnails.', 'noisa_plugin' )
	),

	// Grid Layout
	array(
		'name' => __( 'Grid Layout', 'noisa_plugin' ),
		'id' => '_artists_layout',
		'type' => 'select',
		'std' => 'boxed',
	  	'options' => array(
			array( 'name' => __( 'Boxed', 'noisa_plugin' ), 'value' => 'boxed' ),
			array( 'name' => __( 'Full width', 'noisa_plugin' ), 'value' => 'full-width' )
		),
		'desc' => __( 'Select grid layout.', 'noisa_plugin' )
	),
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	ARTISTS - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Thumbnail Options', 'noisa_plugin' ), 
	'id' =>'r_thumbnail_artists_thumb__options', 
	'page' => array(
		'noisa_artists'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	
	// TIP
	array(
		'name' => __( 'Tooltip', 'noisa_plugin' ),
		'id' => '_tooltip',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Add tooltip text ex:', 'noisa_plugin' ) . '<br><pre><code>&lt;span>Tooltip Title&lt;/span>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor fermentum ullamcorper. Aliquam erat volutpat.</code></pre>',
	)

);

/* Add class instance */
$artists_thumbnails_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	RELEASES GRID - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Releases Options', 'noisa_plugin' ), 
	'id' =>'r_releases_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/releases.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(

	// Grid Layout
	array(
		'name' => __( 'Thumbnails Layout', 'noisa_plugin' ),
		'id' => '_releases_layout',
		'type' => 'select',
		'std' => 'boxed',
	  	'options' => array(
			array( 'name' => __( 'Boxed', 'noisa_plugin' ), 'value' => 'boxed' ),
			array( 'name' => __( 'Full width', 'noisa_plugin' ), 'value' => 'full-width' )
		),
		'desc' => __( 'Select thumbnails grid layout.', 'noisa_plugin' )
	),

	// Gap
	array(
		'name' => __( 'Thumbnails Gap', 'noisa_plugin' ),
		'id' => '_gap',
		'type' => 'select',
		'std' => 'no-gap',
		'options' => array(
			array( 'name' => __( 'Small Gap', 'noisa_plugin' ), 'value' => 'no-gap' ),
			array( 'name' => __( 'Medium gap', 'noisa_plugin' ), 'value' => 'medium-gap' )
		),
		'desc' => __( 'Display gap between thumbnails.', 'noisa_plugin' )
	),

	// Limit
	array(
		'name' => __( 'Releases Limit', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => __( 'items', 'noisa_plugin' ),
		'std' => '40',
		'desc' => __( 'Number of releases items limit.', 'noisa_plugin' )
	)
);

/* Add class instance */
$releases_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	RELEASES - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Thumbnail Options', 'noisa_plugin' ), 
	'id' =>'r_thumbnail_grid_options', 
	'page' => array(
		'noisa_releases'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	
	// TIP
	array(
		'name' => __( 'Tooltip', 'noisa_plugin' ),
		'id' => '_tooltip',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => __( 'Add tooltip text ex:', 'noisa_plugin' ) . '<br><pre><code>&lt;span>Tooltip Title&lt;/span>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor fermentum ullamcorper. Aliquam erat volutpat.</code></pre>',
	)

);

/* Add class instance */
$releases_thumbnails_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
/* GALLERY - TEMPLATE OPTIONS
------------------------------------------------------------------------*/

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Albums Options', 'noisa_plugin' ), 
	'id' =>'r_albums_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/gallery.php',
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);


/* Meta options */
$meta_options = array(

	// Grid Layout
	array(
		'name' => __( 'Gallery Grid Layout', 'noisa_plugin' ),
		'id' => '_gallery_layout',
		'type' => 'select',
		'std' => 'boxed',
	  	'options' => array(
			array( 'name' => __( 'Boxed', 'noisa_plugin' ), 'value' => 'boxed' ),
			array( 'name' => __( 'Full width', 'noisa_plugin' ), 'value' => 'full-width' )
		),
		'desc' => __( 'Select gallery grid layout.', 'noisa_plugin' )
	),

	// Gap
	array(
		'name' => __( 'Thumbnails Gap', 'noisa_plugin' ),
		'id' => '_gap',
		'type' => 'select',
		'std' => 'no-gap',
		'options' => array(
			array( 'name' => __( 'Small Gap', 'noisa_plugin' ), 'value' => 'no-gap' ),
			array( 'name' => __( 'Medium gap', 'noisa_plugin' ), 'value' => 'medium-gap' )
		),
		'desc' => __( 'Display gap between thumbnails.', 'noisa_plugin' )
	),

	// Limit
	array(
		'name' => __( 'Albums Per Page', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => __( 'items', 'noisa_plugin' ),
		'std' => '8',
		'desc' => __( 'Number of albums visible on page.', 'noisa_plugin' )
	)
);

/* Add class instance */
$album_template_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	GALLERY - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Album Images', 'noisa_plugin' ), 
	'id' =>'r_gallery_options', 
	'page' => array(
		'noisa_gallery'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array( 
		// 'name' => __( 'Images', 'noisa_plugin' ),
		'id' => '_gallery_ids',
		'type' => 'media_manager',
		'media_type' => 'images', // images / audio / slider
		'msg_text' => __( 'Currently you don\'t have any photos, you can add them by clicking on the button below.', 'noisa_plugin' ),
		'btn_text' => __( 'Add Photos', 'noisa_plugin' ),
		'desc' => __( 'Add photos.', 'noisa_plugin' ) . '<br>' . __( 'NOTE: Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', 'noisa_plugin' )
	)
);

/* Add class instance */
$gallery_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );

/* ALBUM OPTIONS */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Album Options', 'noisa_plugin' ), 
	'id' =>'r_album_options', 
	'page' => array(
		'noisa_gallery'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array(
		'name' => __( 'Images Limit', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',//__( 'events', 'noisa_plugin' ),
		'std' => '20',
		'desc' => __( 'Number of images limit on page.', 'noisa_plugin' )
	)	
);

/* Add class instance */
$gallery_album_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	TRACKS - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Audio Tracks', 'noisa_plugin'), 
	'id' =>'r_audio_options', 
	'page' => array(
		'noisa_tracks'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array( 
		'id' => '_audio_tracks',
		'type' => 'media_manager',
		'media_type' => 'audio', // images / audio / slider
		'msg_text' => __( 'Currently you don\'t have any audio tracks, you can add them by clicking on the button below.', 'noisa_plugin'),
		'btn_text' => __( 'Add Tracks', 'noisa_plugin'),
		'desc' => __( 'Add audio tracks.', 'noisa_plugin' ) . '<br>' . __( 'NOTE: Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', 'noisa_plugin' )
	)
);

/* Add class instance */
$tracks_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	SLIDER
/* ---------------------------------------------------------------------- */

/* Slider Images */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Slider Images', 'noisa_plugin' ), 
	'id' =>'r_slider_images', 
	'page' => array(
		'noisa_slider'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	array( 
		// 'name' => __( 'Images', 'noisa_plugin' ),
		'id' => '_custom_slider',
		'type' => 'media_manager',
		'media_type' => 'slider', // images / audio / slider
		'msg_text' => __( 'Currently you don\'t have any images, you can add them by clicking on the button below.', 'noisa_plugin' ),
		'btn_text' => __( 'Add Images', 'noisa_plugin' ),
		'desc' => __( 'Add images to slider.', 'noisa_plugin' ) . '<br>' . __( 'NOTE: Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', 'noisa_plugin' )
	)
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* Slider Options */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Slider Options', 'noisa_plugin' ), 
	'id' =>'r_slider_options', 
	'page' => array(
		'noisa_slider'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'
);

/* Meta options */
$meta_options = array(
	array(
		'name' => __( 'Navigation', 'noisa_plugin' ),
		'id' => '_slider_nav',
		'type' => 'switch_button',
		'std' => 'on',
		'desc' => __( 'If this opion is on, then you should see the slider navigation.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Pagination', 'noisa_plugin' ),
		'std' => 'on',
		'type' => 'switch_button',
		'id' => '_slider_pagination',
		'desc' => __( 'If this opion is on, then you should see the slider pagination.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Animation Speed', 'noisa_plugin' ),
		'id' => '_slider_speed',
		'type' => 'range',
		'min' => 200,
		'max' => 2000,
		'unit' => 'ms',
		'std' => '500',
		'desc' => __( 'Slider animation speed.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Pause Time', 'noisa_plugin' ),
		'id' => '_slider_pause_time',
		'type' => 'range',
		'min' => 0,
		'max' => 20000,
		'unit' => 'ms',
		'std' => '3000',
		'desc' => __( 'Determines how long each slide will be shown.  NOTE: Value "0" disable slider timer. Timer is disabled if slider has video background.', 'noisa_plugin' )
	),
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Events Options', 'noisa_plugin' ), 
	'id' =>'r_evens_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/events-grid.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
					  
	array(
		'name' => __( 'Events Type', 'noisa_plugin' ),
		'id' => '_event_type',
		'type' => 'select',
		'std' => 'future-events',
		'options' => array(
			array('name' => __( 'Future events', 'noisa_plugin' ), 'value' => 'future-events'),
			array('name' => __( 'Past events', 'noisa_plugin' ), 'value' => 'past-events'),
			array('name' => __( 'All events', 'noisa_plugin' ), 'value' => 'all-events')
		),
		'group' => 'events_type',
		'desc' => __( 'Choose the events type.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Events Limit', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',//__( 'events', 'noisa_plugin' ),
		'std' => '6',
		'desc' => __( 'Number of events limit.', 'noisa_plugin' )
	),

	// Gap
	array(
		'name' => __( 'Thumbnails Gap', 'noisa_plugin' ),
		'id' => '_gap',
		'type' => 'select',
		'std' => 'no-gap',
		'options' => array(
			array( 'name' => __( 'Small Gap', 'noisa_plugin' ), 'value' => 'no-gap' ),
			array( 'name' => __( 'Medium gap', 'noisa_plugin' ), 'value' => 'medium-gap' )
		),
		'desc' => __( 'Display gap between thumbnails.', 'noisa_plugin' )
	),

	// Grid Layout
	array(
		'name' => __( 'Events Grid Layout', 'noisa_plugin' ),
		'id' => '_events_layout',
		'type' => 'select',
		'std' => 'boxed',
	  	'options' => array(
			array( 'name' => __( 'Boxed', 'noisa_plugin' ), 'value' => 'boxed' ),
			array( 'name' => __( 'Full width', 'noisa_plugin' ), 'value' => 'full-width' )
		),
		'desc' => __( 'Select gallery grid layout.', 'noisa_plugin' )
	),

	// Thumbnail
	array(
		'name' => __( 'Thumbnail Style', 'noisa_plugin' ),
		'id' => '_event_thumb_style',
		'type' => 'select',
		'std' => 'default-style',
	  	'options' => array(
			array( 'name' => __( 'Default', 'noisa_plugin' ), 'value' => 'default-style' ),
			array( 'name' => __( 'Inverted', 'noisa_plugin' ), 'value' => 'inverted' )
		),
		'desc' => __( 'Select thumb style.', 'noisa_plugin' )
	),
);

/* Add class instance */
$event_grid_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS LIST - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Events Options', 'noisa_plugin' ), 
	'id' =>'r_evens_list_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/events-list.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
	
	// Type
	array(
		'name' => __( 'Events Type', 'noisa_plugin' ),
		'id' => '_event_type',
		'type' => 'select',
		'std' => 'future-events',
		'options' => array(
			array('name' => __( 'Future events', 'noisa_plugin' ), 'value' => 'future-events'),
			array('name' => __( 'Past events', 'noisa_plugin' ), 'value' => 'past-events'),
			array('name' => __( 'All events', 'noisa_plugin' ), 'value' => 'all-events')
		),
		'group' => 'events_type',
		'desc' => __( 'Choose the events type.', 'noisa_plugin' )
	),

	// Limit
	array(
		'name' => __( 'Events Limit', 'noisa_plugin' ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',
		'std' => '10',
		'desc' => __( 'Number of events limit.', 'noisa_plugin' )
	)
);

/* Add class instance */
$event_list_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Event Date', 'noisa_plugin' ), 
	'id' =>'r_event_date_options', 
	'page' => array(
		'noisa_events'
	), 
	'context' => 'side', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);

/* Meta options */
$meta_options = array(
					  
	array(
		'name' => __( 'Event Date', 'noisa_plugin' ),
		'id' => array(
			array('id' => '_event_date_start', 'std' => date('Y-m-d')),
			array('id' => '_event_date_end', 'std' => date('Y-m-d'))
		),
		'type' => 'date_range',
		'desc' => __( 'Enter the event date; eg 2010-09-11', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Event Time', 'noisa_plugin' ),
		'id' => array(
			array('id' => '_event_time_start', 'std' => '21:00'),
			array('id' => '_event_time_end', 'std' => '00:00')
		),
		'type' => 'time_range',
		'desc' => __( 'Enter the event time; eg 21:00 or 09:00 pm', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Repeat', 'noisa_plugin' ),
		'type' => 'select',
		'id' => '_repeat_event',
		'std' => 'default',
		'options' => array(
			array('name' => __( 'None', 'noisa_plugin' ), 'value' => 'none'),
			array('name' => __( 'Weekly', 'noisa_plugin' ), 'value' => 'weekly')
			//array('name' => __( 'Monthly', 'noisa_plugin' ), 'value' => 'monthly'),
		),
		'group' => 'repeat_event',
		'desc' => __( 'Repeat event.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Every', 'noisa_plugin' ),
		'id' => '_every',
		'type' => 'range',
		'min' => 1,
		'max' => 52,
		'unit' => __( 'week(s)', 'noisa_plugin' ),
		'std' => '1',
		'main_group' => 'repeat_event',
		'group_name' => array('weekly'),
		'desc' => __( 'Repeat event every week(s).', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Day(s)', 'noisa_plugin' ),
		'id' => '_weekly_days',
		'type' => 'multiselect',
		'std' => array('friday'),
		'options' => array(
			array('name' => __( 'Monday', 'noisa_plugin' ), 'value' => 'monday'),
			array('name' => __( 'Tuesday', 'noisa_plugin' ), 'value' => 'tuesday'),
			array('name' => __( 'Wednesday', 'noisa_plugin' ), 'value' => 'wednesday'),
			array('name' => __( 'Thursday', 'noisa_plugin' ), 'value' => 'thursday'),
			array('name' => __( 'Friday', 'noisa_plugin' ), 'value' => 'friday'),
			array('name' => __( 'Saturday', 'noisa_plugin' ), 'value' => 'saturday'),
			array('name' => __( 'Sunday', 'noisa_plugin' ), 'value' => 'sunday'),
		),
		'main_group' => 'repeat_event',
		'group_name' => array('weekly'),
		'desc' => __( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', 'noisa_plugin' )
		),
);

/* Add class instance */
$event_date_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	SHARE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => __( 'Share Options', 'noisa_plugin' ), 
	'id' =>'r_share_options', 
	'page' => array(
		'post', 
		'page',
		'noisa_artists',
		'noisa_releases',
		'noisa_gallery',
		'noisa_events'
	), 
	'context' => 'side',
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post', 
		'default',
		'page-templates/artists.php',
		'page-templates/releases.php',
		'page-templates/blog.php',
		'page-templates/blog-grid.php',
		'page-templates/gallery.php',
		'page-templates/fullscreen.php',
		'page-templates/events-grid.php',
		'page-templates/events-list.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => 'noisa_plugin'

);	

/* Meta options */
$meta_options = array(

	array(
		'name' => __( 'Image', 'noisa_plugin' ),
		'type' => 'add_image',
		'id' => array(
			array('id' => 'share_image', 'std' => '')
		),
		'width' => '160',
		'height' => '160',
		'source' => 'media_libary', // all, media_libary, external_link
		'crop' => 'c',
		'button_title' => __('Add Image', 'noisa_plugin' ),
		'msg' => __('Currently you don\'t have share image, you can add one by clicking on the button below.', 'noisa_plugin' ),
		'desc' => __('Use images that are at least 1200 x 630 pixels for the best display on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display link page posts with larger images. If share data isn\'t visible on Facebook, please use this link:', 'noisa_plugin' ) . '<br>'.'<a href="https://developers.facebook.com/tools/debug/" target="_blank">Facbook Debuger</a>'
	),
	array(
		'name' => __( 'Title', 'noisa_plugin' ),
		'id' => '_share_title',
		'type' => 'text',
		'std' => '',
		'desc' => __( 'A clear title without branding or mentioning the domain itself.', 'noisa_plugin' )
	),
	array(
		'name' => __( 'Short Description', 'noisa_plugin' ),
		'id' => '_share_description',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '80',
		'desc' => __( 'A clear description, at least two sentences long.', 'noisa_plugin' )
	)

);

/* Add class instance */
$fb_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );
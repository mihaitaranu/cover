<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			functions.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	CONSTANTS NAD GLOBALS
/* ---------------------------------------------------------------------- */
global $noisa_opts;


/* Set up the content width value based on the theme's design.
 -------------------------------------------------------------------------------- */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/* ----------------------------------------------------------------------
	THEME TRANSLATION
/* ---------------------------------------------------------------------- */

load_theme_textdomain( 'noisa', get_template_directory() . '/languages' );


/* ----------------------------------------------------------------------
	ADMIN PANEL
/* ---------------------------------------------------------------------- */

// Admin panel
get_template_part( 'admin/panel', 'init' );


/* ----------------------------------------------------------------------
	THEME SETUP
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_setup' ) ) :

	/**
	 * noisa setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */

function noisa_setup() {

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( get_template_directory_uri() . '/css/editor-style.css' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add Title tag
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 780, 440, array( 'center', 'center' ) );

	add_image_size( 'noisa-release-thumb', 660, 660, array( 'center', 'center' ) );
	add_image_size( 'noisa-full-thumb', 1090, 613, array( 'center', 'center' )  );
	add_image_size( 'noisa-main-thumb', 780, 440, array( 'center', 'center' ) );
	add_image_size( 'noisa-small-thumb', 300, 300, array( 'center', 'center' ) );

	// Menu support
	add_theme_support( 'menus' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'sidebar'   => __( 'Sidebar Menu', 'noisa' ),
		'top'   => __( 'Top Menu', 'noisa' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
	 'quote', 'image', 'video', 'audio', 'gallery', 'link'
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Enable support for Woocommerce
	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'noisa_setup' );

endif; 


/* ----------------------------------------------------------------------
	REQUIRED STYLES AND SCRIPTS
/* ---------------------------------------------------------------------- */
function noisa_scripts_and_styles() {
	
	global $noisa_opts, $post, $wp_query;


	// Add comment reply script when applicable
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	/*--- Required Scripts ---*/

	// Google maps
	if ( ! is_404() && $noisa_opts->get_option( 'google_maps_key' ) && $noisa_opts->get_option( 'google_maps_key' ) !== '') {
		$map_key = '?key=' . $noisa_opts->get_option( 'google_maps_key' );
		if ( $noisa_opts->get_option( 'ajaxed' ) && $noisa_opts->get_option( 'ajaxed' ) === 'on' ) {
	  		wp_enqueue_script('js-gmaps-api','https://maps.googleapis.com/maps/api/js' . $map_key, array('jquery'), '1.0.0' );
	  		wp_enqueue_script( 'gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', false, false, true );
		} else {
			if ( get_post_meta( $wp_query->post->ID, '_intro_type', true ) === 'gmap' || has_shortcode( $post->post_content, 'google_maps' ) ) {
		  		wp_enqueue_script('js-gmaps-api','https://maps.googleapis.com/maps/api/js' . $map_key, array('jquery'), '1.0.0' );
	  			wp_enqueue_script( 'gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', false, false, true );
		  	}
		}
	}
  	// YTPlayer
  	if ( ! is_404() ) {
	  	wp_enqueue_script( 'youtubebackground', get_template_directory_uri() . '/js/jquery.youtubebackground.js', false, false, true );
  	}

	wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/jquery.countdown.js', false, false, true );
	wp_enqueue_script( 'TweenMax', get_template_directory_uri() . '/js/TweenMax.min.js', false, false, true ); //Tween max
	wp_enqueue_script( 'ScrollToPlugin', get_template_directory_uri() . '/js/ScrollToPlugin.min.js', false, false, true ); //ScrollToPlugin
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', false, false, true ); //OWL CAROUSEL
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', false, false, true ); // jQuery lightbox
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', false, false, true ); // jQuery masonry plugin

	// Plugins
	wp_enqueue_script( 'noisa-plugins', get_template_directory_uri() . '/js/plugins.js', false, false, true );

	// Slide sidebar
	wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/js/iscroll.js', false, false, true );
	
	// Enable retina displays
	if ( $noisa_opts->get_option( 'retina' ) && $noisa_opts->get_option( 'retina' ) === 'on' ) {
		wp_enqueue_script( 'retina', get_template_directory_uri() . '/js/retina.min.js', false, false, true );
	}

	// Images loaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js' , false, false, true);

	// Ajax scripts
	$ajaxed = 0;
	if ( $noisa_opts->get_option( 'ajaxed' ) && $noisa_opts->get_option( 'ajaxed' ) === 'on' ) {
		$ajaxed = 1;
		wp_enqueue_script( 'jquery.address', get_template_directory_uri() . '/js/jquery.address.js' , false, false, true);
		wp_enqueue_script( 'jquery.ba-urlinternal', get_template_directory_uri() . '/js/jquery.ba-urlinternal.min.js' , false, false, true);
		wp_enqueue_script( 'jquery.WPAjaxLoader', get_template_directory_uri() . '/js/jquery.WPAjaxLoader.js' , false, false, true);
	}

	// Permalinks
	$permalinks = 0;
	if ( get_option('permalink_structure') ) {
		$permalinks = 1;
	}
	wp_enqueue_script( 'custom-controls', get_template_directory_uri() . '/js/custom.controls.js' , false, false, true ); // Loads ajax scripts

	// WOOCOMMERCE
	if ( class_exists( 'WooCommerce' ) ) {
		$ajax_exclude_links = '';
		$ajax_exclude_links .= get_permalink( get_option( 'woocommerce_shop_page_id' ) ) . '|';
		$ajax_exclude_links .= get_permalink( get_option( 'woocommerce_cart_page_id' ) ) . '|';
		$ajax_exclude_links .= get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) . '|'; 
		$ajax_exclude_links .= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '|'; 
		$ajax_exclude_links .= get_post_type_archive_link( 'product' ) . '|';

		$permalinks = get_option( 'woocommerce_permalinks' ); 
		$ajax_exclude_links .= '?product=|';
		if ( isset( $permalinks['product_base'] ) && $permalinks['product_base'] ) {
			$ajax_exclude_links .= $permalinks['product_base']  . '|';
		} else {
			$ajax_exclude_links .= '/product'  . '|';
		}

		$ajax_exclude_links .= '?product_tag=' . '|';
		if ( isset( $permalinks['tag_base'] ) && $permalinks['tag_base'] ) {
			$ajax_exclude_links .= $permalinks['tag_base']  . '|';
		} else {
			$ajax_exclude_links .= '/product-tag'  . '|';
		}

		$ajax_exclude_links .= '?product_cat=' . '|';
		if ( isset( $permalinks['category_base'] ) && $permalinks['category_base'] != '' ) {
			$ajax_exclude_links .= $permalinks['category_base']  . '|';
		} else {
			$ajax_exclude_links .= '/product-category' . '|';
		}

		if ( isset( $permalinks['attribute_base'] ) && $permalinks['attribute_base'] != '' ) {
			$ajax_exclude_links .= $permalinks['attribute_base']  . '|';
		} else {
			$ajax_exclude_links .= '/attribute'  . '|';
		}
		$ajax_exclude_links = str_replace( home_url(), '', $ajax_exclude_links );
		$ajax_scripts = $noisa_opts->get_option( 'ajax_reload_scripts' );
   		$ajax_el = $noisa_opts->get_option( 'ajax_elements' ) . ',.ajax_add_to_cart,.wc-tabs li a,ul.tabs li a,.woocommerce-review-link,.woocommerce-Button.download';
	} else {
		$ajax_exclude_links = '';
		$ajax_el = $noisa_opts->get_option( 'ajax_elements' );
		$ajax_scripts = $noisa_opts->get_option( 'ajax_reload_scripts' );
	}

	$dir = parse_url( home_url() );
	if ( ! isset( $dir[ 'path' ] ) ) {
		$dir[ 'path' ] = '';
	}

	$js_controls_variables = array(
		'home_url'            => home_url(),
		'theme_uri'           => get_template_directory_uri(),
		'dir'                 => $dir[ 'path' ],
		'ajaxed'              => $ajaxed,
		'permalinks'          => $permalinks,
		'ajax_events'         => $noisa_opts->get_option( 'ajax_events' ),
		'ajax_elements'       => $ajax_el,
		'ajax_async'          => $noisa_opts->get_option( 'ajax_async' ),
		'ajax_cache'          => $noisa_opts->get_option( 'ajax_cache' ),
		'ajax_reload_scripts' => $ajax_scripts,
		'ajax_exclude_links'  => $ajax_exclude_links
	);
	wp_localize_script( 'custom-controls', 'controls_vars', $js_controls_variables );
	wp_localize_script( 'custom-controls', 'ajax_action', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce( 'ajax-nonce') ) );

	// Custom scripts
	wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/js/custom.js' , false, false, true ); // Loads custom scripts

	$js_variables = array(
		'theme_uri'          => get_template_directory_uri(),
		'map_marker'         => $noisa_opts->get_image( $noisa_opts->get_option( 'map_marker' ) ),
		'content_animations' => $noisa_opts->get_option( 'content_animations' ),
		'mobile_animations'  => $noisa_opts->get_option( 'mobile_animations' )
	);
	wp_localize_script( 'custom-scripts', 'theme_vars', $js_variables );

	/*--- Required Styles ---*/
	wp_enqueue_style( 'icomoon', get_stylesheet_directory_uri() . '/icons/icomoon.css' ); // Loads icons ICOMOON.
	wp_enqueue_style( 'magnific-popup', get_stylesheet_directory_uri() . '/css/magnific-popup.css' ); 
	wp_enqueue_style( 'owl-carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.css' ); // Loads OWL CAROUSEL style.
	wp_enqueue_style( 'noisa' . '-style', get_stylesheet_uri() );	// Loads the main stylesheet.

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'woocommerce-theme-style', get_stylesheet_directory_uri() . '/css/woocommerce-theme-style.css' );	// Loads woocommerce stylesheet.
	}
	
}

add_action( 'wp_enqueue_scripts', 'noisa_scripts_and_styles' );



/* ----------------------------------------------------------------------
	TGM PLUGIN ACTIVATION 
/* ---------------------------------------------------------------------- */

require_once( 'inc/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'noisa_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

function noisa_register_required_plugins() {
 
	/**
	 * Array of plugin arrays. Required keys are name, slug and required.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
 		
 		/**
		 * Pre-packaged Plugins
		*/
		array(
			'name'                  => 'Rascals Themes - NOISA Plugin', // The plugin name
			'slug'                  => 'rascals_noisa_plugin', // The plugin slug (typically the folder name)
			'source'                => get_template_directory_uri() . '/plugins/rascals_noisa_plugin.zip', // The plugin source
			'required'              => true, // If false, the plugin is only 'recommended' instead of required
			'version'               => '1.1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'WPBakery Visual Composer', // The plugin name
			'slug'               => 'js_composer', // The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/plugins/js_composer.zip', // The plugin source
			'required'           => true, // If false, the plugin is only 'recommended' instead of required
			'version'            => '5.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Slider Revolution', // The plugin name
			'slug'               => 'revslider', // The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/plugins/revslider.zip', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
			'version'            => '5.3.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),

		/**
		 * WordPress.org Plugins
		 */
		array(
			'name'               => 'Contact Form 7', // The plugin name
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => 'MailChimp for WordPress', // The plugin name
			'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => 'WooCommerce', // The plugin name
			'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		)
 
   );
 
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
 
}


/* ----------------------------------------------------------------------
	WIDGETS AND SIDEBARS
/* ---------------------------------------------------------------------- */
function noisa_widgets_init() {

	global $noisa_opts;

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'noisa' ),
		'id'            => 'primary-sidebar',
		'description'   => __( 'Main sidebar that appears on the left or right.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Category Sidebar', 'noisa' ),
		'id'            => 'category-sidebar',
		'description'   => __( 'Category sidebar that appears on the left or right on category, archives, tag pages.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Slide Sidebar', 'noisa' ),
		'id'            => 'slidebar-sidebar',
		'description'   => __( 'Slide sidebar that appear on the right after click on menu icon button.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Column 1', 'noisa' ),
		'id'            => 'footer-col1-sidebar',
		'description'   => __( 'Footer Column 1 that appear on the botton of the page.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Column 2', 'noisa' ),
		'id'            => 'footer-col2-sidebar',
		'description'   => __( 'Footer Column 2 that appear on the botton of the page.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Column 3', 'noisa' ),
		'id'            => 'footer-col3-sidebar',
		'description'   => __( 'Footer Column 3 that appear on the botton of the page.', 'noisa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	

	// Custom sidebars
	if ( $noisa_opts->get_option( 'custom_sidebars' ) ) {
			
			foreach ( $noisa_opts->get_option( 'custom_sidebars' ) as $sidebar ) {
				
				$id = sanitize_title_with_dashes( $sidebar[ 'name' ] );
				register_sidebar( array(
					'name'          => $sidebar[ 'name' ],
					'id'            => $id,
					'description'   => __( 'Custom sidebar created in admin options.', 'noisa' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				));
			}
		}

}
add_action( 'widgets_init', 'noisa_widgets_init' );


/* ----------------------------------------------------------------------
	VC
/* ---------------------------------------------------------------------- */

if ( function_exists( 'vc_set_as_theme' ) ) {
	vc_set_as_theme( true );
}


/* ----------------------------------------------------------------------
	REVOLUTION SLIDER
/* ---------------------------------------------------------------------- */

if  ( class_exists( 'RevSliderFront' ) ) {
	set_revslider_as_theme();
}


/* ----------------------------------------------------------------------
	WOOCOMMERCE
/* ---------------------------------------------------------------------- */

if ( class_exists( 'WooCommerce' ) ) {

	global $noisa_opts;

	// Add body class if page is excluded
	if ( $noisa_opts->get_option( 'ajaxed' ) && $noisa_opts->get_option( 'ajaxed' ) === 'on' ) {

		if ( ! function_exists( 'wc_body_classes' ) ) {
			function wc_body_classes( $classes ) {

				if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ){
					return array_merge( $classes, array( 'wp-ajax-exclude-page' ) );
				} else {
					return $classes;
				}

	    		
			}
			add_filter( 'body_class','wc_body_classes' );
		}
	}

	if ( ! function_exists( 'loop_columns' ) ) {
		function loop_columns() {

			// Shop page ID
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			$shop_layout = get_post_meta( $shop_page_id, '_layout', true );
			if ( $shop_layout !== 'wide' && $shop_layout !== 'thin' && $shop_layout !== 'vc' ) {
	    		return 3; // 3 products per row
	    	} else {
	    		return 4;
	    	}
	   	}
	}


	add_filter( 'loop_shop_columns', 'loop_columns' );
}

/* ----------------------------------------------------------------------
	FIXES
/* ---------------------------------------------------------------------- */
// YT FIX
if ( ! get_option( 'noisa_yt_fix' ) ) {
	$query = new WP_Query( array( 'post_type' => array( 'post', 'page', 'noisa_artists', 'noisa_releases','noisa_events', 'noisa_gallery' ), 'showposts' => -1, 'posts_per_page' => -1  ) );
	while ( $query ->have_posts() ) {
		$query ->the_post();
		$intro = get_post_meta( $query->post->ID, '_intro_type', true ); 
		if ( $intro == 'intro_page_title' || $intro == 'image' || $intro == 'artist_profile' ) {
			$yt = get_post_meta( $query->post->ID, '_yt_id', true );
			if ($yt == 'BsekcY04xvQ') {
				delete_post_meta( $query->post->ID , '_yt_id', 'BsekcY04xvQ' );
			}
		}
		
	}
	add_option( 'noisa_yt_fix', 'fixed' );
}


/* ----------------------------------------------------------------------
	INCLUDE NECESSARY FILES
/* ---------------------------------------------------------------------- */

// Helpers
require_once( trailingslashit( get_template_directory() ) . '/inc/helpers.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/template-tags.php' );

// Add Theme Customizer functionality.
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer.php' );

// Add Frontend styles and scripts
require_once( trailingslashit( get_template_directory() ) . '/inc/frontend.php' );

// One Click Import
require_once( trailingslashit( get_template_directory() ) . '/inc/importer/init.php' );
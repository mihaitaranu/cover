<?php
/**
 * Plugin Name: 	Rascals NOISA Plugin
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			post-types.php
 *
 * Register the Post types for SLider (noisa_slider), Releases (noisa_releases), Gallery (noisa_gallery)
 *
 * =========================================================================================================================================
 *
 * @package noisa-plugin
 * @since 1.0.0
 */


/* ----------------------------------------------------------------------
	INIT CLASS
/* ---------------------------------------------------------------------- */
if ( ! class_exists( 'R_Custom_Post' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-r-custom-posts.php' );
}


/* ----------------------------------------------------------------------
	ARTISTS

	Create a Custom Post type for managing artists items.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_artists_post_type' ) ) :

function noisa_artists_post_type() {

	global $noisa_artists;

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	// Slugs
	if ( isset( $panel_options['artists_slug'] ) ) {
		$artists_slug = $panel_options['artists_slug'];
	} else {
		$artists_slug = 'artists';
	}
	if ( isset( $panel_options['artists_genres_slug'] ) ) {
		$artists_genres_slug = $panel_options['artists_genres_slug'];
	} else {
		$artists_genres_slug = 'artist-genre';
	}
	if ( isset( $panel_options['artists_cat_slug'] ) ) {
		$artists_cat_slug = $panel_options['artists_cat_slug'];
	} else {
		$artists_cat_slug = 'artist-category';
	}

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_artists', 
		'sortable' => true,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Artists', 'noisa_plugin' ),
		'singular_name' => __( 'Artists', 'noisa_plugin' ),
		'add_new' => __( 'Add New', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Artist', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Artist', 'noisa_plugin' ),
		'new_item' => __( 'New Artist', 'noisa_plugin' ),
		'view_item' => __( 'View Artist', 'noisa_plugin' ),
		'search_items' => __( 'Search Items', 'noisa_plugin' ),
		'not_found' =>  __( 'No artists found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No artists found in Trash', 'noisa_plugin' ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => $artists_slug,
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-groups'
	);

	/* Add Taxonomy */
	register_taxonomy('noisa_artists_genres', array('noisa_artists'), array(
		'hierarchical' => true,
		'label' => __( 'Genres', 'noisa_plugin' ),
		'singular_label' => __( 'genre', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $artists_genres_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_artists_cats', array('noisa_artists'), array(
		'hierarchical' => true,
		'label' => __( 'Categories', 'noisa_plugin' ),
		'singular_label' => __( 'category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $artists_cat_slug,
			'with_front' => false
		),
	));

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_artists = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-noisa_artists_columns', 'artists_columns' );

	function artists_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'noisa_plugin' ),
			'artists_preview' => __( 'Artists Preview', 'noisa_plugin' ),
			'artists_genres' => __( 'Genres', 'noisa_plugin' ),
			'artists_cats' => __( 'Categories', 'noisa_plugin' ),
			'date' => __( 'Date', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'artists_display_columns' );

	function artists_display_columns( $column ) {

		global $post;
	
		switch ( $column ) {
			case 'artists_preview':
					if ( has_post_thumbnail( $post->ID ) ) {
						the_post_thumbnail( array( 60, 60 ) );
					}
			break;
			case 'artists_genres' :
				$genres = get_the_terms( $post->ID, 'noisa_artists_genres' );
				if ($genres) {
					foreach( $genres as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'artists_cats' :
				$categories = get_the_terms( $post->ID, 'noisa_artists_cats' );
				if ($categories) {
					foreach( $categories as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
		}
	}


	/* COLUMN GENRES FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_artists_genre_filter');

	function add_noisa_artists_genre_filter() {

		global $typenow, $noisa_artists;

		if ( $typenow == 'noisa_artists' ) {
			$args = array( 'name' => 'noisa_artists_genres' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Genres', 'noisa_plugin' ) . '</option>';
				$noisa_artists->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_artists_genres_filter');

	function noisa_artists_genres_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_artists' && isset( $request['noisa_artists_genres'] ) ) {
			
		  	$term = get_term( $request['noisa_artists_genres'], 'noisa_artists_genres' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}
			
		}
		return $request;
	}

	/* COLUMN CATEGORIES FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_artists_cat_filter');

	function add_noisa_artists_cat_filter() {

		global $typenow, $noisa_artists;

		if ( $typenow == 'noisa_artists' ) {
			$args = array( 'name' => 'noisa_artists_cats' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Categories', 'noisa_plugin' ) . '</option>';
				$noisa_artists->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_artists_cat_filter');

	function noisa_artists_cat_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_artists' && isset( $request['noisa_artists_cats'] ) ) {
			
		  	$term = get_term( $request['noisa_artists_cats'], 'noisa_artists_cat' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}
			
		}
		return $request;
	}


}

add_action( 'init', 'noisa_artists_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	RELEASES

	Create a Custom Post type for managing releases items.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_releases_post_type' ) ) :

function noisa_releases_post_type() {

	global $noisa_releases;

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	// Slugs
	if ( isset( $panel_options['releases_slug'] ) ) {
		$releases_slug = $panel_options['releases_slug'];
	} else {
		$releases_slug = 'releases';
	}
	if ( isset( $panel_options['releases_genres_slug'] ) ) {
		$releases_genres_slug = $panel_options['releases_genres_slug'];
	} else {
		$releases_genres_slug = 'release-genre';
	}
	if ( isset( $panel_options['releases_cat_slug'] ) ) {
		$releases_cat_slug = $panel_options['releases_cat_slug'];
	} else {
		$releases_cat_slug = 'release-category';
	}
	if ( isset( $panel_options['releases_artists_slug'] ) ) {
		$releases_artists_slug = $panel_options['releases_artists_slug'];
	} else {
		$releases_artists_slug = 'release-artist';
	}

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_releases', 
		'sortable' => true,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Releases', 'noisa_plugin' ),
		'singular_name' => __( 'Releases', 'noisa_plugin' ),
		'add_new' => __( 'Add New', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Release', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Release', 'noisa_plugin' ),
		'new_item' => __( 'New Release', 'noisa_plugin' ),
		'view_item' => __( 'View Release', 'noisa_plugin' ),
		'search_items' => __( 'Search Items', 'noisa_plugin' ),
		'not_found' =>  __( 'No releases found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No releases found in Trash', 'noisa_plugin' ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => $releases_slug,
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-portfolio'
	);

	/* Add Taxonomy */
	register_taxonomy('noisa_releases_artists', array('noisa_releases'), array(
		'hierarchical' => true,
		'label' => __( 'Artists', 'noisa_plugin' ),
		'singular_label' => __( 'Artist', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $releases_artists_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_releases_genres', array('noisa_releases'), array(
		'hierarchical' => true,
		'label' => __( 'Genres', 'noisa_plugin' ),
		'singular_label' => __( 'Genre', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $releases_genres_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_releases_cats', array('noisa_releases'), array(
		'hierarchical' => true,
		'label' => __( 'Categories', 'noisa_plugin' ),
		'singular_label' => __( 'Category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $releases_cat_slug,
			'with_front' => false
		),
	));

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_releases = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-noisa_releases_columns', 'releases_columns' );

	function releases_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'noisa_plugin' ),
			'releases_preview' => __( 'Releases Preview', 'noisa_plugin' ),
			'releases_artists' => __( 'Artists', 'noisa_plugin' ),
			'releases_genres' => __( 'Genres', 'noisa_plugin' ),
			'releases_cat' => __( 'Categories', 'noisa_plugin' ),
			'date' => __( 'Date', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'releases_display_columns' );

	function releases_display_columns( $column ) {

		global $post;
	
		switch ( $column ) {
			case 'releases_preview':
					if ( has_post_thumbnail( $post->ID ) ) {
						the_post_thumbnail( array( 60, 60 ) );
					}
				break;
			case 'releases_artists' :
				$artists = get_the_terms( $post->ID, 'noisa_releases_artists' );
				if ($artists) {
					foreach( $artists as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'releases_genres' :
				$genres = get_the_terms( $post->ID, 'noisa_releases_genres' );
				if ($genres) {
					foreach( $genres as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'releases_cat' :
				$cats = get_the_terms( $post->ID, 'noisa_releases_cats' );
				if ($cats) {
					foreach( $cats as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
		}
	}


	/* COLUMN ARTISTS FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_artists_filter');

	function add_noisa_artists_filter() {

		global $typenow, $noisa_releases;

		if ( $typenow == 'noisa_releases' ) {
			$args = array( 'name' => 'noisa_releases_artists' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Artists', 'noisa_plugin' ) . '</option>';
				$noisa_releases->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_artists_filter');

	function noisa_artists_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_releases' && isset( $request['noisa_releases_artists'] ) ) {
			
		  	$term = get_term( $request['noisa_releases_artists'], 'noisa_releases_artists' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


	/* COLUMN GENRES FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_genres_filter');

	function add_noisa_genres_filter() {

		global $typenow, $noisa_releases;

		if ( $typenow == 'noisa_releases' ) {
			$args = array( 'name' => 'noisa_releases_genres' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Genres', 'noisa_plugin' ) . '</option>';
				$noisa_releases->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_genres_filter');

	function noisa_genres_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_releases' && isset( $request['noisa_releases_genres'] ) ) {
			
		  	$term = get_term( $request['noisa_releases_genres'], 'noisa_releases_genres' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


	/* COLUMN CAT FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_cat_filter');

	function add_noisa_cat_filter() {

		global $typenow, $noisa_releases;

		if ( $typenow == 'noisa_releases' ) {
			$args = array( 'name' => 'noisa_releases_cats' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Categories', 'noisa_plugin' ) . '</option>';
				$noisa_releases->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_cat_filter');

	function noisa_cat_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_releases' && isset( $request['noisa_releases_cats'] ) ) {
			
		  	$term = get_term( $request['noisa_releases_cats'], 'noisa_releases_cats' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


}

add_action( 'init', 'noisa_releases_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	EVENTS

	Create a Custom Post type for managing events.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_events_post_type' ) ) :

function noisa_events_post_type() {

	global $noisa_events, $pagenow, $current_date;

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	// Slugs
	if ( isset( $panel_options['events_slug'] ) ) {
		$events_slug = $panel_options['events_slug'];
	} else {
		$events_slug = 'events';
	}
	if ( isset( $panel_options['events_cat_slug'] ) ) {
		$events_cat_slug = $panel_options['events_cat_slug'];
	} else {
		$events_cat_slug = 'event-category';
	}
	if ( isset( $panel_options['events_artists_slug'] ) ) {
		$events_artists_slug = $panel_options['events_artists_slug'];
	} else {
		$events_artists_slug = 'event-artist';
	}
	if ( isset( $panel_options['events_locations_slug'] ) ) {
		$events_locations_slug = $panel_options['events_locations_slug'];
	} else {
		$events_locations_slug = 'event-location';
	}

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_events', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Events', 'noisa_plugin' ),
		'singular_name' => __( 'Events', 'noisa_plugin' ),
		'add_new' => __( 'Add New', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Event', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Event', 'noisa_plugin' ),
		'new_item' => __( 'New Event', 'noisa_plugin' ),
		'view_item' => __( 'View Event', 'noisa_plugin' ),
		'search_items' => __( 'Search Items', 'noisa_plugin' ),
		'not_found' =>  __( 'No slider events found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No events found in Trash', 'noisa_plugin' ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => __( 'events', 'noisa_plugin' ),
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-calendar'
	);

	/* Add Taxonomy */
	register_taxonomy('noisa_event_type', array('noisa_events'), array(
		'hierarchical' => true,
		'label' => __( 'Event Type', 'noisa_plugin' ),
		'singular_label' => __( 'Event Type', 'noisa_plugin' ),
		'show_ui' => false,
		'query_var' => true,
		'capabilities' => array(
			'manage_terms' => 'manage_divisions',
			'edit_terms' => 'edit_divisions',
			'delete_terms' => 'delete_divisions',
			'assign_terms' => 'edit_posts'
		),
		'rewrite' => array('slug' => 'event-type'),
		'show_in_nav_menus' => false
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_events_cats', array('noisa_events'), array(
		'hierarchical' => true,
		'label' => __( 'Categories', 'noisa_plugin' ),
		'singular_label' => __( 'category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $events_cat_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_events_artists', array('noisa_events'), array(
		'hierarchical' => true,
		'label' => __( 'Artists', 'noisa_plugin' ),
		'singular_label' => __( 'category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $events_artists_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_events_locations', array('noisa_events'), array(
		'hierarchical' => true,
		'label' => __( 'Locations', 'noisa_plugin' ),
		'singular_label' => __( 'location', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $events_locations_slug,
			'with_front' => false
		),
	));


	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_events = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* Helpers Functions
	------------------------------------------------------------------------*/


	/* Insert default taxonomy
	 ------------------------------------------------------------------------*/
	function noisa_insert_taxonomy( $cat_name, $parent, $description, $taxonomy ) {
		global $wpdb;

		if ( ! term_exists( $cat_name, $taxonomy ) ) {
			$args = compact(
				$cat_name = esc_sql( $cat_name ),
				$cat_slug = sanitize_title( $cat_name ),
				$parent = 0,
				$description = ''
			);
			wp_insert_term( $cat_name, $taxonomy, $args );
			return;
		}
	  return;
	}


	/* Get Taxonomy ID
	 ------------------------------------------------------------------------*/
	function noisa_get_taxonomy_id( $cat_name, $taxonomy ) {
		
		$args = array(
			'hide_empty' => false
		);
		
		$taxonomies = get_terms( $taxonomy, $args );
		if ( $taxonomies ) {
			foreach( $taxonomies as $taxonomy ) {
				
				if ( $taxonomy->name == $cat_name ) {
					return $taxonomy->term_id;
				}
				
			}
		}
		
		return false;
	}


	/* Days left
	 ------------------------------------------------------------------------*/
	function noisa_days_left( $start_date, $end_date, $type ) {
		global $current_date;
		
		$now = strtotime( $current_date );
		$start_date = strtotime( $start_date );
		$end_date = strtotime( $end_date );
		
		/* Days left to start date */
		$hours_left_start = ( mktime(0, 0, 0, date( 'm', $start_date ), date( 'd', $start_date ), date( 'Y', $start_date ) ) - $now ) / 3600;
		$days_left_start = ceil( $hours_left_start / 24 );
		
		/* Days left to end date */
		$hours_left_end = ( mktime( 0, 0, 0, date( 'm', $end_date ), date( 'd', $end_date ), date( 'Y', $end_date ) ) - $now ) / 3600;
		$days_left_end = ceil( $hours_left_end / 24 );
		$days_number = ( $days_left_end - $days_left_start ) + 1;
		
		if ( $type == 'days' ) {
			return $days_number;
		}
		
		if ( $type == 'days_left' ) {
			
			/* If future events */
			if ( $days_left_end >= 0 ) {
			
				if ( $days_left_start == 0 ) {
					return '<span style="color:red;font-weight:bold">'. __( 'Start Today', 'noisa_plugin' ) .'</span>';
				}
				elseif ( $days_left_start < 0 ) {
					return '<span style="color:red;font-weight:bold">' . __( 'Continued', 'noisa_plugin' ) . '</span>';
				}
				elseif ( $days_left_start > 0 ) {
					return $days_left_start;
				}
			
			} else return '-- --';
		}
		
	}


	/* Settings
	------------------------------------------------------------------------*/
	$time_zone = 'local_time'; /* local_time, server_time, UTC */

	/* Timezone */
	$current_date = array();
	$current_date['local_time'] = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
	$current_date['server_time'] = date( 'Y-m-d', current_time( 'timestamp', 1 ) );
	$current_date['UTC'] = date( 'Y-m-d' );
	$current_date = $current_date[ $time_zone ];

	/* Insert default taxonomy */
	if ( is_admin() ) {
		if ( ! term_exists( 'Future events', 'noisa_event_type' ) ) {
	    	noisa_insert_taxonomy( 'Future events', 0, '', 'noisa_event_type' );
		}
		if ( ! term_exists( 'Past events', 'noisa_event_type' ) ) {
	    	noisa_insert_taxonomy( 'Past events', 0, '', 'noisa_event_type' );
	    }
	}


	/* Column Layout
	------------------------------------------------------------------------*/
	add_filter( 'manage_edit-noisa_events_columns', 'noisa_events_columns' );

	function noisa_events_columns( $columns ) {
		global $current_date;
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Event Title', 'noisa_plugin' ),
			'event_date' => __( 'Event Date', 'noisa_plugin' ),
			'event_days' => __( 'Days', 'noisa_plugin' ),
			'event_days_left' => __( 'Days Left', 'noisa_plugin' ),
			'event_type' => __( 'Type', 'noisa_plugin' ),
			'event_repeat' => __( 'Repeat', 'noisa_plugin' ),
			'events_artists' => __( 'Artists', 'noisa_plugin' ),
			'events_locations' => __( 'Locations', 'noisa_plugin' ),
			'events_cats' => __( 'Categories', 'noisa_plugin' ),
			'image_preview' => __( 'Preview', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'noisa_events_display_columns' );

	function noisa_events_display_columns( $column ) {
		global $post, $current_date;
		
		$today = strtotime( $current_date );
		
		switch ( $column ) {
			case 'event_date':
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo $event_date_start['_event_date_start'][0] . ' - ' . $event_date_end['_event_date_end'][0];
			break;
			case 'event_days' :
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo noisa_days_left( $event_date_start['_event_date_start'][0], $event_date_end['_event_date_end'][0], 'days' );
			break;
			case 'event_days_left' :
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo noisa_days_left( $event_date_start['_event_date_start'][0], $event_date_end['_event_date_end'][0], 'days_left' );
			break;
			case 'event_type' :
					$taxonomies = get_the_terms( $post->ID, 'noisa_event_type' );
					$event_date_end = get_post_custom();
					if ( $taxonomies ) {
						foreach( $taxonomies as $taxonomy ) {
							if ( strtotime( $event_date_end['_event_date_end'][0] ) >= $today && $taxonomy->name == 'Future events' ) 
							    echo '<strong>' . $taxonomy->name . '</strong>';
							else 
							    echo $taxonomy->name;
						}
					}
			break;
			case 'event_repeat' :
					$custom = get_post_custom();
					if ( isset( $custom['_repeat_event'][0]) && $custom['_repeat_event'][0] != 'none' )
						echo ucfirst( $custom['_repeat_event'][0] );
					
			break;
			case 'events_artists' :
				$artists = get_the_terms( $post->ID, 'noisa_events_artists' );
				if ($artists) {
					foreach( $artists as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'events_locations' :
				$locations = get_the_terms( $post->ID, 'noisa_events_locations' );
				if ($locations) {
					foreach( $locations as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'events_cats' :
				$cats = get_the_terms( $post->ID, 'noisa_events_cats' );
				if ($cats) {
					foreach( $cats as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			
			case 'image_preview':
				if ( has_post_thumbnail( $post->ID ) ) {
					the_post_thumbnail( array( 60, 60 ) );
				}
			break;
		}
	}


	/* Menage Events
	------------------------------------------------------------------------*/
	function manage_events() {
		global $post, $current_date;
		
		$backup = $post;
		$today = strtotime( $current_date );
		$args = array(
			'post_type'     => 'noisa_events',
			'noisa_event_type' => 'Future events',
			'post_status'   => 'publish, pending, draft, future, private, trash',
			'numberposts'   => '-1',
			'orderby'       => 'meta_value',  
			'meta_key'      => '_event_date_end',
			'order'         => 'ASC',
		  	'meta_query' 	 => array(array('key' => '_event_date_end', 'value' => date('Y-m-d'), 'compare' => '<', 'type' => 'DATE')),
		  );
		$events = get_posts( $args );
		
	 	foreach( $events as $event ) {
			
			$event_date_start = get_post_meta( $event->ID, '_event_date_start', true );
			$event_date_end = get_post_meta( $event->ID, '_event_date_end', true );
			$repeat = get_post_meta( $event->ID, '_repeat_event', true );
			
			/* Move Events */

			// If is set repeat event
			if ( isset( $repeat ) && $repeat != 'none' ) {

				// Weekly
				if ( $repeat == 'weekly' ) {
					$every = get_post_meta( $event->ID, '_every', true );
					$weekly_days = get_post_meta( $event->ID, '_weekly_days', true );

					// Event length
					$start_date = strtotime( $event_date_start );
					$end_date = strtotime( $event_date_end );
					$date_diff = $end_date - $start_date;
					$event_length = floor( $date_diff / (60*60*24) );

					unset( $start_date, $end_date, $date_diff );
					//echo "Differernce is $event_length days";

					// Make dates array
					$weekly_dates  = array();
					$weekly_days_a = array();
					foreach ( $weekly_days as $key => $day ) {
						$start_date = strtotime( "+$every week $day $event_date_start" );
						$date_diff = $start_date - $today;
						$days = floor( $date_diff / (60*60*24) );
						$start_date = date( 'Y-m-d', $start_date );
						$end_date = strtotime( "+$event_length day $start_date" );
						$end_date = date( 'Y-m-d', $end_date );
						$weekly_dates[$key]['day'] = $day;
						$weekly_dates[$key]['days'] = $days;
						$weekly_dates[$key]['start_date'] = $start_date;
						$weekly_dates[$key]['end_date'] = $end_date;
						$weekly_days_a[] = $days;
					}
					// Next event date
					$ne = array_search( min( $weekly_days_a ), $weekly_days_a );
					//print_r($ne);

					// Update event date
					update_post_meta( $event->ID, '_event_date_start', $weekly_dates[$ne]['start_date'] );
					update_post_meta( $event->ID, '_event_date_end', $weekly_dates[$ne]['end_date'] );

				}
			} else {
				wp_set_post_terms( $event->ID, noisa_get_taxonomy_id( 'Past events', 'noisa_event_type' ), 'noisa_event_type', false );
			}
		}
		$post = $backup; 
		wp_reset_query();
	}


	/* Shelude Events
	 ------------------------------------------------------------------------*/
	if ( false === ( $event_task = get_transient( 'event_task' ) ) ) {
	    $current_time = time();
		manage_events();
		set_transient( 'event_task', $current_time, 60*60 );
	}
	//delete_transient('event_task');


	/* Save Events
	 ------------------------------------------------------------------------*/
	function save_postdata_events() {
	   	global $current_date;
		
		if ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		} else {
			return; 
		}

		// Inline editor
	 	if ( $_POST['action'] == 'inline-save' ) {
	 		return;
	 	}

	    if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'noisa_events' ) {
				
	        $today = strtotime( $current_date );
		    $event_date_start = strtotime( get_post_meta( $post_id, '_event_date_start', true ) );
		   
		    $event_date_end = strtotime( get_post_meta( $post_id, '_event_date_end', true ) );
			
	        /* Add Default Date */
		    if ( ! $event_date_start ) {
		  	    add_post_meta( $post_id, '_event_date_start', date( 'Y-m-d', $today) );
		    }
		    if ( ! $event_date_end ) {
			    add_post_meta( $post_id, '_event_date_end', get_post_meta( $post_id, '_event_date_start', true ) );
		    }
		    if ( $event_date_end < $event_date_start ) {
			    update_post_meta( $post_id, '_event_date_end', get_post_meta( $post_id, '_event_date_start', true ) );
		    }
			
			$event_date_start = strtotime( get_post_meta($post_id, '_event_date_start', true ) );
		    $event_date_end = strtotime( get_post_meta($post_id, '_event_date_end', true ) );
			
			/* Add Default Term */
			$taxonomies = get_the_terms( $post_id, 'noisa_event_type' );
			if ( ! $taxonomies ) {
				wp_set_post_terms( $post_id, noisa_get_taxonomy_id( 'Future events', 'noisa_event_type' ), 'noisa_event_type', false );	
			}
		    if ( $event_date_end >= $today ) {
		  	    if ( is_object_in_term( $post_id, 'noisa_event_type', 'Past events' ) )
		        wp_set_post_terms( $post_id, noisa_get_taxonomy_id( 'Future events', 'noisa_event_type' ), 'noisa_event_type', false );	
		    } else {	
		        if ( is_object_in_term( $post_id, 'noisa_event_type', 'Future events' ) )
			    wp_set_post_terms( $post_id, noisa_get_taxonomy_id( 'Past events', 'noisa_event_type' ), 'noisa_event_type', false );
		    }
			
	    }
		
	}
	add_action( 'wp_insert_post', 'save_postdata_events' );


	/* Custom order
	 ------------------------------------------------------------------------*/
	function events_manager_order( $query ) {
		global $pagenow;
		if ( is_admin() && $pagenow == 'edit.php' && isset( $query->query['post_type'] ) ) {
		    $post_type = $query->query['post_type'];
	    	if ($post_type == 'noisa_events') {
			   	$events_order = '_event_date_start';
				$query->query_vars['meta_key'] = $events_order;
				$query->query_vars['orderby'] = 'meta_value';
				$query->query_vars['order'] = 'asc';
				$query->query_vars['meta_query'] = array( array( 'key' => $events_order, 'value' => '1900-01-01', 'compare' => '>', 'type' => 'NUMERIC') );
	    	}
	  	}
	}
	add_filter( 'pre_get_posts', 'events_manager_order' );


	/* Event Type Filter
	------------------------------------------------------------------------*/
	function add_events_filter() {

	    global $typenow, $noisa_events;

	    if ($typenow == 'noisa_events') {
	        $args = array( 'name' => 'noisa_event_type' );
	        $filters = get_taxonomies( $args );

	        foreach ( $filters as $tax_slug ) {
	            $tax_obj = get_taxonomy( $tax_slug );
	            $tax_name = $tax_obj->labels->name;

	            echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Types', 'noisa_plugin' ) . '</option>';
	            $noisa_events->generate_taxonomy_options( $tax_slug, 0, 0);
	            echo "</select>";
	        }
	    }
	}
	add_action('restrict_manage_posts', 'add_events_filter');

	/* Add Filter - Request */
	add_action('request', 'events_request');

	function events_request( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_events' && isset( $request['noisa_event_type'] ) ) {
			$term = get_term( $request['noisa_event_type'], 'noisa_event_type' );
			if ( isset( $term->name ) && $term ) {
				$term = $term->name;
				$request['term'] = $term;
			}
		}
		return $request;
	}


	/* COLUMN CAT FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_events_cats_filter');

	function add_noisa_events_cats_filter() {

		global $typenow, $noisa_events;

		if ( $typenow == 'noisa_events' ) {
			$args = array( 'name' => 'noisa_events_cats' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Categories', 'noisa_plugin' ) . '</option>';
				$noisa_events->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_events_cats_filter');

	function noisa_events_cats_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_events' && isset( $request['noisa_events_cats'] ) ) {
			
		  	$term = get_term( $request['noisa_events_cats'], 'noisa_events_cats' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


	/* COLUMN ARTIST FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_events_artists_filter');

	function add_noisa_events_artists_filter() {

		global $typenow, $noisa_events;

		if ( $typenow == 'noisa_events' ) {
			$args = array( 'name' => 'noisa_events_artists' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Artists', 'noisa_plugin' ) . '</option>';
				$noisa_events->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_events_artists_filter');

	function noisa_events_artists_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_events' && isset( $request['noisa_events_artists'] ) ) {
			
		  	$term = get_term( $request['noisa_events_artists'], 'noisa_events_artists' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


	/* COLUMN LOCATION FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_events_locations_filter');

	function add_noisa_events_locations_filter() {

		global $typenow, $noisa_events;

		if ( $typenow == 'noisa_events' ) {
			$args = array( 'name' => 'noisa_events_locations' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Locations', 'noisa_plugin' ) . '</option>';
				$noisa_events->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_events_locations_filter');

	function noisa_events_locations_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_events' && isset( $request['noisa_events_locations'] ) ) {
			
		  	$term = get_term( $request['noisa_events_locations'], 'noisa_events_locations' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}

}

add_action( 'init', 'noisa_events_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	GALLERY

	Create a Custom Post type for managing gallery items.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_gallery_post_type' ) ) :

function noisa_gallery_post_type() {

	global $noisa_gallery;

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	// Slugs
	if ( isset( $panel_options['gallery_slug'] ) ) {
		$gallery_slug = $panel_options['gallery_slug'];
	} else {
		$gallery_slug = 'gallery';
	}
	if ( isset( $panel_options['gallery_cat_slug'] ) ) {
		$gallery_cat_slug = $panel_options['gallery_cat_slug'];
	} else {
		$gallery_cat_slug = 'gallery-category';
	}
	if ( isset( $panel_options['gallery_artists_slug'] ) ) {
		$gallery_artists_slug = $panel_options['gallery_artists_slug'];
	} else {
		$gallery_artists_slug = 'gallery-artist';
	}

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_gallery', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Gallery', 'noisa_plugin' ),
		'singular_name' => __( 'Album', 'noisa_plugin' ),
		'add_new' => __( 'Add New Album', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Album', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Album', 'noisa_plugin' ),
		'new_item' => __( 'New Album', 'noisa_plugin' ),
		'view_item' => __( 'View Album', 'noisa_plugin' ),
		'search_items' => __( 'Search Items', 'noisa_plugin' ),
		'not_found' =>  __( 'No albums found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No albums found in Trash', 'noisa_plugin' ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => $gallery_slug,
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-camera'
	);

	/* Add Taxonomy */
	register_taxonomy('noisa_gallery_cats', array('noisa_gallery'), array(
		'hierarchical' => true,
		'label' => __( 'Categories', 'noisa_plugin' ),
		'singular_label' => __( 'category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $gallery_cat_slug,
			'with_front' => false
		),
	));

	/* Add Taxonomy */
	register_taxonomy('noisa_gallery_artists', array('noisa_gallery'), array(
		'hierarchical' => true,
		'label' => __( 'Artists', 'noisa_plugin' ),
		'singular_label' => __( 'category', 'noisa_plugin' ),
		'query_var' => true,
		'rewrite' => array(
			'slug' => $gallery_artists_slug,
			'with_front' => false
		),
	));

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_gallery = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-noisa_gallery_columns', 'gallery_columns' );

	function gallery_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'noisa_plugin' ),
			'gallery_preview' => __( 'Gallery Preview', 'noisa_plugin' ),
			'gallery_cats' => __( 'Categories', 'noisa_plugin' ),
			'gallery_artists' => __( 'Artists', 'noisa_plugin' ),
			'date' => __( 'Date', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'gallery_display_columns' );

	function gallery_display_columns( $column ) {

		global $post;
	
		switch ( $column ) {
			case 'gallery_preview':
					if ( has_post_thumbnail( $post->ID ) ) {
						the_post_thumbnail( array( 60, 60 ) );
					}
				break;
			case 'gallery_cats' :
				$genres = get_the_terms( $post->ID, 'noisa_gallery_cats' );
				if ($genres) {
					foreach( $genres as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
			case 'gallery_artists' :
				$artists = get_the_terms( $post->ID, 'noisa_gallery_artists' );
				if ($artists) {
					foreach( $artists as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
		}
	}


	/* COLUMN CAT FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_gallery_cats_filter');

	function add_noisa_gallery_cats_filter() {

		global $typenow, $noisa_gallery;

		if ( $typenow == 'noisa_gallery' ) {
			$args = array( 'name' => 'noisa_gallery_cats' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Categories', 'noisa_plugin' ) . '</option>';
				$noisa_gallery->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_gallery_cats_filter');

	function noisa_gallery_cats_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_gallery' && isset( $request['noisa_gallery_cats'] ) ) {
			
		  	$term = get_term( $request['noisa_gallery_cats'], 'noisa_gallery_cats' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}


	/* COLUMN ARTIST FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_noisa_gallery_artists_filter');

	function add_noisa_gallery_artists_filter() {

		global $typenow, $noisa_gallery;

		if ( $typenow == 'noisa_gallery' ) {
			$args = array( 'name' => 'noisa_gallery_artists' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . __( 'All Artists', 'noisa_plugin' ) . '</option>';
				$noisa_gallery->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'noisa_gallery_artists_filter');

	function noisa_gallery_artists_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'noisa_gallery' && isset( $request['noisa_gallery_artists'] ) ) {
			
		  	$term = get_term( $request['noisa_gallery_artists'], 'noisa_gallery_artists' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}	
		}
		return $request;
	}

}

add_action( 'init', 'noisa_gallery_post_type', 0 );


/* Pagination fix */
function noisa_gallery_disable_canonical_redirect( $query ) {
	
    if ( ! is_home() && ! is_404() && isset( $query->query_vars['post_type'] ) && 'noisa_gallery' == $query->query_vars['post_type'] ) {
        remove_filter( 'template_redirect', 'redirect_canonical' );
    }

}
add_action( 'parse_query', 'noisa_gallery_disable_canonical_redirect' );

endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SLIDER

	Create a Custom Post type for managing Slides.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_slider_post_type' ) ) :

function noisa_slider_post_type() {

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_slider', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Slider', 'noisa_plugin' ),
		'singular_name' => __( 'Slider', 'noisa_plugin' ),
		'add_new' => __( 'Add New', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Slider Item', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Slider Item', 'noisa_plugin' ),
		'new_item' => __( 'New Slider Item', 'noisa_plugin' ),
		'view_item' => __( 'View Slider Item', 'noisa_plugin' ),
		'search_items' => __( 'Search Items', 'noisa_plugin' ),
		'not_found' =>  __( 'No slider items found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No slider items found in Trash', 'noisa_plugin' ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => __( 'sliders', 'SLUG', 'noisa_plugin' ),
			'with_front' => false
		),
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-slides'
	);

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_slider = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-noisa_slider_columns', 'slider_columns' );

	function slider_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'noisa_plugin' ),
			'slider_id' => __( 'Slider ID', 'noisa_plugin' ),
			'date' => __( 'Date', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'slider_display_columns' );

	function slider_display_columns( $column ) {

		global $post;
		
		switch ($column) {
			case 'slider_id':
			    the_ID();
			
			break;
		}
	}
}

add_action( 'init', 'noisa_slider_post_type', 0 );
endif; // End check for function_exists()
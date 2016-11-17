<?php
/**
 * Plugin Name: 	Noisa
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			scamp-player.php
 *
 * Register the Post Types for Scamp Player and some functions
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
	TRACKS

	Create a Custom Post Type for managing audio tracks.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'noisa_tracks_post_type' ) ) :

function noisa_tracks_post_type() {

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	/* Class arguments */
	$args = array( 
		'post_name' => 'noisa_tracks', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'noisa_plugin'
	);

	/* Post Labels */
	$labels = array(
		'name' => __( 'Tracks', 'noisa_plugin' ),
		'singular_name' => __( 'Tracks', 'noisa_plugin' ),
		'add_new' => __( 'Add New', 'noisa_plugin' ),
		'add_new_item' => __( 'Add New Tracks', 'noisa_plugin' ),
		'edit_item' => __( 'Edit Tracks', 'noisa_plugin' ),
		'new_item' => __( 'New Tracks', 'noisa_plugin' ),
		'view_item' => __( 'View Tracks', 'noisa_plugin' ),
		'search_items' => __( 'Search Tracks', 'noisa_plugin' ),
		'not_found' =>  __( 'No tracks found', 'noisa_plugin' ),
		'not_found_in_trash' => __( 'No tracks found in Trash', 'noisa_plugin' ), 
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
			'slug' => 'tracks',
			'with_front' => false,
		),
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-format-audio'
	);

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$noisa_tracks = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-noisa_tracks_columns', 'tracks_columns' );

	function tracks_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'noisa_plugin' ),
			'tracks_id' => __( 'Tracks ID', 'noisa_plugin' ),
			'date' => __( 'Date', 'noisa_plugin' )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'tracks_display_columns' );

	function tracks_display_columns( $column ) {

		global $post;
		
		switch ($column) {
			case 'tracks_id':
			    the_ID();
			
			break;
		}
	}
}

add_action( 'init', 'noisa_tracks_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER SCRIPTS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_scripts' ) ) :

function scamp_player_scripts() {

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	$plugin_folder = dirname( __FILE__ );

	// Player Styles
	wp_enqueue_style( 'scamp-player' , plugins_url( 'scamp-player/css/scamp.player.min.css' , $plugin_folder ) , array() , '1.0' , 'all' );

	if ( $panel_options['player_skin'] ) {
		wp_enqueue_style( 'scamp-player-skin' , plugins_url( 'scamp-player/css/scamp.player.' . $panel_options['player_skin'] . '.min.css' , $plugin_folder ) , array() , '1.0' , 'all' );
	}

	// Player Scripts
	wp_enqueue_script( 'soundcloud-sdk' , 'https://connect.soundcloud.com/sdk.js' , false , false , true );
	wp_enqueue_script( 'soundmanager2' , plugins_url( 'scamp-player/js/soundmanager2-nodebug-jsmin.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'iscroll' , plugins_url( 'scamp-player/js/iscroll.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'scamp-player' , plugins_url( 'scamp-player/jquery.scamp.player.min.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'scamp-player-init' , plugins_url( 'scamp-player/jquery.scamp.player-init.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );

	// Settings
	$panel_options['player_autoplay'] === 'on' ? $panel_options['player_autoplay'] = true : $panel_options['player_autoplay'] = false;
	$panel_options['player_random'] === 'on' ? $panel_options['player_random'] = true : $panel_options['player_random'] = false;
	$panel_options['player_loop'] === 'on' ? $panel_options['player_loop'] = true : $panel_options['player_loop'] = false;
	$panel_options['load_first_track'] === 'on' ? $panel_options['load_first_track'] = true : $panel_options['load_first_track'] = false;
	$panel_options['player_titlebar'] === 'on' ? $panel_options['player_titlebar'] = true : $panel_options['player_titlebar'] = false;
	isset( $panel_options['soundcloud_id'] ) && $panel_options['soundcloud_id'] !== '' ? $panel_options['soundcloud_id'] = $panel_options['soundcloud_id'] : $panel_options['soundcloud_id'] = '23f5c38e0aa354cdd0e1a6b4286f6aa4';

	if ( $panel_options['player_autoplay'] && $panel_options['load_first_track'] ) {
		$panel_options['load_first_track'] = false;
	}

	$js_variables = array(
		'plugin_uri'     => plugins_url('scamp-player' , $plugin_folder ),
		'autoplay' => $panel_options['player_autoplay'],
		'random' => $panel_options['player_random'],
		'loop' => $panel_options['player_loop'],
		'load_first_track' => $panel_options['load_first_track'],
		'titlebar' => $panel_options['player_titlebar'],
		'soundcloud_id' => $panel_options['soundcloud_id'],
		'volume' => $panel_options['player_volume'],
		'play_label' => __( 'Play', 'noisa_plugin' ),
		'cover_label' => __( 'Cover', 'noisa_plugin' ),
		'title_label' => __( 'Title/Artist', 'noisa_plugin' ),
		'buy_label' => __( 'Buy/Download', 'noisa_plugin' ),
		'remove_label' => __( 'Remove', 'noisa_plugin' ),
		'empty_queue' => __( 'Empty Queue', 'noisa_plugin' )
	);
	wp_localize_script( 'scamp-player-init', 'scamp_vars', $js_variables );

}
add_action( 'wp_enqueue_scripts' , 'scamp_player_scripts' );

endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER GET LIST ARRAY

 	return: array or false
 	example arrays returns:

	array(
	  	array (
			'custom' => boolean,
			'custom_url' => boolean / string,
			'title' => string,
			'release_url' => string,
			'release_target' => string, 
			'artists' => string,
			'artists_url' => string,
			'artists_target' => string,
			'cart_url' => string,
			'cart_target' => string,
			'free_download' => string,
			'links' => boolean / string,
			'cover' => boolean / string,
			'url' => string
		)
	)
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_get_list' ) ) :

	function scamp_player_get_list( $audio_post ) {

		// Get panel options
		$panel_options = get_option( 'noisa_panel_opts' );

		// Get panel options
		$audio_ids = get_post_meta( $audio_post, '_audio_tracks', true );

		if ( ! $audio_ids || $audio_ids == '' ) {
			 return false;
		}

		$count = 0;
		$ids = explode( '|', $audio_ids );
		$defaults = array(
			'custom' => false,
			'custom_url' => false,
			'title' => '',
			'artists' => false,
			'links' => false,
			'cover' => false,
			'cover_full' => false,
			'release_url' => '',
			'release_target' => '', 
			'artists' => '',
			'artists_url' => '',
			'artists_target' => '',
			'cart_url' => '',
			'cart_target' => '',
			'free_download' => 'no'
		);

		$tracklist = array();

		/* Start Loop */
		foreach ( $ids as $id ) {

			// Vars 
			$title = '';
			$subtitle = '';

			/* Get image meta */
			$track = get_post_meta( $audio_post, '_audio_tracks_' . $id, true );

			/* Add default values */
			if ( isset( $track ) && is_array( $track ) ) {
				$track = array_merge( $defaults, $track );
			} else {
				$track = $defaults;
			}

			/* Custom cover */
			if ( $track['cover'] ) {

				// If from Media Libary
				if ( is_numeric( $track['cover'] ) ) {
					$image_cover = wp_get_attachment_image_src( $track['cover'], 'thumbnail' );
					$image_cover = $image_cover[0];
					$image_cover_full = wp_get_attachment_image_src( $track['cover'], 'noisa-release-thumb' );
					$image_cover_full = $image_cover_full[0];
					if ( $image_cover ) {
						$track['cover'] =  $image_cover;
						$track['cover_full'] =  $image_cover_full;
					} else {
						$track['cover'] = false;
					}
				}

			}

			/* Check if track is custom */
		   	if ( wp_get_attachment_url( $id ) ) {
		      	$track_att = get_post( $id );
		      	$track['url'] = wp_get_attachment_url( $id );
		      	if ( $track['title'] == '' ) {
		      		$track['title'] = $track_att->post_title;
		      	}
		    } else {
				$track['url'] = $track['custom_url'];
				if ( $track['url'] == '' ) {
					continue;
				}
				if ( $track['title'] == '' ) {
					$track['title'] = __( 'Custom Title', SPECTRA_PLUGIN );
				}
				$track['custom'] = true;
		    }


		    
		    array_push( $tracklist, $track );
		}
		
		return $tracklist;
	}

endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER INIT
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_init' ) ) :

function scamp_player_init() {

	// Get panel options
	$panel_options = get_option( 'noisa_panel_opts' );

	// Player Classes
	$classes = '';

	// JS name
	$js_name = 'scamp_player';

	// Show Player on startup
	if ( $panel_options['show_player'] === 'on' ) {
		$classes .= 'sp-show-player';
	}

	// Show Tracklist on startup
	if ( $panel_options['show_tracklist'] === 'on' ) {
		$classes .= ' sp-show-list';
	}

	?>
	<script type="text/javascript">
		if ( undefined !== window.jQuery ) {
	    	// script dependent on jQuery
	    	var <?php echo esc_js( $js_name ) ?>;
		}
	</script>
	<div id="scamp_player" class="<?php echo esc_attr( $classes ); ?>">
		<?php  
			// Startup Tracklist
			if ( $panel_options['startup_tracklist'] !== 'none' ) {
				$startup_tracklist = scamp_player_get_list( $panel_options['startup_tracklist'] );
				if ( $startup_tracklist ) {
					foreach ( $startup_tracklist as $track ) {
						echo '<a href="' . esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">' . esc_html( $track['title'] ) . '</a>' ."\n";
					}
				}
			}

		?>
	</div>
	<?php
}
add_action( 'wp_footer', 'scamp_player_init' );

endif; // End check for function_exists()
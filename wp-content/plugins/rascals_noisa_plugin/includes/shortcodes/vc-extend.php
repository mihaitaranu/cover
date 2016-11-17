<?php
/**
 * Plugin Name:   NOISA Plugin
 * Theme Author:  Mariusz Rek - Rascals Themes
 * Theme URI:     http://rascals.eu/noisa
 * Author URI:    http://rascals.eu
 * File:      vc-extend.php
 * =========================================================================================================================================
 *
 * @package noisa-plugin
 * @since 1.0.0
 */

// Remove visual composer elements
if ( ! function_exists( 'noisa_remove_element' ) ) {

    function noisa_remove_element() {
        vc_remove_element('vc_accordion_tab');
        vc_remove_element('vc_accordion');
        vc_remove_element('vc_button');
        vc_remove_element('vc_carousel');
        // vc_remove_element('vc_column_text');
        vc_remove_element('vc_cta_button');
        // vc_remove_element('vc_facebook');
        vc_remove_element('vc_button2');
        vc_remove_element('vc_cta_button2');
        vc_remove_element('vc_flickr');
        // vc_remove_element('vc_gallery');
        // vc_remove_element('vc_gmaps');
        // vc_remove_element('vc_googleplus');
        vc_remove_element('vc_images_carousel');
        // vc_remove_element('vc_item');
        // vc_remove_element('vc_items');
        // vc_remove_element('vc_message');
        // vc_remove_element('vc_pie');
        // vc_remove_element('vc_pinterest');
        vc_remove_element('vc_posts_grid');
        vc_remove_element('vc_posts_slider');
        // vc_remove_element('vc_progress_bar');
        // vc_remove_element('vc_raw_html');
        // vc_remove_element('vc_separator');
        // vc_remove_element('vc_single_image');
        vc_remove_element('vc_tab');
        vc_remove_element('vc_tabs');
        // vc_remove_element('vc_teaser_grid');
        // vc_remove_element('vc_text_separator');
        // vc_remove_element('vc_toggle');
        // vc_remove_element('vc_tweetmeme');
        // vc_remove_element('vc_twitter');
        // vc_remove_element('vc_video');
        // vc_remove_element('vc_raw_js');
        vc_remove_element('vc_tour');
        // vc_remove_element("vc_widget_sidebar");
        // vc_remove_element("vc_wp_search");
        // vc_remove_element("vc_wp_meta");
        // vc_remove_element("vc_wp_recentcomments");
        // vc_remove_element("vc_wp_calendar");
        // vc_remove_element("vc_wp_pages");
        // vc_remove_element("vc_wp_tagcloud");
        // vc_remove_element("vc_wp_custommenu");
        // vc_remove_element("vc_wp_text");
        // vc_remove_element("vc_wp_posts");
        // vc_remove_element("vc_wp_links");
        // vc_remove_element("vc_wp_categories");
        // vc_remove_element("vc_wp_archives");
        // vc_remove_element("vc_wp_rss");
        // vc_remove_element("vc_gallery");
        // vc_remove_element("vc_teaser_grid");
        // vc_remove_element("vc_button");
    }
    noisa_remove_element();
}

// Remove visual composer elements
if ( ! function_exists( 'noisa_remove_grid' ) ) {

    function noisa_remove_grid() {

        vc_remove_element("vc_basic_grid");
        vc_remove_element("vc_basic_grid_filter");
        vc_remove_element("vc_masonry_media_grid");
        vc_remove_element("vc_media_grid");
        vc_remove_element("vc_masonry_grid");
        vc_remove_element("vc_grid_item");

        function grid_elements_menu(){
            remove_menu_page( 'edit.php?post_type=vc_grid_item' );
            remove_submenu_page( 'vc-general', 'edit.php?post_type=vc_grid_item' );
            global $submenu;
            // var_dump($submenu);
             unset( $submenu['vc-general'][6] );
        }
        add_action( 'admin_menu', 'grid_elements_menu' );
      
    }
    noisa_remove_grid();
}

// Disable frontend editor
if ( function_exists( 'vc_disable_frontend' ) ){
    $panel_options = get_option( 'noisa_panel_opts' );
    if ( isset( $panel_options ) && isset( $panel_options['vc_frontend'] ) && $panel_options['vc_frontend'] == 'off' ) {
        vc_disable_frontend();
    }
}


// Remove default templates
// add_filter( 'vc_load_default_templates', 'my_custom_template_modify_array' ); // Hook in
// function my_custom_template_modify_array( $data ) {
//     return array(); // This will remove all default templates. Basically you should use native PHP functions to modify existing array and then return it.
// }


/* ----------------------------------------------------------------------

    ROW EXTEND

/* ---------------------------------------------------------------------- */

vc_add_param( "vc_row", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => __( "Content Width",  'noisa_plugin' ),
    "param_name" => "content_width",
    "value" => array(
        "Wide" => "wide",
        "Thin" => "thin"
    ),
    "dependency" => Array( 'element' => "full_width", 'value' => array( 'stretch_row' ) )
));

vc_add_param( "vc_row", array(
    "type" => "checkbox",
    "class" => "",
    "heading" => __( "Overlay",  'noisa_plugin' ),
    "param_name" => "overlay",
    "value" => array( 'Yes' => '0' ),
    "dependency" => Array( 'element' => "full_width", 'value' => array( 'stretch_row', 'stretch_row_content', 'stretch_row_content_no_spaces' ) )
));

vc_add_param( "vc_row", array(
    "type" => "colorpicker",
    "class" => "",
    "heading" => __( "Gradient From:",  'noisa_plugin' ),
    "param_name" => "gradient_from",
    "value" => '#272742',
    "dependency" => Array( 'element' => "overlay", 'value' => array( '0' ) )
));
vc_add_param( "vc_row", array(
    "type" => "colorpicker",
    "class" => "",
    "heading" => __( "Gradient To:",  'noisa_plugin' ),
    "param_name" => "gradient_to",
    "value" => 'rgba(230, 64, 14, 0.72)',
    "dependency" => Array( 'element' => "overlay", 'value' => array( '0' ) )
));
vc_add_param( "vc_row", array(
    "type" => "textfield",
    "class" => "",
    "heading" => __( "Gradient Direction:",  'noisa_plugin' ),
    "param_name" => "gradient_direction",
    "value" => '180',
    "dependency" => Array( 'element' => "overlay", 'value' => array( '0' ) )
));



/* ----------------------------------------------------------------------

    Lead Text

/* ---------------------------------------------------------------------- */

function noisa_vc_lead_text() {

    vc_map( array(
        "name" => __( "Lead Text", 'noisa_plugin' ),
        "base" => "lead",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "description" => '',
        "params" => array(
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => __( "Content", 'noisa_plugin' ),
                "param_name" => "content",
                "value" => "Praesent sit amet lorem mollis, tempor est sit amet, venenatis ligula. Vivamus vestibulum neque sit amet tortor aliquam, ut ornare metus pretium.",
                "description" => "",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_lead_text' );


/* ----------------------------------------------------------------------

    SLIDER

/* ---------------------------------------------------------------------- */

function noisa_vc_slider() {

    global $wpdb;

    /* Get Sliders  */
    $slider = array();
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
    $slider[''] = '';
    if ( $sql_slider ) {
        $count = 0;
        foreach( $sql_slider as $track_post ) {
            $slider[$track_post->post_title] = $track_post->id;
            // $slider = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Slider", 'noisa_plugin' ),
        "base" => "slider",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Select Slider ID", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $slider,
                "description" => __( "Select slider ID.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_slider' );


/* ----------------------------------------------------------------------

    SINGLE TRACK

/* ---------------------------------------------------------------------- */

function noisa_vc_single_track() {

    global $wpdb;

    /* Get Audio Tracks  */
    $tracks = array();
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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Single Track", 'noisa_plugin' ),
        "base" => "track",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Track", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", 'noisa_plugin' ),
                "param_name" => "style",
                "value" => array( 'Normal' => 'normal', 'Compact' => 'compact' ),
                "admin_label" => false,
                "description" => __( "Select player style.", 'noisa_plugin' )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Equalizer (effect)", 'noisa_plugin' ),
                "param_name" => "eq",
                "value" => array( 'Yes, please' => '1' ),
                'std' => '0',
                "admin_label" => false,
                "description" => __( "Display track equalizer (effect).", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
      )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_single_track' );


/* ----------------------------------------------------------------------

    TRACKLIST GRID

/* ---------------------------------------------------------------------- */

function noisa_vc_tracklist_grid() {

    global $wpdb;

    /* Get Audio Tracks  */
    $tracks = array();
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
     $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracklist Grid", 'noisa_plugin' ),
        "base" => "tracklist_grid",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracks Per Row", 'noisa_plugin' ),
                "param_name" => "in_row",
                "value" => array( '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false,
                "description" => __( "Number of visible tracks on screen.", 'noisa_plugin' )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Details", 'noisa_plugin' ),
                "param_name" => "track_meta",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist titles and artists.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Display Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '9999',
                "admin_label" => true,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Button", 'noisa_plugin' ),
                "param_name" => "list_button",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist button.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => __( "Play List", 'noisa_plugin' ),
                "admin_label" => true,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Equalizer (effect)", 'noisa_plugin' ),
                "param_name" => "eq",
                "value" => array( 'Yes, please' => '1' ),
                'std' => '0',
                "admin_label" => false,
                "description" => __( "Display track equalizer (effect).", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_tracklist_grid' );


/* ----------------------------------------------------------------------

    TRACKS CAROUSEL

/* ---------------------------------------------------------------------- */

function noisa_vc_tracks_carousel() {

    global $wpdb;

    /* Get Audio Tracks  */
    $tracks = array();
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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracks Carousel", 'noisa_plugin' ),
        "base" => "tracks_carousel",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "description" => '',
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Visible Tracks", 'noisa_plugin' ),
                "param_name" => "visible_items",
                "value" => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
                "admin_label" => false,
                "description" => __( "Number of visible tracks on screen.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false,
                "description" => __( "Number of visible tracks on screen.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", 'noisa_plugin' ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to release page.", 'noisa_plugin' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => __( "View More", 'noisa_plugin' ),
                "admin_label" => true,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Equalizer (effect)", 'noisa_plugin' ),
                "param_name" => "eq",
                "value" => array( 'Yes, please' => '1' ),
                'std' => '0',
                "admin_label" => false,
                "description" => __( "Display track equalizer (effect).", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_tracks_carousel' );


/* ----------------------------------------------------------------------

    TRACKLIST

/* ---------------------------------------------------------------------- */

function noisa_vc_tracklist() {

    global $wpdb;

    /* Get Audio Tracks  */
    $tracks = array();
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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracklist", 'noisa_plugin' ),
        "base" => "tracklist",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", 'noisa_plugin' )
            ),
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", 'noisa_plugin' ),
                "param_name" => "style",
                "value" => array( 'Normal' => 'normal', 'Compact' => 'compact', 'Simple' => 'simple' ),
                "admin_label" => false,
                "description" => __( "Select player style.", 'noisa_plugin' )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Button", 'noisa_plugin' ),
                "param_name" => "list_button",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist button.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => __( "Play List", 'noisa_plugin' ),
                "admin_label" => true,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Equalizer (effect)", 'noisa_plugin' ),
                "param_name" => "eq",
                "value" => array( 'Yes, please' => '1' ),
                'std' => '0',
                "admin_label" => false,
                "description" => __( "Display track equalizer (effect).", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_tracklist' );


/* ----------------------------------------------------------------------

    SINGLE ALBUM

/* ---------------------------------------------------------------------- */

function noisa_vc_single_album() {

    global $wpdb;

    /* Get Audio Tracks  */
    $tracks = array();
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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Single Album", 'noisa_plugin' ),
        "base" => "single_album",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Track", 'noisa_plugin' ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Album Title", 'noisa_plugin' ),
                "param_name" => "album_title",
                "value" => '',
                "admin_label" => true,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Album Artists", 'noisa_plugin' ),
                "param_name" => "album_artists",
            ),
            array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __( "Album Cover", 'noisa_plugin' ),
                "param_name" => "album_cover"
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Equalizer (effect)", 'noisa_plugin' ),
                "param_name" => "eq",
                "value" => array( 'Yes, please' => '1' ),
                'std' => '0',
                "admin_label" => false,
                "description" => __( "Display track equalizer (effect).", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
      )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_single_album' );


/* ----------------------------------------------------------------------

    TWITTER LIST

/* ---------------------------------------------------------------------- */

function noisa_vc_tweets_list() {

    // Get icons
    if ( function_exists( 'noisa_get_icons' ) ) {
        $icons  = noisa_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Tweets List", 'noisa_plugin' ),
        "base" => "tweets_list",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Username", 'noisa_plugin' ),
                "param_name" => "username",
                "value" => "",
                "description" => "Twitter username.",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Key", 'noisa_plugin' ),
                "param_name" => "api_key",
                "value" => "",
                "description" => 'Twitter app API Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Secret", 'noisa_plugin' ),
                "param_name" => "api_secret",
                "value" => "",
                "description" => 'Twitter app API Secret Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Replies", 'noisa_plugin' ),
                "param_name" => "replies",
                "value" => array(
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => "Show Twitter replies."
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Number of Tweets", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => array( "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"
                ),
                "description" => "Number of Tweets."
            )
           
      )
    ));
}

add_action( 'vc_before_init', 'noisa_vc_tweets_list' );


/* ----------------------------------------------------------------------

    TWITTER SLIDER

/* ---------------------------------------------------------------------- */

function noisa_vc_tweets_slider() {

    // Get icons
    if ( function_exists( 'noisa_get_icons' ) ) {
        $icons  = noisa_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Tweets Slider", 'noisa_plugin' ),
        "base" => "tweets_slider",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
           array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Background Color", 'noisa_plugin' ),
                "param_name" => "bg_color",
                "value" => array(
                    "Light" => "light-bg",
                    "Dark" => "dark-bg"
                ),
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Username", 'noisa_plugin' ),
                "param_name" => "username",
                "value" => "",
                "description" => "Twitter username.",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Key", 'noisa_plugin' ),
                "param_name" => "api_key",
                "value" => "",
                "description" => 'Twitter app API Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Secret", 'noisa_plugin' ),
                "param_name" => "api_secret",
                "value" => "",
                "description" => 'Twitter app API Secret Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Replies", 'noisa_plugin' ),
                "param_name" => "replies",
                "value" => array(
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => "Show Twitter replies."
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Number of Tweets", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => array( "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"
                ),
                "description" => "Number of Tweets."
            )
           
      )
    ));
}

add_action( 'vc_before_init', 'noisa_vc_tweets_slider' );


/* ----------------------------------------------------------------------

    BUTTONS

/* ---------------------------------------------------------------------- */

function noisa_vc_buttons() {

    vc_map( array(
        "name" => __( "Buttons", 'noisa_plugin' ),
        "base" => "buttons",
        "as_parent" => array( 'only' => 'button' ),
        "content_element" => true,
        "show_settings_on_create" => false,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "js_view" => 'VcColumnView',
        "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Align", 'noisa_plugin' ),
                    "param_name" => "align",
                    'std' => 'text-left',
                    "value" => array( 'Center' => 'text-center', 'Left' => 'text-left', 'Right' => 'text-right' ),
                    "admin_label" => false
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __( "Extra class name", 'noisa_plugin' ),
                    "param_name" => "classes",
                    "value" => '',
                    "admin_label" => true,
                    "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
                )
            )
        )  
    );
}
add_action( 'vc_before_init', 'noisa_vc_buttons' );

function noisa_vc_button() {

    // Get icons
    if ( function_exists( 'noisa_get_icons' ) ) {
        $icons  = noisa_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Button", 'noisa_plugin' ),
        "base" => "button",
        "content_element" => true,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", 'noisa_plugin' ),
                "param_name" => "title",
                "value" => 'Button Title',
                "admin_label" => true,
                "description" => __( "Button title.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "link",
                "value" => '#',
                "admin_label" => false,
                "description" => __( "Button LINK.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Size", 'noisa_plugin' ),
                "param_name" => "size",
                "value" => array(  'Large' => 'btn-big', 'Medium' => 'btn-medium', 'Small' => 'btn-small' ),
                "std" => 'btn-medium',
                "admin_label" => false,
                "description" => __( "Select button size.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", 'noisa_plugin' ),
                "param_name" => "style",
                "value" => array(  'Default' => 'default-btn', 'Stamp' => 'stamp-btn' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon", 'noisa_plugin' ),
                "param_name" => "icon",
                "value" => $icons,
                "admin_label" => false,
                "description" => __( "Select icon.", 'noisa_plugin' )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "New Window", 'noisa_plugin' ),
                "param_name" => "target",
                "value" => array( 'New window' => '0' ),
                "admin_label" => false,
                "description" => __( "Open link in new window/tab.", 'noisa_plugin' )
            ),
        )
   ));
}

add_action( 'vc_before_init', 'noisa_vc_button' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_buttons extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_button extends WPBakeryShortCode {
    }
}


/* ----------------------------------------------------------------------

    PRICING COLUMN

/* ---------------------------------------------------------------------- */

function noisa_vc_pricing_column() {

    vc_map( array(
        "name" => __( "Pricing Column", 'noisa_plugin' ),
        "base" => "pricing_column",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", 'noisa_plugin' ),
                "param_name" => "title",
                "value" => __( "Basic Plan", 'noisa_plugin' ),
                "description" => "",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Price", 'noisa_plugin' ),
                "param_name" => "price",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Currency", 'noisa_plugin' ),
                "param_name" => "currency",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Price Period", 'noisa_plugin' ),
                "param_name" => "period",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "link",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Target", 'noisa_plugin' ),
                "param_name" => "target",
                "value" => array(
                    "" => "",
                    "Self" => "_self",
                    "Blank" => "_blank",
                    "Parent" => "_parent"
                ),
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Text", 'noisa_plugin' ),
                "param_name" => "button_text",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Important", 'noisa_plugin' ),
                "param_name" => "important",
                "value" => array(
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => ""
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Content", 'noisa_plugin' ),
                "param_name" => "list",
                "value" => "2x option 1,Free option 2,Unlimited option 3,Unlimited option 4,1x option 5",
                "description" => ""
            )
      )
    ));
}

add_action( 'vc_before_init', 'noisa_vc_pricing_column' );


/* ----------------------------------------------------------------------

    ICON COLUMN

/* ---------------------------------------------------------------------- */

function noisa_vc_icon_column() {

    // Get icons
    if ( function_exists( 'noisa_get_icons' ) ) {
        $icons  = noisa_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Icon Column", 'noisa_plugin' ),
        "base" => "icon_column",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", 'noisa_plugin' ),
                "param_name" => "icon_title",
                "value" => "",
                "description" => "",
                "admin_label" => true
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Bolder Title", 'noisa_plugin' ),
                "param_name" => "bold_title",
                "value" => array( 'Yes, please' => '0' ),
                "admin_label" => false,
                "description" =>''
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon", 'noisa_plugin' ),
                "param_name" => "icon",
                "value" => $icons,
                "admin_label" => false,
                "description" => __( "Select icon.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon Place", 'noisa_plugin' ),
                "param_name" => "icon_place",
                "value" => array(
                    "Left" => "icon_left",
                    "Right" => "icon_right",
                    'Top' => 'icon_top',
                    'Top (Dark Background)' => 'icon_top_dark'
                ),
                "description" => ""
            ),
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => __( "Content", 'noisa_plugin' ),
                "param_name" => "content",
                "value" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Button title.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "button_link",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Button LINK.", 'noisa_plugin' )
            )
      )
    ));
}

add_action( 'vc_before_init', 'noisa_vc_icon_column' );


/* ----------------------------------------------------------------------

    DETAILS LIST

/* ---------------------------------------------------------------------- */

function noisa_vc_details_list() {

    vc_map( array(
        "name" => __( "Details List", 'noisa_plugin' ),
        "base" => "details_list",
        "as_parent" => array( 'only' => 'detail' ),
        "content_element" => true,
        "show_settings_on_create" => false,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "js_view" => 'VcColumnView',
        "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __( "Extra class name", 'noisa_plugin' ),
                    "param_name" => "classes",
                    "value" => '',
                    "admin_label" => true,
                    "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
                )
            )
        ) 
    );
}

add_action( 'vc_before_init', 'noisa_vc_details_list' );

function noisa_vc_detail() {

    vc_map( array(
        "name" => __( "Detail", 'noisa_plugin' ),
        "base" => "detail",
        "as_child" => array( 'only' => 'details_list' ),
        "content_element" => true,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", 'noisa_plugin' ),
                "param_name" => "label",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Texts", 'noisa_plugin' ),
                "param_name" => "value",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Text as link", 'noisa_plugin' ),
                "param_name" => "text_link",
                "value" => array( 'Yes' => '0' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "URL", 'noisa_plugin' ),
                "param_name" => "url",
                "value" => '',
                "admin_label" => true,
                "dependency" => Array( 'element' => "text_link", 'value' => array( '0' ) )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "New Window", 'noisa_plugin' ),
                "param_name" => "target",
                "value" => array( 'New window' => '0' ),
                "admin_label" => false,
                "dependency" => Array( 'element' => "text_link", 'value' => array( '0' ) )
            ),
      )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_detail' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_details_list extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_detail extends WPBakeryShortCode {
    }
}


/* ----------------------------------------------------------------------

    GOOGLE MAPS

/* ---------------------------------------------------------------------- */

function noisa_vc_google_maps() {

    // Get icons
    if ( function_exists( 'noisa_get_icons' ) ) {
        $icons  = noisa_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Google Maps", 'noisa_plugin' ),
        "base" => "google_maps",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Height", 'noisa_plugin' ),
                "param_name" => "height",
                "value" => __( "400", 'noisa_plugin' ),
                "description" => "Map height (px).",
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Address", 'noisa_plugin' ),
                "param_name" => "address",
                "value" => __( "Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia", 'noisa_plugin' ),
                "description" => 'Map address.',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Depth", 'noisa_plugin' ),
                "param_name" => "depth",
                "value" => __( "15", 'noisa_plugin' ),
                "description" => 'Zoom depth.',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Zoom Control", 'noisa_plugin' ),
                "param_name" => "zoom_control",
                "value" => array(
                    "No" => "false",
                    "Yes" => "true"
                ),
                "description" => "Zoom control."
            ),
           array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Scroll Whell", 'noisa_plugin' ),
                "param_name" => "scrollwheel",
                "value" => array(
                    "No" => "false",
                    "Yes" => "true"
                ),
                "description" => "Mouse scroll whell."
            )
           
      )
    ));
}
add_action( 'vc_before_init', 'noisa_vc_google_maps' );


/* ----------------------------------------------------------------------

    POSTS LIST

/* ---------------------------------------------------------------------- */

function noisa_vc_posts_list() {

    vc_map( array(
        "name" => __( "Posts List", 'noisa_plugin' ),
        "base" => "posts_list",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "description" => '',
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '10',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Post IDs", 'noisa_plugin' ),
                "param_name" => "posts_in",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Fill this field with posts IDs separated by commas (,), to retrieve only them.", 'noisa_plugin' )
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Categories", 'noisa_plugin' ),
                "param_name" => "categories_in",
                "value" => "",
                "description" => "Fill this field with categories names divided by linebreaks (Enter), to retrieve only them."
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", 'noisa_plugin' ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to blog page.", 'noisa_plugin' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_posts_list' );


/* ----------------------------------------------------------------------

    RELEASES GRID

/* ---------------------------------------------------------------------- */

function noisa_vc_releases() {

    vc_map( array(
        "name" => __( "Releases GRID", 'noisa_plugin' ),
        "base" => "releases_grid",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(

            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_releases_artists'
                ),
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_releases_artists' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Order By", 'noisa_plugin' ),
                "param_name" => "order",
                "value" => array( 'Custom' => 'menu_order', 'Title' => 'title', 'Date' => 'date' ),
                "admin_label" => false,
                "description" => __( "Select menu order.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Items Per Row", 'noisa_plugin' ),
                "param_name" => "in_row",
                'std' => '3',
                "value" => array( '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "url",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Last item will be a link with items counter.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_releases' );


/* ----------------------------------------------------------------------

    RELEASES CAROUSEL

/* ---------------------------------------------------------------------- */

function noisa_vc_releases_carousel() {

    vc_map( array(
        "name" => __( "Releases Carousel", 'noisa_plugin' ),
        "base" => "releases_carousel",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "description" => '',
        "params" => array(
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_releases_artists'
                ),
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_releases_artists' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Order By", 'noisa_plugin' ),
                "param_name" => "order",
                "value" => array( 'Custom' => 'menu_order', 'Title' => 'title', 'Date' => 'date' ),
                "admin_label" => false,
                "description" => __( "Select menu order.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Visible Releases", 'noisa_plugin' ),
                "param_name" => "visible_items",
                "value" => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
                "admin_label" => false,
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", 'noisa_plugin' ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to release page.", 'noisa_plugin' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => __( "View More", 'noisa_plugin' ),
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_releases_carousel' );


/* ----------------------------------------------------------------------

    ARTISTS GRID

/* ---------------------------------------------------------------------- */

function noisa_vc_artists() {

    vc_map( array(
        "name" => __( "Artists GRID", 'noisa_plugin' ),
        "base" => "artists_grid",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(

           array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_events_artists',
                    'By Categories' => 'noisa_events_cats'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_artists_genres', 'noisa_events_cats' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Order By", 'noisa_plugin' ),
                "param_name" => "order",
                "value" => array( 'Custom' => 'menu_order', 'Title' => 'title', 'Date' => 'date' ),
                "admin_label" => false,
                "description" => __( "Select menu order.", 'noisa_plugin' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Items Per Row", 'noisa_plugin' ),
                "param_name" => "in_row",
                'std' => '3',
                "value" => array( '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Disable Artists Links", 'noisa_plugin' ),
                "param_name" => "disable_artists_links",
                'std' => '',
                "value" => array( 'Yes' => '0' ),
                "admin_label" => false,
                "description" => __( "Disable artists links.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "url",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Last item will be a link with items counter.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_artists' );


/* ----------------------------------------------------------------------

    ARTISTS CAROUSEL

/* ---------------------------------------------------------------------- */

function noisa_vc_artists_carousel() {

    vc_map( array(
        "name" => __( "Artists Carousel", 'noisa_plugin' ),
        "base" => "artists_carousel",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "description" => '',
        "params" => array(
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Genres' => 'noisa_artists_genres'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_artists_genres' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Order By", 'noisa_plugin' ),
                "param_name" => "order",
                "value" => array( 'Custom' => 'menu_order', 'Title' => 'title', 'Date' => 'date' ),
                "admin_label" => false,
                "description" => __( "Select menu order.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Visible Tracks", 'noisa_plugin' ),
                "param_name" => "visible_items",
                "value" => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", 'noisa_plugin' ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to artists page.", 'noisa_plugin' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Title", 'noisa_plugin' ),
                "param_name" => "button_title",
                "value" => __( "View More", 'noisa_plugin' ),
                "admin_label" => false,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Show Pagination", 'noisa_plugin' ),
                "param_name" => "pagination",
                'std' => '0',
                "value" => array( 'Yes' => '0' ),
                "admin_label" => false,
                "description" => __( "Show pagination.", 'noisa_plugin' )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", 'noisa_plugin' ),
                "param_name" => "classes",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_artists_carousel' );


/* ----------------------------------------------------------------------

    EVENTS

/* ---------------------------------------------------------------------- */

function noisa_vc_events() {

    vc_map( array(
        "name" => __( "Events", 'noisa_plugin' ),
        "base" => "events",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(

            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Event Type", 'noisa_plugin' ),
                "param_name" => "event_type",
                "value" => array( 
                    'Future Events' => 'future-events', 
                    'Past Events' => 'past-events',
                    'All Events' => 'all-events'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display Type", 'noisa_plugin' ),
                "param_name" => "display_type",
                "value" => array( 
                    'Grid' => 'grid', 
                    'List' => 'list'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_events_artists'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_events_artists' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Items Per Row", 'noisa_plugin' ),
                "param_name" => "in_row",
                'std' => '3',
                "value" => array( '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Thumb Style", 'noisa_plugin' ),
                "param_name" => "thumb_style",
                "value" => array( 'Default' => 'default', 'Inverted' => 'inverted' ),
            ),
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_events' );


/* ----------------------------------------------------------------------

    GALLERY ALBUMS

/* ---------------------------------------------------------------------- */

function noisa_vc_gallery() {

    vc_map( array(
        "name" => __( "Gallery Albums", 'noisa_plugin' ),
        "base" => "gallery_albums",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(

            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_gallery_artists'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_gallery_artists' ) )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Items Per Row", 'noisa_plugin' ),
                "param_name" => "in_row",
                'std' => '3',
                "value" => array( '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Gap", 'noisa_plugin' ),
                "param_name" => "gap",
                "value" => array( 'Small Gap' => 'no-gap', 'Medium Gap' => 'medium-gap' ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "url",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Last item will be a link with items counter.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_gallery' );


/* ----------------------------------------------------------------------

    GALLERY Images

/* ---------------------------------------------------------------------- */

function noisa_vc_gallery_images() {
    global $wpdb;

     /* Get Sliders  */
    $albums = array();
    $albums_post_type = 'noisa_gallery';
    $albums_query = $wpdb->prepare(
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
        $albums_post_type
    );

    $sql_albums = $wpdb->get_results( $albums_query );
    $albums[''] = '';
    if ( $sql_albums ) {
        $count = 0;
        foreach( $sql_albums as $track_post ) {
            $albums[$track_post->post_title] = $track_post->id;
            // $albums = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Gallery Images", 'noisa_plugin' ),
        "base" => "gallery_images",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display Images from", 'noisa_plugin' ),
                "param_name" => "album_id",
                "value" => $albums
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", 'noisa_plugin' ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Link", 'noisa_plugin' ),
                "param_name" => "url",
                "value" => '0',
                "admin_label" => false,
                "description" => __( "Last item will be a link with items counter.", 'noisa_plugin' )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_gallery_images' );


/* ----------------------------------------------------------------------

    EVENT COUNTDOWN

/* ---------------------------------------------------------------------- */

function noisa_vc_event_countdown() {

    // Get events 
    $future_tax = array(
        array(
           'taxonomy' => 'noisa_event_type',
           'field' => 'slug',
           'terms' => 'future-events'
          )
    );
    $future_events = get_posts( array(
        'post_type' => 'noisa_events',
        'showposts' => -1,
        'tax_query' => $future_tax,
        'orderby' => 'meta_value',
        'meta_key' => '_event_date_start',
        'order' => 'ASC'
    ));

    $events = array();
    foreach( $future_events as $event ) {
        $events[$event->post_title] = $event->ID;
    }

    vc_map( array(
        "name" => __( "Event Countdown", 'noisa_plugin' ),
        "base" => "event_countdown",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", 'noisa_plugin' ),
                "param_name" => "style",
                "value" => array( 'Compact' => 'compact', 'Big' => 'big' ),
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Display", 'noisa_plugin' ),
                "param_name" => "display_by",
                "value" => array( 
                    'All' => 'all', 
                    'By Artists' => 'noisa_events_artists'
                ),
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Taxonomies", 'noisa_plugin' ),
                "param_name" => "terms",
                "admin_label" => false,
                "description" => __( "Type slugs separated by commas. ex: dj-nando,general-midi,noisa", 'noisa_plugin' ),
                "dependency" => Array( 'element' => "display_by", 'value' => array( 'noisa_events_artists' ) )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Select Custom Event", 'noisa_plugin' ),
                "param_name" => "custom_event",
                "value" => array( 'Yes, please' => '0' ),
                'std' => '',
                "admin_label" => false,
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Custom Event ID", 'noisa_plugin' ),
                "param_name" => "custom_event_id",
                "value" => $events,
                "admin_label" => true,
                "dependency" => Array( 'element' => "custom_event", 'value' => array( '0' ) )
            )
        ),
   ) );
}

add_action( 'vc_before_init', 'noisa_vc_event_countdown' );


/* ----------------------------------------------------------------------

    TIMELINE

/* ---------------------------------------------------------------------- */

function noisa_vc_time_line() {

    vc_map( array(
        "name" => __( "Timeline", 'noisa_plugin' ),
        "base" => "time_line",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', 'noisa_plugin' ),
        "params" => array(
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Content", 'noisa_plugin' ),
                "param_name" => "list",
                "value" => "01:30 AM - 03:00 AM|Lady C,11:30 PM - 01:30 AM|Gorrilla,10:30 PM - 11:30 PM|Vibeman,09:00 PM - 10:30 PM|DJ Nando,08:00 PM - 09:00 PM|General Midi",
                "description" => ""
            )
      )
    ));
}

add_action( 'vc_before_init', 'noisa_vc_time_line' );
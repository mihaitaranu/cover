<?php
/**
 * Plugin Name:     NOISA Plugin
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/noisa
 * Author URI:      http://rascals.eu
 * File:            shortcodes.php
 * =========================================================================================================================================
 *
 * @package noisa-plugin
 * @since 1.0.0
 */


/* Global shortcode ID */
global $noisa_sid;

$noisa_sid = 0;


/* ----------------------------------------------------------------------
    Color

    Example Usage:
    [styles classes="" ] ...content... [/styles]
/* ---------------------------------------------------------------------- */
function noisa_styles( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'classes'     => ''
    ), $atts));

    return '<span class="' . esc_attr( $classes ) . '" >' . do_shortcode( $content ) . '</span>';
}
add_shortcode( 'styles', 'noisa_styles' );


/* ----------------------------------------------------------------------
    Weight

    Example Usage:
    [weight size="100" ] ...content... [/weight]
/* ---------------------------------------------------------------------- */
function noisa_weight( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'weight'     => '100'
    ), $atts));

    return '<span class="weight-' . esc_attr( $weight ) . '" >' . do_shortcode( $content ) . '</span>';
}
add_shortcode( 'weight', 'noisa_weight' );


/* ----------------------------------------------------------------------
    Circle Button

    Example Usage:
    [circle_button link="#" icon="twitter" target="_self" classes=""]
/* ---------------------------------------------------------------------- */
function noisa_circle_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'    => '#',
        'icon'    => 'twitter',
        'target'  => '_self',
        'classes' => ''
    ), $atts));
   return '<a class="circle-button ' . esc_attr( $classes ) . '" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-' . esc_attr( $icon ) . '"></i></a>';
}
add_shortcode( 'circle_button', 'noisa_circle_button' );


/* ----------------------------------------------------------------------
    Lead

    Example Usage:
    [lead classes=""] ... TEXT HERE ... [/lead]
/* ---------------------------------------------------------------------- */
function noisa_lead( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'classes' => ''
    ), $atts));
   return '<div class="lead ' . esc_attr( $classes ) . '">' . $content . '</div>';
}
add_shortcode( 'lead', 'noisa_lead' );


/* ----------------------------------------------------------------------
    SLIDER

    Example Usage:
    [slider id="1"]
    
    Attributes:
    id - Slider post id. Default: 0 (integer).

/* ---------------------------------------------------------------------- */
function noisa_slider( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'id'   => 0,
        'size' => 'full'
    ), $atts));

    $output = '';

    if ( $id == 0 ) {
        return false;
    }
    $noisa_sid++;

    // Slider Settings

    // Slider navigation
    $slider_nav = get_post_meta( $id, '_slider_nav', true );
    if ( $slider_nav && $slider_nav === 'on' ) {
        $slider_nav = 'true';
    } else {
        $slider_nav = 'false';
    }

    // Slider pagination
    $slider_pagination = get_post_meta( $id, '_slider_pagination', true );
    if ( $slider_pagination && $slider_pagination === 'on' ) {
        $slider_pagination = 'true';
    } else {
        $slider_pagination = 'false';
    }

    // Slider speed
    $slider_speed = get_post_meta( $id, '_slider_speed', true );

    // Slider pause time
    $slider_pause_time = get_post_meta( $id, '_slider_pause_time', true );
    if ( ! $slider_pause_time && $slider_pause_time === '0' ) {
        $slider_pause_time = 'false';
    }
    
    $output .= '<div id="content-slider-id-' . esc_attr( $noisa_sid ) . '" class="content-slider clearfix" data-slider-nav="' . esc_attr( $slider_nav ) . '" data-slider-pagination="' . esc_attr( $slider_pagination ) . '" data-slider-speed="' . esc_attr( $slider_speed ) . '" data-slider-pause-time="' . esc_attr( $slider_pause_time ) . '">';

    /* Images ids */
    $images_ids = get_post_meta( $id, '_custom_slider', true );

    if ( ! $images_ids || $images_ids == '' ) {
         '<p class="message error">' . __( 'Slider error: Slider has no pictures or doesn\'t exists.', 'noisa_plugin' ) . '</p>';
    }

    $count = 0;
    $ids = explode( '|', $images_ids );
    $defaults = array(
        'title'    => '',
        'subtitle' => '',
        'crop'     => 'c'
    );

    /* Start Loop */
    foreach ( $ids as $image_id ) {

        // Vars 
        $title = '';
        $subtitle = '';

        // Get image data
        $image_att = wp_get_attachment_image_src( $image_id );

        if ( ! $image_att[0] ) {
            continue;
        }
        
        /* Count */
        $count++;

        /* Get image meta */
        $image = get_post_meta( $id, '_custom_slider_' . $image_id, true );

        /* Add default values */
        if ( isset( $image ) && is_array( $image ) ) {
            $image = array_merge( $defaults, $image );
        } else { 
            $image = $defaults;
        }

        /* Add image src to array */
        $temp_src = wp_get_attachment_image_src( $image_id, $size );
        $image['src'] = $temp_src[0];

        $output .= '<div class="slide">';

        if ( $image['title'] !== '' || $image['subtitle'] !== '' ) {
            $output .= '<div class="content-captions">';
                if ( $image['title'] !== '' ) {
                    $output .= '<span class="caption-title">' . $image['title'] . '</span>';
                }
                if ( $image['subtitle'] !== '' ) {
                    $output .= '<span class="caption-subtitle">' . $image['subtitle'] . '</span>';
                }
            $output .= '</div>';
        }
        $output .= '<div class="image"><img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( __( 'Slider Image', 'noisa_plugin' ) ) . '"></div>';

        $output .= '</div>';

    } // End foreach

    $output .= '</div>';

    return $output;
}
add_shortcode( 'slider', 'noisa_slider' );


/* ----------------------------------------------------------------------
    TRACKLIST GRID

    Example Usage:
    [tracklist_grid id="1" in_row="4" eq="0" list_button="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    eq - Show EQ. Default: 0 (integer).
    gap - Gap class Default: no-gap'.
    limit - Display limit: 999;
    in_row - 1,2,3,4,5. Default: 3 (string).
    track_meta - 1,0. Default: 1 (string).
    list_button - 1,0. Default: 0 (string).
    button_title - title of button.
    list_button_action - sp-play-list, sp-add-list. Default: sp-play-list (string).
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).
    classes - 

/* ---------------------------------------------------------------------- */
function noisa_tracklist_grid( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'id'                 => 0,
        'in_row'             => '2',
        'track_meta'         => '0',
        'list_button'        => '0',
        'eq'                 => '0',
        'gap'                => 'no-gap',
        'limit'              => '999',
        'list_button_action' => 'sp-play-list',
        'track_action'       => 'sp-play-track',
        'button_title'       => __( 'Play List', 'noisa_plugin'),
        'classes'            => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $noisa_sid++;
    $limit = (int)$limit;
    $count = 1;
    $tracklist_grid = scamp_player_get_list( $id );

    if ( $track_meta == '0' ) {
        $track_meta = 'hidden';
    } else {
        $track_meta = '';
    }

    if ( $eq == '1' ) {
        $eq = '<div class="eq"><div class="bar-init"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>';
    } else {
        $eq = '';
    }

    $output .= '<div class="tracks-grid-wrap ' . esc_attr( $classes ) . '">';
    $output .= '<div id="tracklist-grid-' . esc_attr( $noisa_sid ) . '" class="sp-list tracklist-grid">' ."\n";
    foreach ( $tracklist_grid as $track ) {
        if ( ! $track['cover'] || $track['cover'] == '' ) {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <div class="tracks-grid-' . esc_attr( $in_row ) . '-col">
                <div class="tracks-grid-item  ' . esc_attr( $gap ) . '">
                    <a class="track ' .  esc_attr( $track_action ) . '" href="' .  esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '" title="' . esc_attr( $track['title'] ) . ' <em> - ' . esc_attr( $track['artists'] ) . '</em>">
                        <img class="track-cover" src="' . esc_attr( $track['cover_full'] ) . '" alt="' . esc_attr( __( 'Cover Image', 'noisa_plugin') ) . '">
                        <span class="track-status"></span>
                       '. $eq .'
                        <span class="track-meta ' . esc_attr( $track_meta ) . '">
                            <span class="track-meta-inner">
                                <span class="track-title">' . $track['title'] . '</span>
                                <span class="track-artists">' . $track['artists'] . '</span>
                            </span>
                        </span>
                    </a>
                </div>';
        $output .= '</div>';

        if ( $count >= $limit ) {
            break;
            return false;
        }
        $count++;


    }

    $output .= '</div>' ."\n";

    if ( $list_button == '1' ) {
        $output .= '<a class="list-btn btn btn-icon ' . esc_attr( $list_button_action ) . '" data-id="tracklist-grid-' . esc_attr( $noisa_sid ) . '" ><span class="icon icon-play2"></span>' . $button_title . '</a>';
    }
    $output .= '</div>' ."\n";

   return $output;
}
add_shortcode( 'tracklist_grid', 'noisa_tracklist_grid' );


/* ----------------------------------------------------------------------
    TRACKS CAROUSEL

    Example Usage:
    [tracks_carousel title="Recent Tracks" id="1" limit="6" visible_items="4" button_link="#" eq="0"]

/* ---------------------------------------------------------------------- */
function noisa_tracks_carousel( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'id'                 => 0,
        'visible_items'      => '1',
        'list_button'        => '0',
        'eq'                 => '0',
        'gap'                => 'no-gap',
        'list_button_action' => 'sp-play-list',
        'track_action'       => 'sp-play-track',
        'button_link'        => '',
        'button_title'       => __( 'View More', 'noisa_plugin'),
        'classes'            => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $noisa_sid++;
    $tracks_carousel = scamp_player_get_list( $id );

     if ( $eq == '1' ) {
        $eq = '<div class="eq"><div class="bar-init"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>';
    } else {
        $eq = '';
    }

    $output .= '<div class="tracks-carousel-wrap ' . $classes . '">';
    $output .= '<div id="tracks-carousel-id' . esc_attr( $noisa_sid ) . '" class="carousel-slider carousel-tracks-slider" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false" data-items="' . $visible_items . '">';
    foreach ( $tracks_carousel as $track ) {
       if ( ! $track['cover'] || $track['cover'] == '' ) {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
                    <a class="track thumb-desc ' .  esc_attr( $track_action ) . ' '  . esc_attr( $gap ) . ' owl-link" href="' .  esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                        <img class="track-cover" src="' . esc_attr( $track['cover_full'] ) . '" alt="' . esc_attr( __( 'Cover Image', 'noisa_plugin') ) . '">
                        <span class="track-meta">
                            <span class="track-meta-inner">
                                <span class="track-title">' . $track['title'] . '</span>
                                <span class="track-artists">' . $track['artists'] . '</span>
                            </span>
                        </span>
                        <span class="track-status"></span>
                        '. $eq .'
                    </a>';
    }

    $output .= '</div>'; // carousel;

    if ( $button_link != '' ) {
        $output .= '<div class="button-position"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . $button_title . '</a></div>';
    }

    $output .= '</div>'; // wrap;

   return $output;
}
add_shortcode( 'tracks_carousel', 'noisa_tracks_carousel' );


/* ----------------------------------------------------------------------
    TRACKLIST

    Example Usage:
    [tracklist id="1" style="normal" list_button="0" eq="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    style - normal, compact, simple. Default: normal (string).
    list_button - 1,0. Default: 1 (string).
    list_button_action - sp-play-list, sp-add-list. Default: sp-play-list (string).
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).

/* ---------------------------------------------------------------------- */
function noisa_tracklist( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
         'id'                 => 0,
         'style'              => 'normal',
         'list_button'        => '0',
         'eq'                 => '0',
         'list_button_action' => 'sp-play-list',
         'track_action'       => 'sp-play-track',
         'button_title'       => __( 'Play List', 'noisa_plugin'),
         'classes'              => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }

    if ( $eq == '1' ) {
        $eq = '<div class="eq"><div class="bar-init"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>';
    } else {
        $eq = '';
    }

    $noisa_sid++;
    $tracklist = scamp_player_get_list( $id );

    $output .= '<div class="tracklist-wrap ' . esc_attr( $classes ) . '">';
    $output .= '<ol id="tracklist-' . esc_attr( $noisa_sid ) . '" class="sp-list tracklist ' . esc_attr( $style ) . '">' ."\n";

    $count = 0;

    // Tracklist style: Compact or normal
    if ( $style == 'normal' || $style == 'compact' ) {

        foreach ( $tracklist as $track ) {
           if ( ! $track['cover'] || $track['cover'] == '' ) {
                $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
            }
            $count ++;
            $output .= '
                <li>
                    <div class="single-track ' . esc_attr( $style ) . '">
                    <span class="track-nr">' . sprintf( "%02d", $count ) . '</span>
                    <div class="track-wrap">
                    <a href="' .  esc_url( $track['url'] ) . '" class="track ' .  esc_attr( $track_action ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                        <img class="track-cover" src="' . esc_url( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', 'noisa_plugin') ) . '">
                        <span class="track-status"></span><span class="track-title hidden">' . $track['title'] . '</span>
                        '. $eq .'
                    </a>
                    </div>
                    
                    <span class="track-meta">
                        <span class="track-title">' . $track['title'] . '</span>
                        <span class="track-artists">' . $track['artists'] . '</span>';

            if ( $style == 'normal' ) {
                $output .= '<span class="track-buttons">' . do_shortcode ( $track['links'] ) . '</span>';
            }

            $output .= '</span>';
            $output .= '</div>';
            $output .= '</li>';
        }

    // Simple style
    } elseif ( $style == 'simple' ) {
        foreach ( $tracklist as $track ) {
           if ( ! $track['cover'] || $track['cover'] == '' ) {
                $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
            }
            $count ++;
            $output .= '
            <li>
                <a href="' .  esc_url( $track['url'] ) . '" class="simple-track ' .  esc_attr( $track_action ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                    <span class="track-nr">' . sprintf( "%02d", $count ) . '</span>
                    <span class="action"></span>
                    <span class="title">' . $track['title'] . '</span>
                    <span class="artists">' . $track['artists'] . '</span>
                </a>   
            </li>';
        }
    }

    $output .= '</ol>' ."\n";

    if ( $list_button == '1' ) {
        $output .= '<a class="list-btn btn btn-icon ' . esc_attr( $list_button_action ) . '" data-id="tracklist-' . esc_attr( $noisa_sid ) . '" ><span class="icon icon-play2"></span>' . $button_title . '</a>';
    }
    $output .= '</div>' ."\n";

   return $output;
}
add_shortcode( 'tracklist', 'noisa_tracklist' );


/* ----------------------------------------------------------------------
    SINGLE TRACK

    Example Usage:
    [track id="1" style="normal" eq="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    style - normal, compact. Default: normal (string) 
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).
    class - Special classes. Default: null (string). 

/* ---------------------------------------------------------------------- */
function noisa_track( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'id'           => 0,
        'style'        => 'normal',
        'eq'           => '0',
        'track_action' => 'sp-play-track',
        'classes'      => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }

    if ( $eq == '1' ) {
        $eq = '<div class="eq"><div class="bar-init"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>';
    } else {
        $eq = '';
    }

    $noisa_sid++;
    $track = scamp_player_get_list( $id );

    foreach ( $track as $i => $track ) {
        if ( ! $track['cover'] || $track['cover'] == '' ) {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '<div class="single-track-wrap ' . esc_attr( $classes ) . '">';
        $output .= '
            <div class="single-track ' . esc_attr( $style ) . '">
                <div class="track-wrap">
                <a href="' .  esc_url( $track['url'] ) . '" class="track ' .  esc_attr( $track_action ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                    <img class="track-cover" src="' . esc_url( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', 'noisa_plugin') ) . '">
                    <span class="track-status"></span><span class="track-title hidden">' . $track['title'] . '</span>
                   '. $eq .'
                </a>
                </div>
                <span class="track-meta">
                    <span class="track-title">' . $track['title'] . '</span>
                    <span class="track-artists">' . $track['artists'] . '</span>';

            if ( $style == 'normal' ) {
                $output .= '<span class="track-buttons">' . do_shortcode ( $track['links'] ) . '</span>';
            }

            $output .= '</span>';
        $output .= '</div>';
        $output .= '</div>';
        if ( $i == 0 ) {
            break;
            return false;
        }
    }

   return $output;
}
add_shortcode( 'track', 'noisa_track' );


/* ----------------------------------------------------------------------
    Track Button

    Example Usage:
    [track_button link="#" icon="soundcloud" target="_self" classes=""]
/* ---------------------------------------------------------------------- */
function noisa_track_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'    => '#',
        'icon'    => 'soundcloud',
        'target'  => '_self',
        'classes' => ''
    ), $atts));
   return '<a class="track-button ' . esc_attr( $classes ) . '" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-' . esc_attr( $icon ) . '"></i></a>';
}
add_shortcode( 'track_button', 'noisa_track_button' );


/* ----------------------------------------------------------------------
    SINGLE ALBUM

    Example Usage:
    [single_album id="1" album_cover="0" album_title="Lorem Ipsum" album_artists="John Doe" eq="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer).
    album_cover - Album cover image ID.

/* ---------------------------------------------------------------------- */
function noisa_single_album( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'album_title'   => '',
        'album_artists' => '',
        'id'            => 0,
        'album_cover'   => 0,
        'size'          => 'noisa-release-thumb',
        'eq'            => '0',
        'classes'       => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }

    if ( $eq == '1' ) {
        $eq = '<div class="eq"><div class="bar-init"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>';
    } else {
        $eq = '';
    }

    $noisa_sid++;
    $tracklist = scamp_player_get_list( $id );

    $output .= '<div class="single-album-wrap ' . esc_attr( $classes ) . '">';

   // Hidden tracklist
    $output .= '<ol id="album-list-' . esc_attr( $noisa_sid ) . '" class="sp-list tracklist">' ."\n";

    foreach ( $tracklist as $track ) {
       if ( ! $track['cover'] || $track['cover'] == '' ) {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <li>
                <a href="' .  esc_url( $track['url'] ) . '" class="sp-play-track" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                </a>
            </li>';
    }

    $output .= '</ol>' ."\n";

    // Cover
    $image = wp_get_attachment_image_src( $album_cover, $size );

    $image = $image[0];
    if ( ! $image || $image == '' ) {
        $image = get_template_directory_uri() . '/images/no-track-image.png';
    }
    $output .= '
        <a href="#" class="album-cover track sp-play-list" data-id="album-list-' . esc_attr( $noisa_sid ) . '" >
            <img class="track-cover" src="' . esc_attr( $image ) . '" alt="' . esc_attr( __( 'Cover Image', 'noisa_plugin') ) . '">
            <span class="track-meta">
                <span class="track-count">
                    <span class="icon icon-music"></span>' . count($tracklist) . '
                </span>
                <span class="track-meta-inner">
                    <span class="track-title">' . $album_title . '</span>
                    <span class="track-artists">' . $album_artists . '</span>
                </span>
            </span>
            <span class="track-status"></span>
            '. $eq .'
        </a>';
    
    $output .= '</div>' ."\n";

   return $output;
}
add_shortcode( 'single_album', 'noisa_single_album' );


/* ----------------------------------------------------------------------
    TRACKLIST BUTTON

    Example Usage:
    [tracklist_button id="1" button_title="Play Track"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 

/* ---------------------------------------------------------------------- */
function noisa_tracklist_button( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
         'id'                 => 0,
         'list_button_action' => 'sp-play-list',
         'track_action'       => 'sp-play-track',
         'button_title'       => __( 'Play List', 'noisa_plugin'),
         'classes'            => ''
    ), $atts));

    $output = '';


    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $noisa_sid++;
    $tracklist = scamp_player_get_list( $id );

    // Hidden tracklist
    $output .= '<ol id="tracklist-' . esc_attr( $noisa_sid ) . '" class="sp-list tracklist hidden">' ."\n";

    foreach ( $tracklist as $track ) {
       if ( ! $track['cover'] || $track['cover'] == '' ) {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <li>
                <a href="' .  esc_url( $track['url'] ) . '" class="sp-play-track" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                </a>
            </li>';
    }

    $output .= '</ol>' ."\n";

    $output .= '<a class="list-btn btn btn-icon ' . esc_attr( $list_button_action ) . ' ' . esc_attr( $classes ) . '" data-id="tracklist-' . esc_attr( $noisa_sid ) . '" ><span class="icon icon-play2"></span>' . $button_title . '</a>';
    

   return $output;
}
add_shortcode( 'tracklist_button', 'noisa_tracklist_button' );


/* ----------------------------------------------------------------------
    TWEETS LIST

    Example Usage:
    [tweets_list time="30" limit="2" username="" replies="true" api_key="" api_secret=""]
/* ---------------------------------------------------------------------- */
function noisa_tweets_list( $atts, $content = null ) {
   extract(shortcode_atts(array(
        'time'       => 30,
        'limit'      => '1',
        'username'   => '',
        'replies'    => 'no',
        'api_key'    => '',
        'api_secret' => ''
    ), $atts));

    $opts = array(
        'time'       => $time,
        'limit'      => $limit,
        'username'   => $username,
        'replies'    => $replies,
        'api_key'    => $api_key,
        'api_secret' => $api_secret
    );
    
    $output = '';
    if ( function_exists( 'noisa_twitter_feed' ) ) {

        $tweets = noisa_twitter_feed( $opts );

        if ( is_array( $tweets ) ) {
            $output .= '<ul class="tweets">';
            foreach ( $tweets as $key => $tweet ) {
                $output .= '<li>' . $tweet[ 'text' ] . '<span class="date">' . $tweet[ 'date' ] . '</span></li>';  
                if ( $key == $limit ) {
                    break;
                }
            }

            $output .= '</ul>';
            return $output;

        } else {
            // Errors
            return $tweets;
        }
        
    }

    return;

}
add_shortcode( 'tweets_list', 'noisa_tweets_list' );


/* ----------------------------------------------------------------------
    TWEETS SLIDER

    Example Usage:
    [tweets_list time="30" limit="2" username="" replies="true" api_key="" api_secret=""]
/* ---------------------------------------------------------------------- */
function noisa_tweets_slider( $atts, $content = null ) {

    global $noisa_sid;

    extract(shortcode_atts(array(
        'bg_color'           => 'light-bg',
        'time'                => 30,
        'limit'               => '1',
        'username'            => '',
        'replies'             => 'no',
        'api_key'             => '',
        'api_secret'          => ''
    ), $atts));

    $opts = array(
        'time'                => $time,
        'limit'               => $limit,
        'username'            => $username,
        'replies'             => $replies,
        'api_key'             => $api_key,
        'api_secret'          => $api_secret
    );
    
    $output = '';
    if ( function_exists( 'noisa_twitter_feed' ) ) {

        $tweets = noisa_twitter_feed( $opts );

        if ( is_array( $tweets ) ) {

            $output .= '<div id="twitter-slider-id' . esc_attr( $noisa_sid ) . '" class="slider carousel-slider text-slider tweets-slider ' . esc_attr( $bg_color ) . '" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false">';
            foreach ( $tweets as $key => $tweet ) {
                $output .= '<div class="slide"><div class="tweet">' . $tweet[ 'text' ] . '<span class="date">' . $tweet[ 'date' ] . '</span></div></div>';  
                 if ( $key == $limit ) {
                    break;
                }
            }

            $output .= '</div>';
            return $output;

        } else {
            // Errors
            return $tweets;
        }
        
    }

    return;

}
add_shortcode( 'tweets_slider', 'noisa_tweets_slider' );


/* ----------------------------------------------------------------------
    BUTTON

    Example Usage:
    [button link="#" text_color="#fff" bg_color="#666" title="Example Button Text" size="small" icon="" icon_size="14"]

/* ---------------------------------------------------------------------- */

// List
function noisa_buttons( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'classes'  => '',
        'align' => 'text-left'
    ), $atts));

    $classes .= ' ' . $align;
    return '<div class="buttons ' . $classes . '">' . do_shortcode($content) . '</div>';

}
add_shortcode( 'buttons', 'noisa_buttons' );
function noisa_button( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'size'       => 'btn-medium',
        'title'      => 'Example Button Text',
        'link'       => '#',
        'target'     => '',
        'icon'       => '',
        'style'      => 'default-btn'
    ), $atts));

    if ( $target == '0' ) {
        $target = 'target="_blank"';
    }
    if ( $icon != '' ) {
        $icon = '<span class="icon icon-' . $icon . '"></span>';
        return '<a class="btn btn-icon ' . $size . ' ' .  $style . '" href="' . $link . '" ' . $target . '>' . $icon . $title . '</a>';
    } else {
        return '<a class="btn ' . $size . ' ' . $style . '" href="' . $link . '" ' . $target . '>' . $title . '</a>';
    }

}
add_shortcode( 'button', 'noisa_button' );


/* ----------------------------------------------------------------------
    ICON COLUMN

    Example Usage:
    [icon_column icon="" icon_place="icon_left"]..Text Here...[/icon_column]

/* ---------------------------------------------------------------------- */

function noisa_icon_column( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'icon_title'   => '',
        'bold_title'   => '',
        'icon'         => '',
        'icon_place'   => 'icon_left',
        'button_title' => '',
        'button_link'  => ''
    ), $atts));

    $output = '';
    $button = '';

    if ( $button_link !== '' && $button_title !== '' ) {
        $button = '<a class="readmore" href="' . $button_link . '">' . $button_title . '</a>';
    }

    if ( $icon != '' ) {
        $icon = '<span class="icon icon-' . esc_attr( $icon ) . '"></span>';
    }
    if ( $bold_title == '0' && $icon_title != '' ) {
        $icon_title = '<strong>' . $icon_title . '</strong>';
    }
    if ( $icon_title != '' ) {
        $icon_title = '<span class="icon_column_title">' . $icon_title . '</span>';
    }

    $output .= '
        <div class="icon_column ' . esc_attr( $icon_place ) . '">
            ' . $icon . '
            <div class="text-holder">' . $icon_title. do_shortcode( $content ) . '</div>
            ' . $button . '
        </div>
    ';
    return $output;

}
add_shortcode( 'icon_column', 'noisa_icon_column' );


/* ----------------------------------------------------------------------
    PRICE TABLE

    Example Usage:

/* ---------------------------------------------------------------------- */

function noisa_pricing_column( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'title'         => '',
        'price'         => '0',
        'currency'      => '$',
        'period'        => '',
        'link'          => '#',
        'target'        => '_self',
        'button_text'   => 'Buy Now',
        'important'     => '',
        'list'          => '2x option 1,Free option 2,Unlimited option 3,Unlimited option 4,1x option 5'
    ), $atts));

    $output = '';
    $html_list = '';
    
    $output .= "<div class='price-table'>";
        
    if ( $important == "yes" ){
        $output .= "<div class='price-table-inner important-price'>";
    } else {
        $output .= "<div class='price-table-inner'>";
    }

    if ( $list != '' ){

        $list = explode( ',', $list );
        if ( is_array( $list) ) {
                $html_list .= '<ul>';
                foreach ( $list as $li ) {
                    $html_list .= '<li>' . $li . '</li>';
                }
                $html_list .= '</ul>';
        }
    }

    $output .= "<ul>";
    $output .= "<li class='prices'>";
    $output .= "<div class='price-wrapper'>";
    $output .= "<sup class='value'>" . $currency . "</sup>";
    $output .= "<span class='price'>" . $price . "</span>";
    $output .= "<sub class='mark'>" . $period . "</sub>";
    $output .= "</div>";
    $output .= "</li>"; // end prices
    $output .= "<li class='table-title'>" . $title . "</li>";
    
    $output .= '<li class="price-content-list">' . $html_list . '</li>'; 
    
    $output .= "<li class='price-button-wrapper'>";
    $output .= "<a class='btn medium' href='$link' target='$target'>" . $button_text . "</a>";
    $output .= "</li>"; // end button
    
    $output .= "</ul>";
    $output .= "</div>"; // end price-table-inner
    $output .="</div>"; // end price-table
    
    return $output;

}
add_shortcode( 'pricing_column', 'noisa_pricing_column' );


/* ----------------------------------------------------------------------
    DETAILS LIST

    Example Usage:
    [details_list]
        [detail label="Color" value="Orange"]
        [detail label="Color" value="Blue"]
        [detail label="Color" value="White"]
    [/details_list]
  

/* ---------------------------------------------------------------------- */

// List
function noisa_details_list( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'classes' => ''
    ), $atts));
    
    return '<ul class="details-list ' . esc_attr( $classes ) . '">' . do_shortcode($content) . '</ul>';

}
add_shortcode( 'details_list', 'noisa_details_list' );

// Detail
function noisa_detail( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'label' => 'Color',
        'value' => 'White',
        'text_link' => '1',
        'url' => '',
        'target' => ''
    ), $atts));

    if ( $text_link == '0' && $url != '' ) {
        if ( $target == '0' ) {
            $target = 'target="_blank"';
        }
        $value = '<a href="' . $url . '" ' . $target . '>' . $value . '</a>';
    }

    return '<li><span>' . $label . '</span>' . $value . '</li>';

}
add_shortcode( 'detail', 'noisa_detail' );


/* ----------------------------------------------------------------------
    GOOGLE MAPS

    Example Usage:
    [google_maps address="Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia" height="400" depth="15" zoom_control="true" scrollwhell="false"]

/* ---------------------------------------------------------------------- */
function noisa_google_maps($atts, $content = null) {
    global $r_option, $noisa_sid;
    
    extract(shortcode_atts(array(
        'height' => '400',
        'address' => 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
        'depth' => '15',
        'zoom_control' => 'true',
        'scrollwheel' => 'false',
        'classes' => ''
    ), $atts));

    $output = '<div class="gmap-wrap">';
    $output .= '<div id="gmap_' . esc_attr( $noisa_sid ) . '" class="gmap" style="height:' . esc_attr( $height ) . 'px" data-address="' . esc_attr( $address ) . '" data-zoom="' . esc_attr( $depth ) . '" data-zoom_control="' . esc_attr( $zoom_control ) . '" data-scrollwhell="' . esc_attr( $scrollwheel ) . '">';
    $output .= '<p>' .  __( 'Please enable your JavaScript in your browser, to view our location.', 'noisa_plugin' ) . '</p>';
    $output .= '</div>';
    $output .= '</div>';

    $noisa_sid++;
    
    return $output;
}
add_shortcode('google_maps', 'noisa_google_maps');


/* ----------------------------------------------------------------------
    POSTS LIST

    Example Usage:
    [posts_list limit="4" title="" button_link=""]

/* ---------------------------------------------------------------------- */

function noisa_posts_list( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'  => '10',
        'title' => '',
        'columns' => '2',
        'button_link' => '',
        'posts_in' => '',
        'categories_in' => '',
        'classes' => ''
    ), $atts));
    
    global $wp_query, $post, $noisa_sid;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    $words_number = 30;

    // Date format
    $date_format = 'd/m/y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    // Loop Args.
    $args = array(
        'showposts' => $limit
    );

    /* Posts in */
    if ( $posts_in != '' ) {
        $args['post__in'] = explode( ',', $posts_in );
    }

    /* Categories */
    if ( $categories_in != '' ) {
        $categories_in = explode( ',', $categories_in );
        $c = array();
        foreach ( $categories_in as $cat ) {

            $cat_id = get_cat_ID( $cat );
            if ( $cat_id ) {
                array_push( $c, $cat_id );
            }
        }
        if ( is_array( $c ) && ! empty( $c ) ) {
            $args['cat'] = implode( ',', $c );
        }
    }

    $posts_list = new WP_Query();
    $posts_list->query( $args );

    // Begin Loop
    if ( $posts_list->have_posts() ) {
        $output .= '<div class="posts-list '. $classes .'">';
        while ( $posts_list->have_posts() ) {
            $posts_list->the_post();
    
            $output .= '<a href="' . esc_url( get_permalink() ) . '">';
                $output .= '<span class="date">' . get_the_time( $date_format ) . '</span>';
                $output .= '<div class="title"><h2>' . get_the_title() . '</h2></div>';

                $categories = get_the_category();
                $separator = ' / ';
                $cats = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $cats .=  esc_html( $category->name ) . $separator;
                    }
                }
                $output .= '<span class="cats">' . trim( $cats, $separator ) . '</span>';
                
            $output .= '</a>';
        } // end loop
        $output .= '</div>'; //wrap;
        if ( $button_link != '' ) {
            $output .= '<div class="button-position"><a class="btn btn-medium more-posts" href="' . esc_url( $button_link ) . '">' . __( 'View More Posts', 'noisa_plugin' ) . '</a></div>';
        }

    } // end have_posts

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'posts_list', 'noisa_posts_list' );


/* ----------------------------------------------------------------------
    RELEASES GRID

    Example Usage:
    [releases filter="yes" limit="40" order="menu_order"]

/* ---------------------------------------------------------------------- */

function noisa_releases_grid( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'      => '40',
        'order'      => 'menu_order',
        'in_row'     => '3',
        'url'        => '',
        'gap'        => 'no-gap',
        'display_by' => 'all',
        'terms'  => ''
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option( 'date_format' );
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    if ( $url != '' ) {
        $n_cpt = wp_count_posts( 'noisa_releases' );
        $n_cpt_publish = $n_cpt->publish;
    }

    // Loop Args.
    $args = array(
        'post_type' => 'noisa_releases',
        'orderby'   => $order, // menu_order, date, title
        'order'     => 'ASC',
        'showposts' => $limit
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }
    
    $releases_query = new WP_Query();
    $releases_query->query( $args );

    // begin Loop
    if ( $releases_query->have_posts() ) {
        $output .= '<div class="masonry ' . esc_attr( $gap ) . ' releases-grid clearfix">';
        while ( $releases_query->have_posts() ) {
            $releases_query->the_post();

            if ( has_post_thumbnail() ) {

                $last = false;
                if ( ( $releases_query->current_post ) < ( $releases_query->post_count -1 ) ) {
                    $last = false;
                } else {
                    if ( $url != '' ) {
                        $last = true;
                    }
                }

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-'. $in_row, $releases_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
               
                if ( ! $last ) {
                      $link_classes = 'thumb thumb-desc';
                    $permalink = get_permalink();
                } else {
                    $link_classes = 'thumb thumb-desc thumb-post-count';
                    $permalink = $url;
                }
                $tip = get_post_meta( $releases_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }
                $output .= '<a href="' . esc_url( $permalink ) . '" class="' . $link_classes . '">';

                if ( ! $last ) {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $releases_query->post->ID ), 'noisa-release-thumb' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';
                    $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                    $output .= '<div class="grid-cats">';

                    $categories = get_the_terms( $releases_query->post->ID, 'noisa_releases_genres' );
                    $separator = ' / ';
                    $cats = '';
                    if ( ! empty( $categories ) ) {
                       foreach( $categories as $term ) {

                        $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                        }
                    }
                    $output .= trim( $cats, $separator );

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="arrow-icon"></div>';
                    $output .= '</div>';
                    if ( $tip ) {
                        $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                    }
                } else {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $releases_query->post->ID ), 'noisa-release-thumb' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-plus"></div>';
                    $output .= '<div class="desc-count">' . $n_cpt_publish . '</div>';
                    $output .= '</div>';

                }
                
                $output .= '</a>';
            
                $output .= '</div>';
                $output .= '</article>';
            }

        } // end loop
        // End grid
        $output .= '</div>';

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'releases_grid', 'noisa_releases_grid' );


/* ----------------------------------------------------------------------
    RELEASES CAROUSEL

    Example Usage:
    [releases carousel="yes" limit="40" order="menu_order"]

/* ---------------------------------------------------------------------- */

function noisa_releases_carousel( $atts, $content = null ) {
    
    global $wp_query, $post, $noisa_sid;

    extract(shortcode_atts(array(
        'limit'         => '40',
        'order'         => 'menu_order',
        'visible_items' => '1',
        'gap'           => 'no-gap',
        'display_by'    => 'all',
        'terms'         => '',
        'button_link'   => '',
        'button_title'  => __( 'View More', 'noisa_plugin'),
        'classes'       => ''
    ), $atts));
    
    $noisa_sid++;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    // Loop Args.
    $args = array(
        'post_type' => 'noisa_releases',
        'orderby'   => $order, // menu_order, date, title
        'order'     => 'ASC',
        'showposts' => $limit
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }
    
    $releases_query = new WP_Query();
    $releases_query->query( $args );

    // begin Loop
    if ( $releases_query->have_posts() ) {
        $output .= '<div class="releases-carousel-wrap ' . $classes . '">';
        $output .= '<div id="releases-carousel-id' . esc_attr( $noisa_sid ) . '" class="carousel-slider carousel-releases-slider '. esc_attr( $gap ) . '" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false" data-items="' . $visible_items . '">';
        while ( $releases_query->have_posts() ) {
            $releases_query->the_post();

            if ( has_post_thumbnail() ) {
                $output .= '<article class="' . implode( ' ', get_post_class( $releases_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
                $link_classes = 'thumb thumb-desc';
                $permalink = get_permalink();
            
                $tip = get_post_meta( $releases_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }

                $output .= '<a href="' . esc_url( $permalink ) . '" class="' . $link_classes . '">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $releases_query->post->ID ), 'noisa-release-thumb' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';
                    $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                    $output .= '<div class="grid-cats">';

                    $categories = get_the_terms( $releases_query->post->ID, 'noisa_releases_genres' );
                    $separator = ' / ';
                    $cats = '';
                    if ( ! empty( $categories ) ) {
                       foreach( $categories as $term ) {

                        $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                        }
                    }
                    $output .= trim( $cats, $separator );

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="arrow-icon"></div>';
                    $output .= '</div>';
                    if ( $tip ) {
                        $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                    }
                $output .= '</a>';
            
                $output .= '</div>';
                $output .= '</article>';
            }

        } // end loop
        // End carousel
        $output .= '</div>';
        if ( $button_link != '' ) {
            $output .= '<div class="button-position"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . $button_title . '</a></div>';
        }

    $output .= '</div>'; // wrap;

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'releases_carousel', 'noisa_releases_carousel' );


/* ----------------------------------------------------------------------
    ARTISTS GRID

    Example Usage:
    [releases filter="yes" limit="40" order="menu_order"]

/* ---------------------------------------------------------------------- */

function noisa_artists_grid( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'      => '40',
        'order'      => 'menu_order',
        'in_row'     => '3',
        'url'        => '',
        'gap'        => 'no-gap',
        'display_by' => 'all',
        'disable_artists_links' => '',
        'terms'  => ''
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option( 'date_format' );
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    if ( $url != '' ) {
        $n_cpt = wp_count_posts( 'noisa_artists' );
        $n_cpt_publish = $n_cpt->publish;
    } else {
        $n_cpt_publish = '0';
    }

    // Loop Args.
    $args = array(
        'post_type' => 'noisa_artists',
        'orderby'   => $order, // menu_order, date, title
        'order'     => 'ASC',
        'showposts' => $limit
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }
    
    $artists_query = new WP_Query();
    $artists_query->query( $args );

    // begin Loop
    if ( $artists_query->have_posts() ) {
        $output .= '<div class="masonry ' . esc_attr( $gap ) . ' artists-grid clearfix">';
        while ( $artists_query->have_posts() ) {
            $artists_query->the_post();

            if ( has_post_thumbnail() ) {

                $last = false;
                if ( ( $artists_query->current_post ) < ( $artists_query->post_count -1 ) ) {
                    $last = false;
                } else {
                    if ( $url != '' ) {
                        $last = true;
                    }
                }

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-'. $in_row, $artists_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
               
                if ( ! $last ) {
                      $link_classes = 'thumb thumb-desc';
                    $permalink = get_permalink();
                } else {
                    $link_classes = 'thumb thumb-desc thumb-post-count';
                    $permalink = $url;
                }
                $tip = get_post_meta( $artists_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }
                if ( $disable_artists_links == '0' && ! $last  ) {
                    $output .= '<a class="' . $link_classes . '">';
                } else {
                   $output .= '<a href="' . esc_url( $permalink ) . '" class="' . $link_classes . '">'; 
                }
                

                if ( ! $last ) {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $artists_query->post->ID ), 'full' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '';

                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';
                    $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                    $output .= '<div class="grid-cats">';

                    $categories = get_the_terms( $artists_query->post->ID, 'noisa_artists_genres' );
                    $separator = ' / ';
                    $cats = '';
                    if ( ! empty( $categories ) ) {
                       foreach( $categories as $term ) {

                        $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                        }
                    }
                    $output .= trim( $cats, $separator );

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="arrow-icon"></div>';
                    $output .= '</div>';
                    if ( $tip ) {
                        $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                    }
                } else {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $artists_query->post->ID ), 'full' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-plus"></div>';
                    $output .= '<div class="desc-count">' . $n_cpt_publish . '</div>';
                    $output .= '</div>';

                }
                
                $output .= '</a>';
            
                $output .= '</div>';
                $output .= '</article>';
            }

        } // end loop
        // End grid
        $output .= '</div>';

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'artists_grid', 'noisa_artists_grid' );


/* ----------------------------------------------------------------------
    ARTISTS CAROUSEL

    Example Usage:
    [artists carousel="yes" limit="40" order="menu_order"]

/* ---------------------------------------------------------------------- */

function noisa_artists_carousel( $atts, $content = null ) {
    
    global $wp_query, $post, $noisa_sid;

    extract(shortcode_atts(array(
        'limit'         => '40',
        'order'         => 'menu_order',
        'visible_items' => '1',
        'gap'           => 'no-gap',
        'display_by'    => 'all',
        'pagination'    => '0',
        'terms'         => '',
        'button_link'   => '',
        'button_title'  => __( 'View More', 'noisa_plugin'),
        'classes'       => ''
    ), $atts));
    
    $noisa_sid++;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );
    $thumb_size = 'full';
    $classes .= ' grab';

    // Pagination
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;
    if ( $pagination == '0' ) {
        $pagination = 'true';
    } else {
        $pagination = 'false';
    }

    if ( isset( $post ) ) { 
        $backup = $post;
    }


    // Loop Args.
    $args = array(
        'post_type' => 'noisa_artists',
        'orderby'   => $order, // menu_order, date, title
        'order'     => 'ASC',
        'showposts' => $limit
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }
    
    $artists_query = new WP_Query();
    $artists_query->query( $args );

    // begin Loop
    if ( $artists_query->have_posts() ) {
        $output .= '<div class="artists-carousel-wrap ' . $classes . '">';
        $output .= '<div id="artists-carousel-id' . esc_attr( $noisa_sid ) . '" class="carousel-slider carousel-artists-slider '. esc_attr( $gap ) . '" data-effect="fade" data-pagination="' . $pagination . '" data-nav="false" data-autoplay="false" data-items="' . $visible_items . '">';
        while ( $artists_query->have_posts() ) {
            $artists_query->the_post();

            if ( has_post_thumbnail() ) {
                $output .= '<article class="' . implode( ' ', get_post_class( $artists_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
                $link_classes = 'thumb thumb-desc';
                $permalink = get_permalink();
            
                $tip = get_post_meta( $artists_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }

                $output .= '<a href="' . esc_url( $permalink ) . '" class="' . $link_classes . '">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $artists_query->post->ID ), 'full' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '';

                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';
                    $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                    $output .= '<div class="grid-cats">';

                    $categories = get_the_terms( $artists_query->post->ID, 'noisa_artists_genres' );
                    $separator = ' / ';
                    $cats = '';
                    if ( ! empty( $categories ) ) {
                       foreach( $categories as $term ) {

                        $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                        }
                    }
                    $output .= trim( $cats, $separator );

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="arrow-icon"></div>';
                    $output .= '</div>';
                    if ( $tip ) {
                        $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                    }
                $output .= '</a>';
            
                $output .= '</div>';
                $output .= '</article>';
            }

        } // end loop
        // End carousel
        $output .= '</div>';
        if ( $button_link != '' ) {
            $output .= '<div class="button-position"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . $button_title . '</a></div>';
        }

    $output .= '</div>'; // wrap;

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'artists_carousel', 'noisa_artists_carousel' );


/* ----------------------------------------------------------------------
    EVENTS

    Example Usage:
    [events filter="yes" limit="40" order="menu_order"]

/* ---------------------------------------------------------------------- */

function noisa_events( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'        => '40',
        'in_row'       => '3',
        'gap'          => 'no-gap',
        'display_type' => 'grid',
        'event_type'   => 'future-events',
        'display_by'   => 'all',
        'terms'        => '',
        'thumb_style'  => 'default'
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'event_date' ] ) ) {
        $date_format = $panel_options[ 'event_date' ];
    } else {
        $date_format = get_option( 'date_format' );
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

     // Taxonomies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
    }

    // ---------------------- All events
    if ( $event_type == 'all-events' ) {

        $future_tax = array(
            'relation' => 'AND',
            array(
               'taxonomy' => 'noisa_event_type',
               'field' => 'slug',
               'terms' => 'future-events'
              )
        );

        $past_tax = array(
            'relation' => 'AND',
            array(
               'taxonomy' => 'noisa_event_type',
               'field' => 'slug',
               'terms' => 'past-events'
              )
        );

        if ( $display_by != 'all' && $terms != '' ) {

            array_push( $future_tax,
                array(
                    'taxonomy' => $display_by,
                    'field' => 'slug',
                    'terms' => $terms
                )
            );
            array_push( $past_tax, 
                array(
                    'taxonomy' => $display_by,
                    'field' => 'slug',
                    'terms' => $terms
                )
            );
        }

        $future_events = get_posts( array(
            'post_type' => 'noisa_events',
            'showposts' => -1,
            'tax_query' => $future_tax,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date_start',
            'order' => 'ASC'
        ));

        // Past Events
        $past_events = get_posts(array(
            'post_type' => 'noisa_events',
            'showposts' => -1,
            'tax_query' => $past_tax,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date_start',
            'order' => 'DSC'
        ));

        $future_nr = count( $future_events );
        $past_nr = count( $past_events );

        // echo "Paged: Future events: $future_nr, Past events: $past_nr";

        $mergedposts = array_merge( $future_events, $past_events ); //combine queries

        $postids = array();
        foreach( $mergedposts as $item ) {
            $postids[] = $item->ID; //create a new query only of the post ids
        }
        $uniqueposts = array_unique( $postids ); //remove duplicate post ids

        // var_dump($uniqueposts);
        $args = array(
            'post_type' => 'noisa_events',
            'showposts' => $limit,
            'post__in'  => $uniqueposts,
            'orderby' => 'post__in'
        );

    // ---------------------- Future or past events
    } else {

        /* Set order */
        $order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';

        // Event type taxonomy
        $taxonomies = array(
            array(
               'taxonomy' => 'noisa_event_type',
               'field' => 'slug',
               'terms' => $event_type
              )
        );

        if ( $display_by != 'all' && $terms != '' ) {

            array_push( $taxonomies, 
                array(
                    'taxonomy' => $display_by,
                    'field' => 'slug',
                    'terms' => $terms
                )
            );
        }

        // Begin Loop
        $args = array(
            'post_type'        => 'noisa_events',
            'showposts'        => $limit,
            'tax_query'        => $taxonomies,
            'orderby'          => 'meta_value',
            'meta_key'         => '_event_date_start',
            'order'            => $order,
            'suppress_filters' => 0 // WPML FIX
        );
    }
    
    $events_query = new WP_Query();
    $events_query->query( $args );

    // begin Loop
    if ( $events_query->have_posts() ) {
        if ( $display_type == 'grid' ) {
            $grid_classes = 'masonry events-grid clearfix ' . $gap . ' ' . $thumb_style;
        } elseif ( $display_type == 'list' ) {
            $grid_classes = 'masonry masonry-list events-list clearfix';
        }

        $output .= '<div class="' . esc_attr( $grid_classes ) . ' clearfix">';
        while ( $events_query->have_posts() ) {
            $events_query->the_post();

            /* Event Date */
            $event_time_start = get_post_meta( $events_query->post->ID, '_event_time_start', true );
            $event_date_start = get_post_meta( $events_query->post->ID, '_event_date_start', true );
            $event_date_start = strtotime( $event_date_start );

            if ( $display_type == 'grid' ) {
                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-'. $in_row, $events_query->post->ID ) ) . '">';

                if ( has_post_thumbnail() ) {
                    $output .= '<div class="grid-media">';

                    $link_classes = 'thumb thumb-event';
                    if ( has_term( 'past-events', 'noisa_event_type' ) ) {
                        $link_classes .= ' past-event';
                    }    
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" class="' . $link_classes . '">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $events_query->post->ID ), 'large' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';

                    // Meta top
                    $output .= '<div class="event-meta-top">';
                    $output .= '<span class="event-day">' . date_i18n( 'D', $event_date_start ) . '</span>';
                    $output .= '<span class="event-locations">';

                        $categories = get_the_terms( $events_query->post->ID, 'noisa_events_locations' );
                        $separator = ' / ';
                        $cats = '';
                        if ( ! empty( $categories ) ) {
                           foreach( $categories as $term ) {

                            $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                            }
                        }
                        $output .= trim( $cats, $separator );

                    $output .= '</span>';
                    $output .= '</div>';

                    // Meta bottom
                    $output .= '<div class="event-meta-bottom">';
                    $output .= '<span class="event-date">' . date_i18n( $date_format, $event_date_start ) . '</span>';
                    $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                    $output .= '<span class="event-artists">';

                        $categories = get_the_terms( $events_query->post->ID, 'noisa_events_artists' );
                        $separator = ' / ';
                        $cats = '';
                        if ( ! empty( $categories ) ) {
                           foreach( $categories as $term ) {

                            $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                            }
                        }
                        $output .= trim( $cats, $separator );
                    
                    $output .= '</span>';

                    if ( has_term( 'past-events', 'noisa_event_type' ) ) {
                        $output .= '<span class="pill-btn medium">' . __( 'Past Event', 'noisa_plugin' ) . '</span>';
                    }    
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '</a>';

                    $output .= '</div>';
                    $output .= '</article>';

                }
            } elseif ( $display_type == 'list' ) {

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item', $events_query->post->ID ) ) . '">';
                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="event-li">';
                $output .= '<span class="date">' . date_i18n( $date_format, $event_date_start );
                if ( has_term( 'past-events', 'noisa_event_type' ) ) {
                    $output .= '<span class="past-event-label">' . __( 'Past Event', 'noisa_plugin' ) . '</span>';
                }    
                $output .= '</span>';
                $output .= '<span class="venue">';

                    $categories = get_the_terms( $events_query->post->ID, 'noisa_events_locations' );
                    $separator = ' / ';
                    $cats = '';
                    if ( ! empty( $categories ) ) {
                       foreach( $categories as $term ) {

                        $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                        }
                    }
                    $output .= trim( $cats, $separator );

                $output .= '</span>';
                $output .= '<span class="title">' . get_the_title() . '</span>';

                $output .= '</a>';
                $output .= '</article>';

            }

        } // end loop
        // End grid
        $output .= '</div>';

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'events', 'noisa_events' );


/* ----------------------------------------------------------------------
    GALLERY ALBUMS

    Example Usage:
    [gallery limit="40"]

/* ---------------------------------------------------------------------- */

function noisa_gallery_albums( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'      => '40',
        'in_row'     => '3',
        'url'        => '',
        'gap'        => 'no-gap',
        'display_by' => 'all',
        'terms'  => '',
        'thumb_style' => 'default'
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option( 'date_format' );
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    if ( $url != '' ) {
        $n_cpt = wp_count_posts( 'noisa_artists' );
        $n_cpt_publish = $n_cpt->publish;
    } else {
        $n_cpt_publish = '0';
    }

    // Loop Args.
    $args = array(
        'post_type' => 'noisa_gallery',
        'showposts' => $limit
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' ) {
        $terms = explode( ',', $terms );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }
    
    $gallery_query = new WP_Query();
    $gallery_query->query( $args );

    // begin Loop
    if ( $gallery_query->have_posts() ) {
        $output .= '<div class="masonry ' . esc_attr( $gap ) . ' gallery-shortcode-grid clearfix">';
        while ( $gallery_query->have_posts() ) {
            $gallery_query->the_post();

            if ( has_post_thumbnail() ) {

                $last = false;
                if ( ( $gallery_query->current_post ) < ( $gallery_query->post_count -1 ) ) {
                    $last = false;
                } else {
                    if ( $url != '' ) {
                        $last = true;
                    }
                }

                 // IDS
                $images_ids = get_post_meta( $gallery_query->post->ID, '_gallery_ids', true ); 

                if ( $images_ids || $images_ids != '' ) {
                    $ids = explode( '|', $images_ids );
                    $ids = count( $ids );
                } else {
                    $ids = '0';
                }

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-'. $in_row, $gallery_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
               
                if ( ! $last ) {
                      $link_classes = 'thumb thumb-desc';
                    $permalink = get_permalink();
                } else {
                    $link_classes = 'thumb thumb-desc thumb-post-count';
                    $permalink = $url;
                }
        
                $output .= '<a href="' . esc_url( $permalink ) . '" class="' . $link_classes . '">';

                if ( ! $last ) {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_query->post->ID ), 'noisa-release-thumb' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    if ( $thumb_style == 'default' ) {
                        $output .= '<div class="desc-layer">';
                        $output .= '<div class="images-count">' . $ids . '</div>';
                        $output .= '<div class="desc-details desc-full">';
                        $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                        $output .= '<div class="grid-date">' . get_the_time( $date_format ) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                } else {
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_query->post->ID ), 'noisa-release-thumb' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa_plugin' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-plus"></div>';
                    $output .= '<div class="desc-count">' . $n_cpt_publish . '</div>';
                    $output .= '</div>';

                }
                
                $output .= '</a>';
            
                $output .= '</div>';
                $output .= '</article>';
            }

        } // end loop
        // End grid
        $output .= '</div>';

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'gallery_albums', 'noisa_gallery_albums' );


/* ----------------------------------------------------------------------
    GALLERY IMAGES

    Example Usage:
    [gallery limit="40"]

/* ---------------------------------------------------------------------- */

function noisa_gallery_images( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'      => '40',
        'url'        => '0',
        'gap'        => 'no-gap',
        'album_id' => 0,
        'in_row' => '4',
        'thumb_style' => 'default'
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'noisa_panel_opts' );

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

   // IDS
    $images_ids = get_post_meta( $album_id, '_gallery_ids', true ); 

    if ( ! $images_ids || $images_ids == 0 ) {
        return;
    }

    $ids = explode( '|', $images_ids ); 

    $n_cpt_publish = count( $ids );
    
    // Begin Loop
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post__in' => $ids,
        'orderby' => 'post__in',
        'post_status' => 'any',
        'showposts' => $limit
    );
    
    $gallery_query = new WP_Query();
    $gallery_query->query( $args );

    // begin Loop
    if ( $gallery_query->have_posts() ) {
        $output .= '<div class="masonry ' . esc_attr( $gap ) . ' gallery-shortcode-images-grid clearfix">';
        while ( $gallery_query->have_posts() ) {
            $gallery_query->the_post();

            $last = false;
            if ( ( $gallery_query->current_post ) < ( $gallery_query->post_count -1 ) ) {
                $last = false;
            } else {
                if ( $url != '0' ) {
                    $last = true;
                }
            }

             $image_att = wp_get_attachment_image_src( get_the_id(), 'noisa-small-thumb' );
            if ( ! $image_att[0] ) { 
                continue;
            }

            $defaults = array(
                'title' => '',
                'custom_link'  => '',
                'thumb_icon' => 'view'
             );

            /* Get image meta */
            $image = get_post_meta( $album_id, '_gallery_ids_' . get_the_id(), true );

            /* Add default values */
            if ( isset( $image ) && is_array( $image ) ) {
                $image = array_merge( $defaults, $image );
            } else {
                $image = $defaults;
            }

            /* Add image src to array */
            $image['src'] = $image_att[0];
            if ( $image[ 'custom_link' ] != '' ) {
                $link = $image[ 'custom_link' ];
                $link_class = 'iframe-link';
            } else {
                $link = wp_get_attachment_image_src( get_the_id(), 'full' );
                $link = $link[0];
                $link_class = '';
            }
        
            if ( ! $last ) {
                $thumb_classes = 'thumb-desc';
                if ( $thumb_style == 'simple' ) {
                    $thumb_classes = 'thumb-simple';
                }

                if ( $image[ 'thumb_icon' ] == 'view' ) {
                                    $image[ 'thumb_icon' ] = 'search';
                } else if ( $image[ 'thumb_icon' ] == 'video' ) {
                    $image[ 'thumb_icon' ] = 'play2';
                }
                $output .= '<div class="masonry-item gallery-album-image flex-col-1-' . $in_row . '">';
                $output .= '<a href="' . esc_attr( $link ) .'" class="thumb ' . $thumb_classes . ' ' . esc_attr( $link_class  ) . ' g-item" title="' . esc_attr( $image['title'] ) . '" data-group="gallery">';
                $output .= '<img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( __( 'Gallery thumbnail', 'noisa_theme' ) ) . '" title="' . esc_attr( $image['title'] ) . '">';
                 $output .= '<div class="desc-layer"><span class="thumb-icon"><span class="icon icon-' . esc_attr( $image[ 'thumb_icon' ] ) . '"></span></span></div>';
                $output .= '</a>';            
                $output .= '</div>';
            } else {
                $output .= '<div class="masonry-item gallery-album-image flex-col-1-' . $in_row . '">';
                $output .= '<a href="' . get_permalink( $album_id ) .'" class="thumb thumb-desc thumb-post-count">';
                $output .= '<img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( __( 'Gallery thumbnail', 'noisa_theme' ) ) . '" title="' . esc_attr( $image['title'] ) . '">';
                $output .= '<div class="desc-layer">';
                $output .= '<div class="desc-plus"></div>';
                $output .= '<div class="desc-count">' . $n_cpt_publish . '</div>';
                $output .= '</div>';
                $output .= '</a>';            
                $output .= '</div>';
            }
            

        } // end loop
        // End grid
        $output .= '</div>';

    } // end have_posts

    
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'gallery_images', 'noisa_gallery_images' );


/* ----------------------------------------------------------------------
    EVENT COUNTDOWN

    Example Usage:
    [event_countdown event_id="0"]

/* ---------------------------------------------------------------------- */

function noisa_event_countdown( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'style'           => 'compact',
        'custom_event'    => '',
        'custom_event_id' => '0',
        'display_by'      => 'all',
        'terms'           => ''
    ), $atts));
    
    $custom_event_id = (int)$custom_event_id;
    global $post;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    // Event type taxonomy
    $tax = array(
        array(
           'taxonomy' => 'noisa_event_type',
           'field' => 'slug',
           'terms' => 'future-events'
          )
    );

     // Taxonimies
    if ( $display_by != 'all' && $terms != '' && $custom_event == '' ) {
        $terms = explode( ',', $terms );
        array_push( $tax,
            array(
                'taxonomy' => $display_by,
                'field' => 'slug',
                'terms' => $terms
            )
        );
    }

    $args = array(
        'post_type'        => 'noisa_events',
        'showposts'        => 1,
        'tax_query'        => $tax,
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => 'ASC',
        'suppress_filters' => 0 // WPML FIX
    );
    if ( $custom_event_id ==! 0 ) {
        $custom_event_id_a = array();
        $custom_event_id_a[0] = $custom_event_id;
        $args['post__in'] = $custom_event_id_a;
    }

    $events = get_posts( $args );
    $events_count = count( $events );

    if ( $events_count !== 0 ) {
        $custom_event_id = $events[0]->ID;
    }

    $panel_options = get_option( 'noisa_panel_opts' );

    if ( $custom_event_id == 0 ) {
        return false;
    }
    $output = '';

    // Get event date and time
    $event_date = strtotime( get_post_meta( $custom_event_id, '_event_date_start', true ) );
    $event_time = strtotime( get_post_meta( $custom_event_id, '_event_time_start', true ) );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option('date_format');
    }

    // locations
    $categories = get_the_terms( $custom_event_id, 'noisa_events_locations' );
    $separator = ' / ';
    $locations = '';
    if ( ! empty( $categories ) ) {
       foreach( $categories as $term ) {

        $locations .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
        }
    }

    $output .= '
        <div class="event-countdown ' . esc_attr( $style ) . '">
        <header class="content-header">
        <h6 class="upcoming-title">' . get_the_title( $custom_event_id ) . '</h6>
        <h6 class="upcoming-locations">' . date_i18n( $date_format, $event_date ) . ' @ ' . trim( $locations, $separator ) . '</h6>
        </header>
        <div class="countdown" data-event-date="' . date_i18n( 'Y/m/d', $event_date ) . ' ' . date_i18n( 'H:i', $event_time ) . ':00">
        <div class="days" data-label="' . esc_attr( __( 'Days', 'noisa_plugin' ) ) . '">000</div>
        <div class="hours" data-label="' . esc_attr( __( 'Hours', 'noisa_plugin' ) ) . '">00</div>
        <div class="minutes" data-label="' . esc_attr( __( 'Minutes', 'noisa_plugin' ) ) . '">00</div>
        <div class="seconds" data-label="' . esc_attr( __( 'Seconds', 'noisa_plugin' ) ) . '">00</div>
        </div>
        </div>
    ';
    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'event_countdown', 'noisa_event_countdown' );


/* ----------------------------------------------------------------------
    TIME LINE

    Example Usage:

/* ---------------------------------------------------------------------- */

function noisa_time_line( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'list'          => '01:30 AM - 03:00 AM|Lady C,11:30 PM - 01:30 AM|Gorrilla,10:30 PM - 11:30 PM|Vibeman,09:00 PM - 10:30 PM|DJ Nando,08:00 PM - 09:00 PM|General Midi'
    ), $atts));

    $output = '';
    $html_list = '';
    
    if ( $list != '' ){

        $list = explode( ',', $list );
        if ( is_array( $list) ) {
                $i = 0;
                $html_list .= '<ul class="timeline">';

                foreach ( $list as $li ) {
                    $list_details = explode( '|', $li );
                   
                    if ( is_array( $list_details) ) {
                        $direction = ($i%2 === 0) ? 'direction-r' : 'direction-l';
                        $html_list .= '
                        <li>
                            <div class="'.$direction.'">
                                <div class="flag-wrapper">
                                    <span class="artist-wrapper"><span class="artist">' . $list_details[1] . '</span></span>
                                    <span class="flag">' . $list_details[0] . '</span>
                                </div>
                            </div>
                        </li>';
                        $i++;
                    }
                }


                $html_list .= '</ul>';
        }
    } else {
        return;
    }
    
    return $html_list;

}
add_shortcode( 'time_line', 'noisa_time_line' );
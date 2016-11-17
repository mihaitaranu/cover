<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			helpers.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	COMMENTS LIST
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_comments' ) ) :
function noisa_comments( $comment, $args, $depth ) {

    global $noisa_opts;

    $GLOBALS['comment'] = $comment; 

    // Date format
    $date_format = 'd/m/y';

    if ( $noisa_opts->get_option( 'custom_comment_date' ) ) {
    	$date_format = $noisa_opts->get_option( 'custom_comment_date' );
    }
    ?>

    <!-- Comment -->
    <li id="li-comment-<?php comment_ID() ?>" <?php comment_class( 'theme_comment' ); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <div class="avatar-wrap">
                <?php echo get_avatar( $comment, '100' ); ?>
            </div>
            <div class="comment-meta">
                <h5 class="author"><?php comment_author_link(); ?></h5>
                <p class="date"><?php comment_date( $date_format ); ?> <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('Reply', 'noisa' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span></p>
            </div>
            <div class="comment-body">
                <?php comment_text(); ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="message info"><?php _e( 'Your comment is awaiting moderation.', 'noisa' ); ?></p>
                <?php endif; ?> 
            </div>
        </article>
<?php 
}
endif;


/* ----------------------------------------------------------------------
	TAG CLOUD FILTER
/* ---------------------------------------------------------------------- */
function noisa_tag_cloud_filter( $args = array() ) {
   $args['smallest'] = 12;
   $args['largest'] = 12;
   $args['unit'] = 'px';
   return $args;
}

add_filter( 'widget_tag_cloud_args', 'noisa_tag_cloud_filter', 90 );


/* ----------------------------------------------------------------------
    CUSTOM AJAX LOADER (CONTACT FORM 7)
/* ---------------------------------------------------------------------- */

function my_wpcf7_ajax_loader () {
    return  get_template_directory_uri() . '/images/ajax-loader.gif';
}
add_filter( 'wpcf7_ajax_loader', 'my_wpcf7_ajax_loader' );


/* ----------------------------------------------------------------------
	NICE TITLE FILTER
/* ---------------------------------------------------------------------- */
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
*/
if ( ! function_exists( 'noisa_wp_title' ) ) :
function noisa_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'noisa' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'noisa_wp_title', 10, 2 );
endif;


/* ----------------------------------------------------------------------
    SHARE BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_share_buttons' ) ) :
function noisa_share_buttons( $post_id ) {
    return '<div class="share-buttons">
            <a class="circle-btn share-button fb-share-btn" target="_blank" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-facebook"></span></a>
            <a class="circle-btn share-button twitter-share-btn" target="_blank" href="http://twitter.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-twitter"></span></a>
            <a class="circle-btn share-button gplus-share-btn" target="_blank" href="https://plus.google.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-googleplus"></span></a>
            <a class="circle-btn share-button linkedin-share-btn" target="_blank" href="https://www.linkedin.com/cws/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-linkedin"></span></a>
        </div>';

}
endif;


/* ----------------------------------------------------------------------
    STAMP BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_stamp_buttons' ) ) :
function noisa_stamp_buttons( $content ) {
    
    if ( $content === '' ) {
        return;
    }
    $buttons = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $buttons = explode( "\n", $buttons );
    $html = '';

    if ( is_array( $buttons ) ) {
        foreach ( $buttons as $button ) {
            $button = explode( "|", $button );
            if ( is_array( $button ) ) {
                $html .= '<a class="btn stamp-btn" target="' . $button[2] . '" href="' . $button[1] . '">' . $button[0] . '</a>';
            }
        }
    }

    return $html;

}
endif;


/* ----------------------------------------------------------------------
    SOCIAL BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_social_buttons' ) ) :
function noisa_social_buttons( $content ) {
    
    if ( $content === '' ) {
        return;
    }
    $buttons = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $buttons = explode( "\n", $buttons );
    $html = '';

    if ( is_array( $buttons ) ) {
        foreach ( $buttons as $button ) {
            $button = explode( "|", $button );
            if ( is_array( $button ) ) {
                $html .= '<a class="circle-btn" target="_blank" href="' . $button[1] . '"><span class="icon icon-' . $button[0] . '"></span></a>';
            }
        }
    }

    return $html;

}
endif;


/* ----------------------------------------------------------------------
    INTRO TABS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_intro_tabs' ) ) :
function noisa_intro_tabs( $content ) {
    if ( $content === '' ) {
        return;
    }
    $tabs = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $tabs = explode( "\n", $tabs );
    $html = '';

    if ( is_array( $tabs ) ) {
        $html .= '<div class="intro-tabs-wrap intro-tabs-before-init">';
        $html .= '<div class="container">';
        foreach ( $tabs as $tab ) {
            $tab = explode( "|", $tab );
            if ( is_array( $tab ) ) {
                $html .= '<a href="#" data-id="#' . $tab[0] . '">' . $tab[1] . '</a>';
            }
        }
        $html .= '</div></div>';
    }

    return $html;

}
endif;


/* ----------------------------------------------------------------------
	ADD CUSTOM STYLES
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_add_custom_styles' ) ) :
function noisa_add_custom_styles() {
 	
	global $noisa_opts, $wp_query, $paged, $post;

    $custom_css = "";

	// Add styles
    wp_add_inline_style( 'noisa' . '-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'noisa_add_custom_styles' );
endif;


/* ----------------------------------------------------------------------
    SHARE OPTIONS
 ------------------------------------------------------------------------*/
if ( ! function_exists( 'noisa_share_options' ) ) :
function noisa_share_options() {
    global $wp_query; 
    if ( is_single() || is_page() ) { 

        // URL
        echo "\n" .'<meta property="og:url" content="' . get_permalink( $wp_query->post->ID ) . '"/>' . "\n";
        
        // Title
        $share_title = get_post_meta( $wp_query->post->ID, '_share_title', true );
        if ( isset( $share_title ) && $share_title != '' ) {
             echo "\n" .'<meta property="og:title" content="' . esc_html( $share_title ) . '"/>' . "\n";     
        } else {
            // Site name
            echo "\n" .'<meta property="og:title" content="' . get_bloginfo('name') . '"/>' . "\n";     
        }

        // Description
        $share_description = get_post_meta( $wp_query->post->ID, '_share_description', true );
        if ( isset( $share_description ) && $share_description != '' ) {
             echo "\n" .'<meta property="og:description" content="' . esc_html( $share_description ) . '"/>' . "\n";     
        }

        // Image
        $share_image = get_post_meta( $wp_query->post->ID, 'share_image', true );
        if ( isset( $share_image ) ) {
            $image_attributes = wp_get_attachment_image_src( $share_image, 'full' );
            if ( $image_attributes ) {
                echo "\n" .'<meta property="og:image" content="' . $image_attributes[0] . '"/>' . "\n";
            }
        }  

    }
}
add_action( 'wp_head', 'noisa_share_options' ); 
endif;


/* ----------------------------------------------------------------------
    AJAX FILTERS
 ------------------------------------------------------------------------*/

// ARTISTS
function ajax_noisa_artists_filter() {

    global $noisa_opts;

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type' => $obj['cpt'],
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
        'showposts' => $obj['limit'],
        'post_status'     => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ]
            )
        );
    }

    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            if ( has_post_thumbnail() ) {

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-3', $ajax_query->post->ID ) ) . '">';
                $output .= '<div class="grid-media">';
                
                $link_classes = 'thumb thumb-desc';
                $tip = get_post_meta( $ajax_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }

                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="' . $link_classes . '" data-icon="plus">';
                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), 'full' );
                $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa' ) ) . '">';
                $output .= '';

                $output .= '<div class="desc-layer">';
                $output .= '<div class="desc-details">';
                $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                $output .= '<div class="grid-cats">';

                $categories = get_the_terms( $ajax_query->post->ID, 'noisa_artists_genres' );
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
                $output .= '</div>';

                if ( $tip ) {
                    $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                }
                $output .= '</a>';
                $output .= '</div>';
                
                $output .= '</article>';
            }
        } 
       
        $noisa_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_noisa_artists_filter', 'ajax_noisa_artists_filter');
add_action('wp_ajax_noisa_artists_filter', 'ajax_noisa_artists_filter');


// RELEASES
function ajax_noisa_releases_filter() {

    global $noisa_opts;

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type' => $obj['cpt'],
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
        'showposts' => $obj['limit'],
        'post_status'     => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ]
            )
        );
    }

    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-3', $ajax_query->post->ID ) ) . '">';
            $output .= '<div class="grid-media">';
            
            if ( has_post_thumbnail() ) {

                $link_classes = 'thumb thumb-desc';
                $tip = get_post_meta( $ajax_query->post->ID, '_tooltip', true ); 
                if ( isset( $tip ) && $tip != '' ) {
                    $link_classes .= ' tip';
                } else {
                    $tip = false;
                }
                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="' . $link_classes . '">';
                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), 'noisa-release-thumb' );
                $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa' ) ) . '">';
                $output .= '<div class="desc-layer">';
                $output .= '<div class="desc-details">';
                $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                $output .= '<div class="grid-cats">';

                $categories = get_the_terms( $ajax_query->post->ID, 'noisa_releases_genres' );
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
                $output .= '</div>';

                if ( $tip ) {
                    $output .= '<div class="tip-content hidden">' . $tip . '</div>';
                }
               
                $output .= '</a>';
            }
            $output .= '</div>';

            $output .= '</article>';
        } 
       
        $noisa_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_noisa_releases_filter', 'ajax_noisa_releases_filter');
add_action('wp_ajax_noisa_releases_filter', 'ajax_noisa_releases_filter');


// EVENTS
function ajax_noisa_events_filter() {

    global $noisa_opts;

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = 'd/m';
    if ( $noisa_opts->get_option( 'event_date' ) ) {
        $date_format = $noisa_opts->get_option( 'event_date' );
    }

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;


    // ---------------------- All events
    if ( $obj['event_type'] == 'all-events' ) {

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

        if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {

            array_push( $future_tax,
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
            array_push( $past_tax, 
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
        }

        $future_events = get_posts( array(
            'post_type' => 'noisa_events',
            'showposts' => -1,
            'tax_query' => $future_tax,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date_start',
            'order' => 'ASC',
            'post_status'     => 'publish'
        ));

        // Past Events
        $past_events = get_posts(array(
            'post_type' => 'noisa_events',
            'showposts' => -1,
            'tax_query' => $past_tax,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date_start',
            'order' => 'DSC',
            'post_status'     => 'publish'
        ));

        $future_nr = count( $future_events );
        $past_nr = count( $past_events );

        $mergedposts = array_merge( $future_events, $past_events ); //combine queries

        $postids = array();
        foreach( $mergedposts as $item ) {
            $postids[] = $item->ID; //create a new query only of the post ids
        }
        $uniqueposts = array_unique( $postids ); //remove duplicate post ids

        $args = array(
            'post_type' => $obj['cpt'],
            'showposts' => $obj['limit'],
            'post__in'  => $uniqueposts,
            'orderby' => 'post__in'
        );

    // ---------------------- Future or past events
    } else {

        /* Set order */
        $order = $obj['event_type'] == 'future-events' ? $order = 'ASC' : $order = 'DSC';

        // Event type taxonomy
        $taxonomies = array(
            array(
               'taxonomy' => 'noisa_event_type',
               'field' => 'slug',
               'terms' => $obj['event_type']
              )
        );

        if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {

            array_push( $taxonomies, 
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
        }

        // Begin Loop
        $args = array(
            'post_type'        => $obj['cpt'],
            'showposts'        => $obj['limit'],
            'tax_query'        => $taxonomies,
            'orderby'          => 'meta_value',
            'meta_key'         => '_event_date_start',
            'order'            => $order,
            'suppress_filters' => 0, // WPML FIX,
            'post_status'     => 'publish'
        );
    }

    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            /* Event Date */
            $event_time_start = get_post_meta( $ajax_query->post->ID, '_event_time_start', true );
            $event_date_start = get_post_meta( $ajax_query->post->ID, '_event_date_start', true );
            $event_date_start = strtotime( $event_date_start );
            

            if ( $obj['display_type'] == 'grid' ) {
                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-3', $ajax_query->post->ID ) ) . '">';

                if ( has_post_thumbnail() ) {
                    $output .= '<div class="grid-media">';

                    $link_classes = 'thumb thumb-event';
                    if ( has_term( 'past-events', 'noisa_event_type' ) ) {
                        $link_classes .= ' past-event';
                    }    
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" class="' . $link_classes . '">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), 'full' );
                    $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa' ) ) . '">';
                    $output .= '<div class="desc-layer">';
                    $output .= '<div class="desc-details">';

                    // Meta top
                    $output .= '<div class="event-meta-top">';
                    $output .= '<span class="event-day">' . date_i18n( 'D', $event_date_start ) . '</span>';
                    $output .= '<span class="event-locations">';

                        $categories = get_the_terms( $ajax_query->post->ID, 'noisa_events_locations' );
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

                        $categories = get_the_terms( $ajax_query->post->ID, 'noisa_events_artists' );
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
                        $output .= '<span class="pill-btn medium">' . __( 'Past Event', 'noisa' ) . '</span>';
                    }    
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '</a>';

                    $output .= '</div>';
                    $output .= '</article>';

                }
            } elseif ( $obj['display_type'] == 'list' ) {

                $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item', $ajax_query->post->ID ) ) . '">';
                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="event-li">';
                $output .= '<span class="date">' . date_i18n( $date_format, $event_date_start );
                if ( has_term( 'past-events', 'noisa_event_type' ) ) {
                    $output .= '<span class="past-event-label">' . __( 'Past Event', 'noisa' ) . '</span>';
                }    
                $output .= '</span>';
                $output .= '<span class="venue">';

                    $categories = get_the_terms( $ajax_query->post->ID, 'noisa_events_locations' );
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
            
        } 
       
        $noisa_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_noisa_events_filter', 'ajax_noisa_events_filter');
add_action('wp_ajax_noisa_events_filter', 'ajax_noisa_events_filter');


// GALLERY
function ajax_noisa_gallery_filter() {

    global $noisa_opts;

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = 'd/m/y';
    if ( $noisa_opts->get_option( 'custom_date' ) ) {
        $date_format = $noisa_opts->get_option( 'custom_date' );
    }

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type' => $obj['cpt'],
        'showposts' => $obj['limit'],
        'post_status'     => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ]
            )
        );
    }

    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            $output .= '<article class="' . implode( ' ', get_post_class( 'masonry-item masonry-item-1-3', $ajax_query->post->ID ) ) . '">';
            $output .= '<div class="grid-media">';
            
            if ( has_post_thumbnail() ) {

                // IDS
                $images_ids = get_post_meta( $ajax_query->post->ID, '_gallery_ids', true ); 

                if ( $images_ids || $images_ids != '' ) {
                    $ids = explode( '|', $images_ids );
                    $ids = count( $ids );
                } else {
                    $ids = '0';
                }

                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="thumb thumb-desc">';
                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), 'large' );
                $output .= '<img src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr( __( 'Post Image', 'noisa' ) ) . '">';
                $output .= '<div class="desc-layer">';
                $output .= '<div class="images-count">' . $ids . '</div>';
                $output .= '<div class="desc-details desc-full">';
                $output .= '<h2 class="grid-title">' . get_the_title() . '</h2>';
                $output .= '<div class="grid-date">' . get_the_time( $date_format ) . '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</a>';
            }
            $output .= '</div>';
            $output .= '</article>';
        } 
       
        $noisa_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_noisa_gallery_filter', 'ajax_noisa_gallery_filter');
add_action('wp_ajax_noisa_gallery_filter', 'ajax_noisa_gallery_filter');


// GALLERY IMAGES
function ajax_noisa_gallery_images() {

    global $noisa_opts;

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';
    $obj;
    
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }

    if ( ! isset( $obj ) ) {
        die();
    }

    // ID
    $obj['id'] = (int)$obj['id'];

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // IDS
    $images_ids = get_post_meta( $obj['id'], '_gallery_ids', true ); 

    if ( ! $images_ids || $images_ids == '' ) {
        die();
    }

    $ids = explode( '|', $images_ids ); 
    
    // Begin Loop
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post__in' => $ids,
        'orderby' => 'post__in',
        'post_status' => 'any',
        'showposts' => $obj['limit']
    );
    

    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

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
            $image = get_post_meta( $obj['id'], '_gallery_ids_' . get_the_id(), true );

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

            if ( $image[ 'thumb_icon' ] == 'view' ) {
                                    $image[ 'thumb_icon' ] = 'search';
            } else if ( $image[ 'thumb_icon' ] == 'video' ) {
                $image[ 'thumb_icon' ] = 'play2';
            }

            $output .= '<div class="masonry-item gallery-album-image flex-col-1-4">';
            $output .= '<a href="' . esc_attr( $link ) .'" class="thumb thumb-desc ' . esc_attr( $link_class  ) . ' g-item" title="' . esc_attr( $image['title'] ) . '" data-group="gallery">';
            $output .= '<img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( __( 'Gallery thumbnail', 'noisa' ) ) . '" title="' . esc_attr( $image['title'] ) . '">';
            $output .= '<div class="desc-layer"><span class="thumb-icon"><span class="icon icon-' . esc_attr( $image[ 'thumb_icon' ] ) . '"></span></span></div>';
            $output .= '</a>';            
            $output .= '</div>';
          
        } 
       
        $noisa_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_noisa_gallery_images', 'ajax_noisa_gallery_images');
add_action('wp_ajax_noisa_gallery_images', 'ajax_noisa_gallery_images');
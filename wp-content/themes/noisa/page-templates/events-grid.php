<?php
/**
 * Template Name: Events Grid
 *
 * @package noisa
 * @since 1.0.0
 */

get_header(); ?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>

<?php 
    global $noisa_opts, $wp_query, $post;

    // Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

    // Event Type
    $event_type = get_post_meta( $wp_query->post->ID, '_event_type', true );

    // Pagination Limit
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // Events Grid Layout
    $events_layout = get_post_meta( $wp_query->post->ID, '_events_layout', true );

    // Gap
    $gap = get_post_meta( $wp_query->post->ID, '_gap', true );

    // Event Thumb Style
    $event_thumb_style = get_post_meta( $wp_query->post->ID, '_event_thumb_style', true );

    // Date format
    $date_format = 'd/m';
    if ( $noisa_opts->get_option( 'event_date' ) ) {
        $date_format = $noisa_opts->get_option( 'event_date' );
   }

    if ( $events_layout == 'full-width' ) {
        $events_cols = '3';
    }

?>

<!-- ############ EVENTS GRID ############ -->
<div id="content" class="filter-content">
    <!-- ############ Container ############ -->
    <div class="container clearfix <?php echo esc_attr( $events_layout ) ?> <?php echo esc_attr( $event_thumb_style ) ?>">

    	<!--############ Events Grid grid ############ -->
    	<div class="grid-wrapper clearfix" data-grid="events-grid">

            <!--############ Filters ############ -->
            <div class="filters-wrapper filter-3 container clearfix">
                
                <!-- Filter -->
                <div class="filter" data-obj='{"action": "noisa_events_filter", "filterby": "taxonomy", "cpt": "noisa_events", "tax": "noisa_events_artists", "limit": "<?php echo esc_attr( $limit ); ?>", "event_type": "<?php echo esc_attr( $event_type ); ?>", "display_type": "grid"}' >
                    <div class="filter-dropdown">
                        <div class="filter-collpase-btn">
                            <h4 class="filter-title-anim"><?php echo esc_attr( __( 'Filter by', 'noisa' ) ) ?></h4>
                            <h4 class="filter-title filter-title-anim" data-filter-name=""><?php echo esc_attr( __( 'All Artists', 'noisa' ) ) ?></h4>
                            <span class="filter-btn-icon"></span>
                        </div>
                        <div class="filter-dropdown-content">
                            <ul data-filter-group="">
                                <li><a href="#" data-filter-name="all"><h3><?php echo esc_attr( __( 'All Artists', 'noisa' ) ) ?></h3></a></li>
                                    <?php 
                                        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                                        $terms = get_terms( 'noisa_events_artists', $term_args );
                                        if ( $terms ) {
                                            foreach ( $terms as $term ) {
                                                echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><h3>' . $term->name . '</h3></a></li>';
                                            }
                                        }
                                    ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /filter -->

                <!-- Filter -->
                <div class="filter" data-obj='{"action": "noisa_events_filter", "filterby": "taxonomy", "cpt": "noisa_events", "tax": "noisa_events_locations", "limit": "<?php echo esc_attr( $limit ); ?>", "event_type": "<?php echo esc_attr( $event_type ); ?>", "display_type": "grid"}' >
                    <div class="filter-dropdown">
                        <div class="filter-collpase-btn">
                            <h4 class="filter-title-anim"><?php echo esc_attr( __( 'Filter by', 'noisa' ) ) ?></h4>
                            <h4 class="filter-title filter-title-anim" data-filter-name=""><?php echo esc_attr( __( 'All Locations', 'noisa' ) ) ?></h4>
                            <span class="filter-btn-icon"></span>
                        </div>
                        <div class="filter-dropdown-content">
                            <ul data-filter-group="">
                                <li><a href="#" data-filter-name="all"><h3><?php echo esc_attr( __( 'All Locations', 'noisa' ) ) ?></h3></a></li>
                                    <?php 
                                        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                                        $terms = get_terms( 'noisa_events_locations', $term_args );
                                        if ( $terms ) {
                                            foreach ( $terms as $term ) {
                                                echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><h3>' . $term->name . '</h3></a></li>';
                                            }
                                        }
                                    ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /filter -->

                <!-- Filter -->
                <div class="filter" data-obj='{"action": "noisa_events_filter", "filterby": "taxonomy", "cpt": "noisa_events", "tax": "noisa_events_cats", "limit": "<?php echo esc_attr( $limit ); ?>", "event_type": "<?php echo esc_attr( $event_type ); ?>", "display_type": "grid"}' >
                    <div class="filter-dropdown">
                        <div class="filter-collpase-btn">
                            <h4 class="filter-title-anim"><?php echo esc_attr( __( 'Filter by', 'noisa' ) ) ?></h4>
                            <h4 class="filter-title filter-title-anim" data-filter-name=""><?php echo esc_attr( __( 'All Categories', 'noisa' ) ) ?></h4>
                            <span class="filter-btn-icon"></span>
                        </div>
                        <div class="filter-dropdown-content">
                            <ul data-filter-group="">
                                <li><a href="#" data-filter-name="all"><h3><?php echo esc_attr( __( 'All Categories', 'noisa' ) ) ?></h3></a></li>
                                    <?php 
                                        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                                        $terms = get_terms( 'noisa_events_cats', $term_args );
                                        if ( $terms ) {
                                            foreach ( $terms as $term ) {
                                                echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><h3>' . $term->name . '</h3></a></li>';
                                            }
                                        }
                                    ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /filter -->

            </div>

        	<div class="masonry <?php echo esc_attr( $gap ) ?> events-grid masonry-anim clearfix">	
        		<?php

                    $thumb_size = 'large';

                    if ( $event_type == 'all-events' ) {

                        // Future Events
                        $future_events = get_posts( array(
                            'post_type' => 'noisa_events',
                            'showposts' => -1,
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'noisa_event_type',
                                    'field' => 'slug',
                                    'terms' => 'future-events'
                                )
                            ),
                            'orderby' => 'meta_value',
                            'meta_key' => '_event_date_start',
                            'order' => 'ASC'
                        ));

                        // Past Events
                        $past_events = get_posts(array(
                            'post_type' => 'noisa_events',
                            'showposts' => -1,
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'noisa_event_type',
                                    'field' => 'slug',
                                    'terms' => 'past-events'
                                ),
                            ),
                            'orderby' => 'meta_value',
                            'meta_key' => '_event_date_start',
                            'order' => 'DSC'
                        ));

                        $future_nr = count( $future_events );
                        $past_nr = count( $past_events );

                        // echo "Paged: $paged, Future events: $future_nr, Past events: $past_nr";

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
                            'paged'     => $paged,
                            'post__in'  => $uniqueposts,
                            'orderby' => 'post__in'
                        );

                    } else {

            			// Begin Loop

            			/* Set order */
                        $order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';

                        // Event type taxonomy
                        $tax = array(
                            array(
                               'taxonomy' => 'noisa_event_type',
                               'field' => 'slug',
                               'terms' => $event_type
                              )
                        );

                        // Begin Loop
                        $args = array(
                            'post_type'        => 'noisa_events',
                            'showposts'        => $limit,
                            'tax_query'        => $tax,
                            'orderby'          => 'meta_value',
                            'meta_key'         => '_event_date_start',
                            'order'            => $order,
                            'suppress_filters' => 0 // WPML FIX
                        );

                    }
        			$wp_query = new WP_Query();
        			$wp_query->query( $args );
                ?>
        	
        	 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <?php if ( has_post_thumbnail() ) : ?> 
                    <article <?php post_class( 'masonry-item masonry-item-1-3' ); ?>>
            			<div class="grid-media">
                            <a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb thumb-event <?php if ( has_term( 'past-events', 'noisa_event_type' ) ) { echo 'past-event'; } ?>">
                                <?php 
                                    /* Event Date */
                                    $event_time_start = get_post_meta( $wp_query->post->ID, '_event_time_start', true );
                                    $event_date_start = get_post_meta( $wp_query->post->ID, '_event_date_start', true );
                                    $event_date_start = strtotime( $event_date_start );

                                    $event_date_end = strtotime( get_post_meta( $wp_query->post->ID, '_event_date_end', true ) );
                                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size );

                                    ?>
                                <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                                <div class="desc-layer">
                                    <div class="desc-details">
                                        <div class="event-meta-top">
                                            <span class="event-day"><?php echo date_i18n( 'D', $event_date_start ); ?></span>
                                            <span class="event-locations">
                                            <?php
                                                $categories = get_the_terms( $post->ID, 'noisa_events_locations' );
                                                $separator = ' / ';
                                                $cats = '';
                                                if ( ! empty( $categories ) ) {
                                                   foreach( $categories as $term ) {

                                                    $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                                                    }
                                                }
                                                echo trim( $cats, $separator );
                                             ?>
                                             </span>
                                        </div>
                                        <div class="event-meta-bottom">
                                            <span class="event-date"><?php echo date_i18n( $date_format, $event_date_start ); ?></span>
                                            <?php the_title( '<h2 class="grid-title">', '</h2>' ); ?>
                                            <span class="event-artists">
                                            <?php
                                                $categories = get_the_terms( $post->ID, 'noisa_events_artists' );
                                                $separator = ' / ';
                                                $cats = '';
                                                if ( ! empty( $categories ) ) {
                                                   foreach( $categories as $term ) {

                                                    $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                                                    }
                                                }
                                                echo trim( $cats, $separator );
                                             ?>
                                             </span>
                                             <?php if ( has_term( 'past-events', 'noisa_event_type' ) ) : ?>
                                                <span class="pill-btn medium"><?php _e( 'Past Event', 'noisa' ) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
            		</article>
                <?php endif; // end has_post_thumbnail  ?>
        		<?php endwhile; // End Loop ?>
                <?php endif; ?>

        	</div>
            <div class="clear"></div>

            <div class="load-more-wrap text-center">
                <a href="#" data-pagenum="2" class="btn btn-medium load-more"><span class="icon-wrap"><span class="icon"></span></span> <?php _e( 'Load more', 'noisa' ) ?></a>
            </div>

            <div class="ajax-messages">
                <div class="message ajax-error">
                    <span class="message-title">
                        <?php _e( 'Upsss!', 'noisa' ) ?>
                    </span>
                    <span class="message-body">
                        <?php _e( 'Sorry, something went wrong and we cannot retrieve any results.', 'noisa' ) ?>
                    </span>
                </div>
            </div>

        </div> 
        <!-- /grid wrapper -->
    </div>
    <!-- /container -->
</div>
<!-- /page -->
<?php
   // Get orginal query
   $post = $temp_post;
   $wp_query = $query_temp;
?>
<?php get_footer(); ?>
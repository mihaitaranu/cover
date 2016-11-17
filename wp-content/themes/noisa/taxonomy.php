<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			taxonomy.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
	// Get Category Intro Section
	get_template_part( 'inc/tag-intro' );

?>

<?php 
   	global $noisa_opts, $wp_query, $post;

   	// Vars
   	$thumb_size = 'full';
   	$classes = '';

   	// Current TAX
	$queried_object = get_queried_object();
	$taxonomy = $queried_object->taxonomy;
	$term_id = $queried_object->term_id;

	// Date format
    $date_format = 'd/m/y';
    if ( $noisa_opts->get_option( 'custom_date' ) ) {
        $date_format = $noisa_opts->get_option( 'custom_date' );
    }

   	// Artists
   	if ( is_tax( 'noisa_artists_genres' ) || is_tax( 'noisa_artists_cats' ) )  {
   		$tax = 'artists';
		$thumb_size = 'full';
		$grid_layout = $noisa_opts->get_option( 'artists_cat_layout' );
		$gap = $noisa_opts->get_option( 'gap_artists' );
		$classes .= 'artists-grid';

	// Releases
	} elseif ( is_tax( 'noisa_releases_genres' ) || is_tax( 'noisa_releases_cats' ) || is_tax( 'noisa_releases_artists' ) )  {
		$tax = 'releases';
		$thumb_size = 'noisa-release-thumb';
		$grid_layout = $noisa_opts->get_option( 'releases_cat_layout' );
		$gap = $noisa_opts->get_option( 'gap_releases' );
		$classes .= 'releases-grid';

	// Gallery
	} elseif ( is_tax( 'noisa_gallery_artists' ) || is_tax( 'noisa_releases_cats' ) )  {
		$tax = 'gallery';
		$thumb_size = 'noisa-release-thumb';
		$grid_layout = $noisa_opts->get_option( 'gallery_cat_layout' );
		$gap = $noisa_opts->get_option( 'gap_gallery' );
		$classes .= 'gallery-grid';

	// Events
	} elseif ( is_tax( 'noisa_events_artists' ) || is_tax( 'noisa_events_cats' ) || is_tax( 'noisa_events_locations' ) )  {
		$tax = 'events';
		$thumb_size = 'large';
		$grid_layout = $noisa_opts->get_option( 'events_cat_layout' );
		$gap = $noisa_opts->get_option( 'gap_events' );
		$classes .= 'events-grid';

		// Date format
	    $date_format = 'd/m';
	    if ( $noisa_opts->get_option( 'event_date' ) ) {
	        $date_format = $noisa_opts->get_option( 'event_date' );
	   	}

		// Limit
		$limit = 6;

		// Count
		$count = 1;
		$paged_events = $paged;
		if ( $paged_events > 0 ) {
			$paged_events = $paged_events-1;
		}
		$events_count = ($paged_events*$limit)+1;

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
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_id
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
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_id
				)	
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

	 	$wp_query = new WP_Query();
		$wp_query->query( $args );
		}
	?>
		
<!-- ############ CONTENT ############ -->
<div id="content">

	<!-- ############ Container ############ -->
	<div class="container taxonomies-grid clearfix <?php echo esc_attr( $grid_layout ) ?>">
		<?php if ( have_posts() ) : ?>
				
			<div class="masonry masonry-anim <?php echo esc_attr( $gap ) ?> <?php echo esc_attr( $classes ) ?>">

			<?php // Start the Loop.
			while ( have_posts() ) : the_post() ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<article <?php post_class( 'masonry-item masonry-item-1-3' ); ?>>
    				<div class="grid-media">
						<?php 

						// Artists
						if ( $tax == 'artists' ) : ?>
						
                        <?php 
                            $thumb_classes = 'thumb thumb-desc';
                            $tip = get_post_meta( $wp_query->post->ID, '_tooltip', true ); 
                            if ( isset( $tip ) && $tip != '' ) {
                                $thumb_classes .= ' tip';
                            } else {
                                $tip = false;
                            }
                        ?>
                        <a href="<?php echo esc_url( get_permalink() ) ?>" class="<?php echo esc_attr( $thumb_classes ) ?>" data-icon="plus">
                         
                            <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                            <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                            
                            <div class="desc-layer">
                                <div class="desc-details">
                                    <?php the_title( '<h2 class="grid-title">', '</h2>' ); ?>
                                    <div class="grid-cats">
                                        
                                        <?php 
                                            $categories = get_the_terms( $post->ID, 'noisa_artists_genres' );
                                            $separator = ' / ';
                                            $cats = '';
                                            if ( ! empty( $categories ) ) {
                                               foreach( $categories as $term ) {

                                                $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                                                }
                                            }
                                            echo trim( $cats, $separator );

                                         ?>

                                    </div>
                                </div>
                            </div>
                            <?php if ( $tip ) : ?>
                                <!-- tooltip -->
                                <div class="tip-content hidden">
                                    <?php $noisa_opts->e_esc( $tip ) ?>
                                </div>
                                <!-- /tooltip -->
                            <?php endif; ?>
                        </a>

						<?php 

						// Releases
						elseif ( $tax == 'releases' ) : ?>
							<?php 
                                $thumb_classes = 'thumb thumb-desc';
                                $tip = get_post_meta( $wp_query->post->ID, '_tooltip', true ); 
                                if ( isset( $tip ) && $tip != '' ) {
                                    $thumb_classes .= ' tip';
                                } else {
                                    $tip = false;
                                }
                            ?>
                             <a href="<?php echo esc_url( get_permalink() ) ?>" class="<?php echo esc_attr( $thumb_classes ) ?>" data-icon="plus">
                         
                            <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                            <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                            
                            <div class="desc-layer">
                                <div class="desc-details">
                                    <?php the_title( '<h2 class="grid-title">', '</h2>' ); ?>
                                    <div class="grid-cats">
                                        
                                        <?php 
                                            $categories = get_the_terms( $post->ID, 'noisa_releases_genres' );
                                            $separator = ' / ';
                                            $cats = '';
                                            if ( ! empty( $categories ) ) {
                                               foreach( $categories as $term ) {

                                                $cats .= '<span>' . esc_html( $term->name ) . '</span>' . $separator;
                                                }
                                            }
                                            echo trim( $cats, $separator );

                                         ?>

                                    </div>
                                </div>
                            </div>
                            <?php if ( $tip ) : ?>
                                <!-- tooltip -->
                                <div class="tip-content hidden">
                                    <?php $noisa_opts->e_esc( $tip ) ?>
                                </div>
                                <!-- /tooltip -->
                            <?php endif; ?>
                        </a>
						<?php

						// Gallery
						elseif ( $tax == 'gallery' ) : 

							// IDS
		                    $images_ids = get_post_meta( $post->ID, '_gallery_ids', true ); 

		                    if ( $images_ids || $images_ids != '' ) {
		                        $ids = explode( '|', $images_ids );
		                        $ids = count( $ids );
		                    } else {
		                        $ids = '0';
		                    }

							?>

							<a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb thumb-desc">
                         
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                                <div class="desc-layer">
                                    <div class="images-count">
                                        <?php $noisa_opts->e_esc( $ids ) ?>
                                    </div>
                                    <div class="desc-details desc-full">
                                        <?php the_title( '<h2 class="grid-title">', '</h2>' ); ?>
                                        <div class="grid-date"><?php the_time( $date_format ); ?></div>
                                    </div>
                                </div>
                            
                        	</a>
						<?php	

						// Events
						elseif ( $tax == 'events' ) : ?>
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
	                	<?php endif; // end $tax ?>
					</div>
            	</article>
            <?php endif; // end has_post_thumbnail ?>
	
			<?php endwhile; ?>

			</div>
			<!-- /masonry -->
			<div class="clear"></div>
			<?php noisa_paging_nav(); ?>

		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'noisa' ); ?></p>
		<?php endif; // have_posts() ?>
			
	</div>
    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>
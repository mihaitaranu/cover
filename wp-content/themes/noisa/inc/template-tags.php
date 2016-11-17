<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			template-tags.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	POST PAGINATION
	Display navigation to next/previous set of posts when applicable.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_paging_nav' ) ) :
function noisa_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Prev', 'noisa' ),
		'next_text' => __( 'Next &rarr;', 'noisa' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation">
		<div class="pagination loop-pagination">
			<?php 
			echo paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '&larr; Prev', 'noisa' ),
				'next_text' => __( 'Next &rarr;', 'noisa' ),
			) );

			?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;


/* ----------------------------------------------------------------------
	POST NAVIGATION
	Display navigation to next/previous post when applicable.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_post_nav' ) ) :
function noisa_post_nav() {
	global $post;
	
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$post_type = get_post_type( $post->ID );

	if ( ! $next && ! $previous ) {
		return;
	}

	$next_label = __( 'Next Post', 'noisa' );
	$prev_label = __( 'Prev Post', 'noisa' );


	$next_link = get_adjacent_post( false,'',false );          
	$prev_link = get_adjacent_post( false,'',true ); 

	$next_post_thumb = '';
	$prev_post_thumb = '';

	if ( $next_link ) {
		if ( has_post_thumbnail( $next_link->ID ) ) {
		 	$next_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_link->ID ), 'thumbnail' );
		 	$next_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . $next_post_thumb[0] . ')"></span>';
		}
	}

	if ( $prev_link ) {
		if ( has_post_thumbnail( $prev_link->ID ) ) {
		 	$prev_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_link->ID ), 'thumbnail' );
		 	$prev_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . $prev_post_thumb[0] . ')"></span>';
		}
	}

	?>
	<nav class="navigation post-navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				echo '<span class="attachment-post-link">';
				previous_post_link( '%link', '<span class="meta-nav">' . __( 'Published In', 'noisa' ) . '</span>' . __( '%title', 'noisa' ) );
				echo '</span>';
			else :
				if ( empty( $prev_link ) && $next_link ) {
					echo '<span class="post-nav-inner link-empty"></span>';
					 echo '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $next_link->ID ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-label">' . $next_label . '</span></a></span>';
				} else if ( $prev_link && empty( $next_link ) ) {
					 echo '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $prev_link->ID ) ) . '" class="prev-link"><span class="nav-label">' . $prev_label . '</span>' . $prev_post_thumb . '</a></span>';
					echo '<span class="post-nav-inner link-empty"></span>';
				} else if ( $prev_link && $next_link  ) {
					 echo '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $prev_link->ID ) ) . '" class="prev-link"><span class="nav-label">' . $prev_label . '</span>' . $prev_post_thumb . '</a></span>';
					 echo '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $next_link->ID ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-label">' . $next_label . '</span></a></span>';
				}
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


/* ----------------------------------------------------------------------
	POST NAVIGATION WITH CUSTOM ORDER
	Display navigation to next/previous post with custom order for special CP.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'noisa_custom_post_nav' ) ) :
function noisa_custom_post_nav() {
	global $post;

	if ( isset( $post ) ) {
		$backup = $post;
	}

	$output = '';
	$post_type = get_post_type($post->ID);
	$id = $post->ID;
	$count = 0;
	$prev_id = '';
	$next_id = '';
	$posts = array();
	$next_label = __( 'Next Post', 'noisa' );
	$prev_label = __( 'Prev Post', 'noisa' );

	if ( $post_type == 'noisa_gallery' || $post_type == 'noisa_releases' || $post_type == 'noisa_artists' || $post_type = 'noisa_events' ) {

		// Release
		if ( $post_type == 'noisa_releases' ) {
			
			$args = array(
				'post_type' => 'noisa_releases',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';

			$next_label = __( 'Next Release', 'noisa' );
			$prev_label = __( 'Prev Release', 'noisa' );
		}

		// Gallery
		if ( $post_type == 'noisa_gallery' ) {
			
			$args = array(
				'post_type' => 'noisa_gallery',
				'showposts'=> '-1'
			);

			$next_label = __( 'Next Album', 'noisa' );
			$prev_label = __( 'Prev Album', 'noisa' );
		}

		// Artists
		if ( $post_type == 'noisa_artists' ) {
			
			$args = array(
				'post_type' => 'noisa_artists',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';

			$next_label = __( 'Next Artist', 'noisa' );
			$prev_label = __( 'Prev Artist', 'noisa' );
		}

		// Events
		if ( $post_type == 'noisa_events' ) {
			if ( is_object_in_term( $post->ID, 'noisa_event_type', 'future-events' ) ) {
				$event_type = 'future-events';
			} else {
				$event_type = 'past-events';
			}
			$order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';
			$args = array(
				'post_type' => 'noisa_events',
				'tax_query' => 
					array(
						array(
						'taxonomy' => 'noisa_event_type',
						'field' => 'slug',
						'terms' => $event_type
						)
					),
				'showposts'=> '-1',
				'orderby' => 'meta_value',
				'meta_key' => '_event_date_start',
				'order' => $order
			);

			$next_label = __( 'Next Event', 'noisa' );
			$prev_label = __( 'Prev Event', 'noisa' );
		}

		// Nav loop
		$nav_query = new WP_Query();
		$nav_query->query( $args );
		if ( $nav_query->have_posts() )	{
			while ( $nav_query->have_posts() ) {
				$nav_query->the_post();
				$posts[] = get_the_id();
				if ( $count == 1 ) break;
				if ( $id == get_the_id() ) $count++;
			}
			$current = array_search( $id, $posts );

			$next_post_thumb = '';
			$prev_post_thumb = '';

			// Check IDs
			if ( isset( $posts[$current-1] ) ) {
				$prev_id = $posts[$current-1];
				if ( has_post_thumbnail( $prev_id ) ) {
				 	$prev_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_id ), 'thumbnail' );
				 	$prev_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . $prev_post_thumb[0] . ')"></span>';
				}

			}
			if ( isset( $posts[$current+1] ) ) {
				$next_id = $posts[$current+1];
				if ( has_post_thumbnail( $next_id ) ) {

				 	$next_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_id ), 'thumbnail' );
				 	$next_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . $next_post_thumb[0] . ')"></span>';
				}
			}

			// Display nav
			$output .= '
			<nav class="navigation post-navigation">
			<div class="nav-links">';

			if ( $prev_id === '' && $next_id !== '' ) {
					$output .= '<span class="post-nav-inner link-empty"></span>';
					$output .= '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $next_id ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-label">' . $next_label . '</span></a></span>';
				} else if ( $prev_id !== '' && $next_id === '' ) {
					$output .= '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $prev_id ) ) . '" class="prev-link"><span class="nav-label">' . $prev_label . '</span>' . $prev_post_thumb . '</a></span>';
					$output .= '<span class="post-nav-inner link-empty"></span>';
				} else if ( $prev_id !== '' && $next_id !== '' ) {
					$output .= '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $prev_id ) ) . '" class="prev-link"><span class="nav-label">' . $prev_label . '</span>' . $prev_post_thumb . '</a></span>';
					$output .= '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $next_id ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-label">' . $next_label . '</span></a></span>';
				}

			$output .= '</div></nav>';
		}

		if ( isset( $post ) ) {
			$post = $backup;
		}
		
		return $output;
	} else {
		return false;
	}
}
endif;
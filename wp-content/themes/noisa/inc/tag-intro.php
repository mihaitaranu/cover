<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			tag-intro.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

global $noisa_opts, $wp_query, $post;
$title = '';
$subtitle = __( 'Here are some news from our music site.', 'noisa' );

// Animate
if ( $noisa_opts->get_option( 'page_title_animations' ) == 'on' ) {
	$animated = 'anim-css';
} else {
	$animated = '';
}

// Categories
if ( is_category() ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Category', 'noisa' );
}
// Author
elseif ( is_author() ) {
	$author_id = $wp_query->post->post_author;
	$title = get_the_author_meta( 'display_name', $author_id );
	$subtitle = __( 'Author Posts', 'noisa' );
}
// Tags
elseif ( is_tag() ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Tag', 'noisa' );
}
// Releases
elseif ( is_tax( 'noisa_releases_genres' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Release genre', 'noisa' );
}
elseif ( is_tax( 'noisa_releases_artists' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Artist releases', 'noisa' );
}
elseif ( is_tax( 'noisa_releases_cats' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Release category', 'noisa' );
}
// Artists
elseif ( is_tax( 'noisa_artists_genres' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Artist genre', 'noisa' );
}
elseif ( is_tax( 'noisa_artists_cat' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Artist category', 'noisa' );
}
// Gallery
elseif ( is_tax( 'noisa_gallery_artists' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Gallery artist', 'noisa' );
}
elseif ( is_tax( 'noisa_gallery_cats' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Gallery category', 'noisa' );
}
// Events
elseif ( is_tax( 'noisa_events_artists' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Events artist', 'noisa' );
}
elseif ( is_tax( 'noisa_events_cats' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Events category', 'noisa' );
}
elseif ( is_tax( 'noisa_events_locations' ) ) {
	$title = single_cat_title('', false);
	$subtitle = __( 'Events location', 'noisa' );
}

// Archive
elseif (is_archive()) {
	if ( is_year() ) {
		$title = get_the_time( 'Y' );
	}
	if ( is_month() ) { 
		$title = get_the_time( 'F, Y' );
	}
	if ( is_day() || is_time() ) {
		$title  = get_the_time( 'l - ' . $noisa_opts->get_option( 'custom_date' ) );
	}
	$subtitle = __( 'Archives', 'noisa' );
}
// Search
elseif ( is_search() ) {
	$title = get_search_query();
	$subtitle = __( 'Search Results', 'noisa' );
}

?>
<section class="intro-page-title <?php echo esc_attr( $animated ); ?> intro clearfix <?php echo esc_attr( $noisa_opts->get_option( 'page_title_bg_color' ) ) ?>" style="min-height:400px;">
	<!-- Captions -->
	<div class="intro-captions">
		<div class="container">
			<div class="caption-top">
				<h2 class="caption-title">
					<?php echo do_shortcode( $title ); ?>
				</h2>
			</div>
			<hr class="caption-divider">
			<div class="caption-bottom">
				<?php if ( $subtitle != '' ) : ?>
				<h6 class="caption-subtitle"><?php echo do_shortcode( $subtitle ) ?></h6>
				<?php endif; ?>
			</div>	
		</div>
	</div>
</section>
<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			single-noisa_gallery.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php get_header(); ?>


<?php 
   global $noisa_opts, $wp_query, $post;

   	// Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

   	// Pagination Limit
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

   	/* Images per row */
   	$images_per_row = get_post_meta( $wp_query->post->ID, '_images_per_row', true );

?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>

<!-- ############ GALLERY ############ -->
<div id="content">

    <!-- ############ Container ############ -->
    <div class="container clearfix">
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/* Album ID */
				$album_id = get_the_id();

				/* Images ids */
		        $images_ids = get_post_meta( $wp_query->post->ID, '_gallery_ids', true ); 

				the_content();

		        ?>

			<?php endwhile; ?>

			<?php wp_reset_query(); ?>

			<?php if ( $images_ids || $images_ids !== '' ) :

				$ids = explode( '|', $images_ids ); 
	           	$gallery_loop_args = array(
	                'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'post__in' => $ids,
					'orderby' => 'post__in',
					'post_status' => 'any',
	                'showposts' => $limit
				);
				$wp_query = new WP_Query();
				$wp_query->query( $gallery_loop_args );
				?>
			
				<!--############ Artists grid ############ -->
	        	<div class="grid-wrapper clearfix" data-grid="gallery-images-grid">

					<?php if ( have_posts() ) : ?>
					
						<div class="masonry gallery-images-grid masonry-anim clearfix">

							<?php while ( have_posts() ) : the_post(); ?>
								
							<?php 
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
								} else {
									$link = wp_get_attachment_image_src( get_the_id(), 'full' );
									$link = $link[0];
								}
								if ( $image[ 'thumb_icon' ] == 'view' ) {
									$image[ 'thumb_icon' ] = 'search';
								} else if ( $image[ 'thumb_icon' ] == 'video' ) {
									$image[ 'thumb_icon' ] = 'play2';
								}

								?>

								<div class="masonry-item gallery-album-image flex-col-1-4">
									
									<a href="<?php echo esc_attr( $link ) ?>" class="thumb thumb-desc <?php if ( $image[ 'custom_link' ] != '' ) { echo 'iframe-link'; } ?> g-item" title="<?php echo esc_attr( $image['title'] ); ?>" data-group="gallery">
										<img src="<?php echo esc_url( $image['src'] ) ?>" alt="<?php echo esc_attr( __( 'Gallery thumbnail', 'noisa' ) ); ?>" title="<?php echo esc_attr( $image['title'] ); ?>">
										<div class="desc-layer">
                                    		<span class="thumb-icon"><span class="icon icon-<?php echo esc_attr( $image[ 'thumb_icon' ] ) ?>"></span></span>
                                    	</div>
										
									</a>
									
								</div>

							<?php endwhile; // End Loop ?>

						</div>
					<?php endif; ?>
					
					<!-- Load more -->
		            <div class="grid-wrapper hidden" data-grid="gallery-images-grid">
		            	<div class="filters-wrapper">
		                	<div class="filter" data-obj='{"action": "noisa_gallery_images", "filter_name" : "all", "limit": "<?php echo esc_attr( $limit ); ?>", "id": "<?php echo esc_attr( $album_id ); ?>"}' ></div>
		            	</div>
		            </div>
					<div class="load-more-wrap text-center">
                		<a href="#" data-pagenum="2" class="btn btn-medium load-more"><span class="icon-wrap"><span class="icon"></span></span> <?php _e( 'Load more', 'noisa' ) ?></a>
            		</div>
				</div>
				<div class="clear"></div>

			<?php else : ?>
				<?php echo '<p class="message error">' . __( 'Gallery error: Album has no pictures.', 'noisa' ) . '</p>'; ?>
	        <?php endif; // images ids ?>
			
			<?php
			   // Get orginal query
			   $post = $temp_post;
			   $wp_query = $query_temp;
			?>

		</article>
		<!-- /article -->
	</div>
    <!-- /container -->
    <!-- Single Navigation  -->
    <?php if ( is_single() ) : ?>
        <?php echo noisa_custom_post_nav(); ?>
    <?php endif; ?>
</div>
<!-- /page -->

<!-- Comments -->
<?php
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
	$disqus = $noisa_opts->get_option( 'disqus_comments' );
	$disqus_shortname = $noisa_opts->get_option( 'disqus_shortname' );

	if ( ( $disqus && $disqus == 'on' ) && ( $disqus_shortname && $disqus_shortname != '' ) ) {
		get_template_part( 'inc/disqus' );

	} else {
		comments_template();
	}
}
?>
<!-- /comments -->

<?php get_footer(); ?>
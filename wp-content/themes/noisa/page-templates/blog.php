<?php
/**
 * Template Name: Blog
 *
 * @package noisa
 * @since 1.0.0
 */

get_header(); ?>

<?php 
   	global $noisa_opts, $wp_query, $post, $noisa_layout, $more, $noisa_featured_post;

	// Copy query
	$temp_post = $post;
	$query_temp = $wp_query;

	// Get layout
	$noisa_layout = get_post_meta( $wp_query->post->ID, '_layout', true );
	$noisa_layout = isset( $noisa_layout ) && $noisa_layout != '' ? $noisa_layout = $noisa_layout : $noisa_layout = 'wide';

	$more = 0;

	 // Blog options
    $blog_layout = get_post_meta( $wp_query->post->ID, '_blog_layout', true );
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    $intro_type = get_post_meta( $wp_query->post->ID, '_intro_type', true );

?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>

<!-- ############ CONTENT ############ -->
<div id="content">

	<!-- ############ Container ############ -->
	<div class="container blog-classic clearfix">

		<div role="main" class="main <?php echo esc_attr( $noisa_layout ) ?>">
		<?php
			$args = array(
				'paged' => $paged,
				'showposts' => $limit,
				'ignore_sticky_posts' => false
            );
		
			// Intro featured post
			if ( $intro_type == 'featured_post' ) {
				$args['post__not_in'] = array( $noisa_featured_post ); 
			}
            $wp_query = new WP_Query();
			$wp_query->query($args);

			if ( have_posts() ) :

				// Start the Loop.
				while ( have_posts() ) : the_post();
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content' );

				endwhile; ?>
				<div class="clear"></div>
    			<?php noisa_paging_nav(); ?>

			<?php else : ?>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'noisa' ); ?></p>

			<?php endif; // have_posts() ?>
			
		</div>
		<!-- /main -->
		<?php if ( $noisa_layout !== 'wide' && $noisa_layout !== 'thin' ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
    <!-- /container -->
</div>
<!-- /content -->
<?php get_footer(); ?>
<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			index.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
   	global $noisa_opts, $wp_query, $post, $noisa_layout, $more;

	// Get layout
	$noisa_layout = 'main-left';

	$more = 0;

	// Animate
	if ( $noisa_opts->get_option( 'page_title_animations' ) == 'on' ) {
		$animated = 'anim-css';
	} else {
		$animated = '';
	}

?>
<section class="intro-page-title intro <?php echo esc_attr( $animated ); ?> clearfix" style="min-height:400px;">
	<!-- Captions -->
	<div class="intro-captions">
		<div class="container">
			<div class="caption-top"><h2 class="caption-title"><?php _e( 'Latest Blog Posts', 'noisa') ?></h2></div>
			<hr class="caption-divider">
			<div class="caption-bottom"><h6 class="caption-subtitle"><?php _e( 'Here are some news from our music site', 'noisa') ?></h6></div>	
		</div>
	</div>
</section>

<!-- ############ CONTENT ############ -->
<div id="content">

	<!-- ############ Container ############ -->
	<div class="container blog-classic clearfix">

		<div role="main" class="main <?php echo esc_attr( $noisa_layout ) ?>">
		<?php
		

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
		<?php get_sidebar(); ?>
	</div>
    <!-- /container -->
</div>
<!-- /content -->
<?php get_footer(); ?>
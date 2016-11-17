<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			category.php
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
	// Blog Layout
	$blog_layout = $noisa_opts->get_option( 'blog_cat_layout' );
?>

<?php 
	// Get Category Intro Section
	get_template_part( 'inc/tag-intro' );

?>
	
<!-- Grid -->
<?php if ( $noisa_opts->get_option( 'blog_cat_type' ) == 'grid' ) : ?>
		
<!-- ############ CONTENT ############ -->
<div id="content">

	<!-- ############ Container ############ -->
	<div class="container blog-grid clearfix <?php echo esc_attr( $blog_layout ) ?>">
		<?php if ( have_posts() ) : ?>
				
				<div class="masonry masonry-blog-grid">

				<?php // Start the Loop.
				while ( have_posts() ) : the_post() ?>

					<div class="masonry-item masonry-item-1-3">
					<?php get_template_part( 'content' ); ?>
					</div>
		
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

<!-- List -->
<?php else : ?>

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

				endwhile;

			else : ?>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'noisa' ); ?></p>

			<?php endif; // have_posts() ?>
			<div class="clear"></div>
			<?php noisa_paging_nav(); ?>
		</div>
		<!-- /main -->
		<?php get_sidebar( 'category' ); ?>
	</div>
	<!-- /container -->
</div>
<!-- /content -->
<?php endif; ?>

<?php get_footer(); ?>
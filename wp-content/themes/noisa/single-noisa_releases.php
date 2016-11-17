<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			single-noisa_releases.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php get_header(); ?>


<?php 
   global $noisa_opts, $wp_query, $post;

   // Get layout
   $noisa_layout = get_post_meta( $wp_query->post->ID, '_layout', true );
   $noisa_layout = isset( $noisa_layout ) && $noisa_layout != '' ? $noisa_layout = $noisa_layout : $noisa_layout = 'wide';


?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>

<!-- ############ CONTENT ############ -->
<div id="content" class="<?php echo esc_attr( $noisa_layout ) ?>">

	<!-- ############ Container ############ -->
	<div class="container clearfix">
		
		<div role="main" class="main <?php echo esc_attr( $noisa_layout ) ?>">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'custom' );

				endwhile;
			?>
		</div>
		<!-- /main -->
		<?php if ( $noisa_layout !== 'wide' && $noisa_layout !== 'thin' && $noisa_layout !== 'vc' ) : ?>
			<?php get_sidebar( 'custom' ); ?>
		<?php endif; ?>
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
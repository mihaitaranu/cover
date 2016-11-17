<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			404.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
   	global $noisa_opts, $wp_query, $post;

?>


<!-- ############ CONTENT ############ -->
<div id="content">

	<!-- ############ Container ############ -->
	<div class="container clearfix error-page">
		<div class="row text-center">
			<span class="big-404">404</span>
		</div>
		<div class="col-1-2">
			<h1 class="title-404"><?php _e( 'Oops! Page was not found', 'noisa' ); ?></h1>
        	<p class="sub-title-404"><?php _e( 'Sorry, something went wrong and we cannot retrieve the page you were looking for. Maybe try a search?', 'noisa' ); ?></p>
        	<a href="<?php echo esc_url( home_url() ) ?>" class="btn btn-big"><?php _e( 'Go to homepage', 'noisa' ); ?></a>
		</div>
		<div id="search-404" class="col-1-2 last">
			<?php get_search_form(); ?>
		</div>
	</div>
    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>
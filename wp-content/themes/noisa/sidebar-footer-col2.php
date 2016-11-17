<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			sidebar-footer-col2.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>

<?php 
   global $noisa_opts, $wp_query, $post;
?>
	
<!-- Sidebar -->
<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar( 'footer-col2-sidebar' ) ) ?>
<!-- /sidebar -->
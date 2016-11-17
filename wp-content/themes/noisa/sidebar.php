<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			sidebar.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>

<?php 
   global $noisa_opts, $wp_query, $post;

   $noisa_layout = 'main-left';
?>
	
<!-- Sidebar -->
<aside class="sidebar <?php echo esc_attr( $noisa_layout ) ?>">
	<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar( 'primary-sidebar' ) ) ?>
</aside>
<!-- /sidebar -->
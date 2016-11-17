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

   	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$page_id = get_option( 'woocommerce_shop_page_id' );
	} else {
		$page_id = $wp_query->post->ID;
	}

   // Get custom sidebar
   $custom_sidebar = get_post_meta( $page_id, '_custom_sidebar', true );

   // Get layout
   $noisa_layout = get_post_meta( $page_id, '_layout', true );
   $noisa_layout = isset( $noisa_layout ) && $noisa_layout != '' ? $noisa_layout = $noisa_layout : $noisa_layout = 'wide';
?>
	
<!-- Sidebar -->
<aside class="sidebar <?php echo esc_attr( $noisa_layout ) ?>">
	<?php if ( $custom_sidebar === '' || $custom_sidebar === '_default' ) : ?>
	<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar( 'primary-sidebar' ) ) ?>
	<?php else : ?>
	<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar( sanitize_title_with_dashes( $custom_sidebar ) ) ) ?> 
	<?php endif; ?>
</aside>
<!-- /sidebar -->
<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			content-custom.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>

<?php 
   global $crow_opts, $wp_query, $post; 
?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <?php  the_content( __( 'Continue reading ', 'noisa' ) . '<span class="meta-nav">&rarr;</span>' ); ?>
 	
</article>
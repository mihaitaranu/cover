<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			content-page.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>

<?php 
   global $noisa_opts, $wp_query, $post; 
?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php the_content( __( '...View the rest of this post', 'noisa' ) ); ?>

	<?php
		wp_link_pages( array(
			'before' 	=> '<div class="page-links">' . __( 'Jump to Page', 'noisa' ),
			'after' 	=> '</div>',
		) );
	?>

</article>
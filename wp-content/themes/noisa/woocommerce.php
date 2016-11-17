<?php
/**
 * woocommerce.php
 *
 * @package noisa
 * @since 1.0.0
 */

get_header(); ?>
<?php 
    global $noisa_opts, $wp_query, $post;

    // Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

    // Shop id
    $shop_id = get_option( 'woocommerce_shop_page_id' );


   // Get layout
   $noisa_layout = get_post_meta( $shop_id, '_layout', true );
   $noisa_layout = isset( $noisa_layout ) && $noisa_layout != '' ? $noisa_layout = $noisa_layout : $noisa_layout = 'wide';

  if ( ! is_shop() ) {
    $noisa_layout = 'wide';
  }
?>

<?php 
    // Get Custom Intro Section
    if ( is_shop() ) {
      get_template_part( 'inc/custom-intro' );
    } else {
      echo '<section class="intro intro-disabled light-bg clearfix"></section>';
    }

?>

<?php
   
   /* Hooks and functions
   ------------------------------------------------------------------------*/

   /* Remove default page title */
   add_filter('woocommerce_show_page_title', 'override_page_title');
   function override_page_title() {
      return false;
   }

   /* Change default catalog image */ 
   remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

   add_action( 'woocommerce_before_shop_loop_item_title', 'wc_catalog_thumb', 10);
 
   /* WooCommerce Loop Product Thumbs */
   function wc_catalog_thumb() {
        echo wc_get_product_thumbnail();
   } 
   
 
   /* WooCommerce Product Thumbnail */
    
   if ( ! function_exists( 'wc_get_product_thumbnail' ) ) {
        
      function wc_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
         global $post, $woocommerce;
    
         if ( ! $placeholder_width )
            $placeholder_width = wc_get_image_size( 'shop_catalog_image_width' );
         if ( ! $placeholder_height )
            $placeholder_height = wc_get_image_size( 'shop_catalog_image_height' );
            
            $output = '<span class="thumb-icon">';
    
            if ( has_post_thumbnail() ) {
               
               $output .= get_the_post_thumbnail( $post->ID, $size ); 
               
            } else {
            
               $output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
            
            }
            $output .= '<span class="icon plus"></span>';
            $output .= '</span>';
            return $output;
      }
   }


   // Remove add to cart button on archives
   // remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

?>


<!-- ############ CONTENT ############ -->
<div id="content">

   <!-- ############ Container ############ -->
   <div class="container blog-classic clearfix">
      <div role="main" class="main <?php echo esc_attr( $noisa_layout ) ?>">
         <?php woocommerce_content(); ?>

      </div>
      <!-- /main -->
      <?php if ( $noisa_layout !== 'wide' && $noisa_layout !== 'thin' && $noisa_layout !== 'vc' ) : ?>
         <?php get_sidebar( 'custom' ); ?>
      <?php endif; ?>
   </div>
    <!-- /container -->
</div>
<!-- /content -->

<?php
   // Get orginal query
   $post = $temp_post;
   $wp_query = $query_temp;
?>
<?php get_footer(); ?>
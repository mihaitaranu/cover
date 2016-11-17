<?php
/**
 * Theme Name:      NOISA - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/noisa
 * Author URI:      http://rascals.eu
 * File:            content-search.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>

<?php 
   global $noisa_opts, $wp_query, $post, $noisa_layout;

   /* $noisa_layout = wide, thin, main_right, main_left, blog_grid */

    // Set width and height
    if ( $noisa_layout == 'wide' || $noisa_layout == 'thin' ) {
        $width = 1090;
        $height = 613;
        $thumb_size = 'noisa-full-thumb';
    } else {
        $width = 780;
        $height = 440;
        $thumb_size = 'noisa-main-thumb';
    }

    // Date format
    $date_format = 'd/m/Y';
    if ( $noisa_opts->get_option( 'custom_date' ) ) {
        $date_format = $noisa_opts->get_option( 'custom_date' );
    }


?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-article' ); ?>>
    <header class="article-header">
        <?php the_title( '<h2 class="article-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
        <div class="meta-top">
            <div class="meta-col">
                <span class="meta-author-image"><?php echo get_avatar( get_the_author_meta( 'email' ), '24' ); ?></span>
                <div class="meta-author">
                    <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="author-name"><?php echo get_the_author_meta( 'display_name', $post->post_author ); ?></a>
                </div>
            </div>
            <div class="meta-col">
                <span class="meta-date"><?php the_time( $date_format ); ?></span>
            </div>
            <div class="meta-col">
                
            </div>
        </div>
    </header><!-- .article-header -->

   
    <?php if ( has_post_thumbnail() ) : ?>
     
            <div class="article-media-search content-image featured-image">
                <a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb thumb-glitch" data-icon="plus">
                    <span class="hoverlayer"></span>
                    <span class="img">
                        <?php  $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                        <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                    </span>
                </a>
            </div>
       
    <?php endif; ?>


    <div class="article-content">
        <?php echo '<a href="' . esc_url( get_permalink() ) . '" class="more-link-excerpt">' . __( 'Read more', 'noisa' ) . '</a>'; ?>
    </div>

</article><!-- #post-## -->
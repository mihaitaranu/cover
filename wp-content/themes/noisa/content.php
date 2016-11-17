<?php
/**
 * Theme Name:      NOISA - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/noisa
 * Author URI:      http://rascals.eu
 * File:            content.php
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

    // Disqus
    $disqus = $noisa_opts->get_option( 'disqus_comments' );
    $disqus_shortname = $noisa_opts->get_option( 'disqus_shortname' );

    if ( ( $disqus && $disqus == 'on' ) && ( $disqus_shortname && $disqus_shortname != '' ) ) {
        $disqus = true;

    } else {
        $disqus = false;
    }

    // Post format
    $post_format = get_post_meta( $wp_query->post->ID, '_post_format', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-article' ); ?>>
    <?php if ( ! is_single()  ) : ?>
    <header class="article-header">
        <span class="meta-cats"><?php the_category( ' ' ) ?></span>
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
                <span class="meta-comments">
                    <a href="<?php echo esc_url( get_permalink() ); ?>#comments" class="comments-link"><?php if ( ! $disqus ) { comments_number('0','1','%'); } else { echo '&#160;'; } ?>
                    </a>
                </span>
            </div>
        </div>
    </header><!-- .article-header -->
    <?php endif;?>
    <?php 

    // -------------------- Post Type Image

    if  ( get_post_format() === 'image' ) : ?>
        
        <?php 
            // Single
            if ( is_single() && $noisa_opts->get_option( 'display_featured_image_ipf' ) == 'on' && has_post_thumbnail() ) : ?>
            <div class="article-media content-image featured-image">
                <img src="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
            </div>
            <?php endif; ?>

            <?php 
            // List
            if ( ! is_single() && has_post_thumbnail() ) : ?>
            <div class="article-media content-image featured-image">
                <a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb">
                    <?php  $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                    <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                </a>
            </div>
            <?php endif; ?>

    <?php 

    // -------------------- Post Type Link

    elseif  ( get_post_format() === 'link' ) : ?>
      
        <?php 
        $link_title = get_post_meta( $wp_query->post->ID, '_link_title', true );
        $link_url = get_post_meta( $wp_query->post->ID, '_link_url', true );
        $link_new_window = get_post_meta( $wp_query->post->ID, '_link_new_window', true );

        if ( ( $link_title && $link_title !== '' ) && ( $link_url && $link_url !== '' ) ) : ?>
        <div class="article-media">
            <?php 
                if ( $link_new_window && $link_new_window == 'on' ) {
                    $target = '_blank';
                } else {
                    $target = '_self';
                }

            ?>

            <a class="pf-link" href="<?php echo esc_url( $link_url ) ?>" target="<?php echo esc_attr( $target ) ?>"><?php echo esc_html( $link_title ) ?></a>
        </div>
        <?php endif; // if link ?>
    
    <?php 

    // -------------------- Post Type Quote

    elseif  ( get_post_format() === 'quote' ) : ?>
        
        <?php 
        $quote_text = get_post_meta( $wp_query->post->ID, '_quote_text', true );
        $quote_author = get_post_meta( $wp_query->post->ID, '_quote_author', true );
        $quote_link = get_post_meta( $wp_query->post->ID, '_quote_link', true );
        if ( $quote_text && $quote_text !== '' ) : ?>
            <div class="article-media">
                <p class="quote-text"><?php echo esc_html( $quote_text ) ?>
                    <br>
                    <?php if ( $quote_author && $quote_author !== '' ) : ?>
                    <cite>
                        <?php if ( $quote_link && $quote_link !== '' ) : ?>
                            <a href="<?php echo esc_url( $quote_link ) ?>"><?php echo esc_html( $quote_author ) ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $quote_author ) ?>
                        <?php endif; ?>
                    </cite>
                    <?php endif ?>
                </p>
            </div>
        <?php endif; // if quote text ?>

    <?php 

    // -------------------- Post Type Gallery

    elseif  ( get_post_format() === 'gallery' ) : ?>
        <?php 
        $gallery_slider_id = get_post_meta( $wp_query->post->ID, '_gallery_slider_id', true );
        if ( $gallery_slider_id && $gallery_slider_id !== 'none' ) :
        ?>
        <div class="article-media">
            <?php 
            if ( function_exists( 'noisa_slider' ) ) {
                echo noisa_slider( array( 'id' => $gallery_slider_id, 'size' => $thumb_size ) );
            }

            ?>
        </div>
        <?php endif; // if slider ids ?>
        
    <?php 

    // -------------------- Post Type Audio

    elseif  ( get_post_format() === 'audio' ) : ?>

        <?php
        // Soundcloud
        if ( $post_format == 'pf_audio_sc' ) : 
            $sc_iframe = get_post_meta( $wp_query->post->ID, '_sc_iframe', true );
            if ( $sc_iframe && $sc_iframe !== '' && strpos( $sc_iframe, 'iframe' ) !== false ) : ?>     
            <div class="article-media sc-iframe">
                <?php echo str_replace( '&', '&amp;', $sc_iframe ); ?>
            </div>
            <?php endif; // $sc_iframe ?>
        <?php 
        // Audio tracks
        elseif ( $post_format == 'pf_audio_album' ) : ?>
        <div class="article-media sc-audio">
            <?php 
                $pf_tracks_id = get_post_meta( $wp_query->post->ID, '_pf_tracks_id', true );
                $album_title = get_post_meta( $wp_query->post->ID, '_album_title', true );
                $album_artists = get_post_meta( $wp_query->post->ID, '_album_artists', true );
                $album_image = get_post_meta( $wp_query->post->ID, '_album_image', true );
                if ( ! isset( $album_image ) || $album_image == '' ) {
                    $album_image = get_post_thumbnail_id( $post->ID );
                }

                if ( function_exists( 'noisa_single_album' ) ) {
                    echo noisa_single_album( $atts = array( 'id' => $pf_tracks_id, 'album_title' => $album_title, 'album_artists' => $album_artists, 'album_cover' => $album_image ) );
                }

             ?>
        </div>
        <?php endif; // post_format ?>
    <?php 

    // -------------------- Post Type Video

    elseif  ( get_post_format() === 'video' ) : ?>

        <?php 
        $video_yt_id = get_post_meta( $wp_query->post->ID, '_video_yt_id', true );
        $video_vimeo_id = get_post_meta( $wp_query->post->ID, '_video_vimeo_id', true );
        if ( $video_yt_id && $video_yt_id !== '' ) :
        ?>
        <div class="article-media content-video">
            <div class="video">
                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr( $video_yt_id ) ?>" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>" allowfullscreen></iframe>
            </div>
        </div>
        <?php endif; // video_yt_id ?>
        <?php if ( $video_vimeo_id && $video_vimeo_id !== '' ) : ?>
        <div class="article-media content-video">
            <div class="video">
                <iframe src="https://player.vimeo.com/video/<?php echo esc_attr( $video_vimeo_id ) ?>" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>" allowfullscreen></iframe>
            </div>
        </div>
        <?php endif; // video_vimeo_id ?>

        
    <?php 

    // -------------------- Default Content

    else : ?>

         <?php if ( has_post_thumbnail() ) : ?>
            <?php if ( is_single() && $noisa_opts->get_option( 'display_featured_image' ) == 'on' ) : ?>
                <div class="article-media content-image featured-image">
                    <img src="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                </div>
            <?php elseif ( ! is_single() ) : ?>
                <div class="article-media content-image featured-image">
                    <a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb">
                        <?php  $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                        <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; // post type ?>

    <div class="article-content">
        <?php 
            if ( ! is_single() && has_excerpt() ) {
                the_excerpt();
                echo '<a href="' . esc_url( get_permalink() ) . '" class="more-link-excerpt">' . __( 'Read more', 'noisa' ) . '</a>';
            } else {
                the_content( __( 'Read more', 'noisa' ) );
            }
        ?>

        <?php 
            if ( get_the_title() === '' ) {
                the_excerpt();
                echo '<a href="' . esc_url( get_permalink() ) . '" class="more-link-excerpt">' . __( 'Read more', 'noisa' ) . '</a>';
            }
        ?>

    
    <?php if ( is_single() && $noisa_layout !== 'vc' ) : ?>

    <div class="meta-bottom">
        <div class="meta-col">
            <span class="meta-share-title"><?php _e( 'Share in', 'noisa' ); ?></span>
            <?php if ( function_exists( 'noisa_share_buttons' ) ) { echo noisa_share_buttons( $post->ID ); } ?>
        </div>
        <div class="meta-col">
            <span class="meta-tags-title"><?php _e( 'Tagged in', 'noisa' ); ?></span>
            <?php the_tags( '<span class="meta-tags">', ' ', '</span>' ); ?>
        </div>
    </div>

    <div class="clear"></div>

    <?php
        wp_link_pages( array(
            'before'    => '<div class="page-links">' . __( 'Jump to Page', 'noisa' ),
            'after'     => '</div>',
        ) );
    ?>
    <?php endif; // single ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
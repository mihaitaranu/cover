<?php
/**
 * Template Name: Gallery
 *
 * @package noisa
 * @since 1.0.0
 */

get_header(); ?>

<?php 
    // Get Custom Intro Section
    get_template_part( 'inc/custom-intro' );

?>

<?php 
    global $noisa_opts, $wp_query, $post;

    // Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

    // Pagination Limit
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // Gap
    $gap = get_post_meta( $wp_query->post->ID, '_gap', true );
    
    // Gallery layout
    $gallery_layout = get_post_meta( $wp_query->post->ID, '_gallery_layout', true );

    // Date format
    $date_format = 'd/m/y';
    if ( $noisa_opts->get_option( 'custom_date' ) ) {
        $date_format = $noisa_opts->get_option( 'custom_date' );
    }

    if ( $gallery_layout == 'full-width' ) {
        $gallery_cols = '3';
    }

?>

<!-- ############ GALLERY ############ -->
<div id="content" class="filter-content">
    <!-- ############ Container ############ -->
    <div class="container clearfix <?php echo esc_attr( $gallery_layout ) ?>">

        <!--############ Artists grid ############ -->
        <div class="grid-wrapper clearfix" data-grid="gallery-grid">

            <!--############ Filters ############ -->
            <div class="filters-wrapper filter-2 container clearfix">
                
                <!-- Filter -->
                <div class="filter" data-obj='{"action": "noisa_gallery_filter", "filterby": "taxonomy", "cpt": "noisa_gallery", "tax": "noisa_gallery_artists", "limit": "<?php echo esc_attr( $limit ); ?>"}' >
                    <div class="filter-dropdown">
                        <div class="filter-collpase-btn">
                            <h4 class="filter-title-anim"><?php echo esc_attr( __( 'Filter by', 'noisa' ) ) ?></h4>
                            <h4 class="filter-title filter-title-anim" data-filter-name=""><?php echo esc_attr( __( 'All Artists', 'noisa' ) ) ?></h4>
                            <span class="filter-btn-icon"></span>
                        </div>
                        <div class="filter-dropdown-content">
                            <ul data-filter-group="">
                                <li><a href="#" data-filter-name="all"><h3><?php echo esc_attr( __( 'All Artists', 'noisa' ) ) ?></h3></a></li>
                                    <?php 
                                        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                                        $terms = get_terms( 'noisa_gallery_artists', $term_args );
                                        if ( $terms ) {
                                            foreach ( $terms as $term ) {
                                                echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><h3>' . $term->name . '</h3></a></li>';
                                            }
                                        }
                                    ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /filter -->

                <!-- Filter -->
                <div class="filter" data-obj='{"action": "noisa_gallery_filter", "filterby": "taxonomy", "cpt": "noisa_gallery", "tax": "noisa_gallery_cats", "limit": "<?php echo esc_attr( $limit ); ?>"}' >
                    <div class="filter-dropdown">
                        <div class="filter-collpase-btn">
                            <h4 class="filter-title-anim"><?php echo esc_attr( __( 'Filter by', 'noisa' ) ) ?></h4>
                            <h4 class="filter-title filter-title-anim" data-filter-name=""><?php echo esc_attr( __( 'All Categories', 'noisa' ) ) ?></h4>
                            <span class="filter-btn-icon"></span>
                        </div>
                        <div class="filter-dropdown-content">
                            <ul data-filter-group="">
                                <li><a href="#" data-filter-name="all"><h3><?php echo esc_attr( __( 'All Categories', 'noisa' ) ) ?></h3></a></li>
                                    <?php 
                                        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                                        $terms = get_terms( 'noisa_gallery_cats', $term_args );
                                        if ( $terms ) {
                                            foreach ( $terms as $term ) {
                                                echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><h3>' . $term->name . '</h3></a></li>';
                                            }
                                        }
                                    ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /filter -->

            </div>

            <div class="masonry <?php echo esc_attr( $gap ) ?> gallery-grid masonry-anim clearfix"> 
                <?php

                    $thumb_size = 'large';

                    // Begin Loop
                    $args = array(
                        'post_type' => 'noisa_gallery',
                        'showposts' => $limit
                    );
                    $wp_query = new WP_Query();
                    $wp_query->query( $args );
                ?>
            
             <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
                <?php if ( has_post_thumbnail() ) : ?> 

                <?php 

                    // IDS
                    $images_ids = get_post_meta( $post->ID, '_gallery_ids', true ); 

                    if ( $images_ids || $images_ids != '' ) {
                        $ids = explode( '|', $images_ids );
                        $ids = count( $ids );
                    } else {
                        $ids = '0';
                    }

                     
                 ?>
                <article <?php post_class( 'masonry-item masonry-item-1-3' ); ?>>
                    <div class="grid-media">
                            <a href="<?php echo esc_url( get_permalink() ) ?>" class="thumb thumb-desc">
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Post Image', 'noisa' ) ); ?>">
                                <div class="desc-layer">
                                    <div class="images-count">
                                        <?php $noisa_opts->e_esc( $ids ) ?>
                                    </div>
                                    <div class="desc-details desc-full">
                                        <?php the_title( '<h2 class="grid-title">', '</h2>' ); ?>
                                        <div class="grid-date"><?php the_time( $date_format ); ?></div>
                                    </div>
                                </div> 
                            </a>
                    </div>
                </article>
                <?php endif; // end has_post_thumbnail  ?>

                <?php endwhile; // End Loop ?>
                <?php endif; ?>

            </div>
            <div class="clear"></div>

            <div class="load-more-wrap text-center">
                <a href="#" data-pagenum="2" class="btn btn-medium load-more"><span class="icon-wrap"><span class="icon"></span></span> <?php _e( 'Load more', 'noisa' ) ?></a>
            </div>

            <div class="ajax-messages">
                <div class="message ajax-error">
                    <span class="message-title">
                        <?php _e( 'Upsss!', 'noisa' ) ?>
                    </span>
                    <span class="message-body">
                        <?php _e( 'Sorry, something went wrong and we cannot retrieve any results.', 'noisa' ) ?>
                    </span>
                </div>
            </div>

        </div> 
        <!-- /grid wrapper -->
    </div>
    <!-- /container -->
</div>
<!-- /page -->
<?php
   // Get orginal query
   $post = $temp_post;
   $wp_query = $query_temp;
?>
<?php get_footer(); ?>
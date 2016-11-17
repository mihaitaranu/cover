<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			custom-intro.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

global $noisa_opts, $wp_query, $post, $noisa_featured_post;

if ( class_exists( 'WooCommerce' ) && is_shop() ) {
    $intro_id = get_option( 'woocommerce_shop_page_id' );
} else {
	$intro_id = $wp_query->post->ID;
}

$intro_type = get_post_meta( $intro_id, '_intro_type', true );

if ( ! $intro_type ) {
	$intro_type = 'intro_page_title';
}

if ( $intro_type === 'intro_none' ) {
	return;
}

$scroll_icon = get_post_meta( $intro_id, '_scroll_icon', true );
$captions_align = get_post_meta( $intro_id, '_captions_align', true );
$overlay = get_post_meta( $intro_id, '_overlay', true );
$animated = get_post_meta( $intro_id, '_animated', true );
$intro_title = get_post_meta( $intro_id, '_intro_title', true );
$intro_subtitle = get_post_meta( $intro_id, '_intro_subtitle', true );
$intro_captions_classes = get_post_meta( $intro_id, '_caption_classes', true );
$intro_buttons = get_post_meta( $intro_id, '_intro_buttons', true );

// Gradient
$from = get_post_meta( $intro_id, '_from', true );
$to = get_post_meta( $intro_id, '_to', true );
$direction = get_post_meta( $intro_id, '_direction', true );
$gradient_style = 'background-image: linear-gradient(' . esc_attr( intval( $direction ) ) . 'deg, ' . esc_attr( $from ) . ', ' . esc_attr( $to ) . ')';

// Animated
if ( $animated && $animated === 'on' ) {
	$animated = 'anim-css';
} else {
	$animated = '';
}

// Intro BG Color
$intro_bg_color = 'dark-bg';


// Quick Scroll
if ( $noisa_opts->get_option( 'quick_scroll' ) && $noisa_opts->get_option( 'quick_scroll' ) === 'on' ) {
	$quick_scroll = 'quick-scroll';
} else {
	$quick_scroll = '';
}

$img_classes = '';

// Custom CSS
$custom_css = "";

// Disqus
$disqus = $noisa_opts->get_option( 'disqus_comments' );
$disqus_shortname = $noisa_opts->get_option( 'disqus_shortname' );

if ( ( $disqus && $disqus == 'on' ) && ( $disqus_shortname && $disqus_shortname != '' ) ) {
    $disqus = true;

} else {
    $disqus = false;
}


// ==================================================== Disabled ====================================================

if ( $intro_type === 'disabled' ) : ?>
<section class="intro intro-disabled light-bg clearfix"></section>


<?php
// ==================================================== Revo Slider ====================================================

elseif ( $intro_type === 'revslider' ) : ?>

<section class="intro intro-revslider clearfix">
	
	<?php
      $rev_id = get_post_meta( $intro_id, '_revslider_id', true );

      if ( isset( $rev_id ) && function_exists( 'putRevSlider' ) ) { 
        	$rev_id = intval( $rev_id );
        	putRevSlider( $rev_id );
      	}
   ?>
</section>

<?php
// ==================================================== Intro Image ====================================================

elseif ( $intro_type === 'intro_image' || $intro_type === 'intro_full_image' || $intro_type === 'intro_full_image_content' || $intro_type === 'intro_image_zoom_out' ) : ?>
	
	<?php

		// Full resize image
		if ( $intro_type === 'intro_full_image' || $intro_type === 'intro_full_image_content' ) {
			$intro_full_image = 'intro-resize ' . esc_attr( $quick_scroll );
		} else {
			$intro_full_image = '';
		}

		$img = get_post_meta( $intro_id, '_intro_image', true );
		$min_height = get_post_meta( $intro_id, '_min_height', true );

		// Min height
    	if ( $intro_type == 'intro_image' || $intro_type === 'intro_image_zoom_out' ) {
    		$min_height = 'min-height:' . $min_height . 'px';
		} else {
			$min_height = '';	
		}

		// Image effect
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );

		// Zoom Out
		if ( $intro_type === 'intro_image_zoom_out' ) {
			$intro_full_image = 'intro-image-zoom';
			$image_effect = 'parallax';
		}

		// No overlay
		if ( ! $overlay || $overlay == 'disabled' ) {
			$no_overlay_class = 'no-intro-overlay';
		} else {
			$no_overlay_class = '';
		}

		if ( $intro_type === 'intro_full_image' ) {
			$intro_captions_classes .= ' ' . $captions_align;
		}

	 ?>
	
    <section class="intro-image intro <?php echo esc_attr( $intro_bg_color ) ?> <?php echo esc_attr( $intro_full_image ) ?> <?php echo esc_attr( $animated ); ?> clearfix intro-id-<?php echo esc_attr( $intro_id ); ?> <?php echo esc_attr( $no_overlay_class ) ?>" style="<?php echo esc_attr( $min_height ) ?>">
    	<div class="intro-inner">

	    	<?php if ( $intro_type === 'intro_full_image_content' ) : ?>
	    	<!-- Intro Content -->
	    	<?php 
	    		$intro_content = get_post_meta( $intro_id, '_intro_content', true );
	    	?>
			<div class="intro-content">
				<?php echo do_shortcode( $intro_content ); ?>			
			</div>

	    	<?php endif; ?>

	    	<?php if ( ( $intro_title !== '' || $intro_subtitle !== '' || $intro_buttons !== '' ) && ( $intro_type === 'intro_full_image' || $intro_type === 'intro_image' || $intro_type === 'intro_image_zoom_out' ) ) : ?>
		        <!-- Captions -->
				<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
					<div class="container">
						<?php if ( $intro_title !== '' ) : ?>
						<div class="caption-top"><h2 class="caption-title"><?php echo do_shortcode( $intro_title ) ?></h2></div>
						<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
						<?php endif; ?>
						<div class="caption-bottom">
							<?php if ( $intro_subtitle !== '' ) : ?>
							<h6 class="caption-subtitle"><?php echo do_shortcode( $intro_subtitle ) ?></h6>
							<?php endif; ?>
							<?php if ( function_exists( 'noisa_stamp_buttons' ) ) { echo '<div class="caption-button">' . noisa_stamp_buttons( $intro_buttons ) . '</div>'; } ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
	        <!-- Image -->
	        <?php

	        	// If image exists
			   	if ( $img ) {
			   		$img = $noisa_opts->get_image( $img );
				} else {
					$img = '';
				}

	        	// Intro Image
				if ( $image_effect && $image_effect === 'zoom' ) {
					$img_classes = 'image zoom';
				} else if ( $image_effect && $image_effect === 'parallax' ) {
					$img_classes = 'parallax';
				} else {
					$img_classes = 'image';
				}

				echo '<div class="' . esc_attr( $img_classes ) . ' image-container ' . esc_attr( $animated ) . '" style="background-image: url(' . esc_url( $img ) . ')"></div>';

	        ?>
			
			<?php if ( $scroll_icon && $scroll_icon === 'on' && $intro_type === 'intro_full_image' ) : ?>
	        <!-- Scroll Animation -->
	        <span class="scroll-anim-button <?php echo esc_attr( $animated ) ?>">
           	 	<span class="scroll"></span>
            	<span class="scroll-text"><?php _e( 'scroll down', 'noisa' ) ?></span>
	        </span>
			<?php endif; ?>
	       	<?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					if ( $overlay != 'gradient' ) {
						$gradient_style = '';
					}
					echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
				}
	       	 ?>
	    </div>
    </section>
<?php 

// ==================================================== Intro Map ====================================================

elseif ( $intro_type === 'gmap' ) : ?>
	<?php  
		$map_address = get_post_meta( $intro_id, '_map_address', true );
		if ( $map_address === '' ) {
			$map_address = 'Plac Defilad 1, Warszawa';
		}
		
	?>
	
	<section id="intro-map-id-<?php echo esc_attr( $intro_id ) ?>" class="intro-map intro gmap clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>" data-address="<?php echo esc_attr( $map_address ) ?>" data-zoom="16" data-zoom_control="true" data-scrollwheel="false"></section>

<?php 

// ==================================================== Intro Youtube ====================================================

elseif ( $intro_type === 'intro_youtube' || $intro_type === 'intro_youtube_fullscreen' ) : ?>
	<?php  
		$yt_id = get_post_meta( $intro_id, '_yt_id', true );
		$min_height = get_post_meta( $intro_id, '_min_height', true );

		$img = get_post_meta( $intro_id, '_intro_image', true );

		// Custom fields
		$mute_video = get_post_meta( $intro_id, 'mute_video', true );

		if ( $mute_video == '' ) {
			$mute_video = 'true';
		}

		// Full resize Youtube
		if ( $intro_type === 'intro_youtube_fullscreen' ) {
			$intro_full_video = 'intro-resize ' . esc_attr( $quick_scroll );
			$intro_captions_classes .= ' ' . $captions_align;
		} else {
			$intro_full_video = '';
		}

	?>
	<?php if ( $yt_id && $yt_id !== '' ) : ?>
	<section id="intro-youtube" class="intro-youtube videobg intro <?php echo esc_attr( $intro_full_video ) ?> <?php echo esc_attr( $intro_bg_color ) ?> <?php echo esc_attr( $animated ); ?> clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>" <?php if ( $intro_type === 'intro_youtube' ) : ?> style="min-height:<?php echo esc_attr( $min_height ) ?>px" <?php endif ?>>
		<div class="intro-inner">
			
			<?php if ( $intro_title !== '' || $intro_subtitle !== '' || $intro_buttons !== '' ) : ?>
			<!-- Captions -->
			<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
				<div class="container">
					<?php if ( $intro_title !== '' ) : ?>
					<div class="caption-top"><h2 class="caption-title"><?php echo do_shortcode( $intro_title ) ?></h2></div>
					<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
					<?php endif; ?>
					<div class="caption-bottom">
						<?php if ( $intro_subtitle !== '' ) : ?>
						<h6 class="caption-subtitle"><?php echo do_shortcode( $intro_subtitle ) ?></h6>
						<?php endif; ?>
						<?php if ( function_exists( 'noisa_stamp_buttons' ) ) { echo '<div class="caption-button">' . noisa_stamp_buttons( $intro_buttons ) . '</div>'; } ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<?php 
				// Min height
		    	if ( $intro_type === 'intro_youtube' ) {
		    		$min_height = 'min-height:' . $min_height . 'px';
				} else {
					$min_height = '';	
				}
			 ?>
			<div id="video-bg" class="image-video image desktop-video" data-video-id="<?php echo esc_attr( $yt_id ) ?>" data-mute="<?php echo esc_attr( $mute_video ) ?>" style="background-image: url(<?php echo esc_url( $noisa_opts->get_image( $img ) ) ?>);<?php echo esc_attr( $min_height ) ?>">
				<div class="video-loader">
					<div class="spinner"></div>
				</div>
			</div>
			
			<?php if ( $scroll_icon && $scroll_icon === 'on' && $intro_type === 'intro_youtube_fullscreen' ) : ?>
	        <!-- Scroll Animation -->
	        <span class="scroll-anim-button <?php echo esc_attr( $animated ) ?>">
           	 	<span class="scroll"></span>
            	<span class="scroll-text"><?php _e( 'scroll down', 'noisa' ) ?></span>
	        </span>
			<?php endif; ?>
	       	<?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					if ( $overlay != 'gradient' ) {
						$gradient_style = '';
					}
					echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
				}
	       	 ?>
		</div>
	</section>
	<?php endif; ?>
<?php

// ==================================================== Intro Content ====================================================

elseif ( $intro_type === 'intro_content' ) : ?>
	<?php  
		$intro_content = get_post_meta( $intro_id, '_intro_content', true );
		$intro_bg = get_post_meta( $intro_id, '_intro_bg', true );
	?>
	
	<section class="intro-custom-content <?php echo esc_attr( $intro_bg_color ) ?> intro clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>" style="<?php echo esc_attr( $intro_bg ) ?>">
		<div class="intro-inner">
			<div class="container">
				
				<?php echo do_shortcode( $intro_content ); ?>

			</div>
		</div>
	</section>
<?php


// ==================================================== Featured Post ====================================================

elseif ( $intro_type === 'featured_post' ) : ?>
	<?php 

		// QUERY
		// Copy query
		$temp_featured_post = $post;
		$temp_featured_query = $wp_query;

		// Set default featured post ID
		$noisa_featured_post = 0;

		// Date format
	    $date_format = 'd/m/Y';
	    if ( $noisa_opts->get_option( 'custom_date' ) ) {
	        $date_format = $noisa_opts->get_option( 'custom_date' );
	    }

		// Get CSS data
		$img = get_post_meta( $intro_id, '_intro_image', true );
		$min_height = 500;

		// Min height
    	$min_height = 'min-height:' . $min_height . 'px';

		// Animate
		if ( $noisa_opts->get_option( 'page_title_animations' ) == 'on' ) {
			$animated = 'anim-css';
		} else {
			$animated = '';
		}
		
	?>
	<section class="intro-page-title intro-featured-post dark-bg intro-image <?php echo esc_attr( $animated ); ?> intro clearfix intro-id-<?php echo esc_attr( $temp_featured_query->post->ID ); ?>" style="<?php echo esc_attr( $min_height ) ?>">
		<div class="intro-inner">

			<?php
				$featured_args = array(
					'showposts' => 1,
					'ignore_sticky_posts' => false
		        );

				$count = 0;
				$featured_query = new WP_Query();
				$featured_query->query( $featured_args );
			?>
			<?php if ( $featured_query->have_posts() )  : ?>
				<?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
					<?php
						// Count 
						if ( $count >= 1 ) {
							continue;
						}
						$count = 1;
						// Author
						$author_id = $featured_query->post->post_author;
						$noisa_featured_post = $featured_query->post->ID;
					?>
			<!-- Captions -->
			<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
				<div class="container">
					<div class="caption-top">
						<span class="meta-cats"><?php the_category( ' ' ) ?></span>
						<h2 class="caption-title"><?php echo esc_html( get_the_title( $featured_query->post->ID ) ) ?></h2>
						<?php 
							// Author
							$author_id = $featured_query->post->post_author;
						?>
					</div>
					<!-- /caption top -->
					<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
					<div class="caption-bottom">
						<div class="meta-top">
				            <div class="meta-col">
				                <span class="meta-author-image"><?php echo get_avatar( get_the_author_meta( 'email', $author_id ), '24' ); ?></span>
				                <div class="meta-author">
				                    <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="author-name"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></a>
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
				        <div class="caption-button"><a href="<?php echo esc_url( get_permalink() ) ?>" class="btn stamp-btn"><?php echo esc_html( __( 'Read more', 'noisa' ) ) ?></a></div>
					</div>
					<!-- /caption-bottom -->

				</div>
			</div>
			        <!-- Image -->
			        <?php

			        	// If image exists
					   	if ( has_post_thumbnail() ) {
					   		$img = $noisa_opts->get_image( $img );
							$img_classes = 'image';

							echo '<div class="' . esc_attr( $img_classes ) . ' parallax image-container anim-css" style="background-image: url(' . esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ) . ')"></div>';
						}

			        ?>
		        	<?php endwhile ?>
				<?php endif; ?>
			
	      <?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					if ( $overlay != 'gradient' ) {
						$gradient_style = '';
					}
					echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
				}
	       	 ?>
			<?php
				// Get orginal query
				$post = $temp_featured_post;
				$wp_query = $temp_featured_query;

	       	 ?>
		</div>
	</section>


<?php 
// ==================================================== Artist Profile ====================================================

elseif ( $intro_type === 'artist_profile' ) : ?>
	<?php  
		$page_subtitle = get_post_meta( $intro_id, '_page_subtitle', true );
		$title = get_the_title( $intro_id );

		// Get Image BG
		$img = get_post_meta( $intro_id, '_intro_image', true );

		// Get Artist image
		$artist_img = get_post_meta( $intro_id, '_artist_image', true );

		// Get Social links
		$artist_social = get_post_meta( $intro_id, '_social_links', true );

		// Tracklist button
		$intro_tracks_id = get_post_meta( $intro_id, '_intro_tracks_id', true );
		$intro_play_button_title = get_post_meta( $intro_id, '_intro_play_button_title', true );

		// Image effect
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );

		// Tabs
		$intro_tabs = get_post_meta( $intro_id, '_intro_tabs', true );

		// Animate
		if ( $noisa_opts->get_option( 'page_title_animations' ) == 'on' ) {
			$animated = 'anim-css';
		} else {
			$animated = '';
		}

		// YT

		$yt_id = get_post_meta( $intro_id, '_yt_id', true );
		$min_height = get_post_meta( $intro_id, '_min_height', true );


		// Custom fields
		$mute_video = get_post_meta( $intro_id, 'mute_video', true );

		if ( $mute_video == '' ) {
			$mute_video = 'true';
		}

	
	?>
	<section class="intro-page-title intro-artist-profile <?php echo esc_attr( $intro_bg_color ) ?> <?php if ( $intro_tabs != '' ) { echo 'intro-tabs'; } ?> intro-image <?php echo esc_attr( $animated ); ?> intro clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>">
		<div class="intro-inner">
	        <!-- Captions -->
			<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
				<div class="container">
					<div class="profile-image">
						<?php if ( $artist_img ) : ?>
							<?php $img_src = wp_get_attachment_image_src( $artist_img, 'noisa-small-thumb'); ?>
							<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Artist Image', 'noisa' ) ); ?>">
						<?php elseif ( has_post_thumbnail() ) : ?>
							<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'noisa-small-thumb'); ?>
                            <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( __( 'Artist Image', 'noisa' ) ); ?>">
						<?php endif; ?>
					</div>
					<div class="profile-content">
						<div class="caption-top">
							<h2 class="caption-title"><?php echo esc_html( $title ) ?></h2>
						</div>
						<!-- /caption top -->
						<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
						<div class="caption-bottom">
							<div class="meta-top">
					            <div class="meta-col">
					            	<?php if ( $intro_tracks_id != 'none' ) : ?>
					            		<?php 
					            		if ( function_exists( 'noisa_tracklist_button' ) ) { 
					            			echo noisa_tracklist_button( 
					            				array( 
					            					'id' => $intro_tracks_id, 
					            					'button_title' => $intro_play_button_title 
					            				) 
					            			); 
					            		} 
					            		?>
									<?php endif; ?>
									<?php if ( function_exists( 'noisa_stamp_buttons' ) ) { echo noisa_stamp_buttons( $intro_buttons ); } ?>
					            </div>
					           	<div class="meta-col">
	            					<?php if ( function_exists( 'noisa_social_buttons' ) ) { echo noisa_social_buttons( $artist_social ); } ?>
	        					</div>
					        </div>
						</div>
						<!-- /caption-bottom -->
					</div>
				</div>
			</div>
	        <!-- Image -->
	        <?php

	        	// If image exists

	        	?>
				<?php if ( $yt_id != '' ) { ?>
	        	<div id="video-bg" class="image-video image desktop-video" data-video-id="<?php echo esc_attr( $yt_id ) ?>" data-mute="<?php echo esc_attr( $mute_video ) ?>" style="background-image: url(<?php echo esc_url( $noisa_opts->get_image( $img ) ) ?>);<?php echo esc_attr( $min_height ) ?>">
					<div class="video-loader">
						<div class="spinner"></div>
					</div>
				</div>
	        	<?php
			   	 } else if ( $img ) {
			   		$img = $noisa_opts->get_image( $img );

		        	// Intro Image
					if ( $image_effect && $image_effect === 'zoom' ) {
						$img_classes = 'image zoom';
					} else if ( $image_effect && $image_effect === 'parallax' ) {
						$img_classes = 'parallax';
					} else {
						$img_classes = 'image';
					}

					echo '<div class="' . esc_attr( $img_classes ) . ' image-container anim-css" style="background-image: url(' . esc_url( $img ) . ')"></div>';
				}

	        ?>
			
	       <?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					if ( $overlay != 'gradient' ) {
						$gradient_style = '';
					}
					echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
				}
	       	 ?>
	       	 <?php if ( $intro_tabs != '' && function_exists( 'noisa_intro_tabs' ) ) { echo noisa_intro_tabs( $intro_tabs ); } ?>
		</div>

	</section>


<?php 
// ==================================================== Intro Page Title ====================================================

elseif ( $intro_type === 'intro_page_title' ) : ?>
	<?php  
		$page_subtitle = get_post_meta( $intro_id, '_page_subtitle', true );
		$title = get_the_title( $intro_id );

		// Get CSS data
		$img = get_post_meta( $intro_id, '_intro_image', true );
	
		// Image effect
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );

		// Animate
		if ( $noisa_opts->get_option( 'page_title_animations' ) == 'on' ) {
			$animated = 'anim-css';
		} else {
			$animated = '';
		}

		// Date format
	    $date_format = 'd/m/Y';
	    if ( $noisa_opts->get_option( 'custom_date' ) ) {
	        $date_format = $noisa_opts->get_option( 'custom_date' );
	    }

	    // YT

		$yt_id = get_post_meta( $intro_id, '_yt_id', true );
		$min_height = get_post_meta( $intro_id, '_min_height', true );


		// Custom fields
		$mute_video = get_post_meta( $intro_id, 'mute_video', true );

		if ( $mute_video == '' ) {
			$mute_video = 'true';
		}

	?>
	<section class="intro-page-title <?php echo esc_attr( $intro_bg_color ) ?> intro-image <?php echo esc_attr( $animated ); ?> intro clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>">
		<div class="intro-inner">
	        <!-- Captions -->
			<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
				<div class="container">
					<div class="caption-top">

						<?php if ( get_post_type() == 'post' ) : ?>
							<span class="meta-cats"><?php the_category( ' ' ) ?></span>
						<?php endif; ?>

						<?php if ( get_post_type() == 'noisa_releases' ) : ?>
				        	<span class="meta-cats"><?php the_terms( $post->ID, 'noisa_releases_genres', '', ' ' ); ?></span>
						<?php endif; ?>
						<h2 class="caption-title"><?php echo esc_html( $title ) ?></h2>
						<?php 
							if ( get_post_type() == 'post' ) {

								// Author
								$author_id = $wp_query->post->post_author;
								
							}
						?>
					</div>
					<!-- /caption top -->
					<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
					<div class="caption-bottom">
						<?php 

						// POST
						if ( get_post_type() == 'post' ) : ?>
						<div class="meta-top">
				            <div class="meta-col">
				                <span class="meta-author-image"><?php echo get_avatar( get_the_author_meta( 'email', $author_id ), '24' ); ?></span>
				                <div class="meta-author">
				                    <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="author-name"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></a>
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
						<?php endif; ?>

						<?php 

						// RELEASES
						if ( get_post_type() == 'noisa_releases' ) : ?>
						<div class="meta-top">
				            <div class="meta-col">
				                <h6 class="caption-subtitle"><?php the_terms( $post->ID, 'noisa_releases_artists', '', ', ' ); ?></h6>
				            </div>
				            <div class="meta-col">
	            				<?php if ( function_exists( 'noisa_share_buttons' ) ) { echo noisa_share_buttons( $post->ID ); } ?>
	        				</div>
				        </div>
						<?php endif; ?>

						<?php 

						// GALLERY
						if ( get_post_type() == 'noisa_gallery' ) : ?>
						<div class="meta-top">
				            <div class="meta-col">
				                <h6 class="caption-subtitle"><?php the_terms( $post->ID, 'noisa_gallery_artists', '', ', ' ); ?></h6>
				            </div>
				            <div class="meta-col">
				                <span class="meta-date"><?php the_time( $date_format ); ?></span>
				            </div>
				            <div class="meta-col">
	            				<?php if ( function_exists( 'noisa_share_buttons' ) ) { echo noisa_share_buttons( $post->ID ); } ?>
	        				</div>
				        </div>
						<?php endif; ?>

						<?php
						// EVENTS
						if ( get_post_type() == 'noisa_events' ) :

							/* Event Date */
							$time_format = 'H:i';

						    if ( $noisa_opts->get_option( 'event_time' ) ) {
						        $time_format = $noisa_opts->get_option( 'event_time' );
						    }

                            $event_time_start = get_post_meta( $post->ID, '_event_time_start', true );
                            $event_date_start = get_post_meta( $post->ID, '_event_date_start', true );
                            $cd_date = strtotime( $event_date_start );
 							$event_date_start = $event_date_start . ' ' . $event_time_start;
                            $event_date_start = strtotime( $event_date_start );
						?>
						<div class="meta-top">
				            <div class="meta-col">
				                <h6 class="event-start-date"><?php echo date_i18n( $date_format . ' @ ' . $time_format, $event_date_start ); ?></h6>
				            </div>
				            <?php if ( has_term( 'future-events', 'noisa_event_type' ) ) : ?>
				            <div class="meta-col">
				                <div class="event-countdown-wrap">
									<div class="countdown" data-event-date="<?php echo date_i18n( 'Y/m/d', $cd_date ) ?> <?php echo date_i18n( 'H:i', strtotime( $event_time_start ) ) ?>:00">
								        <div class="days" data-label="<?php echo esc_attr( __( 'Days', 'noisa') ) ?>">000</div>
								        <div class="hours" data-label="<?php echo esc_attr( __( 'Hours', 'noisa') ) ?>">00</div>
								        <div class="minutes" data-label="<?php echo esc_attr( __( 'Minutes', 'noisa') ) ?>">00</div>
								        <div class="seconds" data-label="<?php echo esc_attr( __( 'Seconds', 'noisa') ) ?>">00</div>
							        </div>
				                </div>
				            </div>
				            <?php endif; ?>
				            <div class="meta-col">
	            				<?php if ( function_exists( 'noisa_share_buttons' ) ) { echo noisa_share_buttons( $post->ID ); } ?>
	        				</div>
				        </div>
						<?php endif; ?>

					</div>
					<!-- /caption-bottom -->
					
				</div>
			</div>
	        <!-- Image -->
	        <?php

	        	// If image exists

	        	?>
				<?php if ( $yt_id != '' ) { ?>
	        	<div id="video-bg" class="image-video image desktop-video" data-video-id="<?php echo esc_attr( $yt_id ) ?>" data-mute="<?php echo esc_attr( $mute_video ) ?>" style="background-image: url(<?php echo esc_url( $noisa_opts->get_image( $img ) ) ?>);<?php echo esc_attr( $min_height ) ?>">
					<div class="video-loader">
						<div class="spinner"></div>
					</div>
				</div>
	        	<?php
			   	 } else if ( $img ) {
			   		$img = $noisa_opts->get_image( $img );

		        	// Intro Image
					if ( $image_effect && $image_effect === 'zoom' ) {
						$img_classes = 'image zoom';
					} else if ( $image_effect && $image_effect === 'parallax' ) {
						$img_classes = 'parallax';
					} else {
						$img_classes = 'image';
					}

					echo '<div class="' . esc_attr( $img_classes ) . ' image-container anim-css" style="background-image: url(' . esc_url( $img ) . ')"></div>';
				}

	        ?>
			
	       <?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					if ( $overlay != 'gradient' ) {
						$gradient_style = '';
					}
					echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
				}
	       	 ?>
		</div>
	</section>
<?php

// ==================================================== Intro Slider ====================================================

elseif ( $intro_type === 'intro_full_slider' || $intro_type === 'intro_slider' ) : ?>
	<?php
		$slider_id = get_post_meta( $intro_id, '_slider_id', true );
		
	?>

	<?php if ( $slider_id && $slider_id !== 'none' ) : ?>
	<?php 

		// Min height
		$min_height = get_post_meta( $intro_id, '_min_height', true );

		// Slider Settings
		if ( $intro_type === 'intro_full_slider' ) {
			$intro_resize = 'intro-resize';
			$slider_min_height = '';
			$qs = $quick_scroll;
		} else {
			$qs = '';
			$intro_resize = '';
	    	$slider_min_height = 'min-height:' . $min_height . 'px;';
		}

		// Zoom
		$zoom_effect = get_post_meta( $intro_id, '_zoom_effect', true );
		if ( $zoom_effect && $zoom_effect === 'on' ) {
			$zoom_effect = 'zoom';
		} else {
			$zoom_effect = '';
		}

		// Slider navigation
		$slider_nav = get_post_meta( $slider_id, '_slider_nav', true );
		if ( $slider_nav && $slider_nav === 'on' ) {
			$slider_nav = 'true';
		} else {
			$slider_nav = 'false';
		}

		// Slider pagination
		$slider_pagination = get_post_meta( $slider_id, '_slider_pagination', true );
		if ( $slider_pagination && $slider_pagination === 'on' ) {
			$slider_pagination = 'true';
		} else {
			$slider_pagination = 'false';
		}

		// Slider speed
		$slider_speed = get_post_meta( $slider_id, '_slider_speed', true );

		// Slider pause time
		$slider_pause_time = get_post_meta( $slider_id, '_slider_pause_time', true );
		if ( ! $slider_pause_time && $slider_pause_time === '0' ) {
			$slider_pause_time = 'false';
		}

		if ( $intro_type === 'intro_full_slider' ) {
			$intro_captions_classes .= ' ' . $captions_align;
		}
	?>

    <section class="intro <?php echo esc_attr( $animated ); ?> intro-slider-outer <?php echo esc_attr( $qs ) ?>">
    	<div class="intro-inner">
			<div id="intro-slider" class="<?php echo esc_attr( $intro_resize ) ?> intro-slider content-slider <?php echo esc_attr( $zoom_effect ) ?> <?php echo esc_attr( $intro_bg_color ) ?> clearfix intro-id-<?php echo esc_attr( $intro_id ); ?>" data-slider-nav="<?php echo esc_attr( $slider_nav ) ?>" data-slider-pagination="<?php echo esc_attr( $slider_pagination ) ?>" data-slider-speed="<?php echo esc_attr( $slider_speed ) ?>" data-slider-pause-time="<?php echo esc_attr( $slider_pause_time ) ?>" style="<?php echo esc_attr( $slider_min_height ) ?>">

		    	<?php  

		    	/* Images ids */
				$images_ids = get_post_meta( $slider_id, '_custom_slider', true );

				if ( ! $images_ids || $images_ids == '' ) {
					 return '<p class="message error">' .  __( 'Slider error: Slider has no pictures or doesn\'t exists.', 'noisa' ) . '</p>';
				}

				$count = 0;
				$ids = explode( '|', $images_ids );
				$defaults = array(
					'youtube_id'           => '',
					'title'                => '',
					'subtitle'             => '',
					'slider_button_url'    => '',
					'slider_button_target' => '_self',
					'slider_button_title'  => ''
				);

				/* Start Loop */
				foreach ( $ids as $id ) {

					// Vars 
					$title = '';
					$subtitle = '';

					// Get image data
					$image_att = wp_get_attachment_image_src( $id );

					if ( ! $image_att[0] ) {
						continue;
					}
					
					/* Count */
				   	$count++;

					/* Get image meta */
					$image = get_post_meta( $slider_id, '_custom_slider_' . $id, true );

					/* Add default values */
					if ( isset( $image ) && is_array( $image ) ) {
						$image = array_merge( $defaults, $image );
					} else { 
						$image = $defaults;
					}

					// Min height
				   	if ( $min_height && $intro_type !== 'intro_full_slider'  ) {
						$slide_min_height = 'min-height:' . $min_height. 'px';
					} else {
						$slide_min_height = '';
					}

				   	?>
					<!-- Slide -->
			        <div class="slide <?php if ( $image['youtube_id'] != '' ) echo 'video-slide' ?>" style="<?php echo esc_attr( $slide_min_height ) ?>">
						<?php if ( $image['title'] !== '' || $image['subtitle'] !== '' || $image['slider_button_url'] !== '' ) : ?>

						<!-- Captions -->
						<div class="intro-captions <?php echo esc_attr( $intro_captions_classes ) ?>">
							<div class="container">
								<?php if ( $image['title'] !== '' ) : ?>
								<div class="caption-top"><h2 class="caption-title"><?php echo do_shortcode( $image['title'] ) ?></h2></div>
								<div class="caption-divider-wrapper"><hr class="caption-divider"></div>
								<?php endif; ?>
								<div class="caption-bottom">
									<?php if ( $intro_subtitle !== '' ) : ?>
									<h6 class="caption-subtitle"><?php echo do_shortcode( $image['subtitle'] ) ?></h6>
									<?php endif; ?>
									<?php if ( function_exists( 'noisa_stamp_buttons' ) ) { echo '<div class="caption-button">' . noisa_stamp_buttons( $intro_buttons ) . '</div>'; } ?>
								</div>
							</div>
						</div>
						<?php endif; ?>
			       
			            <!-- Image -->
			            <?php 
			            	/* Add image src to array */
						   	$image['src'] = wp_get_attachment_url( $id );
			             ?>

			            <?php if ( $image['youtube_id'] != '' ) : ?>

			            <div id="video-slide<?php echo esc_attr( $slider_id . $id ) ?>" class="image-video desktop-video" data-video-id="<?php echo esc_attr( $image['youtube_id'] ) ?>" style="background-image: url(<?php echo esc_url( $image['src'] ) ?>);">
							<div class="video-loader">
								<div class="spinner"></div>
							</div>
						</div>
						
						<?php else: ?>
						
			            <div class="image slide-<?php echo esc_attr( $intro_id . '-' . $id ); ?>" style="background-image: url(<?php echo esc_url( $image['src'] ) ?>)" ></div>
			            <?php endif; ?>
			            <!-- Overlay -->
			           <?php
				       		// Overlay
							if ( $overlay && $overlay != 'disabled' ) {
								if ( $overlay != 'gradient' ) {
									$gradient_style = '';
								}
								echo '<span class="overlay ' . esc_attr( $overlay ) . ' ' . esc_attr( $animated ) . '" style="' .  esc_attr( $gradient_style ) . '"></span>';
							}
				       	 ?>
			        </div>
			        <!-- /slide -->

				   	<?php
				}

		    	?>
		    </div>
		    <!-- /slider -->
		</div>
		<!-- inner -->
    </section>

	<?php endif; // Slider ID ?>

<?php endif; ?>
<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			header.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php global $noisa_opts, $post, $wp_query; ?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php 
    $page_id = '0';

    if ( isset( $wp_query ) && isset( $post ) ) {
        $page_id = $wp_query->post->ID;
    }
?>
<body <?php body_class( ) ?> data-page_id="<?php echo esc_attr( $page_id ) ?>" data-wp_title="<?php esc_attr( wp_title( '|', true, 'right' ) ) ?>">

<!-- ############################# Slidebar / Menu ############################# -->
<div id="slidebar" class="dark-bg">
    <?php if ( $noisa_opts->get_option( 'site_image' ) && $noisa_opts->get_option( 'site_image' ) != '' ) : ?>
    <?php 
        $site_image = $noisa_opts->get_option( 'site_image' );
        $site_image = $noisa_opts->get_image( $site_image );
    ?>
    <!-- /site image -->
    
    <!-- ############ Site image ############ -->
    <div class="slidebar-image" style="background-image:url(<?php echo esc_url( $site_image ) ?>)"></div>
    <?php endif; ?>
    <a href="#" id="slidebar-close"></a>
    <div id="slidebar-content" class="clearfix dark-bg">
        <div>
            <?php if ( $noisa_opts->get_option( 'search_box' ) && $noisa_opts->get_option( 'search_box' ) === 'on' ) : ?>
            <!-- ############ Search ############ -->
            <div id="slidebar-search">
                <?php get_search_form(); ?>
            </div>
            <!-- /search -->
            <?php endif; ?>
            <?php
                $defaults = array(
                    'theme_location'  => 'sidebar',
                    'menu'            => '',
                    'container'       => false,
                    'container_class' => '',
                    'menu_class'      => 'menu',
                    'fallback_cb'     => 'wp_page_menu',
                    'depth'           => 4
                );              
            ?>
        
        <nav id="main-nav">
            <?php if ( has_nav_menu( 'sidebar' ) ) : ?>
            <?php wp_nav_menu( $defaults ); ?>
            <?php endif; ?>
        </nav>
            <?php get_sidebar( 'slidebar' ); ?>
        </div>
    </div>

</div>  
<div id="slidebar-layer"></div>


<div id="site" class="site">
    <!-- ############################# Header ############################# -->
    <header id="header">

        <div class="container">
        	<!-- ############ Logo ############ -->
    	   	<a href="<?php echo esc_url( home_url() ) ?>" id="logo">
    	   		<?php
    	   			// Get Theme Logo
    	   			$logo = $noisa_opts->get_option( 'logo' );
    	   			$logo = $noisa_opts->get_image( $logo );
    	   		?>
    	   		<?php if ( $logo ) : ?>
    	   			<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( __( 'Logo Image', 'noisa' ) ); ?>">
    	   		<?php endif; ?>
    	   	</a>
    	   	<!-- /logo -->
            
            <nav id="icon-nav">
                 <!-- Menu Tigger -->
                <a href="#" class="icon-nav-item" id="menu-trigger"><span class="icon"></span></a>
                <!-- /menu Tigger -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <?php 
                        global $woocommerce;
                        $count = $woocommerce->cart->cart_contents_count;
                    ?>
                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ) ?>" class="icon-nav-item" id="shop-link"><span class="icon icon-cart"></span><?php if ( $count > 0 ) { echo "<span class='shop-items-count'>$count</span>"; } ?></a>
                <?php endif ?>
            </nav>

            <!-- ############################# Menu ############################# -->

            <!-- ############ Navigation ############ -->
            <?php
                $defaults = array(
                    'theme_location'  => 'top',
                    'menu'            => '',
                    'container'       => false,
                    'container_class' => '',
                    'menu_class'      => 'menu',
                    'fallback_cb'     => 'wp_page_menu',
                    'depth'           => 3
                );              
            ?>
            <?php if ( has_nav_menu( 'top' ) ) : ?>
            <nav id="nav">
                <?php wp_nav_menu( $defaults ); ?>
            </nav>
        	<?php endif; ?>
            <!-- /navigation -->

        </div>
    </header>

    <!-- ############################# AJAX CONTAINER ############################# -->
    <div id="ajax-container">
        <div id="ajax-content">
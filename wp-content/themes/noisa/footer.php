<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			footer.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */
?>
<?php global $noisa_opts, $post, $wp_query; ?>

        </div>
        <!-- /ajax content -->
    </div>
    <!-- /ajax container -->
    
    <!-- Footer container -->
    <section id="footer-container">
        <?php if ( $noisa_opts->get_option( 'footer_widgets' ) === 'on' ) : ?>
        <!-- ############################# Footer ############################# -->
        <footer id="footer-widgets">
            <div class="container">
                <!-- Footer Columns -->
                <div class="footer-col">
                    <?php get_sidebar( 'footer-col1' ); ?>
                </div>
                <div class="footer-col footer-col-middle">
                    <?php get_sidebar( 'footer-col2' ); ?>
                </div>
                <div class="footer-col last">
                    <?php get_sidebar( 'footer-col3' ); ?>
                </div>
                <!-- /footer columns -->
            </div>
        </footer>
        <!-- /footer -->
        <?php endif; ?>

        <!-- Footer Note -->
        <div id="footer-note">
            <div class="container">
                    <?php 
                        echo do_shortcode( $noisa_opts->get_option( 'footer_note' ) );
                    ?>
           
            </div>
        </div>
        <!-- /footer note -->
    </section>
    <!-- /footer container -->

</div>
<!-- /site -->
<?php wp_footer(); ?>
</body>
</html>
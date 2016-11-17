<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  color
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_color' ) ) {

	class MuttleyBox_color extends MuttleyBox {

		private static $_initialized = false;
		private static $_args;
		private static $_saved_options;
		private static $_option;


		/**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function __construct( $option, $args, $saved_options ) {
			
			// Variables
			self::$_args = $args;
			self::$_saved_options = $saved_options;
			self::$_option = $option;

			// Only for first instance
			if ( ! self::$_initialized ) {
	            self::$_initialized = true;

	            // Enqueue
				add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ) );

	            // Ajax
	            add_action( 'wp_ajax_easy_link_ajax', array( &$this, 'easy_link_ajax' ) );            
	            
	        }

		}


		/**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function enqueue() {

			wp_enqueue_script( 'wp-color-picker' );
	    	wp_enqueue_style( 'wp-color-picker' );
			
		}


		/**
         * Field Render Function.
         * Takes the vars and outputs the HTML
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function render() {

			if ( isset( self::$_saved_options[self::$_option['id']] ) ) {
				self::$_option['std'] = self::$_saved_options[self::$_option['id']];
			}

			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label for="' . self::$_option['id'] . '" >' . self::$_option['name'] . '</label>';
			}
			echo '<div class="clear"></div>';
			echo '<input name="' . self::$_option['id'] . '" id="' . self::$_option['id'] . '" type="text" value="' . self::$_option['std'] . '" class="colorpicker-input" />';
			echo '<div class="clear"></div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}

	}
}
<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  gradient
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_gradient' ) ) {

	class MuttleyBox_gradient extends MuttleyBox {

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

			if ( isset( self::$_saved_options[self::$_option['id'][0]['id']] ) ) {
				self::$_option['std'][0]['std'] = self::$_saved_options[self::$_option['id'][0]['id']];
			}
			if ( isset( self::$_saved_options[self::$_option['id'][1]['id']] ) ) {
				self::$_option['std'][1]['std'] = self::$_saved_options[self::$_option['id'][1]['id']];
			}
			if ( isset( self::$_saved_options[self::$_option['id'][2]['id']] ) ) {
				self::$_option['std'][2]['std'] = self::$_saved_options[self::$_option['id'][2]['id']];
			}
			

			echo '<div class="box-row gradient-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label>' . self::$_option['name'] . '</label>';
			}
			echo '<div class="clear"></div>';

			echo '<div class="gradient-col">';
			echo  _x( 'From:', 'MuttleyBox Class', $this->textdomain );
			echo '<input name="' . self::$_option['id'][0]['id'] . '" id="' . self::$_option['id'][0]['id'] . '" type="text" value="' . self::$_option['id'][0]['std'] . '" class="colorpicker-input gradient-from" />';
			echo '</div>';

			echo '<div class="gradient-col">';
			echo  _x( 'To:', 'MuttleyBox Class', $this->textdomain );
			echo '<input name="' . self::$_option['id'][1]['id'] . '" id="' . self::$_option['id'][1]['id'] . '" type="text" value="' . self::$_option['id'][1]['std'] . '" class="colorpicker-input gradient-to" />';
			echo '</div>';

			echo '<div class="gradient-col">';
			echo  _x( 'Direction:', 'MuttleyBox Class', $this->textdomain );
			echo '<input name="' . self::$_option['id'][2]['id'] . '" id="' . self::$_option['id'][2]['id'] . '" type="text" value="' . self::$_option['id'][2]['std'] . '" class="gradient-direction" />';
			echo '</div>';

			echo '<div class="clear"></div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}

	}
}
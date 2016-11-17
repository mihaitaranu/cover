<?php

/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  add_image
 * @author      Mariusz Rek
 * @version     1.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_add_image' ) ) {

	class MuttleyBox_add_image extends MuttleyBox {

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
	        }

		}


		/**
         * Field Render Function.
         * Takes the vars and outputs the HTML
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function render() {

			/* Set image crop and display */
			if ( isset( self::$_option['id'][1]['id'] ) && isset( self::$_option['id'][1]['std'] ) ) {
				$preview_crop = self::$_option['id'][1]['std'];
			} else {
				$preview_crop = 'c';
			}
			if ( isset( self::$_option['id'][0]['std'] ) || self::$_option['id'][0]['std'] != '' ) {
				$crop_display = 'table';
			} else {
				$crop_display = 'none';
			}

			// Variables
			$media_libary = '';
			$external_link = '';
			$holder_classes = '';


			// Source
			if ( isset( self::$_option['source'] ) && self::$_option['source'] == 'all' ) {
				$source = 'all';
			} elseif ( isset( self::$_option['source'] ) && self::$_option['source'] == 'media_libary' ){
				$source = 'media_libary';
				$input_type = 'hidden';
			} elseif ( isset( self::$_option['source'] ) && self::$_option['source'] == 'external_link' ){
				$source = 'external_link';
				$input_type = 'text';
				$holder_classes .= ' hidden';
			} else {
				$source = 'all';
			}

			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label>' . self::$_option['name'] . '</label>';
			}

			if ( $source == 'all' ) {

				if ( is_numeric( self::$_option['id'][0]['std'] ) || self::$_option['id'][0]['std'] == '' ) {
					$media_libary = 'selected="selected"';
					$input_type = 'hidden';
				} else {
					$external_link = 'selected="selected"';
					$input_type = 'text';
					$holder_classes .= ' hidden';
				}

				echo '<select size="1" class="image-source-select" >';

					echo "<option $media_libary value='media_libary'>" . _x( 'Media libary', 'MuttleyBox Class', $this->textdomain ) . "</option>";
					echo "<option $external_link value='external_link'>" . _x( 'External link', 'MuttleyBox Class', $this->textdomain ) . "</option>";
				
				echo '</select>';

			}

			// Input
			echo '<input type="' . $input_type . '" value="' . self::$_option['id'][0]['std'] . '" id="' . self::$_option['id'][0]['id'] . '" name="' . self::$_option['id'][0]['id'] . '" class="image-input"/>';

			/* Image preview */
			
			// Get image data
			$image = wp_get_attachment_image_src( self::$_option['id'][0]['std'], 'thumbnail' );
			$image = $image[0];

			// If image exists
			if ( $image ) {
				$image_html = '<img src="' . $image . '" alt="' . _x( 'Preview Image', 'MuttleyBox Class', $this->textdomain ) . '">';
				$holder_classes .= ' is_image'; 
			} else {
				$image_html = ''; 
			}

			echo '<div class="image-holder ' . $holder_classes . '">';

			// Image
			echo $image_html;

			// Button
			echo '<button class="upload-image"><i class="fa icon fa-plus"></i></button>';

			/* Remove image */
			echo '<a class="remove-image"><i class="fa icon fa-remove"></i></a>';
			echo '</div>';


			/* Crop */
			if ( isset( self::$_option['id'][1]['id'] ) ) {
		  
				echo '<div class="image-crop-wrap input-group" style="display:' . $crop_display . '">';
				echo '<span class="input-group-addon"><i class="fa fa-crop"></i></span>';
				echo '<select name="' . self::$_option['id'][1]['id'] . '" id="' . self::$_option['id'][1]['id'] . '" size="1" class="image-crop" >';
				$options = array(
					array('name' => 'Center', 'value' => 'c'),
					array('name' => 'Top', 'value' => 't'),
					array('name' => 'Top right', 'value' => 'tr'),
					array('name' => 'Top left', 'value' => 'tl'),
					array('name' => 'Bottom', 'value' => 'b'),
					array('name' => 'Bottom right', 'value' => 'br'),
					array('name' => 'Bottom left', 'value' => 'bl'),
					array('name' => 'Left', 'value' => 'l'),
					array('name' => 'Right', 'value' => 'r')
					);
				foreach ( $options as $option ) {
					
					if ( self::$_option['id'][1]['std'] == $option['value'] ) $selected = 'selected="selected"';
					else $selected = '';
					echo "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				echo '</select></div>';
			}		

			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';

		}

	}
}
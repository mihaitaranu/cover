<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyPanel
 * @subpackage  sortable_social
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyPanel_sortable_social' ) ) {

	class MuttleyPanel_sortable_social extends MuttleyPanel {

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

			echo '<div class="box-row clearfix">';
			
			if ( isset(self::$_option['button_text']) && self::$_option['button_text'] != '' ) {
			    $button_text = self::$_option['button_text'];
			 } else {
			    $button_text = __( 'Add New Item', 'noisa' );
			}
			
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label >' . self::$_option['name'] . '</label>';
			}

			// Helpers
			$options_type = array(
				array( 
					'value' => 'twitter', 
					'label' => 'Twitter'
				), 
				array(
					'value' => 'facebook', 
					'label' => 'Facebook'
				),
				array(
					'value' => 'youtube', 
					'label' => 'Youtube'
				)
			);
			echo '<div class="clear"></div>';
			

			/* Hidden items */
			echo '<div class="new-item" style="display:none">';
			echo '<ul>';
			echo '<li>';
			echo '<span class="delete-item"><i class="fa fa-times"></i></span>';
			echo '<span class="drag-item"><i class="fa fa-arrows-alt"></i></span>';
			echo '<div class="content">';
			echo '<input type="hidden" value="" name="' . self::$_option['array_name'] . '_hidden[]"/>';

				// Social
				echo '<div class="scol">';
				echo '<label>' . __( 'Social:', 'noisa' ) . '</label>';
				echo '<select name="social_type[]" class="no-save">';
					foreach( $options_type as $option ) {
							
			     		echo '<option  value="' . $option['value'] . '">' . $option['label'] . '</option>';
					}
				echo '</select>';
				echo '</div>';

				// Link
				echo '<div class="scol">';	
			    echo '<label>' . __( 'Link:', 'noisa' ) . '</label>';
				echo '<input type="text" value="#" name="social_link[]" class="no-save"/>';
				echo '</div>'; // end col

				// Title
				echo '<div class="scol">';	
			    echo '<label>' . __( 'Title:', 'noisa' ) . '</label>';
				echo '<input type="text" value="" name="social_title[]" class="no-save"/>';
				echo '</div>'; // end col
				
				// Target
				echo '<div class="scol">';
				echo '<label>' . __( 'Target:', 'noisa' ) . '</label>';
				echo '<select name="social_target[]" class="no-save">';
				echo '<option value="_self">' . __( 'Same Window', 'noisa' ) . '</option>';
				echo '<option value="_blank">' . __( 'New Window', 'noisa' ) . '</option>';
				echo '</select>';
				echo '</div>'; // end col

			echo '</div>';
			echo '</li>';
			echo '</ul>';
			echo '</div>';
			
			if ( self::$_option['sortable'] == true ) 
				$sort = 'sortable';
			else 
				$sort = '';

			if ( isset( self::$_saved_options[self::$_option['array_name']] ) && is_array( self::$_saved_options[self::$_option['array_name']] ) )
			  $list_class = self::$_option['array_name'];
			else 
			  $list_class = '';

			echo '<ul class="sortable-list ' . $list_class . ' ' . $sort .'">';

			if ( isset( self::$_saved_options[self::$_option['array_name']] ) && is_array( self::$_saved_options[self::$_option['array_name']] ) ) {
				foreach ( self::$_saved_options[self::$_option['array_name']] as $items ) {
					echo '<li>';
					echo '<span class="delete-item"><i class="fa fa-times"></i></span>';
					echo '<span class="drag-item"><i class="fa fa-arrows-alt"></i></span>';
					echo '<div class="content">';
					echo '<input type="hidden" value="" name="' . self::$_option['array_name'] . '_hidden[]"/>';
					foreach ( self::$_option['id'] as $count => $item ) {
						switch ( $item['id'] ) {

							case 'social_type':
								echo '<div class="scol">';	
								echo '<label>' . __( 'Social:', 'noisa' ) . '</label>';
								echo '<select name="' . $item['id'] . '[]">';

								foreach( $options_type as $option ) {
									
									if ( isset( $items[$item['name']] ) && $items[$item['name']] == $option['value'] ) {
										$selected = 'selected="selected"';
									} else {
										$selected = '';
									}
										
						     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
								}
								echo '</select>';
								echo '</div>';
							break;

							case 'social_link':
								echo '<div class="scol">';	
							   	echo '<label>' . __( 'Link:', 'noisa' ) . '</label>';
							   	if ( isset( $items[$item['name']] ) ) {
									echo '<input type="text" value="' . htmlentities($items[$item['name']]) . '" name="' . $item['id'] . '[]"/>';
								} else {
									echo '<input type="text" value="#" name="' . $item['id'] . '[]"/>';
								}
								echo '</div>';
							break;

							case 'social_title':
								echo '<div class="scol">';	
								echo '<label>' . __( 'Title:', 'noisa' ) . '</label>';
							   	if ( isset( $items[$item['name']] ) ) {
									echo '<input type="text" value="' . htmlentities($items[$item['name']]) . '" name="' . $item['id'] . '[]"/>';
								} else {
									echo '<input type="text" value="#" name="' . $item['id'] . '[]"/>';
								}
								echo '</div>';
							break;

							case 'social_target':
								echo '<div class="scol">';	
								echo '<label>' . __( 'Target:', 'noisa' ) . '</label>';
							   	echo '<select name="' . $item['id'] . '[]">';
							   		echo '<option value="_self">' . __( 'Same Window', 'noisa' ) . '</option>';

							   		if ( isset( $items[$item['name']] ) && $items[$item['name']] == '_blank' ) {
										$selected = 'selected="selected"';
									} else {
										$selected = '';
									}

							   		echo '<option ' . $selected . ' value="_blank">' . __( 'New Window', 'noisa' ) . '</option>';
							   	echo '</select>';
							   	echo '</div>';
									
							break;

						}
						
					}
					echo '</div>';
					echo '</li>';
				}
			}
			echo '</ul>';
	        echo '<div class="clear"></div>';
			echo '<button class="_button add-new-item"><i class="icon fa-plus"></i>' . $button_text . '</button>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';

		}

	}
}
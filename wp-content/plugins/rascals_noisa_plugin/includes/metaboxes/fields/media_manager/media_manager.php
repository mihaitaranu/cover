<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  media_manager
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_media_manager' ) ) {

	class MuttleyBox_media_manager extends MuttleyBox {

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

	           	/* Media Manager - Get data of single item */
				add_action( 'wp_ajax_mm_editor', array( &$this, 'mm_editor') );

				/* Media Manager - Save data of single item */
				add_action( 'wp_ajax_mm_editor_save', array( &$this, 'mm_editor_save') );

				/* Media Manager - Actions */
				add_action( 'wp_ajax_mm_actions', array( &$this, 'mm_actions') );       
	            
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
			
			// Admin Footer
			add_action( 'admin_footer', array( &$this, 'admin_footer' ) );

			$path = self::$_args['admin_path'];

			// Load script
			$handle = self::$_option['type'] . '.js';
			if ( ! wp_script_is( $handle, 'enqueued' ) ) {
				wp_enqueue_script( $handle, $path . '/fields/' . self::$_option['type'] . '/' . self::$_option['type'] . '.js', false, false, true );
			}

			// Load style
			$handle_css = self::$_option['type'] . '.css';
			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_enqueue_style( $handle, $path . '/fields/' . self::$_option['type'] . '/' . self::$_option['type'] . '.css' );
			}
			
		}


		/**
         * Render HTML code in admin footer
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function admin_footer() {
			$this->mm_explorer_box();
			$this->mm_editor_box();
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
			global $post;

			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label for="' . self::$_option['id'] . '" >' . self::$_option['name'] . '</label>';
			}
			
			if ( ! isset( self::$_option['std'] ) || self::$_option['std'] == '') 
				$no_images = 'block';
			else 
				$no_images = 'none';

			/* Select All Items */
			echo '<span class="mm-select-all">select all</span>';
			echo '<div class="clear"></div>';

			// Texts
			if ( isset( self::$_option['btn_text'] ) && self::$_option['btn_text'] != '' ) 
				$btn_text = self::$_option['btn_text'];
			else 
				$btn_text = __('Add Images', 'muttleybox' );
			if ( isset( self::$_option['msg_text'] ) && self::$_option['msg_text'] != '' ) 
				$msg_text = self::$_option['msg_text'];
			else 
				$msg_text = __( 'Currently slider does not have images, you can add them by clicking on button below.', 'muttleybox' );
			
			/* Message */
			echo '<div class="msg-dotted" style="display:' . $no_images . '">' . $msg_text . '</div>';

			/* Settings */
			echo '<span class="mm-settings mm-hidden" data-post-id="' . $post->ID . '" data-mm-id="' . self::$_option['id'] . '" data-mm-type="' . self::$_option['media_type'] . '" data-mm-admin-path="' . self::$_args[ 'admin_path' ] . '"></span>';

			/*  Hidden input */
			echo '<input type="hidden" value="' . self::$_option['std'] . '" id="' . self::$_option['id'] . '" name="' . self::$_option['id'] . '" class="mm-ids"/>';

			/* Preview */
			echo '<div class="mm-wrap">';

			/* Preview Items */
			if ( isset( self::$_option['std'] ) && self::$_option['std'] != '' ) {

				$items = explode('|', self::$_option['std'] );

				foreach( $items as $id ) {

					/* Image */
					if ( self::$_option['media_type'] == 'images' || self::$_option['media_type'] == 'slider' ) {

						$image = wp_get_attachment_image_src( $id );

						if ( $image ) {
							$item = get_post( $id );
							$meta = wp_get_attachment_metadata( $id );
							if ( is_array( $meta ) ) {
								$meta_html = esc_html( basename( $item->guid ) ) . ' - ' . $meta['width'] . 'x' . $meta['height'];
							} else {
								$meta_html = '';
							}
							echo '
							<a class="mm-item" id="' . $id . '" title="' . $meta_html . '">
								<div class="mm-item-preview">
							    	<div class="mm-item-image">
							    		<div class="mm-centered">
							    			<img src="' . $image[0] . '" />
							    		</div>
							    	</div>
								</div>
								<span class="mm-edit-button"><i class="fa fa-gear"></i></span>
							</a>';
						} else {
							echo '
							<a class="mm-item" id="' . $id . '">
								<div class="mm-item-preview">
							    	<div class="mm-filename"><div>' . __( 'Error: Image file doesn\'t exists.', 'muttleybox' ) . '</div></div>
								</div>
							</a>';
						}
					}

					/* Audio */
					if ( self::$_option['media_type'] == 'audio' ) {

						/* If custom id */
						$audio = get_post( $id );
						$track = false;

						if ( $audio ) {

							/* This is not custom audio */
							$track = get_post_meta( $post->ID, self::$_option['id'] . '_' . $id, true );
							if ( ! isset( $track['title'] ) ) {
								$track['title'] = $audio->post_title;
							}
							$audio_filename = $audio->guid;
						} else {

							$track = get_post_meta( $post->ID, self::$_option['id'] . '_' . $id, true );

							/* Check custom track */
							if ( isset( $track['custom_url'] ) ) {
								$audio = true;
								$audio_filename = $track['custom_url'];
							} else {
								$audio_filename = '';
							}
						}

						if ( $audio ) {

							if ( isset( $track[ 'cover' ] ) ) {
								$image = wp_get_attachment_image_src( $track['cover'], 'thumbnail' );
								$image = $image[0];
							} else {
								$image = false;
							}
							// If image exists
							if ( $image ) {
								$image_html = '<img class="mm-audio-icon mm-audio-custom-cover" src="' . $image . '" alt="' . _x( 'Preview Image', 'MuttleyBox Class', $this->textdomain ) . '">';
							} else {
								$image_html = '<img src="' . self::$_args[ 'admin_path' ] . '/assets/images/metabox/audio.png" class="mm-audio-icon" />';
							}

							echo '
								<a class="mm-item mm-audio" id="' . $id . '" title="' . esc_html( basename( $audio_filename ) ) . '">
									<div class="mm-item-preview">
								    	' . $image_html . '
								    	<div class="mm-filename"><div>' . $track['title'] . '</div></div>
									</div>
									<span class="mm-edit-button"><i class="fa fa-gear"></i></span>
								</a>';
						} else {
							echo '
								<a class="mm-item" id="' . $id . '">
									<div class="mm-item-preview">
								    	<div class="mm-filename"><div>' . __( 'Error: Audio file doesn\'t exists.', 'muttleybox' ) . '</div></div>
									</div>
								</a>';
						}

					}
			    }	
			}
			echo '</div>';

			/* Error message */
			echo '<p class="msg msg-error" style="display:none;">' . __( 'Error: AJAX Transport', 'muttleybox' ) . '</p>';

			/* Buttons */

			/* Explorer */
			echo '<button class="_button mm-explorer-button"><i class="fa icon fa-plus"></i>' . $btn_text . '</button>';

			/* Add custom audio */
			if ( self::$_option['media_type'] == 'audio' ) echo '<button class="_button mm-custom-audio"><i class="fa icon fa-plus"></i>' . __( 'Add Custom Track', 'muttleybox' ) . '</button>';

			/* Delete */
			echo '<button class="_button ui-button-delete mm-delete-button" style="display:none"><i class="fa icon fa-trash-o"></i>' . __( 'Remove Selected', 'muttleybox' ) . '</button>';

			/* Ajax loader */
			echo '<img class="mm-ajax" src="' . esc_url( admin_url( 'images/wpspin_light.gif' ) ) . '" alt="Loading..." />';

			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}


		/* Ajax Actions
		---------------------------------------------- */

		/* Save item data */
		function mm_editor_save() {
			
			/* Variables */
			$fields = $_POST['fields'];
			$settings = $_POST['settings'];
			$id = $_POST['item_id'];
			$output = '';
			$response = 'success';

			/* Update attachment audio title */
			if ( $settings['mm_type'] == 'audio' && $fields['title'] != '' ) {
				$response = $fields['title'];
			}

			$option_name = $settings['mm_id'] . '_' . $id;
			$options = get_post_meta($settings['post_id'], $option_name , true);
			
			if ( ! isset( $fields ) && is_array( $fields ) || ! isset( $settings ) ) 
				die();
			
			if ( update_post_meta( $settings['post_id'], $option_name, $fields ) )
		        $this->e_esc( $response );
			else
			    echo 'error';
		   exit;
		}

		/* Media Manager - Ajax Actions */
		function mm_actions() {
			
			$action = $_POST['mm_action'];
			$output = '';

			if ( ! isset( $_POST['action'] ) ) {
				exit;
				echo 'Error - Not set action';
			}


			/* --- Media Explorer --- */
			if ( $action == 'media_explorer' ) {

				/* Variables */
				$pagenum = $_POST['page_num'];
			    $args = array();
			    $args['pagenum'] = $pagenum;
			    $args['numberposts'] = $_POST['numberposts'];
			    $output = '';

				if ( isset( $_POST['type'] ) ) 
					$args['type'] = $_POST['type'];
				else 
					$args['type'] = 'images';

				if ( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
					$args['ids'] = $_POST['ids'];
				}
				if ( isset( $_POST['s'] ) && $_POST['s'] != '' ) 
					$args['s'] = stripslashes( $_POST['s'] );
				
				$results = $this->mm_query( $args );

				if ( ! isset( $results ) ) die();
				
			    $output = '';
				if ( ! empty( $results ) ) {

					foreach ( $results as $i => $result ) {

						$item = get_post( $result['ID'] );

						/* Images */
						if ( $args['type'] == 'images' || $args['type'] == 'slider' ) {
							$meta = wp_get_attachment_metadata( $result['ID'] );
							if ( is_array( $meta ) ) {
								$meta_html = esc_html( basename( $item->guid ) ) . ' - ' . $meta['width'] . 'x' . $meta['height'];
							} else {
								$meta_html = '';
							}
							$output .= '
							<a class="mm-item" id="' . $result['ID'] . '" title="' . $meta_html . '">
								<div class="mm-item-preview">
							    	<div class="mm-item-image">
							    		<div class="mm-centered">
							    			<img src="' . $result['image'][0] . '" />
							    		</div>
							    	</div>
								</div>
							</a>';


						/* Audio */
						} else {
							$output .= '
							<a class="mm-item mm-audio" id="' . $result['ID'] . '" title="' . esc_html( basename( $item->guid ) ) . '">
								<div class="mm-item-preview">
							    	<img src="' . self::$_args[ 'admin_path' ] . '/assets/images/metabox/audio.png" class="mm-audio-icon" />
							    	<div class="mm-filename"><div>' . $result['title'] . '</div></div>
								</div>
							</a>';
						}
					}
				} else {
					$output = 'end pages';
				}

			    $this->e_esc( $output );
			    exit;
			}


			/* --- Add Media --- */
			if ( $action == 'add_media' ) {

				/* Variables */
				$items = $_POST['items'];
				$type = $_POST['type'];

				if ( ! isset( $items ) || empty( $items ) ) 
					die();
				if ( isset( $type ) ) {
					if ( $type == 'images' || $type == 'slider' ) 
						$type = 'image';
					else 
						$type = 'audio';
				}

				$output = '';
				foreach( $items as $id ) {

					$item = get_post( $id );

					/* Image */
					if ( $type == 'image' ) {
						$image = wp_get_attachment_image_src( $id );
						$meta = wp_get_attachment_metadata( $id );
						if ( is_array( $meta ) ) {
							$meta_html = esc_html( basename( $item->guid ) ) . ' - ' . $meta['width'] . 'x' . $meta['height'];
						} else {
							$meta_html = '';
						}
						$output .= '
						<a class="mm-item" id="' . $id . '" title="' . $meta_html . '">
		                	<div class="mm-item-preview">
			                	<div class="mm-item-image">
			                		<div class="mm-centered">
			                			<img src="' . $image[0] . '" />
			                		</div>
			                	</div>
		                	</div>
		                	<span class="mm-edit-button"><i class="fa fa-gear"></i></span>
		                </a>';
					}

					/* Audio */
					if ( $type == 'audio' ) {
						$audio = get_post( $id );
						$output .= '
						<a class="mm-item mm-audio" id="' . $id . '" title="' . esc_html( basename( $item->guid ) ) . '">
							<div class="mm-item-preview">
						    	<img src="' . self::$_args[ 'admin_path' ]. '/assets/images/metabox/audio.png" class="mm-audio-icon" />
						    	<div class="mm-filename"><div>' . $audio->post_title . '</div></div>
							</div>
							<span class="mm-edit-button"><i class="fa fa-gear"></i></span>
						</a>';
					}
				}

				$this->e_esc( $output );
				exit;
			}


			/* --- Remove Media --- */
			if ( $action == 'remove_media' ) {

				/* Variables */
				$settings = $_POST['settings'];
				$selected_ids = $_POST['selected_ids'];
				$output = '';

				if ( ! isset( $selected_ids ) || empty( $selected_ids ) ) 
					die();
				if ( ! isset( $settings ) ) 
					die();

				foreach ( $selected_ids as $id ) {
					$option_name = $settings['mm_id'] . '_' . $id;
					
					if ( get_post_meta( $settings['post_id'], $option_name ) ) {
						delete_post_meta( $settings['post_id'], $option_name );
					}

				}
				echo 'success';
				exit;
			}


			/* --- Update Media --- */
			if ( $action == 'update_media' ) {

				/* Variables */
				$settings = $_POST['settings'];
				$ids = $_POST['ids'];
				$output = '';
				
				if ( ! isset( $settings ) ) 
					die();

				/* Update post string */
				if ( ! isset( $ids ) || $ids == '' )
					delete_post_meta( $settings['post_id'], $settings['mm_id'] );
				else
			    	update_post_meta( $settings['post_id'], $settings['mm_id'], $ids );
			  	
				echo 'success';
			   	exit;
			}

			echo 'Error: Bad action';
			exit;
		}


		/* Widgets
		---------------------------------------------- */

		/* mm Box */
		function mm_explorer_box() {
		  
			echo '<div id="mm-explorer-box" style="display:none">';
			echo '<input type="hidden" autofocus="autofocus" />';
			echo '<div id="explorer-top">';
			echo '<label for="mm-search">';
			//echo '<span>' . __( 'Search:', 'muttleybox' ) . '</span>';
			echo '<input type="text" id="mm-search" name="mm-search" tabindex="60" autocomplete="off" value="" placeholder="' . __( 'Search', 'muttleybox' ) . '" />';
			echo '</label>';
			echo '<label for="mm-select" class="mm-label-select">';
			echo '<span>' . __( 'Select All:', 'muttleybox' ) . '</span>';
			echo '<input type="checkbox" id="mm-select" name="mm-select"/>';
			echo '</label>';
			echo '<img id="mm-explorer-loader" class="mm-ajax" src="' . esc_url(admin_url('images/wpspin_light.gif')) . '" alt="" />';
			echo '</div>';
			
			/* Results */
			echo '<div class="mm-wrap">';
			echo '</div>';
			echo '<div class="clear"></div>';
			echo '<span class="mm-load-next">' . __( 'Load Next 30 Items', 'muttleybox' ) . '</span>';

			echo '</div>';

		}


		/* ----- Helper functions ----- */

		/* mm query */
		function mm_query( $args = array() ) {

			/* Media Manager type */
			if ( $args['type'] == 'images' || $args['type'] == 'slider'  ) 
				$args['type'] = 'image';
			else 
				$args['type'] = 'audio';

			$query = array(
				'post_type'      => 'attachment',
				'order'          => 'DESC',
				'orderby'        => 'post_date',
				'post_status'    => null,
				'post_parent'    => null, // any parent
				'post_mime_type' => $args['type'],
				'numberposts'    => $args['numberposts']
			);
		    
			if ( isset( $args['ids'] ) ) 
				$query['exclude'] = $args['ids'];
			
			$args['pagenum'] = isset( $args['pagenum']) ? absint( $args['pagenum'] ) : 1;

			if ( isset( $args['s'] ) ) $query['s'] = $args['s'];

			$query['offset'] = $args['pagenum'] > 1 ? $query['numberposts'] * ($args['pagenum'] - 1) : 0;

			// Do main query.
			$posts = get_posts( $query );

			// Check if any posts were found.
			if ( ! $posts )
				return false;

			// Build results.
			$results = array();
			foreach ( $posts as $post ) {
				setup_postdata( $post ); 
				$results[] = array(
					'ID' => $post->ID,
					'image' => wp_get_attachment_image_src( $post->ID ),
					'title' => trim( esc_html( strip_tags( get_the_title( $post) ) ) ),
					'permalink' => get_permalink( $post->ID )
				);
			}
			return $results;
		}


		/* ------------------------------------------------------------------------------------------- */

		/*											EDITOR 											   */
		
		/* ------------------------------------------------------------------------------------------- */


		/* Box */
		private function mm_editor_box() {
		  
		    echo '<div id="mm-editor-box" style="display:none">';
		    echo '<input type="hidden" autofocus="autofocus" />';
			echo '<img id="mm-editor-loader" src="' . esc_url(admin_url('images/wpspin_light.gif')) . '" alt="" />';
			echo '<div id="mm-editor-content">';

			echo '</div>';
		    echo '</div>';
		}

		/* Editable content */
		public function mm_editor() {
		
			/* Variables */
			$id = $_POST['item_id'];
			$settings = $_POST['settings'];
			$custom = ($_POST['custom'] === 'true');
			if ( ! isset( $id ) || ! isset( $settings ) ) 
				die();
			$type = $settings['mm_type'];
			$item = get_post( $id );
			$output = '';
			$option_name = $settings[ 'mm_id' ] . '_' . $id;
			$options = get_post_meta( $settings[ 'post_id' ], $option_name, true );

			/* Audio defaults */
			if ( $type == 'audio' ) {
				$defaults = array(
					'custom' => $custom,
					'custom_url' => '',
					'title' => '',
					'artists' => '',
					'artists_url' => '',
					'artists_target' => '',
					'links' => '',
					'cover' => '',
					'release_url' => '',
					'release_target' => '',
					'cart_url' => '',
					'cart_target' => '',
					'free_download' => 'no'
				);
			}

			/* Image defaults */
		  	if ( $type == 'images' ) {
			   	$defaults = array(
					'custom' => $custom,
					'title' => '',
					'custom_link' => '',
					'thumb_icon' => 'view'
				);
		   	}

		   	/* Slider defaults */
		  	if ( $type == 'slider' ) {
			   	$defaults = array(
					'custom' => $custom,
					'title' => '',
					'youtube_id' => '',
					'subtitle' => '',
					'slider_button_url' => '',
					'slider_button_target' => '_self',
					'slider_button_title'  => __( 'View More', 'muttleybox' )
				);
		   	}

		   	/* Set default options */
			if ( isset( $options ) && is_array( $options ) ) 
				$options = array_merge( $defaults, $options );
			else 
				$options = $defaults;

			if ( ! $item && ! $options['custom'] ) {
					echo '<p class="msg msg-error">' . __( 'Error: File does not exist!', 'muttleybox' ) . '</p>';
				exit;
				return die();
			}

			/* Target options */
			$target_options = array(
				array('name' => 'Self', 'value' => '_self'),
				array('name' => 'Blank', 'value' => '_blank')
			);

			/* Yes/No */
			$yes_no_options = array(
				array('name' => _x( 'No', 'Metabox Class', $this->textdomain ), 'value' => 'no'),
				array('name' => _x( 'Yes', 'Metabox Class', $this->textdomain ), 'value' => 'yes')
			);
		

			/* Meta */

			/* --- IMAGES OR SLIDER --- */
			if ( $type == 'images' || $type == 'slider' ) {

				/* Get Image Data */
				$meta = wp_get_attachment_metadata( $id );
				$image_data = wp_get_attachment_image_src( $id );

				$output .= '
					<div class="mm-item mm-item-editor" id="' . $id . '">
						<div class="mm-item-preview">
					    	<div class="mm-item-image">
					    		<div class="mm-centered">
					    			<a href="' . $item->guid . '" target="_blank"><img src="' . $image_data[0] . '" /></a>
					    		</div>
					    	</div>
						</div>
					</div>';
				
				/* Meta */
				$output .= '<div id="mm-editor-meta">';
				$output .= '<span><strong>' . __( 'File name:', 'muttleybox' ) . '</strong> ' . esc_html( basename( $item->guid ) ) . '</span>';
				$output .= '<span><strong>' . __( 'File type:', 'muttleybox' ) . '</strong> ' . $item->post_mime_type . '</span>';
				$output .= '<span><strong>' . __( 'Upload date:', 'muttleybox' ) . '</strong> ' . mysql2date( get_option( 'date_format' ), $item->post_date ) . '</span>';

				if ( is_array( $meta ) && array_key_exists( 'width', $meta ) && array_key_exists('height', $meta ) )
					$output .= '<span><strong>' . __( 'Dimensions:', 'muttleybox' ) . '</strong> ' . $meta['width'] . ' x ' . $meta['height'] . '</span>';

				$output .= '<span><strong>' . __( 'Image URL:', 'muttleybox' ) . '</strong> <br>
				<a href="' . $item->guid . '" target="_blank">' . __( '[IMAGE LINK]', 'muttleybox' ) . '</a>
				</span>';

				$output .= '</div>';

			}

			/* --- Make Form --- */

			/* --- SLIDER --- */
			if ( $type == 'slider' ) {
				$output .= '<fieldset>';

				/* VideoBG */
			   	$output .= '<div class="dialog-row"><label for="mm-video-bg">' . __( 'YouTube Video Background', 'muttleybox' ) . '</label>';
				$output .= '<input type="text" id="mm-video-bg" name="youtube_id" value="' . $options['youtube_id'] . '" />';
				$output .= '<p class="help-box">' . __( 'Type Youtube video ID e.g: 1XZGulDxz9o. Replace image on video background.', 'muttleybox' ) . '<br>' . __( 'NOTE: Displayed only on desktop devices.', 'muttleybox' ) . '<br>' . __( 'NOTE: Displayed only on Intro slider section.', 'muttleybox' ) . '</p></div>';
				
				/* Title */
			   	$output .= '<div class="dialog-row"><label for="mm-image-title">' . __( 'Title', 'muttleybox' ) . '</label>';
				$output .= '<textarea id="mm-image-title" name="title" style="min-height:40px">'. $options['title'] .'</textarea>';
				$output .= '<p class="help-box">' . __( 'Title for the image.', 'muttleybox' ) . '</p></div>';

				/* SubTitle */
			   	$output .= '<div class="dialog-row"><label for="mm-image-subtitle">' . __( 'Subtitle', 'muttleybox' ) . '</label>';
				$output .= '<textarea id="mm-image-subtitle" name="subtitle" style="min-height:40px">'. $options['subtitle'] .'</textarea>';
				$output .= '<p class="help-box">' . __( 'Subtitle for the image.', 'muttleybox' ) . '</p></div>';


				/* Slider Button Title */
				$output .= '
				<div class="dialog-row">
					<label for="r-slider_button_title">' . __( 'Slider Button Title', 'muttleybox' ) . '</label>
					<input type="text" id="r-slider_button_title" name="slider_button_title" value="' . $options['slider_button_title'] . '" />
					<p class="help-box">' . __( 'Paste slider button URL.', 'muttleybox' ) . '<br>' . __( 'NOTE: Displayed only on Intro slider section.', 'muttleybox' ) . '
				</div>';

				/* Slider Button Link */
				$output .= '
				<div class="dialog-row">
					<label for="r-slider_button_url">' . __( 'Slider Button URL', 'muttleybox' ) . '</label>
					<input type="text" id="r-slider_button_url" name="slider_button_url" value="' . $options['slider_button_url'] . '" />
					<p class="help-box">' . __( 'Paste slider button URL.', 'muttleybox' ) . '<br>' . __( 'NOTE: Displayed only on Intro slider section.', 'muttleybox' ) . '
				</div>';

				/* Slider Button target */
				$output .= '<div class="dialog-row"><label for="mm-slider-button-target">' . __( 'Slider Button Target', 'muttleybox' ) . '</label>';
				$output .= '<select id="mm-slider-button-target" name="slider_button_target" size="1" class="mm-select">';
				foreach ( $target_options as $option ) {
					
					if ( $options['slider_button_target'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . __( 'Select buton target.', 'muttleybox' ) . '<br>' . __( 'NOTE: Displayed only on Intro slider section.', 'muttleybox' ) . '</p></div>';


				$output .= '</fieldset>';
			}

			/* --- IMAGES --- */
			if ( $type == 'images' ) {
				
				$output .= '<fieldset>';
				
				/* Title */
			   	$output .= '<div class="dialog-row"><label for="mm-image-title">' . __( 'Title', 'muttleybox' ) . '</label>';
				$output .= '<input type="text" id="mm-image-title" name="title" value="' . $options['title'] . '" />';
				$output .= '<p class="help-box">' . __( 'Title for the image.', 'muttleybox' ) . '</p></div>';
				

				/* Custom Link */
			   	$output .= '<div class="dialog-row"><label for="mm-image-custom-link">' . __( 'Custom Link', 'muttleybox' ) . '</label>';
				$output .= '<textarea id="mm-custom-link" name="custom_link" style="min-height:40px">'. $options['custom_link'] .'</textarea>';
				$output .= '<p class="help-box">' . __( 'Add custom link to popup window.', 'muttleybox' ) . '</p></div>';


				/* Icons options */
				$icon_options = array(
					array('name' => 'Preview', 'value' => 'view'),
					array('name' => 'Plus', 'value' => 'plus'),
					array('name' => 'Video', 'value' => 'video'),
					array('name' => 'Soundcloud', 'value' => 'soundcloud'),
					array('name' => 'Headphones', 'value' => 'headphones')
				);

				/* Thumbnail Icon */
				$output .= '<div class="dialog-row"><label for="mm-thumb-icon">' . __( 'Thumbnail Icon', 'muttleybox' ) . '</label>';
				$output .= '<select id="mm-thumb-icon" name="thumb_icon" size="1" class="mm-select">';
				foreach ( $icon_options as $option ) {
					
					if ( $options['thumb_icon'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . __( 'Select thumb icon.', 'muttleybox' ) . '</p></div>';


				$output .= '</fieldset>';

			}

			
			/* --- Audio --- */
			if ( $type == 'audio' ) {
				
				$output .= '<fieldset>';

				/* Title */
				if ( $options['title'] == '' && ! $options['custom'] ) 
					$options['title'] = $item->post_title;
				if ( $options['title'] == '' ) 
					$options['title'] = __( 'Custom title', 'muttleybox' );

			   	$output .= '<div class="dialog-row"><label for="mm-audio-title">' . __( 'Release/Track Title', 'muttleybox' ) . '</label>';
				$output .= '<input type="text" id="mm-audio-title" name="title" value="' . $options['title'] . '" />';
				$output .= '<p class="help-box">' . __( 'Title for the audio.', 'muttleybox' ) . '</p></div>';

				/* Custom url */
				if ( $options['custom'] ) {
				   $output .= '<div class="dialog-row"><label for="mm-audio-custom-url">' . __( 'Release/Track URL', 'muttleybox' ) . '</label>';
					$output .= '<input type="text" id="mm-audio-custom-url" name="custom_url" value="'.$options['custom_url'].'" />';
					$output .= '<p class="help-box">' . __( 'Paste here link to the MP3 file or link to Soundcloud track, list, favorite tracks.', 'muttleybox' ) . '</p></div>';
				}

				/* Artists */
			   	$output .= '<div class="dialog-row"><label for="mm-image-artists">' . __( 'Artists', 'muttleybox' ) . '</label>';
				$output .= '<input type="text" id="mm-image-artists" name="artists" value="' . $options['artists'] . '" />';
				$output .= '<p class="help-box">' . __( 'Track artists.', 'muttleybox' ) . '</p></div>';

				/* Artists Link */
				$output .= '
				<div class="dialog-row">
					<label for="r-artists_url">' . __( 'Artists URL', 'muttleybox' ) . '</label>
					<input type="text" id="r-artists_url" name="artists_url" value="' . $options['artists_url'] . '" />
					<p class="help-box">' . __( 'Paste artist URL.', 'muttleybox' ) . '
				</div>';

				/* Artists target */
				$output .= '<div class="dialog-row"><label for="mm-artists-target">' . __( 'Artists Link Target', 'muttleybox' ) . '</label>';
				$output .= '<select id="mm-artists-target" name="artists_target" size="1" class="mm-select">';
				foreach ( $target_options as $option ) {
					
					if ( $options['artists_target'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . __( 'Select target link.', 'muttleybox' ) . '</p></div>';

				/* Links */
				$output .= '<div class="dialog-row"><label for="mm-audio-links">' . __( 'Track Links', 'muttleybox' ) . '</label>';
				$output .= '<textarea id="mm-audio-links" name="links">'. $options['links'] .'</textarea>';
				$output .= '<p class="help-box">' . __('Add player buttons. Add player links. Button example:
	[track_button link="#" icon="soundcloud" target="_self"].', 'muttleybox' ) . '</p></div>';

				/* Cover */
				$output .= '
				<div class="dialog-row">

					<label for="r-cover">' . __( 'Cover Image', 'muttleybox' ) . '</label>';

				/* Source */

				if ( is_numeric( $options['cover'] ) || $options['cover'] == '' ) {
					$media_libary = 'selected="selected"';
					$input_type = 'hidden';
				} else {
					$external_link = 'selected="selected"';
					$input_type = 'text';
					$holder_classes .= ' hidden';
				}

				$output .= '<select size="1" class="image-source-select" >';

					$output .= "<option $media_libary value='media_libary'>" . _x( 'Media libary', 'MuttleyBox Class', $this->textdomain ) . "</option>";
					$output .= "<option $external_link value='external_link'>" . _x( 'External link', 'MuttleyBox Class', $this->textdomain ) . "</option>";
				
				$output .= '</select>';

				$output .= '<input type="' . $input_type . '" id="r-cover" name="cover" value="' . $options['cover'] . '" class="track-cover" />';

				$image = wp_get_attachment_image_src( $options['cover'], 'thumbnail' );
				$image = $image[0];
				// If image exists
				if ( $image ) {
					$image_html = '<img src="' . $image . '" alt="' . _x( 'Preview Image', 'MuttleyBox Class', $this->textdomain ) . '">';
					$is_image = 'is_image'; 
				} else {
					$image_html = '';
					$is_image = ''; 
				}

				$output .= '<div class="image-holder image-holder-cover ' . $is_image . ' ' . $holder_classes . '" data-placeholder="' . self::$_args[ 'admin_path' ] . '/assets/images/metabox/audio.png">';

				// Image
				$output .=  $image_html;

				// Button
				$output .= '<button class="upload-image"><i class="fa icon fa-plus"></i></button>';

				/* Remove image */
				$output .= '<a class="remove-image"><i class="fa icon fa-remove"></i></a>';
				$output .= '</div>';

				$output .= '<p class="help-box">' . __( 'Add image cover.', 'muttleybox' ) . '</p></div>';
		

				/* Release Link */
				$output .= '
				<div class="dialog-row">
					<label for="r-release_url">' . __( 'Release URL', 'muttleybox' ) . '</label>
					<input type="text" id="r-release_url" name="release_url" value="' . $options['release_url'] . '" />
					<p class="help-box">' . __( 'Paste release URL.', 'muttleybox' ) . '
				</div>';

				/* Release target */
				$output .= '<div class="dialog-row"><label for="mm-release-target">' . __( 'Release Link Target', 'muttleybox' ) . '</label>';
				$output .= '<select id="mm-release-target" name="release_target" size="1" class="mm-select">';
				foreach ( $target_options as $option ) {
					
					if ( $options['release_target'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . __( 'Select target link.', 'muttleybox' ) . '</p></div>';

				/* Free download */
				$output .= '<div class="dialog-row"><label for="mm-free-download">' . _x( 'Free Download?', 'Metabox Class', $this->textdomain ) . '</label>';
				$output .= '<select id="mm-free-download" name="free_download" size="1" class="mm-select">';
				foreach ( $yes_no_options as $option ) {
					
					if ( $options['free_download'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . _x( 'If you choose this option, "Buy" icon will be replaced on "Download". ', 'Metabox Class', $this->textdomain ) . '</p></div>';

				/* Cart Link */
				$output .= '
				<div class="dialog-row">
					<label for="r-cart_url">' . __( 'Cart URL / Download URL', 'muttleybox' ) . '</label>
					<input type="text" id="r-cart_url" name="cart_url" value="' . $options['cart_url'] . '" />
					<p class="help-box">' . __( 'Paste cart URL or download link.', 'muttleybox' ) . '
				</div>';

				/* Cart target */
				$output .= '<div class="dialog-row"><label for="mm-cart-target">' . __( 'Cart Link Target', 'muttleybox' ) . '</label>';
				$output .= '<select id="mm-cart-target" name="cart_target" size="1" class="mm-select">';
				foreach ( $target_options as $option ) {
					
					if ( $options['cart_target'] == $option['value'] ) 
						$selected = 'selected="selected"';
					else 
						$selected = '';
					$output .= "<option $selected value='" . $option['value'] . "'>" . $option['name'] . "</option>";
				}
				$output .= '</select>';
				$output .= '<p class="help-box">' . __( 'Select target link.', 'muttleybox' ) . '</p></div>';


				$output .= '</fieldset>';
			}

		    $this->e_esc( $output );
		    exit;
		}

	}
}
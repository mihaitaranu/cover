<?php

/**
 * Plugin Name: Gallery Widget
 * Plugin URI: http://rascals.eu
 * Description: Display latest tweets from twitter.
 * Version: 1.0.0
 * Author: Rascals Themes
 * Author URI: http://rascals.eu
 */
 
class r_gallery_widget extends WP_Widget {

	/* Widget setup */ 
	function __construct() {

		/* Widget settings */
		$widget_ops = array(
			'classname' => 'widget_r_gallery',
			'description' => __( 'Display gallery', 'Gallery Widget' )
		);

		/* Widget control settings */
		$control_ops = array(
			'width' => 200,
			'height' => 200,
			'id_base' => 'r-gallery-widget'
		);
		
		/* Create the widget */
		if ( function_exists( 'noisa_tracklist' ) && function_exists( 'noisa_track' ) && function_exists( 'noisa_tracklist_grid' ) ) {
			parent::__construct( 'r-gallery-widget', __( 'Gallery (RT)', 'Gallery Widget' ), $widget_ops, $control_ops );
		}
		
	}

	/* Display the widget on the screen */ 
	function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$gallery_id = $instance['gallery_id'];
		$type = ( $instance['type'] != '' ) ? $type = $instance['type'] : $type = 'single_track';
		$button = ( $instance['button'] != '' ) ? $button = '1' : $button = '0';
		$in_row = $instance['in_row'];
		$url = $instance['url'];
		$limit = $instance['limit'];

		echo $args['before_widget'];
		
		// Title
		if ( isset( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		
		// Display gallery
	 	if ( $type == 'latest_images' ) {
			echo noisa_gallery_images( $atts = array( 'album_id' => $gallery_id, 'url' => $button, 'limit' => $limit, 'in_row' => $in_row, 'thumb_style' => 'simple' ) );
		} else if ( $type == 'latest_albums' ) {
			echo noisa_gallery_albums( $atts = array( 'url' => $url, 'limit' => $limit, 'in_row' => $in_row, 'thumb_style' => 'simple') );
		}
		echo $args['after_widget'];
		
	}

	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'gallery_id' ] = strip_tags( $new_instance[ 'gallery_id' ] );
		$instance[ 'type' ] = strip_tags( $new_instance[ 'type' ] );
		$instance[ 'button' ] = strip_tags( $new_instance[ 'button' ] );
		$instance[ 'in_row' ] = strip_tags( $new_instance[ 'in_row' ] );
		$instance[ 'link' ] = strip_tags( $new_instance[ 'link' ] );
		$instance[ 'limit' ] = strip_tags( $new_instance[ 'limit' ] );
		$instance[ 'url' ] = strip_tags( $new_instance[ 'url' ] );
		
		return $instance;
	}
	function form( $instance ) {
		global $wpdb;

		$defaults = array('title' => __( 'Gallery', 'Gallery Widget' ), 'gallery_id' => '', 'type' => 'single_track', 'button' => '', 'in_row' => '2', 'link' => '', 'url' => '', 'limit' => '4' );
		$instance = wp_parse_args( (array ) $instance, $defaults );
	    
		// Title
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">' . __( 'Title:', 'Gallery Widget' ) . '</label>';
		echo '<input id="' . $this->get_field_id('title') . '" type="text" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />';
		echo '</p>';

	    // Type
		$options_type = array(
			array(
				'value' => 'latest_albums', 
				'label' => 'Latest Albums'
			),
			array(
				'value' => 'latest_images', 
				'label' => 'Latest Images'
			)
		);
		echo '<p>';
		echo '<label for="' . $this->get_field_id('type') . '">' . __( 'Display:', 'Gallery Widget' ) . '</label>';
		echo '<select id="' . $this->get_field_id('type') . '" name="' . $this->get_field_name('type') . '" class="widefat">';

		foreach( $options_type as $option ) {
				
			if ( $instance['type'] == $option['value'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
				
     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
		}
		echo '</select>';
		echo '</p>';


		/* Get Audio Gallery  */
		$gallery = '';
		$gallery_post_type = 'noisa_gallery';
		$gallery_query = $wpdb->prepare(
			"
		    SELECT
				{$wpdb->posts}.id,
				{$wpdb->posts}.post_title
		  	FROM 
				{$wpdb->posts}
		  	WHERE
				{$wpdb->posts}.post_type = %s
			AND 
				{$wpdb->posts}.post_status = 'publish'
			",
			$gallery_post_type
		);

		$sql_gallery = $wpdb->get_results( $gallery_query );
		if ( $sql_gallery ) {
	        echo '<p>';
			echo '<label for="' . $this->get_field_id('gallery_id') . '">' . __( 'Select Album:', 'Gallery Widget' ) . '</label>';
			echo '<select id="' . $this->get_field_id('gallery_id') . '" name="' . $this->get_field_name('gallery_id') . '" class="widefat">';
			foreach( $sql_gallery as $track_post ) {
	        	if ( $instance['gallery_id'] == $track_post->id ) {
	        		$selected = 'selected="selected"';
	        	} else {
	        		$selected = '';
	        	}
	            echo '<option ' . $selected . ' value="' . $track_post->id . '">' . $track_post->post_title . '</option>';
	        }
			echo '</select>';
			echo '</p>';
	    } else {
	    	echo __( 'There are no albums available.', 'Gallery Widget' );
	    }

	    // Button
		echo '<p>';
		if ( $instance[ 'button' ] ) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		echo '<input class="checkbox" type="checkbox" value="true" id="' . $this->get_field_id('button') . '" ' . $checked . ' name="' . $this->get_field_name('button') . '" />';
		echo '<label for="' . $this->get_field_id('button') . '"> ' . __( 'Last item as a button?', 'Gallery Widget' ) . '</label>';
		echo '</p>';

		// URL
		echo '<p>';
		echo '<label for="' . $this->get_field_id('url') . '">' . __( 'Gallery link:', 'Gallery Widget' ) . '</label>';
		echo '<input id="' . $this->get_field_id('url') . '" type="text" name="' . $this->get_field_name('url') . '" value="' . $instance['url'] . '" class="widefat" />';
		echo '</p>';

		// Limit
		echo '<p>';
		echo '<label for="' . $this->get_field_id('limit') . '">' . __( 'Display limit:', 'Gallery Widget' ) . '</label>';
		echo '<input id="' . $this->get_field_id('limit') . '" type="text" name="' . $this->get_field_name('limit') . '" value="' . $instance['limit'] . '" class="widefat" />';
		echo '</p>';

		// Gallery per row
		$options_in_row = array(
			array( 
				'value' => '2', 
				'label' => '2'
			), 
			array(
				'value' => '3', 
				'label' => '3'
			),
			array(
				'value' => '4', 
				'label' => '4'
			),
			array(
				'value' => '5', 
				'label' => '5'
			)
		);
		echo '<h4>' . __( 'Only for Tracklist Grid:', 'Gallery Widget' ) . '</h4>';
		echo '<p>';
		echo '<label for="' . $this->get_field_id('in_row') . '">' . __( 'Items Per Row:', 'Gallery Widget' ) . '</label>';
		echo '<select id="' . $this->get_field_id('in_row') . '" name="' . $this->get_field_name('in_row') . '" class="widefat">';

		foreach( $options_in_row as $option ) {
				
			if ( $instance['in_row'] == $option['value'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
				
     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
		}
		echo '</select>';
		echo '</p>';

	}
	
}

add_action( 'widgets_init', 'register_r_gallery_widget' );
function register_r_gallery_widget() {
    register_widget('r_gallery_widget');
}

?>
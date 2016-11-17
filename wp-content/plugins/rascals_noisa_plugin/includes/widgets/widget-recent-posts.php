<?php

/**
 * Plugin Name: Recent Posts Widget
 * Plugin URI: http://rascals.eu
 * Description: Display recent posts.
 * Version: 1.0.0
 * Author: Rascals Themes
 * Author URI: http://rascals.eu
 */
 
class noisa_recent_posts extends WP_Widget {

	/* Widget setup */ 
	function __construct() {

		/* Widget settings */
		$widget_ops = array(
			'classname' => 'widget_noisa_recent_posts',
			'description' => __( 'Display recent posts containing featured image.', 'recent_posts_widget' )
		);

		/* Widget control settings */
		$control_ops = array(
			'width' => 200,
			'height' => 200,
			'id_base' => 'r-recent-posts-widget'
		);
		
		/* Create the widget */

		parent::__construct( 'r-recent-posts-widget', __( 'Recent Posts (RT)', 'recent_posts_widget' ), $widget_ops, $control_ops );
		
		
	}

	/* Display the widget on the screen */ 
	function widget( $args, $instance ) {
		
		extract( $args );

		global $wp_query, $post;

		$title = apply_filters('widget_title', $instance['title']);
		$limit = ( $instance['limit'] != '' ) ? $limit = $instance['limit'] : $limit = '5';

		// Get panel options
    	$panel_options = get_option( 'noisa_panel_opts' );

		// Date format
	    $date_format = 'd/m/Y';
	    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
       		$date_format = $panel_options[ 'custom_date' ];
    	}
			
		echo $args['before_widget'];

		// Title
		if ( isset( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		
		// Display posts

		// Post backup
		if ( isset( $post ) ) { 
		    $backup = $post;
		}

		// Loop Args.
	    $loop_args = array(
	        'showposts' => (int)$limit
	    );

	    $recent_posts_widget = new WP_Query();
    	$recent_posts_widget->query( $loop_args );

   		// Begin Loop
    	if ( $recent_posts_widget->have_posts() ) {
    		echo '<ul class="rp-list">';
    		while ( $recent_posts_widget->have_posts() ) {
	            $recent_posts_widget->the_post();
	            if ( has_post_thumbnail() ) {
		            echo '<li>';
		    		echo '<div class="rp-post-thumb">';
			        echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
		    		echo '</div>';
		    		echo '<div class="rp-caption">';
		    		echo '<h4><a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '">' . get_the_title() . '</a></h4>';
		    		echo '<span class="rp-date">' . get_the_time( $date_format ) . '</span>';
		    		echo '</div>';
		    		echo '</li>';
		    	}
	    	}
	    	echo '</ul>';
    	}


		if ( isset( $post ) ) {
        	$post = $backup;
    	}

		echo $args['after_widget'];

	}

	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'limit' ] = strip_tags( $new_instance[ 'limit' ] );		
		return $instance;
	}
	function form( $instance ) {
		global $wpdb;

		$defaults = array(
			'title' => __( 'Recent Posts', 'recent_posts_widget' ),  
			'limit' => '6',
		);
		$instance = wp_parse_args( (array ) $instance, $defaults );
	     
	    // Title
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">' . __( 'Title:', 'recent_posts_widget' ) . '</label>';
		echo '<input id="' . $this->get_field_id('title') . '" type="text" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />';
		echo '</p>';


		// Limit
		echo '<p>';
		echo '<label for="' . $this->get_field_id('limit') . '">' . __( 'Limit:', 'recent_posts_widget' ) . '</label>';
		echo '<input id="' . $this->get_field_id('limit') . '" type="text" name="' . $this->get_field_name('limit') . '" value="' . $instance['limit'] . '" class="widefat" />';
		echo '</p>';
	
	}
	
}

add_action( 'widgets_init', 'register_noisa_recent_posts' );
function register_noisa_recent_posts() {
    register_widget('noisa_recent_posts');
}

?>
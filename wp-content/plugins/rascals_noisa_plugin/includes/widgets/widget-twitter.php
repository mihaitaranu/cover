<?php

/**
 * Plugin Name: twitter_widget
 * Plugin URI: http://rascals.eu
 * Description: Display latest tweets from twitter.
 * Version: 1.0.0
 * Author: Rascals Themes
 * Author URI: http://rascals.eu
 */
 
class r_twitter_widget extends WP_Widget {

	/* Widget setup */ 
	function __construct() {

		/* Widget settings */
		$widget_ops = array(
			'classname' => 'widget_r_twitter',
			'description' => __( 'Display latest tweets from twitter', 'twitter_widget' )
		);

		/* Widget control settings */
		$control_ops = array(
			'width' => 200,
			'height' => 200,
			'id_base' => 'r-twitter-widget'
		);
		
		/* Create the widget */ 
		parent::__construct( 'r-twitter-widget', __( 'Twitter (RT)', 'twitter_widget' ), $widget_ops, $control_ops );
		
	}

	/* Display the widget on the screen */ 
	function widget( $args, $instance ) {

		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$username = $instance['username'];
		$limit = ( $instance['limit'] != '' ) ? $limit = $instance['limit'] : $limit = 3;
		$replies = ( $instance['replies'] != '' ) ? $replies = $instance['replies'] : $replies = 'false';
		$api_key = ( isset( $instance[ 'api_key' ] ) && $instance[ 'api_key' ] != '' ) ? $api_key = $instance[ 'api_key' ] : $api_key = '';
		$api_secret = ( isset( $instance[ 'api_secret'] ) && $instance[ 'api_secret' ] != '' ) ? $api_secret = $instance[ 'api_secret' ] : $api_secret = '';
		
		echo $args['before_widget'];
		
		// Title
		if ( isset( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		
		// Defaults options
	    $defaults = array(
			'time'       => 3,
			'limit'      => '1',
			'username'   => '',
			'replies'    => 'no',
			'api_key'    => '',
			'api_secret' => ''
	    );

		$options = array(
			'limit'      => $limit,
			'username'   => $username,
			'replies'    => $replies,
			'api_key'    => $api_key,
			'api_secret' => $api_secret
		);
		
		if ( isset( $options ) && is_array( $options ) ) {
	        $options = array_merge( $defaults, $options );
	    } else { 
	        $options = $defaults;
	    }

	    // Extract $options
	    extract( $options, EXTR_PREFIX_SAME, "twitter" );

	    // Errors
	    $errors = '';

	    if ( empty( $api_key ) ) $errors = __( 'ERROR: Missing API Key.', 'twitter_widget' );
	    if ( empty( $api_secret ) ) $errors = __( 'ERROR: Missing API Secret.', 'twitter_widget' );
	    if ( empty( $username ) ) $errors = __( 'ERROR: Missing Twitter Feed User Name.', 'twitter_widget' );
	    if ( $errors ) {
	        echo'<p class="error">' . $errors . '</p>';
	        echo $args['after_widget'];
	        return;
	    }

	    // Replies
	    if ( $replies == 'yes' ) {
	        $replies = '0';
	    } else {
	        $replies = '1';
	    }

	    // Vars
	    $trans_name = 'r_twitter_widget_' . $username;
	    $token = '';
	    $count = 1;
	    $output = '';


	    // Delete saved data
	    //delete_transient( $trans_name );

	    /* Shelude feed */
	    if ( false === ( $tweet_task = get_transient( $trans_name ) ) ) {

	        $bearer_token_credential = $api_key . ':' . $api_secret;
	        $credentials = base64_encode( $bearer_token_credential );
	        
	        $args_feed = array(
	            'method' => 'POST',
	            'httpversion' => '1.1',
	            'blocking' => true,
	            'headers' => array( 
	                'Authorization' => 'Basic ' . $credentials,
	                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
	            ),
	            'body' => array( 'grant_type' => 'client_credentials' )
	        );

	        add_filter( 'https_ssl_verify', '__return_false' );
	        $response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args_feed );

	        $keys = json_decode( $response['body'] );
	        
	        if ( $keys ) {
	            $token = $keys->{'access_token'};

	            $args_feed = array(
	                'httpversion' => '1.1',
	                'blocking' => true,
	                'headers' => array( 
	                    'Authorization' => "Bearer $token"
	                )
	            );
	            add_filter('https_ssl_verify', '__return_false');
	            $api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$username&count=20&exclude_replies=$replies&include_rts=0";

	            $response = wp_remote_get( $api_url, $args_feed );

	            if ( ! is_wp_error( $response ) ) {
	            	set_transient( $trans_name, $response['body'], (1*60) * $time );
	        	}

	        } else {
	        	echo '<p class="error">' . __( 'ERROR: User access verification.', 'twitter_widget' ) . '</p>';
	            delete_transient( $trans_name );
	            echo $args['after_widget'];
	            return;
	        }
	        
	    }

	    // Get transient
	    @$json = json_decode( get_transient( $trans_name ) );

	    if ( ! empty( $json ) ){

	        /* If feed has error */
	        if ( isset( $json->errors ) ) {
	            $errors = '';

	            foreach ( $json->errors as $error ) {
	                $errors .= '<p class="error">ERROR: ' . $error->code . ': ' . $error->message . '</p>';
	            }

	            // Delete transient
	            delete_transient( $trans_name );
	            echo $errors;
	        } else {

		        $tweets_a = array();
		        foreach ( $json as $tweet ) {
		            $datetime = $tweet->created_at;
		            $date = date( 'F j, Y, g:i a', strtotime( $datetime ) );
		            $time = date( 'g:ia', strtotime( $datetime ) );
		            $date = human_time_diff( strtotime( $date ), current_time( 'timestamp', 1 ) );
		            $tweet_text = $tweet->text;
		            
		            // check if any entites exist and if so, replace then with hyperlinked versions
		            $tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $tweet_text);
		            $tweet_text = preg_replace('/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="https://$1" target="_blank">https://$1</a>&nbsp;', $tweet_text);

		            // convert @ to follow
		            $tweet_text = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" >$1</a>",$tweet_text);

		            // convert # to search
		            $tweet_text = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=%23$2&amp;src=hash\" title=\"Search $1\" >$1</a>",$tweet_text);

		            $tweets_a[$count]['text'] = $tweet_text;
		            $tweets_a[$count]['date'] = '<a href="https://twitter.com/' . $username . '/statuses/' . $tweet->id_str . '">' . $date . ' ' . __('ago', 'twitter_widget') . '</a>';
		            
		            // if ( $count == $limit ) {
		            //     break;
		            // }
		            $count++;
		        }

	            echo '<ul class="tweets-widget">';
	            foreach ( $tweets_a as $key => $tweet ) {
	                echo '<li>' . $tweet[ 'text' ] . '<span class="date">' . $tweet[ 'date' ] . '</span></li>';  
	                if ( $key == $limit ) {
	                    break;
	                }
	            }

	            echo '</ul>';

	        }
	          
	    } else {
	        echo '<p class="error">' . __( 'ERROR: Username not exists or Twitter API error.', 'twitter_widget' ) . '</p>';
	        delete_transient( $trans_name );
	    }
	    // delete_transient( $trans_name );

	    
	    echo $args['after_widget'];
		
		
	}

	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'username' ] = strip_tags( $new_instance[ 'username' ] );
		$instance[ 'api_key' ] = strip_tags( $new_instance[ 'api_key' ] );
		$instance[ 'api_secret' ] = strip_tags( $new_instance[ 'api_secret' ] );
		$instance[ 'limit' ] = strip_tags( $new_instance[ 'limit' ] );
		$instance[ 'replies' ] = strip_tags( $new_instance[ 'replies' ] );
		
		return $instance;
	}
	function form( $instance ) {
		
		$defaults = array('title' => __( 'Tweets', 'twitter_widget' ), 'username' => '', 'api_key' => '', 'api_secret' => '', 'limit' => '3', 'replies' => 'true');
		$instance = wp_parse_args( (array ) $instance, $defaults );
		echo '<p>';
			echo '<label for="' . $this->get_field_id('title') . '">' . __( 'Title:', 'twitter_widget' ) . '</label>';
			echo '<input id="' . $this->get_field_id('title') . '" type="text" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id('username') . '">' . __( 'Username:', 'twitter_widget' ) . '</label>';
			echo '<input id="' . $this->get_field_id('username') . '" type="text" name="' . $this->get_field_name('username') . '" value="' . $instance['username'] . '" class="widefat" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id('api_key') . '">' . __( 'API key:', 'twitter_widget' ) . '</label>';
			echo '<input id="' . $this->get_field_id('api_key') . '" type="text" name="' . $this->get_field_name('api_key') . '" value="' . $instance['api_key'] . '" class="widefat" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id('api_secret') . '">' . __( 'API secret:', 'twitter_widget' ) . '</label>';
			echo '<input id="' . $this->get_field_id('api_secret') . '" type="text" name="' . $this->get_field_name('api_secret') . '" value="' . $instance['api_secret'] . '" class="widefat" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id('limit') . '">' . __( 'Number of tweets to show:', 'twitter_widget' ) . '</label>';
			echo '<input id="' . $this->get_field_id('limit') . '" type="text" name="' . $this->get_field_name('limit') . '" value="' . $instance['limit'] . '" class="widefat" />';
			echo '<small style="line-height:12px;">' . __( '20 is the maximum', 'twitter_widget' ) . '</small>';
		echo '</p>';
		echo '<p>';
			if ($instance['replies']) $checked = 'checked="checked"';
			else $checked = '';
			echo '<input class="checkbox" type="checkbox" value="true" id="' . $this->get_field_id('replies') . '" ' . $checked . ' name="' . $this->get_field_name('replies') . '" />';
			echo '<label for="' . $this->get_field_id('replies') . '"> ' . __( 'Display replies', 'twitter_widget' ) . '</label>';
		echo '</p>';

	}
	
}

add_action( 'widgets_init', 'register_r_twitter_widget' );
function register_r_twitter_widget() {
    register_widget('r_twitter_widget');
}

?>
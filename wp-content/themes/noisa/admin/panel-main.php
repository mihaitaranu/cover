<?php

/* Panel Options
------------------------------------------------------------------------*/

/* Options array */
$noisa_main_options = array( 


	/* General Settings
	-------------------------------------------------------- */
	array( 
		'type' => 'open',
		'tab_name' => __( 'General Settings', 'noisa' ),
		'tab_id' => 'general-settings',
		'icon' => 'gears'
	),

		array( 
			'type' => 'sub_open',
			'sub_tab_name' => __( 'General Settings', 'noisa' ),
			'sub_tab_id' => 'sub-general-basics'
		),

			// Custom Date 
			array(
				'name' => __( 'Date Format', 'noisa' ),
				'id' => 'custom_date',
				'type' => 'text',
				'std' => 'd/m/Y',
				'desc' => __( 'Enter your custom date. More information: http://codex.wordpress.org/Formatting_Date_and_Time', 'noisa' )
			),

			// Retina Displays
			array( 
				'name' => __( 'Retina Displays', 'noisa' ),
				'id' => 'retina',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'To make this work you need to specify the width and the height of the image directly and provide the same image twice the size withe the @2x selector added at the end of the image name. For instance if you want your "logo.png" file to be retina compatible just include it in the markup with specified width and height ( the width and height of the original image in pixels ) and create a "logo@2x.png" file in the same directory that is twice the resolution.', 'noisa' ),
			),

			// VC Frontend
			array( 
				'name' => __( 'Visual Composer Frontend Editor', 'noisa' ),
				'id' => 'vc_frontend',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Enable Visual Composer frontend editor. Please Note: The editor may not work properly when AJAX is enabled.', 'noisa' ),
			),

			// Google MAPS API Key
			array(
				'name' => __( 'Google Maps API Key', 'noisa'),
				'id' => 'google_maps_key',
				'type' => 'text',
				'std' => '',
				'desc' => __( 'Insert your Google Maps API key.', 'noisa')
			),

			// Google Map Marker
			array(
				'name' => __( 'Google Maps Marker', 'noisa' ),
				'id' => 'map_marker',
				'type' => 'add_image',
				'plugins' => array( 'add_image' ),
				'by_id' => true,
				'width' => '48',
				'height' => '56',
				'crop' => 'c',
				'std' => '',
				'button_title' => __( 'Add Image', 'noisa' ),
				'msg' => __( 'Currently you don\'t have image, you can add one by clicking on the button below.', 'noisa' ),
				'desc' => __( 'Add Google Map Marker (48px x 56px).', 'noisa' )
			),
			
		array( 
			'type' => 'sub_close'
		),
	

		/* Header / Navigation
		 -------------------------------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Navigation Header', 'noisa' ),
			'sub_tab_id' => 'sub-header'
		),	

			// Logo
			array(
				'name' => __( 'Logo Image', 'noisa' ),
				'id' => 'logo',
				'type' => 'add_image',
				'plugins' => array( 'add_image' ),
				'by_id' => true,
				'width' => '100',
				'height' => '100',
				'crop' => 'c',
				'std' => '',
				'button_title' => __( 'Add Image', 'noisa' ),
				'msg' => __( 'Currently you don\'t have image, you can add one by clicking on the button below.', 'noisa' ),
				'desc' => __( 'Add a logo image to the theme header.', 'noisa' )
			),

		array( 
			'type' => 'sub_close'
		),


		/* Slidebar
		 -------------------------------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Slidebar', 'noisa' ),
			'sub_tab_id' => 'sub-slidebar'
		),	

			// Image
			array(
				'name' => __( 'Image', 'noisa' ),
				'id' => 'site_image',
				'type' => 'add_image',
				'plugins' => array( 'add_image' ),
				'by_id' => true,
				'width' => '150',
				'height' => '150',
				'crop' => 'c',
				'std' => '',
				'button_title' => __( 'Add Image', 'noisa' ),
				'msg' => __( 'Currently you don\'t have image, you can add one by clicking on the button below.', 'noisa' ),
				'desc' => __( 'Display background image in slide panel.', 'noisa' )
			),

			// Search
			array( 
				'name' => __( 'Display Search Box', 'noisa' ),
				'id' => 'search_box',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Display search box above main navigation in slide panel.', 'noisa' ),
			),

		array( 
			'type' => 'sub_close'
		),


		/* Footer
		 -------------------------------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Footer', 'noisa' ),
			'sub_tab_id' => 'sub-footer'
		),	
			// Footer Widgets
			array( 
				'name' => __( 'Footer Widgets', 'noisa' ),
				'id' => 'footer_widgets',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Enable footer widgets.', 'noisa' ),
			),

			// Footer Note
			array( 
				'name' => __( 'Footer Note', 'noisa' ),
				'id' => 'footer_note',
				'type' => 'textarea',
				'tinymce' => 'true',
				'std' => '<p>All right reserved to NOISA Net Label | Designed by <a href="#">Rascals Themes</a></p>',
				'height' => '100',
				'desc' => __( 'Add footer note.', 'noisa' )
			),
			

		array( 
			'type' => 'sub_close'
		),

	
	array( 
		'type' => 'close'
	),


	/* Fonts
	-------------------------------------------------------- */
	array( 
		'type' => 'open',
		'tab_name' => __( 'Fonts', 'noisa' ),
		'tab_id' => 'fonts',
		'icon' => 'font'
	),

		/* Google fonts
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Google Web Fonts', 'noisa' ),
			'sub_tab_id' => 'sub-google-fonts',
		),
			array(
				'name' => __( 'Google Fonts', 'noisa' ),
				'id' => 'use_google_fonts',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'group' => 'google_fonts',
				'desc' => __( 'When this option is enabled, the text elements will be automatically replaced with the Google Web Fonts.', 'noisa' ),
			),
			array(
				'name' => __( 'Google Fonts', 'noisa' ),
				'sortable' => false,
				'array_name' => 'google_fonts',
				'id' => array(
							  array( 'type' => 'textarea', 'name' => 'font_link', 'id' => 'font_link', 'label' => 'Font Link:' )
							  ),
				'type' => 'sortable_list',
				'main_group' => 'google_fonts',
				'group_name' => array( 'use_google_fonts' ),
				'button_text' => __( 'Add Font', 'noisa' ),
				'desc' => __( '1. Go to ', 'noisa' ) . '<a href="http://www.google.com/webfonts" target="_blank">Google Fonts</a><br/>'.__( '2. Select your font and click on "Quick-use"', 'noisa' ).'<br/>'.__( '3. Choose the styles you want (bold, italic...)', 'noisa' ).'<br/>'.__( '4. Choose the character sets you want', 'noisa' ).'<br/>'.__( '5. Copy code from "blue box" and paste. For example:', 'noisa' ).'<br/><code> &lt;link href=\'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,300,300italic,400italic,600italic,700,700italic&subset=latin,latin-ext\' rel=\'stylesheet\' type=\'text/css\'&gt;</code>',
			),
			array(
				'name' => __( 'Integrate The Fonts Into Your CSS', 'noisa' ),
				'id' => 'google_code',
				'type' => 'textarea',
				'height' => '100',
				'std' => '',
				'main_group' => 'google_fonts',
				'group_name' => array( 'use_google_fonts' ),
				'desc' => __( '
							The Google Web Fonts API will generate the necessary browser-specific CSS to use the fonts. All you need to do is add the font name to your CSS styles. For example:', 'noisa' ). '<br/> <code>
							h1,h2,h3,h4,h5,h6,body { font-family : "Source Sans Pro", Helvetica, Arial, sans-serif; }
							</code>
							',
			),
		array(
			'type' => 'sub_close'
		),
		

	array( 
		'type' => 'close'
	),


	/* Sections
	-------------------------------------------------------- */
	array( 
		'type' => 'open',
		'tab_name' => __( 'Sections', 'noisa' ),
		'tab_id' => 'plugins',
		'icon' => 'th-large'
	),	

		/* Header / Intro
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Header', 'noisa' ),
			'sub_tab_id' => 'sub-section-intro',
		),

			// Default background
			array(
				'name' => __( 'Page Title Background', 'noisa' ),
				'id' => 'page_title_bg',
				'type' => 'bg_generator',
				'plugins' => array( 'bg_generator', 'colorpicker', 'add_image' ),
				'std' => '',
				'desc' => __( 'Select default background for Page Title section (category, tag...).', 'noisa' )
			),

			// Display animations on page title
			array(
				'name' => __( 'Page Title Animations', 'noisa' ),
				'id' => 'page_title_animations',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => '',
			),

			// Quick Scroll
			array( 
				'name' => __( 'Quick Scroll', 'noisa' ),
				'id' => 'quick_scroll',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Quick jump between header intro and content with animations.', 'noisa' ),
			),

			
		array(
			'type' => 'sub_close'
		),


		/* Comments
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Comments', 'noisa' ),
			'sub_tab_id' => 'sub-sections-comments'
		),

			// Custom Comments Date
			array(
				'name' => __( 'Comment Date Format', 'noisa' ),
				'id' => 'custom_comment_date',
				'type' => 'text',
				'std' => 'F j, Y (H:i)',
				'desc' => __( 'Enter your custom comment date. More information: http://codex.wordpress.org/Formatting_Date_and_Time', 'noisa' )
			),

			// Enable Disqus comments
			array(
				'name' => __( 'DISQUS Comments', 'noisa' ),
				'id' => 'disqus_comments',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Enable DISQUS comments. Replace default Wordpress comments.', 'noisa' ),
				'group' => 'disqus'
			),

			// Disqus ID
			array(
				'name' => __( 'DISQUS Website\'s Shortname', 'noisa' ),
				'id' => 'disqus_shortname',
				'type' => 'text',
				'std' => '',
				'desc' => __( 'Enter DISQUS Website\'s Shortname.', 'noisa' ),
				'main_group' => 'disqus',
				'group_name' => array( 'disqus_comments' )
			),
			
		array(
			'type' => 'sub_close'
		),
		

		/* Tracks
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Music', 'noisa' ),
			'sub_tab_id' => 'sub-sections-music',
		),

			// Enable Scamp Player
			array(
				'name' => __( 'Music Player', 'noisa' ),
				'id' => 'scamp_player',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Enable music player. NOTE: Spectra Plugin must be instaled and activated.', 'noisa' ),
				'group' => 'player',
			),

			// Autoplay
			array(
				'name' => __( 'Autoplay', 'noisa' ),
				'id' => 'player_autoplay',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Autoplay tracklist. NOTE: Autoplay does not work on mobile devices.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),
			
			// Load first track
			array(
				'name' => __( 'Load First Track', 'noisa' ),
				'id' => 'load_first_track',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Load first track from tracklist after load list.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Startup Tracklist
			array( 
				'name' => __( 'Startup Tracklist', 'noisa' ),
				'id' => 'startup_tracklist',
				'type' => 'posts',
				'post_type' => 'noisa_tracks',
				'std' => 'none',
				'options' => array(
				   	array( 'name' => '', 'value' => 'none' )
				),
				'desc' => __( 'Select startup tracklist.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Show Player
			array(
				'name' => __( 'Show Player on Startup', 'noisa' ),
				'id' => 'show_player',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Show player on startup.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Show Tracklist
			array(
				'name' => __( 'Show Tracklist on Startup', 'noisa' ),
				'id' => 'show_tracklist',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Show playlist on startup.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Random Tracks
			array(
				'name' => __( 'Random Play', 'noisa' ),
				'id' => 'player_random',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Random play tracks.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Loop Tracks
			array(
				'name' => __( 'Loop Tracklist', 'noisa' ),
				'id' => 'player_loop',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Loop tracklist.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Titlebar
			array(
				'name' => __( 'Change Titlebar', 'noisa' ),
				'id' => 'player_titlebar',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'Replace browser titlebar on track title.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Player Skin
			array( 
				'name' => __( 'Player Skin', 'noisa' ),
				'id' => 'player_skin',
				'type' => 'select',
				'std' => 'dark',
				'desc' => __( 'Select player skin.', 'noisa' ),
				'options' => array( 
					array( 'name' => 'Light Compact', 'value' => 'light.compact'),
					array( 'name' => 'Dark Compact', 'value' => 'dark.compact'),
					array( 'name' => 'Light', 'value' => 'light'),
					array( 'name' => 'Dark', 'value' => 'dark')
				),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Soundcloud Client ID
			array(
				'name' => __( 'Soundcloud Client ID', 'noisa' ),
				'id' => 'soundcloud_id',
				'type' => 'text',
				'std' => '',
				'desc' => __( 'Add your Soundcloud ID', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),

			// Startup Volume
			array( 
				'name' => __( 'Startup Volume', 'noisa' ),
				'id' => 'player_volume',
				'type' => 'range',
				'plugins' => array( 'range' ),
				'min' => 0,
				'max' => 100,
				'unit' => '',
				'std' => '70',
				'desc' => __( 'Set startup volume.', 'noisa' ),
				'main_group' => 'player',
				'group_name' => array( 'scamp_player' )
			),
			
		array(
			'type' => 'sub_close'
		),


		/* Blog
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Blog', 'noisa' ),
			'sub_tab_id' => 'sub-section-blog',
		),

			// Featured image
			array(
				'name' => __( 'Display Featured Image on Standard Post Format', 'noisa' ),
				'id' => 'display_featured_image',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => '',
			),

			// Featured image 2
			array(
				'name' => __( 'Display Featured Image on Single Post (Image Format)', 'noisa' ),
				'id' => 'display_featured_image_ipf',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => '',
			),

			// Category type
			array(
				'name' => __( 'Category/Tag/Search Type', 'noisa' ),
				'id' => 'blog_cat_type',
				'type' => 'select',	
				'std' => 'boxed',
			  	'options' => array(
					array( 'name' => __( 'List (Default)', 'noisa' ), 'value' => 'list' ),
					array( 'name' => __( 'Grid', 'noisa' ), 'value' => 'grid' )
				),
				'group' => 'cat_type',
				'desc' => '',	
			),

			// Category layout
			array(
				'name' => __( 'Grid Layout', 'noisa' ),
				'id' => 'blog_cat_layout',
				'type' => 'select',	
				'std' => 'boxed',
			  	'options' => array(
					array( 'name' => __( 'Boxed', 'noisa' ), 'value' => 'boxed' ),
					array( 'name' => __( 'Full width', 'noisa' ), 'value' => 'full-width' )
				),
				'main_group' => 'cat_type',
				'group_name' => array( 'grid' ),
				'desc' => '',	
			),

		array(
			'type' => 'sub_close'
		),

		/* Events
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Events', 'noisa' ),
			'sub_tab_id' => 'sub-section-events',
		),	

			// Custom Event Date
			array(
				'name' => __( 'Event Date Format', 'noisa' ),
				'id' => 'event_date',
				'type' => 'text',
				'std' => 'd/m',
				'desc' => __( 'Enter your custom event date. More information: http://codex.wordpress.org/Formatting_Date_and_Time', 'noisa' )
			),

			// Custom Time
			array(
				'name' => __( 'Event Time Format', 'noisa' ),
				'id' => 'event_time',
				'type' => 'text',
				'std' => 'g:i A',
				'desc' => __( 'Enter your custom event time e.g: H:i. If time field isn\'t empty the then the time is displayed after event date. More information: http://codex.wordpress.org/Formatting_Date_and_Time', 'noisa' )
			),
			array(
				'name' => __( 'Category Thumbnails Gap', 'noisa' ),
				'id' => 'gap_events',
				'type' => 'select',
				'std' => 'no-gap',
				'options' => array(
					array( 'name' => __( 'Small Gap', 'noisa' ), 'value' => 'no-gap' ),
					array( 'name' => __( 'Medium gap', 'noisa' ), 'value' => 'medium-gap' )
				),
				'desc' => __( 'Display gap between thumbnails.', 'noisa' )
			),
			
		array(
			'type' => 'sub_close'
		),


		/* Artists
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Artists', 'noisa' ),
			'sub_tab_id' => 'sub-section-artists',
		),

			// Category Layout
			array(
				'name' => __( 'Category Layout', 'noisa' ),
				'id' => 'artists_cat_layout',
				'type' => 'select',	
				'std' => 'boxed',
			  	'options' => array(
					array( 'name' => __( 'Boxed', 'noisa' ), 'value' => 'boxed' ),
					array( 'name' => __( 'Full width', 'noisa' ), 'value' => 'full-width' )
				),
				'desc' => '',	
			),
			array(
				'name' => __( 'Category Thumbnails Gap', 'noisa' ),
				'id' => 'gap_artists',
				'type' => 'select',
				'std' => 'no-gap',
				'options' => array(
					array( 'name' => __( 'Small Gap', 'noisa' ), 'value' => 'no-gap' ),
					array( 'name' => __( 'Medium gap', 'noisa' ), 'value' => 'medium-gap' )
				),
				'desc' => __( 'Display gap between thumbnails.', 'noisa' )
			),
		array(
			'type' => 'sub_close'
		),

		/* Releases
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Releases', 'noisa' ),
			'sub_tab_id' => 'sub-section-releases',
		),

			// Category Layout
			array(
				'name' => __( 'Category Layout', 'noisa' ),
				'id' => 'releases_cat_layout',
				'type' => 'select',	
				'std' => 'boxed',
			  	'options' => array(
					array( 'name' => __( 'Boxed', 'noisa' ), 'value' => 'boxed' ),
					array( 'name' => __( 'Full width', 'noisa' ), 'value' => 'full-width' )
				),
				'desc' => '',	
			),
			array(
				'name' => __( 'Category Thumbnails Gap', 'noisa' ),
				'id' => 'gap_releases',
				'type' => 'select',
				'std' => 'no-gap',
				'options' => array(
					array( 'name' => __( 'Small Gap', 'noisa' ), 'value' => 'no-gap' ),
					array( 'name' => __( 'Medium gap', 'noisa' ), 'value' => 'medium-gap' )
				),
				'desc' => __( 'Display gap between thumbnails.', 'noisa' )
			),
		array(
			'type' => 'sub_close'
		),
		

		/* Gallery
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Gallery', 'noisa' ),
			'sub_tab_id' => 'sub-section-gallery',
		),

			// Category Layout
			array(
				'name' => __( 'Category Layout', 'noisa' ),
				'id' => 'gallery_cat_layout',
				'type' => 'select',	
				'std' => 'boxed',
			  	'options' => array(
					array( 'name' => __( 'Boxed', 'noisa' ), 'value' => 'boxed' ),
					array( 'name' => __( 'Full width', 'noisa' ), 'value' => 'full-width' )
				),
				'desc' => '',	
			),
			array(
				'name' => __( 'Category Thumbnails Gap', 'noisa' ),
				'id' => 'gap_gallery',
				'type' => 'select',
				'std' => 'no-gap',
				'options' => array(
					array( 'name' => __( 'Small Gap', 'noisa' ), 'value' => 'no-gap' ),
					array( 'name' => __( 'Medium gap', 'noisa' ), 'value' => 'medium-gap' )
				),
				'desc' => __( 'Display gap between thumbnails.', 'noisa' )
			),
		array(
			'type' => 'sub_close'
		),

		/* Permalinks
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Permalinks', 'noisa' ),
			'sub_tab_id' => 'sub-section-permalinks',
		),	
			
			// Artists
			array(
				'name' => __( 'Artists Slug', 'noisa' ),
				'id' => 'artists_slug',
				'type' => 'text',
				'std' => 'artists',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Artists Categories Slug', 'noisa' ),
				'id' => 'artists_cat_slug',
				'type' => 'text',
				'std' => 'artist-category',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Artists Genres Slug', 'noisa' ),
				'id' => 'artists_genres_slug',
				'type' => 'text',
				'std' => 'artist-genre',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),

			// Releases
			array(
				'name' => __( 'Releases Slug', 'noisa' ),
				'id' => 'releases_slug',
				'type' => 'text',
				'std' => 'releases',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Releases Genres Slug', 'noisa' ),
				'id' => 'releases_genres_slug',
				'type' => 'text',
				'std' => 'release-genre',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Releases Categories Slug', 'noisa' ),
				'id' => 'releases_cat_slug',
				'type' => 'text',
				'std' => 'release-category',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Releases Artists Slug', 'noisa' ),
				'id' => 'releases_artists_slug',
				'type' => 'text',
				'std' => 'release-artist',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),

			// Events
			array(
				'name' => __( 'Events Slug', 'noisa' ),
				'id' => 'events_slug',
				'type' => 'text',
				'std' => 'events',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Events Artists Slug', 'noisa' ),
				'id' => 'events_artists_slug',
				'type' => 'text',
				'std' => 'event-artist',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Events Categories Slug', 'noisa' ),
				'id' => 'events_cat_slug',
				'type' => 'text',
				'std' => 'event-category',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Events Location Slug', 'noisa' ),
				'id' => 'events_locations_slug',
				'type' => 'text',
				'std' => 'event-location',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),

			// Gallery
			array(
				'name' => __( 'Gallery Slug', 'noisa' ),
				'id' => 'gallery_slug',
				'type' => 'text',
				'std' => 'galleries',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Gallery Artists Slug', 'noisa' ),
				'id' => 'gallery_artists_slug',
				'type' => 'text',
				'std' => 'gallery-artist',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			array(
				'name' => __( 'Gallery Categories Slug', 'noisa' ),
				'id' => 'gallery_cat_slug',
				'type' => 'text',
				'std' => 'gallery-category',
				'desc' => __( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'noisa' )
			),
			
		array(
			'type' => 'sub_close'
		),

	array( 
		'type' => 'close'
	),


	/* Sidebars
	 ------------------------------------------------------------------------------------------ */
	array(
		'type' => 'open',
		'tab_name' => __( 'Sidebars', 'noisa' ),
		'tab_id' => 'sidebars',
		'icon' => 'bars'
	),
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Sidebars', 'noisa' ),
			'sub_tab_id' => 'sub-sidebars'
		),
			array(
				'name' => __( 'Sidebars', 'noisa' ),
				'sortable' => false,
				'array_name' => 'custom_sidebars',
				'id' => array(
							  array( 'name' => 'name', 'id' => 'sidebar', 'label' => 'Name:' )
							  ),
				'type' => 'sortable_list',
				'button_text' => __( 'Add Sidebar', 'noisa' ),
				'desc' => __( 'Add your custom sidebars.', 'noisa' )
			),
		array(
			'type' => 'sub_close'
		),
	array(
		'type' => 'close'
	),

	
	/* Quick Edit
	 ------------------------------------------------------------------------------------------ */
	array(
		'type'     => 'open',
		'tab_name' => __( 'Quick Edit', 'noisa' ),
		'tab_id'   => 'editing',
		'icon' => 'code'
	),
	
		/* Custom CSS */
		array(
			'type'         => 'sub_open',
			'sub_tab_name' => __( 'CSS', 'noisa' ),
			'sub_tab_id'   => 'sub-custom-css'
		),
			array(
				'type'   => 'code_editor',
				'plugins' => array( 'code_editor' ),
				'lang' => 'css',
				'std'    => '',
				'height' => '200',
				'desc'   => __( 'Add your custom CSS rules here. Every main CSS rule can be adjusted. Whenever you want to change theme style always use this field. When you do that you\'ll have assurance that whenever you upgrade the theme, your code will stay untouched. Avoid making changes to "style.css" file directly. Whenever you change something, you can always export your data using Advanced > Import/Export.', 'noisa' ),
				'id'     => 'custom_css'
			),
		array(
			'type' => 'sub_close'
		),
	
		/* Custom Javascript */
		array(
			'type'         => 'sub_open',
			'sub_tab_name' => __( 'Javascript', 'noisa' ),
			'sub_tab_id'   => 'sub-custom-js'
		),
			array(
				'type'   => 'code_editor',
				'plugins' => array( 'code_editor' ),
				'lang' => 'js',
				'std'    => '',
				'height' => '200',
				'desc'   => __( 'Add your custom Javascript code. Below you have simple example of jQuery script:', 'noisa' ) . '<br/><code>jQuery.noConflict(); <br/>jQuery(document).ready(function () { <br/>alert(\'Hello World!\' );<br/>});</code>',
				'id'     => 'custom_js'
			),
		array(
			'type' => 'sub_close'
		),
	
	array(
		'type' => 'close'
	),

	/* Advanced
	-------------------------------------------------------- */
	array( 
		'type' => 'open',
		'tab_name' => __( 'Advanced', 'noisa' ),
		'tab_id' => 'advanced',
		'icon' => 'wrench'
	),

		/* Ajax
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Ajax', 'noisa' ),
			'sub_tab_id' => 'sub-ajax'
		),

			// Ajax
			array( 
				'name' => __( 'Ajax Load', 'noisa' ),
				'id' => 'ajaxed',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Enable if you want ajax loading.', 'noisa' ),
			),

			// Ajax classes
			array( 
				'name' => __( 'AJAX Filter', 'noisa' ),
				'id' => 'ajax_elements',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '.sp-play-list,.sp-add-list,.sp-play-track,.sp-add-track,.smooth-scroll,.ui-tabs-nav li a, .wpb_tour_next_prev_nav span a,.wpb_accordion_header a,.vc_tta-tab,.vc_tta-tab a',
				'height' => '60',
				'desc' => __( 'Add selectors separated by commas. These elements will not be processed by AJAX. NOTE: Don\'t remove default elements.', 'noisa' )
			),

			// Ajax events
			array( 
				'name' => __( 'AJAX Events', 'noisa' ),
				'id' => 'ajax_events',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => 'YTAPIReady,getVideoInfo_bgndVideo',
				'height' => '60',
				'desc' => __( 'Add events separated by commas. These events will be removed after page page by AJAX. NOTE: Don\'t remove default events.', 'noisa' )
			),

			// Ajax reload scripts
			array( 
				'name' => __( 'AJAX Reload Scripts', 'noisa' ),
				'id' => 'ajax_reload_scripts',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '/js/custom.js,shortcodes/assets/js/shortcodes.js,contact-form-7/includes/js/scripts.js,/dist/skrollr.min.js,js_composer_front.min.js',
				'height' => '60',
				'desc' => __( 'Add strings for reloaded scripts separated by commas. These scripts will be reloaded after page page by AJAX. NOTE: Don\'t remove default scripts.', 'noisa' )
			),

			// Ajax Async
			array(
				'name' => __( 'Asynchronous', 'noisa' ),
				'id' => 'ajax_async',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => __( 'Asynchronous AJAX.', 'noisa' )
			),

			// Ajax Cache
			array(
				'name' => __( 'Ajax Cache', 'noisa' ),
				'id' => 'ajax_cache',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => __( 'AJAX Cache.', 'noisa' )
			),
			
		array(
			'type' => 'sub_close'
		),

		/* Import and export
		 -------------------------------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => __( 'Import/Export', 'noisa' ),
			'sub_tab_id' => 'sub-import'
		),
			array( 
				'type' => 'export'
			),
			array( 
				'type' => 'import'
			),
		array( 
			'type' => 'sub_close'
		),

	array( 
		'type' => 'close'
	),


	/* Hidden fields
	 -------------------------------------------------------- */
	array( 
		'type' => 'hidden_field',
		'id' => 'theme_name',
		'value' => 'noisa'
	),
	
);


/* Dummy data
 ------------------------------------------------------------------------*/
$dummy_data = 'YTo1ODp7czoxMToiY3VzdG9tX2RhdGUiO3M6NjoiRiBqLCBZIjtzOjY6InJldGluYSI7czozOiJvZmYiO3M6MTM6InNtb290aF9zY3JvbGwiO3M6Mzoib2ZmIjtzOjEwOiJzZWFyY2hfYm94IjtzOjI6Im9uIjtzOjE0OiJmb290ZXJfd2lkZ2V0cyI7czozOiJvZmYiO3M6MTE6ImZvb3Rlcl9ub3RlIjtzOjkzOiI8cD5OT0lTQSBNdXNpYyZuYnNwO0FnZW5jeSB8IERlc2lnbmVkIGJ5IDxhIGhyZWY9IiMiIGRhdGEtbWNlLWhyZWY9IiMiPlJhc2NhbHMgVGhlbWVzPC9hPjwvcD4iO3M6MTY6InVzZV9nb29nbGVfZm9udHMiO3M6Mjoib24iO3M6MTI6Imdvb2dsZV9mb250cyI7YToxOntpOjA7YToxOntzOjk6ImZvbnRfbGluayI7czoxODE6IjxsaW5rIGhyZWY9J2h0dHBzOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1Tb3VyY2UrU2FucytQcm86NDAwLDYwMCwzMDAsMzAwaXRhbGljLDQwMGl0YWxpYyw2MDBpdGFsaWMsNzAwLDcwMGl0YWxpYyZzdWJzZXQ9bGF0aW4sbGF0aW4tZXh0JyByZWw9J3N0eWxlc2hlZXQnIHR5cGU9J3RleHQvY3NzJz4iO319czoyMToicGFnZV90aXRsZV9hbmltYXRpb25zIjtzOjM6Im9mZiI7czoxMjoicXVpY2tfc2Nyb2xsIjtzOjM6Im9mZiI7czoxOToiY3VzdG9tX2NvbW1lbnRfZGF0ZSI7czoxMjoiRiBqLCBZIChIOmkpIjtzOjE1OiJkaXNxdXNfY29tbWVudHMiO3M6Mzoib2ZmIjtzOjEyOiJzY2FtcF9wbGF5ZXIiO3M6Mjoib24iO3M6MTU6InBsYXllcl9hdXRvcGxheSI7czozOiJvZmYiO3M6MTY6ImxvYWRfZmlyc3RfdHJhY2siO3M6Mjoib24iO3M6MTc6InN0YXJ0dXBfdHJhY2tsaXN0IjtzOjI6IjQ4IjtzOjExOiJzaG93X3BsYXllciI7czoyOiJvbiI7czoxNDoic2hvd190cmFja2xpc3QiO3M6Mzoib2ZmIjtzOjEzOiJwbGF5ZXJfcmFuZG9tIjtzOjM6Im9mZiI7czoxMToicGxheWVyX2xvb3AiO3M6Mjoib24iO3M6MTU6InBsYXllcl90aXRsZWJhciI7czozOiJvZmYiO3M6MTE6InBsYXllcl9za2luIjtzOjEzOiJsaWdodC5jb21wYWN0IjtzOjEzOiJwbGF5ZXJfdm9sdW1lIjtzOjI6IjcwIjtzOjIyOiJkaXNwbGF5X2ZlYXR1cmVkX2ltYWdlIjtzOjI6Im9uIjtzOjI2OiJkaXNwbGF5X2ZlYXR1cmVkX2ltYWdlX2lwZiI7czoyOiJvbiI7czoxMzoiYmxvZ19jYXRfdHlwZSI7czo0OiJncmlkIjtzOjE1OiJibG9nX2NhdF9sYXlvdXQiO3M6NToiYm94ZWQiO3M6MTA6ImV2ZW50X2RhdGUiO3M6MzoiZC9tIjtzOjEwOiJldmVudF90aW1lIjtzOjU6Imc6aSBBIjtzOjEwOiJnYXBfZXZlbnRzIjtzOjY6Im5vLWdhcCI7czoxODoiYXJ0aXN0c19jYXRfbGF5b3V0IjtzOjU6ImJveGVkIjtzOjExOiJnYXBfYXJ0aXN0cyI7czo2OiJuby1nYXAiO3M6MTk6InJlbGVhc2VzX2NhdF9sYXlvdXQiO3M6NToiYm94ZWQiO3M6MTI6ImdhcF9yZWxlYXNlcyI7czo2OiJuby1nYXAiO3M6MTg6ImdhbGxlcnlfY2F0X2xheW91dCI7czo1OiJib3hlZCI7czoxMToiZ2FwX2dhbGxlcnkiO3M6Njoibm8tZ2FwIjtzOjEyOiJhcnRpc3RzX3NsdWciO3M6NzoiYXJ0aXN0cyI7czoxNjoiYXJ0aXN0c19jYXRfc2x1ZyI7czoxNToiYXJ0aXN0LWNhdGVnb3J5IjtzOjE5OiJhcnRpc3RzX2dlbnJlc19zbHVnIjtzOjEyOiJhcnRpc3QtZ2VucmUiO3M6MTM6InJlbGVhc2VzX3NsdWciO3M6ODoicmVsZWFzZXMiO3M6MjA6InJlbGVhc2VzX2dlbnJlc19zbHVnIjtzOjEzOiJyZWxlYXNlLWdlbnJlIjtzOjE3OiJyZWxlYXNlc19jYXRfc2x1ZyI7czoxNjoicmVsZWFzZS1jYXRlZ29yeSI7czoyMToicmVsZWFzZXNfYXJ0aXN0c19zbHVnIjtzOjE0OiJyZWxlYXNlLWFydGlzdCI7czoxMToiZXZlbnRzX3NsdWciO3M6NjoiZXZlbnRzIjtzOjE5OiJldmVudHNfYXJ0aXN0c19zbHVnIjtzOjEyOiJldmVudC1hcnRpc3QiO3M6MTU6ImV2ZW50c19jYXRfc2x1ZyI7czoxNDoiZXZlbnQtY2F0ZWdvcnkiO3M6MjE6ImV2ZW50c19sb2NhdGlvbnNfc2x1ZyI7czoxNDoiZXZlbnQtbG9jYXRpb24iO3M6MTI6ImdhbGxlcnlfc2x1ZyI7czo2OiJhbGJ1bXMiO3M6MjA6ImdhbGxlcnlfYXJ0aXN0c19zbHVnIjtzOjE0OiJnYWxsZXJ5LWFydGlzdCI7czoxNjoiZ2FsbGVyeV9jYXRfc2x1ZyI7czoxNjoiYWxidW0tY2F0ZWdvcmllcyI7czoxNToiY3VzdG9tX3NpZGViYXJzIjthOjE6e2k6MDthOjE6e3M6NDoibmFtZSI7czoxNDoiQ3VzdG9tIFNpZGViYXIiO319czo2OiJhamF4ZWQiO3M6Mjoib24iO3M6MTM6ImFqYXhfZWxlbWVudHMiO3M6MTcwOiIuc3AtcGxheS1saXN0LC5zcC1hZGQtbGlzdCwuc3AtcGxheS10cmFjaywuc3AtYWRkLXRyYWNrLC5zbW9vdGgtc2Nyb2xsLC51aS10YWJzLW5hdiBsaSBhLCAud3BiX3RvdXJfbmV4dF9wcmV2X25hdiBzcGFuIGEsLndwYl9hY2NvcmRpb25faGVhZGVyIGEsLnZjX3R0YS10YWIsLnZjX3R0YS10YWIgYSI7czoxMToiYWpheF9ldmVudHMiO3M6MzM6IllUQVBJUmVhZHksZ2V0VmlkZW9JbmZvX2JnbmRWaWRlbyI7czoxOToiYWpheF9yZWxvYWRfc2NyaXB0cyI7czoxMzI6Ii9qcy9jdXN0b20uanMsc2hvcnRjb2Rlcy9hc3NldHMvanMvc2hvcnRjb2Rlcy5qcyxjb250YWN0LWZvcm0tNy9pbmNsdWRlcy9qcy9zY3JpcHRzLmpzLC9kaXN0L3Nrcm9sbHIubWluLmpzLGpzX2NvbXBvc2VyX2Zyb250Lm1pbi5qcyI7czoxMDoiYWpheF9hc3luYyI7czoyOiJvbiI7czoxMDoiYWpheF9jYWNoZSI7czozOiJvZmYiO3M6MTA6InRoZW1lX25hbWUiO3M6MTE6Im5vaXNhX3RoZW1lIjt9';


/* init Panel
 ------------------------------------------------------------------------*/

global $noisa_opts;

/* Class arguments */
$args = array(
	'admin_path'  => '',
	'admin_uri'	 => '',
	'panel_logo' => '',
	'menu_name' => __( 'Theme Options', 'noisa' ), 
	'page_name' => 'panel-main',
	'option_name' => 'noisa_panel_opts',
	'admin_dir' => '/admin',
	'menu_icon' => '',
	'dummy_data' => $dummy_data,
	'textdomain' => 'noisa'
	);

/* Add class instance */
$noisa_opts = new MuttleyPanel( $args, $noisa_main_options );

/* Remove variables */
unset( $args );
?>
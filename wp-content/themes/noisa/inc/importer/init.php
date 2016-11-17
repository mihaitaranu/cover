<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'MuttleyImporterData' ) ) {

	require_once( dirname( __FILE__ ) . '/MuttleyImporter.php' ); //load admin theme data importer

	class MuttleyImporterData extends MuttleyImporter {

		/**
		 * Set framewok
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'MuttleyPanel';


		/**
		 * Show Console
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $wp_importer_console = 'hidden';


		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name       = 'pendulum_panel_opts'; 

		/**
		 * Set name of the theme options file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_options_file_name = 'theme_options.txt';

		/**
		 * Set name of the widgets json file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widgets_file_name       = 'widgets.json';

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $content_demo_file_name  = 'content.xml';
		public $content_demo_file_name_two  = 'content_tracks.xml';

		/**
		 * Set homepage by slug
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $homepage_name = 'home'; 

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Required plugins
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $required_plugins = array(
			array(
		    	'path' => 'js_composer/js_composer.php',
		    	'name' => 'WPBakery Visual Composer'
		    ),
		    array(
		    	'path' => 'rascals_noisa_plugin/rascals_noisa_plugin.php',
		    	'name' => 'Rascals Themes - NOISA Plugin'
		    )
		);

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = dirname(__FILE__) . '/demo-files/'; //can

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$sidebar_menu = get_term_by( 'name', 'Sidebar Menu', 'nav_menu' );
			$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array(
					'sidebar' => $sidebar_menu->term_id,
					'top' => $top_menu->term_id
				)
			);

			$this->flag_as_imported['menus'] = true;

		}


	}

	new MuttleyImporterData;

}
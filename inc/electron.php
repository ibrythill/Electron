<?php
/**
 * Proton - A WordPress theme development framework.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   Proton
 * @version   1.0
 * @author    Karol Pentak <admin@ibrythill.com>
 * @copyright Copyright (c) 2010 - 2018, Karol "Ibrythill" Pentak
 * @link      http://ibrythill.com/
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Electron;

use Electron\Helpers\Sidebars 	as Sidebars;

class Core{

	/**
	 * instance
	 *
	 * (default value: null)
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $instance = null;

	/**
	 * theme_slug
	 *
	 * (default value: 'Electron')
	 *
	 * @var string
	 * @access protected
	 */
	protected $theme_slug = 'Electron';

	/**
	 * __construct function.
	 *
	 * @access private
	 * @return void
	 */
	private function __construct(){

		/* Load the framework extensions. */
		add_action( 'after_setup_theme', array( &$this, 'extensions' ), 5 );

		add_action( 'after_setup_theme', array( &$this, 'proton_init_options' ), 100 );


	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ){
			self::$instance = new self;
			self::$instance->constants();
			self::$instance->core();
			self::$instance->setup();
		}
		return self::$instance;
	}

	/**
	 * Defines the constant paths for use within the core framework.
	 *
	 * @since 0.9.0
	 */
	public function constants() {


		/* Sets the framework version number. */
		define( 'ELECTRON_VERSION', 		wp_get_theme()->get( 'Version' ) );

		/* Sets the framework slug. */
		define( 'ELECTRON_SLUG', 			$this->theme_slug );

		/* PROTON */
		if(!defined('DS'))					define('DS', DIRECTORY_SEPARATOR);
		define('ELECTRON_DIR', 				trailingslashit(dirname(__FILE__)) . DS);
		define('ELECTRON_URL', 				get_template_directory_uri().'/');

		/* THEME */
		if(!defined('THEME'))				define( 'THEME', get_template_directory() . DS );
		if(!defined('THEME_URL'))			define( 'THEME_URL', get_template_directory_uri());

		/* CLASSES */
		define( 'ELECTRON_INC', 			trailingslashit(ELECTRON_DIR) );
		define( 'ELECTRON_INC_URL', 		trailingslashit(ELECTRON_URL) );

		/* EXTENSIONS */
		define( 'ELECTRON_EXTENSIONS', 		trailingslashit(ELECTRON_DIR) . "extensions" . DS );
		define( 'ELECTRON_EXTENSIONS_URL', 	trailingslashit(ELECTRON_URL) . "extensions/" );

		/* EXTENSIONS */
		define( 'ELECTRON_ASSETS', 			trailingslashit(ELECTRON_DIR) . "assets" . DS );
		define( 'ELECTRON_ASSETS_URL', 		trailingslashit(ELECTRON_URL) . "assets/" );

		/* WIDGETS */
		//define( 'WPWIDGETS_DIR', trailingslashit(PLUGINS_DIR)."widgets" . DS);


	}

	/**
	 * Loads the core framework functions.  These files are needed before loading anything else in the
	 * framework because they have required functions for use.
	 *
	 * @since 1.8.0
	 */
	public function core() {

		require_once( ELECTRON_INC . 'autoload.php' );

		require_once( ELECTRON_INC . 'breadcrumbs.php' );
		require_once( ELECTRON_INC . 'pagination.php' );
		require_once( ELECTRON_INC . 'proton-megamenu.php' );
		require_once( ELECTRON_INC . 'functions-wpbakery.php' );


		require_once( ELECTRON_INC . 'external/simple_html_dom.php' );


		if(in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))){
			require_if_theme_supports( 'electron-theme-login', trailingslashit(ELECTRON_DIR).'admin/login.php');
		}

		/*functions*/
		//require_once (trailingslashit(ELECTRON_INC) . 'electron-assets.php');

		if(is_admin()){
			require_once (trailingslashit(ELECTRON_INC) . 'external/class-tgm-plugin-activation.php');
			//require_once ('lib/JSMin.php');
			require_once (trailingslashit(ELECTRON_INC) . 'functions-plugins.php');
			require_once (trailingslashit(ELECTRON_INC) . 'config.php');
		}else{



		}



		/*shortcodes*
		include(SHORTCODES_DIR . 'mygallery.php');
		include(SHORTCODES_DIR . 'shortcodes.php');
		*/
	}

	/**
	 * setup function.
	 *
	 * @access private
	 * @return void
	 */
	private function setup() {

		/* Initialize classes. */
		add_action( 'after_setup_theme', 	array( $this, 'init' ), 87 );

		add_filter( 'widget_text', 			'do_shortcode' );
		add_filter( 'term_description', 	'do_shortcode' );
	}


	/**
	 * Load extensions (external projects).  Not required by the plugin to run properly.
	 *
	 * @since 2.1.0
	 */
	public function extensions() {
		/* Load the meta SEO options. */
		//require_if_theme_supports( 'electron-megamenu',trailingslashit( ELECTRON_INC ) . 'proton-megamenu.php' );

		/* Load the meta SEO options. */
		//require_if_theme_supports( 'electron-extend-seo',trailingslashit( ELECTRON_EXTENSIONS_DIR ) . 'proton.seo.php' );

		/* Load the Event Calendar extension if supported. */
		//require_if_theme_supports( 'electron-extend-calendar',trailingslashit( ELECTRON_EXTENSIONS_DIR ) . 'calendar/calendar.php' );

		/* Load the Cleaner Gallery extension if supported. */
		//require_if_theme_supports( 'electron-extend-cleaner-gallery', trailingslashit( ELECTRON_EXTENSIONS_DIR ) . 'cleaner-gallery.php' );

		/* Load the Event Booking extension if supported. */
		//require_if_theme_supports( 'electron-extend-eventbooking', trailingslashit( ELECTRON_EXTENSIONS_DIR ) . 'eventbooking/eventbooking.php' );

		/* Load the Ajax Search extension if supported. */
		//require_if_theme_supports( 'electron-extend-ajaxsearch', trailingslashit( ELECTRON_EXTENSIONS_DIR ) . 'ajaxedsearch/ajaxedsearch.php' );

	}

	public function proton_init_options(){
		// proton Metabox Options


		if(class_exists('Electron_assets')){
			Electron_assets::get_instance();
		}


		if(get_theme_support( 'electron-menu' )){
			/* Get theme-supported menus. */
			$menus = get_theme_support( 'electron-menu' );

			/* If there is no array of menus IDs, return. */
			if ( is_array( $menus[0] ) ){
				/** Menus define **/
				register_nav_menus( $menus[0] );
			}
		}


		require_once (trailingslashit(ELECTRON_INC) . 'functions-electron.php');

	}
	/**
	 * Initialize framework clsses.
	 *
	 * @since 2.2.0
	 */

	public function init(){

		// proton classes init

		Sidebars::get_instance();


		if(is_admin()){



		}else{



		}

	}




}

	/**
	 * Gets the instance of the `Electron` class.  This function is useful for quickly grabbing data
	 * used throughout the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	function electron() {
		return \Electron\Core::get_instance();
	}

	// Let's do this thang!
	electron();
?>
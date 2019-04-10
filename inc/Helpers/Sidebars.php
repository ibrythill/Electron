<?php
namespace Electron\Helpers;

class Sidebars{

	/**
	* Holds the instance of this class.
	*/
	private static $instance;

	private $sidebars;

	/**
	 * Template Constructor.
	*/
	public function __construct(){
		$this->sidebars = get_theme_support( 'electron-sidebars' );
		add_filter( 'init', array( $this, 'sidebars_init' ));
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance ){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function render_sidebar($name){

			if ( function_exists('dynamic_sidebar') && dynamic_sidebar($name) ) : endif;
	}

	public function sidebars_init(){

			if ( !is_array( $this->sidebars[0] ) )
				return;

			foreach ($this->sidebars[0] as $sidebar) {
				if ( function_exists('register_sidebar') ) {

					register_sidebar(array(
							'name'=> $sidebar,
							'id' => $sidebar,
							'description' => __("Normal full width Sidebar",'proton_framework'),
							'before_widget' => '<div class="widget">', // Removes <li>
							'after_widget' => '<div class="clear"></div></div>', // Removes </li>
							'before_title' => '<h3 class="widget-header">', // Replaces <h2>
							'after_title' => '</h3>', // Replaces </h2>
					));

	            }
			}
	}

}

?>
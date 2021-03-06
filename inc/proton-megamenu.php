<?php
// File Security Check
if ( ! defined( 'ELECTRON_VERSION' ) ) exit;

if(class_exists('_PF_Opt_Menu')){
_PF_Opt_Menu::addConfig('pmm_config', array(
		"title"  => "MegaMenu",
		"desc" => __( "Mega Menu settings", ELECTRON_SLUG ),
		"hint" => "Clever hint",
		"icon"  => "compass",
		"theme" => "Teal",
		"fields" => array(
			/*array(
				"id"  => "pmm_modal",
				"type" => "extended",
				"title" => __( "Mega Menu" , ELECTRON_SLUG ),
				"desc" => __( "Enable Mega Menu" , ELECTRON_SLUG ),
				"default"  => 0,
				"export"  => 'multi',
				"template" => "default",
				"classes" => "pmm-modal ",
				"options" => array(
					"required"  => array("pmm_header", "equals", 0)
				),
				"fields" => array(
					array(
						"id"  => "pmm_mega",
						"type" => "checkbox",
						"title" => __( "Mega Menu" , ELECTRON_SLUG ),
						"desc" => __( "Enable Mega Menu" , ELECTRON_SLUG ),
						"default"  => 0,
						"template" => "default",
						"classes" => "pmm-trigger ",
						"options" => array(
							//"required"  => array("pmm_header", "equals", 0)
						)
					),
					array(
						"id"  => "pmm_header",
						"type" => "checkbox",
						"title" => __( "Header" , ELECTRON_SLUG ),
						"desc" => __( "Make this a header" , ELECTRON_SLUG ),
						"default"  => 0,
						"template" => "default",
						"classes" => "pmm-head-trigger ",
						"options" => array(
							//"required"  => array("pmm_mega", "equals", 0)
						)
					),
					array(
						"id"  => "pmm_link",
						"type" => "checkbox",
						"title" => __( "Disable link" , ELECTRON_SLUG ),
						"desc" => __( "Check this to disable linking" , ELECTRON_SLUG ),
						"default"  => 0,
						"template" => "default",
						"classes" => "pmm-link-trigger "
					),
					array(
						"id"  => "pmm_label",
						"type" => "checkbox",
						"title" => __( "Hide label" , ELECTRON_SLUG ),
						"desc" => __( "Check this to hide label" , ELECTRON_SLUG ),
						"default"  => 0,
						"template" => "default"
					),
					array(
						"id"  => "pmm_fullwidth",
						"type" => "checkbox",
						"title" => __( "Full width" , ELECTRON_SLUG ),
						"desc" => __( "Check this to make this menu full width" , ELECTRON_SLUG ),
						"default"  => 0,
						"template" => "default",
						"options" => array(
							"required"  => array("pmm_mega", "equals", 1)
						)
					),
					array(
						"id"  => "pmm_trigger",
						"type" => "select",
						"title" => __( "Trigger" , ELECTRON_SLUG ),
						"desc" => __( "Set trigger action" , ELECTRON_SLUG ),
						"default"  => 'hover',
						"template" => "default",
						"options" => array(
							"sortable"  => false, //select only
							"multi" => false, //select only
							//"data" => "posts", //select only
							"choices" => array(
								'hover' => __( "On hover" , ELECTRON_SLUG ),
								'click' => __( "On click" , ELECTRON_SLUG )
							), //select only
							"args" => "", //misc
							//"required"  => array("required_id", "equals", "value"), //misc
							"width" => "100%", //in %
							"required"  => array("pmm_mega", "equals", 1)
						)
					),
					array(
						"id"  => "pmm_icon",
						"type" => "iconpicker",
						"title" => __( "Icon" , ELECTRON_SLUG ),
						"desc" => __( "Set menu item icon" , ELECTRON_SLUG ),
						"default"  => '',
						"template" => "default"
					),
					array(
						"id"  => "pmm_image",
						"type" => "upload",
						"title" => __( "Image" , ELECTRON_SLUG ),
						"desc" => __( "Set image" , ELECTRON_SLUG ),
						"default"  => '',
						"template" => "default",
						"options" => array(
							"data" => "image",
							"required"  => array("pmm_mega", "equals", 0)
						)
					),
					array(
						"id"  => "pmm_padding",
						"type" => "text",
						"title" => __( "Padding" , ELECTRON_SLUG ),
						"desc" => __( "Set menu padding (top right bottom left)." , ELECTRON_SLUG ),
						"hint" => __( "You can use px or %" , ELECTRON_SLUG ),
						"default"  => '0px 0px 0px 0px',
						"template" => "default",
						"options" => array(
							"required"  => array("pmm_mega", "equals", 1)
						)
					),
					array(
						"id"  => "pmm_user_col",
						"type" => "select",
						"title" => __( "Columns" , ELECTRON_SLUG ),
						"desc" => __( "Set number of columns" , ELECTRON_SLUG ),
						"default"  => 'auto',
						"template" => "default",
						"options" => array(
							"sortable"  => false, //select only
							"multi" => false, //select only
							//"data" => "posts", //select only
							"choices" => array(
								'auto' => "auto",
								12 => "12 ". __( "columns" , ELECTRON_SLUG ),
								6 => "6 ". __( "columns" , ELECTRON_SLUG ),
								4 => "4 ". __( "columns" , ELECTRON_SLUG ),
								3 => "3 ". __( "columns" , ELECTRON_SLUG ),
								2 => "2 ". __( "columns" , ELECTRON_SLUG ),
								1 => "1 ". __( "column" , ELECTRON_SLUG ),
							), //select only
							"args" => "", //misc
							//"required"  => array("required_id", "equals", "value"), //misc
							"width" => "100%", //in %
							"required"  => array("pmm_mega", "equals", 1)
						)
					),

				)
			),*/
			array(
				"id"  => "pmm_mega",
				"type" => "checkbox",
				"title" => __( "Mega Menu" , ELECTRON_SLUG ),
				"desc" => __( "Enable Mega Menu" , ELECTRON_SLUG ),
				"default"  => 0,
				"template" => "default",
				"classes" => "pmm-trigger ",
				"options" => array(
					"required"  => array("pmm_header", "equals", 0)
				)
			),
			array(
				"id"  => "pmm_header",
				"type" => "checkbox",
				"title" => __( "Header" , ELECTRON_SLUG ),
				"desc" => __( "Make this a header" , ELECTRON_SLUG ),
				"default"  => 0,
				"template" => "default",
				"classes" => "pmm-head-trigger ",
				"options" => array(
					"required"  => array("pmm_mega", "equals", 0)
				)
			),
			array(
				"id"  => "pmm_link",
				"type" => "checkbox",
				"title" => __( "Disable link" , ELECTRON_SLUG ),
				"desc" => __( "Check this to disable linking" , ELECTRON_SLUG ),
				"default"  => 0,
				"template" => "default",
				"classes" => "pmm-link-trigger "
			),
			array(
				"id"  => "pmm_label",
				"type" => "checkbox",
				"title" => __( "Hide label" , ELECTRON_SLUG ),
				"desc" => __( "Check this to hide label" , ELECTRON_SLUG ),
				"default"  => 0,
				"template" => "default"
			),
			array(
				"id"  => "pmm_fullwidth",
				"type" => "checkbox",
				"title" => __( "Full width" , ELECTRON_SLUG ),
				"desc" => __( "Check this to make this menu full width" , ELECTRON_SLUG ),
				"default"  => 0,
				"template" => "default",
				"options" => array(
					"required"  => array("pmm_mega", "equals", 1)
				)
			),
			array(
				"id"  => "pmm_trigger",
				"type" => "select",
				"title" => __( "Trigger" , ELECTRON_SLUG ),
				"desc" => __( "Set trigger action" , ELECTRON_SLUG ),
				"default"  => 'hover',
				"template" => "default",
				"options" => array(
					"sortable"  => false, //select only
					"multi" => false, //select only
					//"data" => "posts", //select only
					"choices" => array(
						'hover' => __( "On hover" , ELECTRON_SLUG ),
						'click' => __( "On click" , ELECTRON_SLUG )
					), //select only
					"args" => "", //misc
					//"required"  => array("required_id", "equals", "value"), //misc
					"width" => "100%", //in %
					"required"  => array("pmm_mega", "equals", 1)
				)
			),
			array(
				"id"  => "pmm_icon",
				"type" => "iconpicker",
				"title" => __( "Icon" , ELECTRON_SLUG ),
				"desc" => __( "Set menu item icon" , ELECTRON_SLUG ),
				"default"  => '',
				"template" => "default"
			),
			array(
				"id"  => "pmm_image",
				"type" => "upload",
				"title" => __( "Image" , ELECTRON_SLUG ),
				"desc" => __( "Set image" , ELECTRON_SLUG ),
				"default"  => '',
				"template" => "default",
				"options" => array(
					"data" => "image",
					"required"  => array("pmm_mega", "equals", 0)
				)
			),
			array(
				"id"  => "pmm_padding",
				"type" => "text",
				"title" => __( "Padding" , ELECTRON_SLUG ),
				"desc" => __( "Set menu padding (top right bottom left)." , ELECTRON_SLUG ),
				"hint" => __( "You can use px or %" , ELECTRON_SLUG ),
				"default"  => '0px 0px 0px 0px',
				"template" => "default",
				"options" => array(
					"required"  => array("pmm_mega", "equals", 1)
				)
			),
			array(
				"id"  => "pmm_user_col",
				"type" => "select",
				"title" => __( "Columns" , ELECTRON_SLUG ),
				"desc" => __( "Set number of columns" , ELECTRON_SLUG ),
				"default"  => 'auto',
				"template" => "default",
				"options" => array(
					"sortable"  => false, //select only
					"multi" => false, //select only
					//"data" => "posts", //select only
					"choices" => array(
						'auto' => "auto",
						12 => "12 ". __( "columns" , ELECTRON_SLUG ),
						6 => "6 ". __( "columns" , ELECTRON_SLUG ),
						4 => "4 ". __( "columns" , ELECTRON_SLUG ),
						3 => "3 ". __( "columns" , ELECTRON_SLUG ),
						2 => "2 ". __( "columns" , ELECTRON_SLUG ),
						1 => "1 ". __( "column" , ELECTRON_SLUG ),
					), //select only
					"args" => "", //misc
					//"required"  => array("required_id", "equals", "value"), //misc
					"width" => "100%", //in %
					"required"  => array("pmm_mega", "equals", 1)
				)
			)
		)
	));
}
require_once( 'class-opt-menu-walker.php');



# Load megamenu scripts.
add_action( 'wp_enqueue_scripts', 'pmm_enqueue', 5 );

/**
 * Registers JavaScript files for the framework.  This function merely registers scripts with WordPress using
 * the wp_register_script() function.  It does not load any script files on the site.  If a theme wants to register
 * its own custom scripts, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @since  1.2.0
 * @access public
 * @return void
 */
function pmm_enqueue() {
	//css
	$git_path = '//cdn.jsdelivr.net/gh/ibrythill/Electron@latest/';
	wp_register_style( 'electron_megamenu', $git_path . 'assets/css/proton_megamenu.css', false, ELECTRON_VERSION);
	//wp_enqueue_style('electron_megamenu');

	//JS
	//wp_register_script( 'pmm_position', PROTON_EXT_URL . 'megamenu/js/position.min.js', array( 'jquery' ), PROTON_VERSION , true );
	//wp_enqueue_script( 'pmm_position' );

	//wp_register_script( 'pmm_hoverintent', PROTON_EXT_URL . 'megamenu/js/jquery.hoverIntent.minified.js', array( 'jquery' ), PROTON_VERSION , true );
	//wp_enqueue_script( 'pmm_hoverintent' );

	//wp_register_script( 'pmm_aim', PROTON_EXT_URL . 'megamenu/js/jquery.menu-aim.js', array( 'jquery' ), PROTON_VERSION , true );
	//wp_enqueue_script( 'pmm_aim' );

	//wp_register_script( 'proton-megamenu', PROTON_EXT_URL . 'megamenu/js/proton-megamenu.js', array( 'jquery' ), PROTON_VERSION , true );
	//wp_enqueue_script( 'proton-megamenu' );

	//proton_enqueue_script( 'pmm_position', PROTON_EXT_URL . 'megamenu/js/position.min.js', PROTON_VERSION , true );
	//proton_enqueue_script( 'pmm_hoverintent', PROTON_EXT_URL . 'megamenu/js/jquery.hoverIntent.minified.js', PROTON_VERSION , true );
	//proton_enqueue_script( 'electron-megamenu', ELECTRON_URL . 'assets/js/electron-megamenu.min.js', ELECTRON_VERSION , true, 2 );
	electron_register_script('hoverIntent', $git_path . 'assets/js/vendor/jquery.hoverIntent.minified', 3, false, array());
	electron_enqueue_script('electron_megamenu', $git_path . 'assets/js/electron-megamenu.min', 3, false, array('jquery','hoverIntent'));
}

# Load megamenu scripts.
add_action( 'admin_enqueue_scripts', 'pmm_admin_enqueue', 5 );
function pmm_admin_enqueue() {
	//wp_register_script( 'proton-megamenu-admin', PROTON_EXT_URL . 'megamenu/js/proton-megamenu-admin.js', array( 'jquery' ), PROTON_VERSION , true );
	proton_enqueue_script( 'proton-megamenu-admin', $git_path . 'assets/js/proton-megamenu-admin.js', ELECTRON_VERSION , true );
}


?>
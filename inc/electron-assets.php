<?php

# Register Proton Core scripts.
//add_action( 'admin_enqueue_scripts', 'electron_admin_enqueue', 11 );
//add_action( 'admin_footer', 'electron_admin_lab', 5 );

# Load Proton Core scripts.
//add_action( 'wp_enqueue_scripts', 'electron_front_enqueue', 35 );
//add_action( 'wp_footer', 'electron_front_lab', 45 );

/**
 * Registers JavaScript files for the framework.  This function merely registers scripts with WordPress using
 * the wp_register_script() function.  It does not load any script files on the site.  If a theme wants to register
 * its own custom scripts, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @since  1.2.0
 * @access public
 * @return void
 */
function electron_admin_enqueue() {

	// Register the 'mobile-toggle' script'.

	//wp_enqueue_style( 'proton-admin-styles', ELECTRON_ASSETS_URL . 'css/proton-admin.css', false, PROTON_VERSION);
	//wp_enqueue_style( 'proton-themes', ELECTRON_ASSETS_URL . 'css/proton-themes.css', false, PROTON_VERSION);
	//wp_enqueue_style( 'proton-fontawesome', 	'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css', false, PROTON_VERSION);

	//wp_enqueue_script('wp-util');
	//wp_enqueue_script('backbone');
	//wp_enqueue_script( 'proton-framework', ELECTRON_ASSETS_URL . 'js/proton.init.min.js', array('backbone', 'jquery', 'wp-util', 'jquery-ui-tabs'), PROTON_VERSION  );

	//wp_localize_script( 'proton-framework', 'electron_var', array(
                 //   'electron_nonce' => wp_create_nonce( "PROTON" )
         //   ));


}



/**
 * Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function.
 *
 * @since  1.2.0
 * @access public
 * @return void
 */
function electron_front_enqueue() {
	// Load the comment reply script on singular posts with open comments if threaded comments are supported.
	wp_enqueue_style( 'fontawesome', 	'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css', false, ELECTRON_VERSION);
	//wp_enqueue_style( 'proton-lightgallery', 	ELECTRON_ASSETS_URL . 'css/lightgallery.min.css', false, PROTON_VERSION);
	//wp_enqueue_style( 'proton-lg-transitions', 	ELECTRON_ASSETS_URL . 'css/lg-transitions.min.css', false, PROTON_VERSION);


	//wp_localize_script( 'proton-framework', 'electron_var', array(
                 //   'electron_nonce' => wp_create_nonce( "PROTON" )
            //));
}

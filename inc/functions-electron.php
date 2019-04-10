<?php

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );
/*--- Enqueue scripts and styles --*/




/*-- Cleanup --*/


// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function disable_embeds_init() {

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

//add_action('init', 'disable_embeds_init', 9999);


// Show posts of 'post', 'page' and 'movie' post types on home page
//add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
	if ( is_category() && $query->is_main_query() || is_author() && $query->is_main_query())
		$query->set( 'post_type', array( 'post', 'newsy' ) );
	return $query;
}

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/*--- Head scripts ---*/

/* Load the framework theme header elements. */
add_action( 'wp_head',  'themeHeader' , 1 );
function themeHeader() {
		echo "\n\t\t" . '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">'."\n";
		echo "\n\t\t" . '<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>'."\n";
	}


/* Load the framework theme header elements. */
add_action( 'wp_head',  'themeFooter' , 1 );
function themeFooter() {
		echo '<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
		 http://chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->'."\n";
	}




/*--- Backend tweaks ---*/

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function electron_register_script($name, $path, $priority = 1, $fallback = false, $req = array()){
	if($fallback || !function_exists('proton_enqueue_script')){
		wp_register_script($name, $path.'.js', $req, ELECTRON_VERSION);
	}else{
		//proton_enqueue_script($name, $path, $order, $fallback, $req);
		\Proton\Loaders\Scripts::get_instance()->register($name, $path, $req, $priority);
	}
	return;
}

function electron_enqueue_script($name, $path, $priority = 1, $fallback = false, $req = array()){
	if($fallback || !function_exists('proton_enqueue_script')){
		wp_enqueue_script($name, $path.'.js', $req, ELECTRON_VERSION);
	}else{
		//proton_enqueue_script($name, $path, $order, $fallback, $req);
		\Proton\Loaders\Scripts::get_instance()->queue($name, $path, $req, $priority);
	}
	return;
}


function electron_register_style($name, $path, $priority = 1, $fallback = false, $req = array()){
	if($fallback || !function_exists('proton_enqueue_style')){
		wp_enqueue_style($name, $path.'.js', $req, ELECTRON_VERSION);
	}else{
		//proton_enqueue_script($name, $path, $order, $fallback, $req);
		\Proton\Loaders\Styles::get_instance()->register($name, $path, $req, $priority);
	}
	return;
}

function electron_enqueue_style($name, $path, $priority = 1, $fallback = false, $req = array()){
	if($fallback || !function_exists('proton_enqueue_style')){
		wp_enqueue_style($name, $path.'.js', $req, ELECTRON_VERSION);
	}else{
		//proton_enqueue_script($name, $path, $order, $fallback, $req);
		\Proton\Loaders\Styles::get_instance()->queue($name, $path, $req, $priority);
	}
	return;
}

?>
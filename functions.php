<?php

require_once( 'inc/electron.php');
function wpa54064_inspect_scripts() {
    global $wp_scripts;
    var_dump($wp_scripts);
    foreach( $wp_scripts->queue as $handle ) :
        echo $handle;
    endforeach;
}
//add_action( 'wp_print_scripts', 'wpa54064_inspect_scripts' );

//require_once( 'config.php');
require_once( get_stylesheet_directory().'/wpbakery.php');

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_template_directory() . '/static/no-timber.html';
	});

	return;
}


Timber::$dirname = array('templates', 'views');


class electronSite extends TimberSite {

	function __construct() {
		load_theme_textdomain( 'electron', TEMPLATEPATH . '/lang' );
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		add_theme_support( 'electron-menu', array(
												'primary' => __( 'Main menu', 'electron' ),
												'top' => __( 'Top menu', 'electron' ),
												'footer1' => __( 'Footer menu 1', 'electron' ),
												'footer2' => __( 'Footer menu 2', 'electron' ),
												'mobile' => __( 'Mobile menu', 'electron' )
											)
						);
		//add_theme_support( 'proton-core-menu-ext' , $menuboxes);
		add_theme_support( 'electron-sidebars', array("main_page", "menu_media", "menu_kontakt") );

		add_post_type_support( 'post', 'page-attributes' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 50,
				'width'       => 400,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
		$labels = array(
	        'name'                => _x( 'Artykuły', 'Post Type General Name', 'medpoint' ),
	        'singular_name'       => _x( 'Artykuł', 'Post Type Singular Name', 'medpoint' ),
	        'menu_name'           => __( 'Prasa', 'medpoint' ),
	        'parent_item_colon'   => __( 'Parent Blog', 'medpoint' ),
	        'all_items'           => __( 'Wszystkie artykuły', 'medpoint' ),
	        'view_item'           => __( 'Zobacz', 'medpoint' ),
	        'add_new_item'        => __( 'Dodaj nowy artykuł', 'medpoint' ),
	        'add_new'             => __( 'Dodaj nowy', 'medpoint' ),
	        'edit_item'           => __( 'Edytuj artykuł', 'medpoint' ),
	        'update_item'         => __( 'Uaktualnij artykuł', 'medpoint' ),
	        'search_items'        => __( 'Szukaj artykułów', 'medpoint' ),
	        'not_found'           => __( 'Nie znaleziono', 'medpoint' ),
	        'not_found_in_trash'  => __( 'Nie znaleziono w koszu', 'medpoint' ),
	    );

	// Set other options for Custom Post Type

	    $args = array(
	        'label'               => __( 'prasa', 'medpoint' ),
	        'description'         => __( 'Media o nas', 'medpoint' ),
	        'labels'              => $labels,
	        // Features this CPT supports in Post Editor
	        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	        // You can associate this CPT with a taxonomy or custom taxonomy.
	       // 'taxonomies'          => array( 'genres' ),
	        /* A hierarchical CPT is like Pages and can have
	        * Parent and child items. A non-hierarchical CPT
	        * is like Posts.
	        */
	        'hierarchical'        => false,
	        'public'              => true,
	        'show_ui'             => true,
	        'show_in_menu'        => true,
	        'show_in_nav_menus'   => true,
	        'show_in_admin_bar'   => true,
	        'menu_position'       => 5,
	        'can_export'          => true,
	        'has_archive'         => true,
	        'exclude_from_search' => false,
	        'publicly_queryable'  => true,
	        'capability_type'     => 'post',
	    );

	    // Registering your Custom Post Type
	    register_post_type( 'prasa', $args );
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['is_home'] = is_home();
		$context['is_front'] = is_front_page();

		$context['alltags'] = get_tags();

		if ( has_custom_logo() ){
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			$context['logo'] = $image[0];
		}else{
			get_stylesheet_directory_uri(). '/assets/images/logo.png';
		}

		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['primary_menu'] = new TimberMenu('primary');
		$context['top_menu'] = new TimberMenu('top');
		$context['mobile_menu'] = new TimberMenu('mobile');
		$context['site'] = $this;
		$img_height = 400 ;
		$context['img_sizes']['header_image'] = 	array(
									array('width' => '2560','height' => $img_height,'breakpoint' => '1920'),
									array('width' => '1920','height' => $img_height,'breakpoint' => '1440'),
									array('width' => '1440','height' => $img_height,'breakpoint' => '1200'),
									array('width' => '1200','height' => $img_height,'breakpoint' => '992'),
									array('width' => '992','height' => $img_height,'breakpoint' => '768'),
									array('width' => '767','height' => $img_height,'breakpoint' => '480'),
									array('width' => '480','height' => $img_height,'breakpoint' => '100')
								);
		$context['img_sizes']['oferta_box'] = array(
									 array('width' => '480','height' => '200'),
									 array('width' => '360','height' => '150','breakpoint' => '1200'),
									 array('width' => '550','height' => '195','breakpoint' => '992'),
									 array('width' => '450','height' => '160','breakpoint' => '768'),
									 array('width' => '710','height' => '180','breakpoint' => '480')
								 );
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}


	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new electronSite();

if ( ! function_exists ( 'generate_thumb_sizes' ) ) {
	function generate_thumb_sizes(){
		$context = Timber::get_context();
		foreach($context['img_sizes'] as $key => $sizes){
			foreach($sizes as $size){
				add_image_size( $key.'_'.$size['width'].'x'.$size['height'], $size['width'], $size['height'] );
			}
		}

	}
	generate_thumb_sizes();
}

/*---------------------*/
if ( ! function_exists ( 'page_bodyclass' ) ) {
	// add category nicenames in body and post class
	function page_bodyclass($classes) {  // add class to <body> tag
		global $wp_query, $post;
		if (is_front_page() ) {
	    	$classes[] = 'homepage';
		} elseif (is_page()) {
	   		$classes[] = $wp_query->query_vars["pagename"];
		}
		foreach((get_the_category($post->ID)) as $category){
			$classes[] = $category->category_nicename;
			}
		return $classes;
	}
	add_filter('body_class', 'page_bodyclass');
}

if ( ! function_exists ( 'category_id_class' ) ) {
	function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
			$classes[] = $category->category_nicename;
		return $classes;
	}
	add_filter('post_class', 'category_id_class');
}

if ( ! function_exists ( 'electron_enqueue_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'electron_enqueue_scripts',  99);
	function electron_enqueue_scripts() {
		$git_path = '//cdn.jsdelivr.net/gh/ibrythill/Electron/';
		wp_enqueue_style( 'electron-style', THEME_URL.'assets/css/electron.css', array(), ELECTRON_VERSION );
		if(is_child_theme()){ wp_enqueue_style( 'electron-child-style', get_stylesheet_uri(), array('electron-style'), ELECTRON_VERSION ); }
		else{electron_enqueue_style( 'electron-theme', THEME_URL.'assets/css/base.css', 1);}

		electron_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', 5);

		wp_enqueue_script('electron-init', $git_path.'assets/js/electron-init.min.js', array('jquery'), ELECTRON_VERSION);

		//electron_enqueue_style('webfont', THEME_URL.'assets/js/vendor/webfont-min.js', 5);

		$electron_vars = array(
	            'assets' => THEME_URL.'assets/',
	            'basejs' => wp_parse_url(THEME_URL)['path'].'assets/js/'
	    );
	    if(is_child_theme()){
	            $electron_vars['child_assets'] = get_stylesheet_directory_uri().'/assets/';
	            $electron_vars['child_js'] = get_stylesheet_directory_uri().'/assets/js/';
	    }

		wp_localize_script( 'electron-init', 'electron', $electron_vars);

		electron_enqueue_script('electron_main', $git_path.'assets/js/electron.min', 2, false, array('jquery','parallax'));


		//wp_enqueue_script('webfont-loader', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');

	}
}

// Load theme fonts
if ( ! function_exists ( 'load_google_fonts' ) ) {
	function load_google_fonts() {
	?>
		<script type="text/javascript">
			require(['https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'], function(WebFont) {
		    WebFont.load({
				google: {
					families: ['Poppins:200,400,500,700:latin,latin-ext']
				}
			});
		})

		</script>
	<?php
	}
	add_action('wp_print_footer_scripts', 'load_google_fonts', 21);
}

// add a favicon to your
/**
 * blog_favicon function.
 *
 * @access public
 * @return void
 */
if ( ! function_exists ( 'blog_favicon' ) ) {
	function blog_favicon() {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/favicon.ico" />';
		if(isiOS()){
		echo '<link rel="apple-touch-icon" sizes="57x57" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-57x57.png">';
		echo '<link rel="apple-touch-icon" sizes="60x60" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-60x60.png">';
		echo '<link rel="apple-touch-icon" sizes="72x72" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-72x72.png">';
		echo '<link rel="apple-touch-icon" sizes="76x76" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-76x76.png">';
		echo '<link rel="apple-touch-icon" sizes="114x114" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-114x114.png">';
		echo '<link rel="apple-touch-icon" sizes="120x120" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-120x120.png">';
		echo '<link rel="apple-touch-icon" sizes="144x144" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-144x144.png">';
		echo '<link rel="apple-touch-icon" sizes="152x152" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-152x152.png">';
		echo '<link rel="apple-touch-icon" sizes="180x180" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/apple-icon-180x180.png">';
		}
		if(isAndroidOS()){
		echo '<link rel="icon" type="image/png" sizes="192x192"  href="'. get_stylesheet_directory_uri() .'/assets/images/icons/android-icon-192x192.png">';
		echo '<link rel="icon" type="image/png" sizes="32x32" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/favicon-32x32.png">';
		echo '<link rel="icon" type="image/png" sizes="96x96" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/favicon-96x96.png">';
		echo '<link rel="icon" type="image/png" sizes="16x16" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/favicon-16x16.png">';
		}
		echo '<link rel="manifest" href="'. get_stylesheet_directory_uri() .'/assets/images/icons/manifest.json">';
		echo '<meta name="msapplication-TileColor" content="#d60469">';
		echo '<meta name="msapplication-TileImage" content="'. get_stylesheet_directory_uri() .'/assets/images/icons/ms-icon-144x144.png">';
		echo '<meta name="theme-color" content="#000000">';
	}
	add_action('wp_head', 'blog_favicon');
	add_action('admin_head', 'blog_favicon');
}


if ( ! function_exists ( 'lazy_image_content_filter' ) ) {
function lazy_image_content_filter($content) {
	$pattern = '/<img\s*(?:class\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|src\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|alt\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|width\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|height\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|srcset\s*\=\s*[\'\"](.*?)[\'\"].*?\s*)+(.*?)>/si';
	$pattern2 = '/(<\s*img[^>]+)(src\s*=\s*"([^"]+)")(src\s*=\s*"([^"]+)")([^>]+>)/i';
  //preg_match_all( $pattern, $content, $matches);
  //var_dump($matches);


  //$content = preg_replace( '/(<\s*img[^>])+class\s*=(\s*"[^"]+)"([^>]+>)/i', '$1 class="lazyload  $3', $content);
  //$content = preg_replace( $pattern, '<img class="$1 lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="$2" alt="$3" width="$4" height="$5" data-srcset="$6" $7>', $content);
  // otherwise returns the database content
  $html = str_get_html($content);

// Find all images
	//$html->find('div')->class = 'bar';
	//$html->find('img', 1)->class = 'bar';
	foreach($html->find('img') as $key => $element){
		$element->class = $element->class. ' lazyload';
		$element->setAttribute('data-src', $element->src);
		$element->setAttribute('data-srcset', $element->srcset);
		$element->removeAttribute('srcset');
		$element->src = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";

	}

	foreach($html->find('iframe') as $key => $element){
		$element->class = $element->class. ' lazyload';
		$element->setAttribute('data-src', $element->src);
		$element->removeAttribute('src');

	}

  return $html;
}

add_filter( 'the_content', 'lazy_image_content_filter', 99 );
}

function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );

?>
<?php
/* Basic WP SEO
	Optional: add custom description, keywords, and/or title
	to any post or page using these custom field keys:

		pro_seo_desc
		pro_seo_keywords
		pr_seo_title

	To migrate from any SEO plugin, replace its custom field 
	keys with those listed above. 
*/
function basic_wp_seo() {
	global $page, $paged, $post, $shortname;
	$default_keywords = get_option($shortname."_global_keywords"); // customize
	$output = '';

	// description
	$seo_desc = get_post_meta($post->ID, 'pro_seo_desc', true);
	$description = get_bloginfo('description', 'display');
	$pagedata = get_post($post->ID);
	if (is_singular()) {
		if (!empty($seo_desc)) {
			$content = $seo_desc;
		} else if (!empty($pagedata)) {
			$content = apply_filters('the_excerpt_rss', $pagedata->post_content);
			$content = substr(trim(strip_tags($content)), 0, 155);
			$content = preg_replace('#\n#', ' ', $content);
			$content = preg_replace('#\s{2,}#', ' ', $content);
			$content = trim($content);
		} 
	} else {
		$content = $description;	
	}
	$output .= "\n\t\t" . '<meta name="description" content="' . esc_attr($content) . '">' . "\n";

	// keywords
	$keys = get_post_meta($post->ID, 'pro_seo_keywords', true);
	$cats = get_the_category();
	$tags = get_the_tags();
	if (empty($keys)) {
		if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
		if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
		$keys .= $default_keywords;
	}
	$output .= "\t\t" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";

	// robots
	if (is_category() || is_tag()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($paged > 1) {
			$output .=  "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
		} else {
			$output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
		}
	} else if (is_home() || is_singular()) {
		$output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
	} else {
		$output .= "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
	}


	echo $output;
} 
add_action( 'wp_head',  'basic_wp_seo');
 
 
function pro_seo_title( $title, $sep ) {
	global $paged, $page, $post;
	
	// title
	$title_custom = get_post_meta($post->ID, 'pro_seo_title', true);
	$url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
	$name = get_bloginfo('name', 'display');
	$title = trim($title);
	$cat = single_cat_title('', false);
	$tag = single_tag_title('', false);
	$search = get_search_query();

	if (!empty($title_custom)) $title = $title_custom;
	if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Strona %s', max($paged, $page));
	else $page_number = '';

	if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $title;
	elseif (is_singular())            $seo_title = $title . ' | ' . $name;
	elseif (is_tag())                 $seo_title = 'Tag: ' . $tag . ' | ' . $name;
	elseif (is_category())            $seo_title = 'Kategoria: ' . $cat . ' | ' . $name;
	elseif (is_archive())             $seo_title = 'Archiwum: ' . $title . ' | ' . $name;
	elseif (is_search())              $seo_title = 'Wyszukiwanie: ' . $search . ' | ' . $name;
	elseif (is_404())                 $seo_title = '404 - Nie znaleziono: ' . $url . ' | ' . $name;
	else                              $seo_title = $name . ' | ' . $description;

	$title =   esc_attr($seo_title . $page_number);
	
	return $title;
	
}
add_filter( 'wp_title', 'pro_seo_title', 10, 2 );


add_action( 'wp_footer',  'pro_seo_footer');
function pro_seo_footer(){
global $shortname;
	$tracking = get_option($shortname."_google_analytics");
		if(!empty($tracking)) echo $tracking;
}

global $shortname;
add_filter('pro-meta', 'pro_seo_options');
function pro_seo_options($proton_metaboxes){
// proton Metabox Options
//global $post, $shortname;
//$proton_metaboxes = get_option($shortname.'_pro_meta_config');
$proton_metaboxes['seo'] = array();

        
        
        $proton_metaboxes['seo'][] = array(
            "name"  => "SEO",
            "icon"  => "sitemap",
            "label" => "",
            "type" => "tab",
            "desc" => ""
        );
        $proton_metaboxes['seo'][] = array(
	            "name"  => "pro_seo_title",
	            "std"  => "",
	            "label" => __("SEO Title:",'proton_framework'),
	            "type" => "text",
	            "desc" => __("Put new webpage title",'proton_framework')
            );
        $proton_metaboxes['seo'][] = array(
	            "name"  => "pro_seo_keywords",
	            "std"  => "",
	            "label" => __("META keyword:",'proton_framework'),
	            "type" => "text",
	            "desc" => __("Put in webpage META keywords",'proton_framework')
            );
        $proton_metaboxes['seo'][] = array(
	            "name"  => "pro_seo_desc",
	            "std"  => "",
	            "label" => __("META description:",'proton_framework'),
	            "type" => "textarea",
	            "desc" => __("Put in webpage META description",'proton_framework')
            );
return $proton_metaboxes;
//update_option($shortname.'_pro_meta_config',$proton_metaboxes); 
}

function add_seo_section($sections){
	global $shortname;
	
	//$sections = array();
	$sections[] = array(
				'title' => __('SEO', 'proton_framework'),
				'desc' => __('<p class="description">Here You can change your global SEO settings.</p>', 'proton_framework'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(ADMIN_URL).'img/glyphicons/glyphicons_254_fishes.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array(
					array(
						'id' => "google_auth", //must be unique
						'type' => 'text', //builtin fields include:
										  //text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
						'title' => __('Google auth','proton_framework'),
						'sub_desc' => __("Paste Google authentication key",'proton_framework'),
						'desc' => __("Paste Google authentication key",'proton_framework'),
						//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
						//'msg' => 'custom error message', //override the default validation error message for specific fields
						//'std' => '', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
						//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
						),
					array(
						'id' => "global_keywords", //must be unique
						'type' => 'text', //builtin fields include:
										  //text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
						'title' => __('Global Keywords','proton_framework'),
						'sub_desc' => __("Write your website keywords",'proton_framework'),
						'desc' => __("Write your website keywords",'proton_framework'),
						//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
						//'msg' => 'custom error message', //override the default validation error message for specific fields
						//'std' => '', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
						//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
						),
					array(
						'id' => "global_desc",
						'type' => 'textarea',
						'title' =>  __('Global description','proton_framework'), 
						'sub_desc' => __("Write your website description",'proton_framework'),
						'desc' => __("Write your website description",'proton_framework'),
						'validate' => 'no_html',
						'std' => ''
						),
					array(
						'id' => "google_analytics",
						'type' => 'textarea',
						'title' => __('Tracking Code','proton_framework'), 
						'sub_desc' => __('Paste Google Analytics (or other) tracking code here.','proton_framework'),
						'desc' => __('Paste Google Analytics (or other) tracking code here.','proton_framework'),
						'validate' => 'no_html',
						'std' => ''
						),
				)
				);
	
	return $sections;
	
}//function
global $shortname;
add_filter('nhp-opts-sections-'.$shortname, 'add_seo_section');

?>
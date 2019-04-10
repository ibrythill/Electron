<?php

//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => __("Image Header", ELECTRON_SLUG),
    "base" => "electron_image_header",
	'category' => 'Electron',
    //"as_parent" => array('only' => 'oferta_single, oferta_single2, staff_single, mp_price'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "number",
            "heading" => __("Element height", ELECTRON_SLUG),
            "param_name" => "eih_height",
            "value" => "240",
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("Set your element height in pixels", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", ELECTRON_SLUG),
            "param_name" => "eih_class",
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", ELECTRON_SLUG)
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Obrazek", ELECTRON_SLUG),
            "param_name" => "eih_img",
            "group" => __("Image", ELECTRON_SLUG),
            "description" => __("Ustaw obrazek boxa", ELECTRON_SLUG)
        ),

    ),
    "js_view" => 'VcColumnView'
) );

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_electron_image_header extends WPBakeryShortCodesContainer {
	    protected function content($atts, $content = null) {
			do_action('electron/shortcode/electron_image_header');

			$context = Timber::get_context();
			//$context = array_merge($context, $atts);

			$atts['eih_height'] = (array_key_exists('eih_height', $atts) ? $atts['eih_height'] : 240 ) ;
		    $img_height = (array_key_exists('eih_height', $atts) ? $atts['eih_height'] * 2 : 480 ) ;

		    $breakpoints = array();
		    foreach($context['img_sizes']['header_image'] as $size){
				$breakpoints[] = array('width' => $size['width'],'height' => $img_height,'breakpoint' => $size['breakpoint']);

			}

			$atts['eih_breakpoints'] = $breakpoints;
			$atts['content'] = do_shortcode( $content );

			return Timber::compile( 'shortcode-header-image.twig', $atts);
		}
    }
}


//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => __("Breadcrumbs", ELECTRON_SLUG),
    "base" => "electron_breadcrumbs",
	'category' => 'Electron',
    //"as_parent" => array('only' => 'oferta_single, oferta_single2, staff_single, mp_price'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "checkbox",
			"class" => "",
            "heading" => __("Show current page", ELECTRON_SLUG),
            "param_name" => "showcurrent",
			"value" => array( 'Show'=>true ),
            "std" => false,
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("Show current page title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Delimiter", ELECTRON_SLUG),
            "param_name" => "delimiter",
            "value" => ' &raquo; ',
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("Set your delimiter", ELECTRON_SLUG)
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Text align", ELECTRON_SLUG),
            "param_name" => "align",
            "description" => __("Set text align", "ELECTRON_SLUG"),
            "value" => array('left','center','right'),
            "group" => __("General", ELECTRON_SLUG),
            "std" => 'center'
        ),
        array(
            "type" => "textfield",
            "heading" => __("Home", ELECTRON_SLUG),
            "param_name" => "home",
            "value" => __( 'Home', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Category", ELECTRON_SLUG),
            "param_name" => "category",
            "value" => __( 'Archive by Category "%s"', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Taxonomy", ELECTRON_SLUG),
            "param_name" => "tax",
            "value" => __( 'Archive for "%s"', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Search", ELECTRON_SLUG),
            "param_name" => "search",
            "value" => __( 'Search Results for "%s" Query', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tag", ELECTRON_SLUG),
            "param_name" => "tag",
            "value" => __( 'Posts Tagged "%s"', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Author", ELECTRON_SLUG),
            "param_name" => "author",
            "value" => __( 'Articles Posted by %s', ELECTRON_SLUG ),
            "group" => __("Text", ELECTRON_SLUG),
            "description" => __("Set your title", ELECTRON_SLUG)
        )

    )
) );

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_electron_breadcrumbs extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			do_action('electron/shortcode/electron_breadcrumbs');

		    $defaults = array (
		 		'home'     	=> __( 'Home', ELECTRON_SLUG ), // text for the 'Home' link
				'category' 	=> __( 'Archive by Category "%s"', ELECTRON_SLUG ), // text for a category page
				'tax' 	  	=> __( 'Archive for "%s"', ELECTRON_SLUG ), // text for a taxonomy page
				'search'   	=> __( 'Search Results for "%s" Query', ELECTRON_SLUG ), // text for a search results page
				'tag'     	=> __( 'Posts Tagged "%s"', ELECTRON_SLUG ), // text for a tag page
				'author'   	=> __( 'Articles Posted by %s', ELECTRON_SLUG ), // text for an author page
				'404'      	=> __( 'Error 404', ELECTRON_SLUG ), // text for the 404 page

		 		'showcurrent' => 1,
		 		'showOnHome' => 1,
		 		'delimiter' => ' &raquo; ',
		 		'before' => '<span class="current">',
		 		'after' => '</span>',
		 		'align' => 'center'
			);

			// Parse incoming $args into an array and merge it with $defaults
			$args = wp_parse_args( $atts, $defaults );

			$showCurrent = $args['showcurrent']; // 1 - show current post/page title in breadcrumbs, 0 - don't show
			$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
			$delimiter   = $args['delimiter']; // delimiter between crumbs
			$before      = $args['before']; // tag before the current crumb
			$after       = $args['after']; // tag after the current crumb
			/* === END OF OPTIONS === */

			global $post;
			$homeLink = get_bloginfo('url') . '/';
			$linkBefore = '<span typeof="v:Breadcrumb">';
			$linkAfter = '</span>';
			$linkAttr = ' rel="v:url" property="v:title"';
			$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

			$output = '';

			if (is_home() || is_front_page()) {

				if ($showOnHome == 1) $output .= '<div id="crumbs" style="text-align:'.$args['align'].'"><a href="' . $homeLink . '">' . $args['home'] . '</a></div>';

			} else {

				$output .= '<div id="crumbs" style="text-align:'.$args['align'].'" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $args['home']) . $delimiter;


				if ( is_category() ) {
					$thisCat = get_category(get_query_var('cat'), false);
					if ($thisCat->parent != 0) {
						$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
						$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
						$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
						$output .= $cats;
					}
					$output .= $before . sprintf($args['category'], single_cat_title('', false)) . $after;

				} elseif( is_tax() ){
					$thisCat = get_category(get_query_var('cat'), false);
					if ($thisCat->parent != 0) {
						$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
						$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
						$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
						$output .= $cats;
					}
					$output .= $before . sprintf($args['tax'], single_cat_title('', false)) . $after;

				}elseif ( is_search() ) {
					$output .= $before . sprintf($args['search'], get_search_query()) . $after;

				} elseif ( is_day() ) {
					$output .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
					$output .= sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
					$output .= $before . get_the_time('d') . $after;

				} elseif ( is_month() ) {
					$output .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
					$output .= $before . get_the_time('F') . $after;

				} elseif ( is_year() ) {
					$output .= $before . get_the_time('Y') . $after;

				} elseif ( is_single() && !is_attachment() ) {
					if ( get_post_type() != 'post' ) {
						$post_type = get_post_type_object(get_post_type());
						$slug = $post_type->rewrite;
						printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
						if ($showCurrent == 1) $output .= $delimiter . $before . get_the_title() . $after;
					} else {
						$cat = get_the_category(); $cat = $cat[0];
						$cats = get_category_parents($cat, TRUE, $delimiter);
						if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
						$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
						$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
						$output .= $cats;
						if ($showCurrent == 1) $output .= $before . get_the_title() . $after;
					}

				} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
					$post_type = get_post_type_object(get_post_type());
					$output .= $before . $post_type->labels->singular_name . $after;

				} elseif ( is_attachment() ) {
					$parent = get_post($post->post_parent);
					$cat = get_the_category($parent->ID); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					$output .= $cats;
					printf($link, get_permalink($parent), $parent->post_title);
					if ($showCurrent == 1) $output .= $delimiter . $before . get_the_title() . $after;

				} elseif ( is_page() && !$post->post_parent ) {
					if ($showCurrent == 1) $output .= $before . get_the_title() . $after;

				} elseif ( is_page() && $post->post_parent ) {
					$parent_id  = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						$output .= $breadcrumbs[$i];
						if ($i != count($breadcrumbs)-1) $output .= $delimiter;
					}
					if ($showCurrent == 1) $output .= $delimiter . $before . get_the_title() . $after;

				} elseif ( is_tag() ) {
					$output .= $before . sprintf($args['tag'], single_tag_title('', false)) . $after;

				} elseif ( is_author() ) {
			 		global $author;
					$userdata = get_userdata($author);
					$output .= $before . sprintf($args['author'], $userdata->display_name) . $after;

				} elseif ( is_404() ) {
					$output .= $before . $args['404'] . $after;
				}

				if ( get_query_var('paged') ) {
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ' (';
					$output .= __('Page') . ' ' . get_query_var('paged');
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ')';
				}

				$output .= '</div>';
				return $output;
			}
		}
    }
}

vc_map( array(
    "name" => __("Selective container", ELECTRON_SLUG),
    "base" => "selective_container",
	'category' => 'Electron',
    //"as_parent" => array('only' => 'oferta_single, oferta_single2, staff_single, mp_price'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "checkbox",
			"class" => "",
            "heading" => __("Show on desktop", ELECTRON_SLUG),
            "param_name" => "show_desktop",
			"value" => array( 'Show'=>true ),
            "std" => false,
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("Show content on desktop", ELECTRON_SLUG)
        ),
        array(
            "type" => "checkbox",
			"class" => "",
            "heading" => __("Show on mobile", ELECTRON_SLUG),
            "param_name" => "show_mobile",
			"value" => array( 'Show'=>true ),
            "std" => false,
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("Show content on mobile", ELECTRON_SLUG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", ELECTRON_SLUG),
            "param_name" => "el_class",
            "group" => __("General", ELECTRON_SLUG),
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", ELECTRON_SLUG)
        )
    ),
    "js_view" => 'VcColumnView'
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_selective_container extends WPBakeryShortCodesContainer {
	    protected function content($atts, $content = null) {
			do_action('electron/shortcode/selective_container');

			if($atts["show_desktop"] && $atts["show_mobile"] ){
				$output = '<div class="selective-container">';
				$output .= do_shortcode( $content );
				$output .= '</div>';
			}elseif($atts["show_desktop"]){
				if(!isMobile()){
					$output = '<div class="selective-container hidden-xs hidden-sm">';
					$output .= do_shortcode( $content );
					$output .= '</div>';
				}
			}else{
				if(isMobile()){
					$output = '<div class="selective-container hidden-md hidden-lg hidden-xl">';
					$output .= do_shortcode( $content );
					$output .= '</div>';
				}
			}

			return $output;
		}
    }
}


?>
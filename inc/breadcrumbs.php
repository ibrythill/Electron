<?php
// File Security Check
if ( ! defined( 'PROTON_VERSION' ) ) exit;

if(!function_exists('proton_simple_breadcrumb')):
function proton_simple_breadcrumb() {
  if(!is_home()) {
    echo '<ol class="breadcrumb">';
    $front_page_id = get_option( 'page_on_front' );
    if($front_page_id){
	    echo '<li><a href="'.get_option('home').'">'.get_the_title($front_page_id) .'</a></li>';
    }else{
	    echo '<li><a href="'.get_option('home').'">'.__( 'Home', ELECTRON_SLUG ) .'</a></li>';
    }
    if (is_single()) {
      echo '<li>';
      the_category(', ');
      echo '</li>';
      if (is_single()) {
        echo '<li class="active">';
        the_title();
        echo '</li>';
      }
    } elseif (is_category()) {
      echo '<li class="active">';
      single_cat_title();
      echo '</li>';
    } elseif (is_page() && (!is_front_page())) {
      echo '<li class="active">';
      the_title();
      echo '</li>';
    } elseif (is_tag()) {
      echo '<li class="active">'.__( 'Tag:', ELECTRON_SLUG ) .' ';
      single_tag_title();
      echo '</li>';
    } elseif (is_day()) {
      echo'<li class="active">'.__( 'Archive for', ELECTRON_SLUG ) .' ';
      the_time('F jS, Y');
      echo'</li>';
    } elseif (is_month()) {
      echo'<li class="active">'.__( 'Archive for', ELECTRON_SLUG ) .' ';
      the_time('F, Y');
      echo'</li>';
    } elseif (is_year()) {
      echo'<li class="active">'.__( 'Archive for', ELECTRON_SLUG ) .' ';
      the_time('Y');
      echo'</li>';
    } elseif (is_author()) {
      echo'<li class="active">'.__( 'Author Archives', ELECTRON_SLUG ) .'';
      echo'</li>';
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
      echo '<li class="active">'.__( 'Blog Archives', ELECTRON_SLUG ) .'';
      echo'</li>';
    } elseif (is_search()) {
      echo'<li class="active">'.__( 'Search Results', ELECTRON_SLUG ) .'';
      echo'</li>';
    }
    echo '</ol>';
  }
}
endif;

if(!function_exists('electron_breadcrumb')):
function electron_breadcrumb(){
  /* === OPTIONS === */
	$text['home']     = __( 'Home', ELECTRON_SLUG ); // text for the 'Home' link
	$text['category'] = __( 'Archive by Category "%s"', ELECTRON_SLUG ); // text for a category page
	$text['tax'] 	  = __( 'Archive for "%s"', ELECTRON_SLUG ); // text for a taxonomy page
	$text['search']   = __( 'Search Results for "%s" Query', ELECTRON_SLUG ); // text for a search results page
	$text['tag']      = __( 'Posts Tagged "%s"', ELECTRON_SLUG ); // text for a tag page
	$text['author']   = __( 'Articles Posted by %s', ELECTRON_SLUG ); // text for an author page
	$text['404']      = __( 'Error 404', ELECTRON_SLUG ); // text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' &raquo; '; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$homeLink = get_bloginfo('url') . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;


		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

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
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div>';

	}
} // end proton_breadcrumbs()
endif;

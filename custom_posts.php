<?php
/*
custom post

query_posts(array('post_type' => array('post', 'movies')));

or

global $wp_query;
$wp_query = new WP_Query("post_type=property&post_status=publish&posts_per_page=5");


$args = array( 'post_type' => 'product', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	the_title();
	echo '<div class="entry-content">';
	the_content();
	echo '</div>';
endwhile;




// Show posts of 'post', 'page' and 'movie' post types on home page
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'page', 'movie' ) );
	return $query;
}

*/

function custom_post(){


register_post_type('sluzby', array(
	'labels' => array(
    'name' => _x('Służby', 'post type general name'),
    'singular_name' => _x('Służba', 'post type singular name'),
    'add_new' => _x('Dodaj służbę', 'book'),
    'add_new_item' => __('Dodaj nową służbę'),
    'edit_item' => __('Edytuj służbę'),
    'new_item' => __('Nowa służba'),
    'all_items' => __('Wszystkie służby'),
    'view_item' => __('Zobacz służbę'),
    'search_items' => __('Przeszukuj służby'),
    'not_found' =>  __('Nie znaleziono'),
    'not_found_in_trash' => __('Pusto'),
    'parent_item_colon' => '',
    'menu_name' => 'Służby'

  ),
	'public' => true,
	'show_ui' => true,
	'menu_position' => 5,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => true,
	'query_var' => false,
	'supports' => array('title','editor','thumbnail', 'protonthemes-settings'),
	'capabilities' => array(
        'edit_post' => 'edit_admin',
        'edit_posts' => 'edit_admin_m',
        'edit_others_posts' => 'edit_other_admin_m',
        'publish_posts' => 'publish_admin_m',
        'read_post' => 'read_admin',
        'read_private_posts' => 'read_private_admin_m',
        'delete_post' => 'delete_admin',
		'delete_posts' => 'delete_admin_m',
		'delete_others_posts' => 'delete_others__admin_m',

    ),
    // as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly
    'map_meta_cap' => true
));







register_post_type('cytat', array(
	'labels' => array(
    'name' => _x('Cytaty', 'post type general name'),
    'singular_name' => _x('Cytat', 'post type singular name'),
    'add_new' => _x('Dodaj cytat', 'book'),
    'add_new_item' => __('Dodaj nowy cytat'),
    'edit_item' => __('Edytuj cytat'),
    'new_item' => __('Nowy cytat'),
    'all_items' => __('Wszystkie cytaty'),
    'view_item' => __('Zobacz cytat'),
    'search_items' => __('Przeszukuj cytaty'),
    'not_found' =>  __('Nie znaleziono'),
    'not_found_in_trash' => __('Pusto'),
    'parent_item_colon' => '',
    'menu_name' => 'Cytaty'

  ),
	'public' => true,
	'show_ui' => true,
	'menu_position' => 5,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => true,
	'query_var' => false,
	'supports' => array('title','editor', 'protonthemes-settings'),
	'capabilities' => array(
        'edit_post' => 'edit_admin',
        'edit_posts' => 'edit_admin_m',
        'edit_others_posts' => 'edit_other_admin_m',
        'publish_posts' => 'publish_admin_m',
        'read_post' => 'read_admin',
        'read_private_posts' => 'read_private_admin_m',
        'delete_post' => 'delete_admin',
		'delete_posts' => 'delete_admin_m',
		'delete_others_posts' => 'delete_others__admin_m',

    ),
    // as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly
    'map_meta_cap' => true
));


//add_rewrite_rule( 'promo/?$', '?post_type=promo', 'top' );


}
//add_action( 'init', 'custom_post' );

function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_admin' );
    $admins->add_cap( 'edit_admin_m' );
    $admins->add_cap( 'edit_other_admin_m' );
    $admins->add_cap( 'publish_admin_m' );
    $admins->add_cap( 'read_admin' );
    $admins->add_cap( 'read_private_admin_m' );
    $admins->add_cap( 'delete_admin' );
    $admins->add_cap( 'delete_admin_m' );
    $admins->add_cap( 'delete_others__admin_m' );
}
add_action( 'admin_init', 'add_theme_caps');

// Add to admin_init function
add_filter('manage_edit-galeria_columns', 'add_new_slajdy_columns');
add_filter('manage_edit-promo_columns', 'add_new_promo_columns');
add_filter('manage_edit-cennik_columns', 'add_new_slajdy_columns');
function add_new_slajdy_columns($gallery_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';

    $new_columns['title'] = __('Title');
    $new_columns['images'] = __('Images');
    $new_columns['category'] = __('Categories');
    $new_columns['post_tags'] = __('Tags');
    $new_columns['author'] = __('Author');


    $new_columns['date'] = _x('Date', 'column name');

    return $new_columns;
}
function add_new_promo_columns($gallery_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';

    $new_columns['title'] = __('Title');
    $new_columns['images'] = __('Images');
    $new_columns['category'] = __('Categories');
    $new_columns['author'] = __('Author');


    $new_columns['date'] = _x('Date', 'column name');

    return $new_columns;
}
// Add to admin_init function
add_action('manage_galeria_posts_custom_column', 'manage_slajdy_columns', 10, 2);
add_action('manage_promo_posts_custom_column', 'manage_promo_columns', 10, 2);
add_action('manage_cennik_posts_custom_column', 'manage_slajdy_columns', 10, 2);

function manage_slajdy_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'id':
        echo $id;
            break;

    case 'images':
        if(get_post_thumbnail_id($id)!=''){
			$bodyclass1 = wp_get_attachment_image_src( get_post_thumbnail_id($id) ,'medium');	pro_thumbnail('preview='.$bodyclass1[0].'&width=269&height=100&alt=Galeria');
			}
        break;
    case 'category':
    	$categories = get_the_category($id);
		$separator = ' ';
		$output = '';
		if($categories){
				foreach($categories as $category) {
					$output .= '<a href="edit.php?category_name='.$category->category_nicename.'&post_type=newsy">'.$category->cat_name.'</a>'.$separator;
				}
			echo trim($output, $separator);
			}
    	break;
    case 'post_tags':
    	$categories = wp_get_post_tags( $id );
		$separator = ' ';
		$output = '';
		if($categories){
				foreach($categories as $category) {
					$output .= '<a href="edit.php?tag='.$category->slug.'&post_type=newsy">'.$category->name.'</a>'.$separator;
				}
			echo trim($output, $separator);
			}
    	break;
    default:
        break;
    } // end switch
}

function manage_promo_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'id':
        echo $id;
            break;

    case 'images':
        if(get_post_thumbnail_id($id)!=''){
			$bodyclass1 = wp_get_attachment_image_src( get_post_thumbnail_id($id) ,'medium');	pro_thumbnail('preview='.$bodyclass1[0].'&width=269&height=100&alt=Galeria');
			}
        break;
    case 'category':
    	$categories = wp_get_post_terms($id, 'rodzaj', array("fields" => "all"));;
		$separator = ' ';
		$output = '';
		if($categories){
				foreach($categories as $category) {
					$output .= ''.$category->name.$separator;
				}
			echo trim($output, $separator);
			}
    	break;
    default:
        break;
    } // end switch
}

//add_filter('manage_users_columns', 'pippin_add_user_id_column');
function pippin_add_user_id_column($columns) {
    $columns['avatar'] = 'Avatar';
    return $columns;
}

//add_action('manage_users_custom_column',  'pippin_show_user_id_column_content', 10, 3);
function pippin_show_user_id_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
	if ( 'username' == $column_name )
		return pro_thumbnail('echo=0&preview='.get_user_meta( $user_id, 'userphoto', true ).'&height=50&width=50');
    return $value;
}

function remove_avatar_from_users_list( $avatar, $id_or_email) {
    if (is_admin()) {
        global $current_screen;
        if ( $current_screen->base == 'users' ) {
            $avatar = pro_thumbnail('echo=0&preview='.get_user_meta( $id_or_email, 'userphoto', true ).'&height=50&width=50');
        }
    }
    return $avatar;
}
add_filter( 'get_avatar', 'remove_avatar_from_users_list', 10, 2 );


/*
taxonomies

Taxonomy Cloud
wp_tag_cloud( array( 'taxonomy' => 'taxonomy_name_1','taxonomy_name_2' ) );

---
Custom Taxonomy Query
$args = array(
    'tax_query' => array(
        'taxonomy' => 'movie_genre',
        'field' => 'slug',
        'terms' => 'comedy'
        )
);
query_posts( $args );

----
Custom Taxonomy Lists
the_terms( $post->ID, '{taxonomy name}', '{Displayed Title}: ', ', ', ' ' );
*/



function custom_taxonomy() {
   $labels = array(
    'name' => _x( 'Województwo', 'taxonomy general name' ),
    'singular_name' => _x( 'Województwo', 'taxonomy singular name' ),
    'search_items' =>  __( 'Szukaj województwa' ),
    'all_items' => __( 'Wszystkie' ),
    'parent_item' => __( 'Nadzrzedne' ),
    'parent_item_colon' => __( 'Nadzrzedne:' ),
    'edit_item' => __( 'Edytuj województwo' ),
    'update_item' => __( 'Uaktualnij województwo' ),
    'add_new_item' => __( 'Dodaj nowe województwo' ),
    'new_item_name' => __( 'Nazwa nowego woj.' ),
    'menu_name' => __( 'Województwo' ),
  );

  register_taxonomy('wojewodztwa',array('programy'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'wojewodztwo' ),
  ));

     $labels = array(
    'name' => _x( 'Region', 'taxonomy general name' ),
    'singular_name' => _x( 'Region', 'taxonomy singular name' ),
    'search_items' =>  __( 'Szukaj regionu' ),
    'all_items' => __( 'Wszystkie' ),
    'parent_item' => __( 'Nadzrzedne' ),
    'parent_item_colon' => __( 'Nadzrzedne:' ),
    'edit_item' => __( 'Edytuj region' ),
    'update_item' => __( 'Uaktualnij region' ),
    'add_new_item' => __( 'Dodaj nowy region' ),
    'new_item_name' => __( 'Nazwa nowego regionu' ),
    'menu_name' => __( 'Region' ),
  );

  register_taxonomy('region',array('programy'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'wojewodztwo' ),
  ));

register_taxonomy_for_object_type( 'category', 'cennik' );
register_taxonomy_for_object_type( 'post_tag', 'newsy' );

  $labels = array(
    'name' => _x( 'Rodzaj', 'taxonomy general name' ),
    'singular_name' => _x( 'Rodzaj', 'taxonomy singular name' ),
    'search_items' =>  __( 'Szukaj' ),
    'all_items' => __( 'Wszystkie rodzaje' ),
    'parent_item' => __( 'Nadzrzedny rodzaj' ),
    'parent_item_colon' => __( 'Nadzrzedne:' ),
    'edit_item' => __( 'Edytuj rodzaj' ),
    'update_item' => __( 'Uaktualnij rodzaj' ),
    'add_new_item' => __( 'Dodaj nowy' ),
    'new_item_name' => __( 'Nazwa nowego rodzaju' ),
    'menu_name' => __( 'Rodzaj' ),
  );

  register_taxonomy('rodzaj',array('promo'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'rodzaj' ),
  ));
}

add_action( 'init', 'custom_taxonomy' );




/*metabox*/
/*
//add_action("admin_init", "admin_init");
   // add_action('save_post', 'save_price');

    function admin_init(){
        add_meta_box("cytaty-meta", "Opcje dodatkowe", "cytaty_options", "cytatys", "normal", "low");
    }

    function cytaty_options(){
        global $post;
        $custom = get_post_custom($post->ID);
        $cytat = $custom["autor"][0];
?>
    <label>Autor:</label><input style="width:90%;" name="autor" value="<?php echo $cytat; ?>" />
<?php
    }

function save_price(){
    global $post;
    update_post_meta($post->ID, "autor", $_POST["autor"]);
} */



?>
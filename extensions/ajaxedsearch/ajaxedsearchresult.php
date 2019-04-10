<?

require_once (dirname(__FILE__) .'./../../proton.core.php');
new Proton(); 
 
?>

<p id="searchresults">
<?php 

$search = $_POST["search"];

 $wyniki = array();
 $count = 0;
 $maxwynik = 10;
 global $wpdb;

    $request = "SELECT * FROM $wpdb->posts ";
    $request .= " WHERE post_content like '%$search%' ";
    $request .= " AND post_status='publish' ";
    //$request .= " ORDER BY $wpdb->postmeta.meta_value+0 DESC LIMIT $numberOf";
    $posts = $wpdb->get_results($request);

    foreach ($posts as $post) {
     $post_title = stripslashes($post->post_title);
     $permalink = get_permalink($post->ID);
     $theid = $post->ID;
     $post_content = stripslashes($post->post_content);
     $post_category = get_the_category( $theid );
     if(empty($post_category)){
	     $post_category[0]->cat_name = 'Strony';
     }
     
     $wyniki[$post_category[0]->cat_name][$theid] = $post_content;
    }

		foreach ($wyniki as $key => $wynik) {
			if($count<=$maxwynik){
			
				// Get the ID of a given category
			    $category_id = get_cat_ID($key);
			
			    // Get the URL of this category
			    $category_link = get_category_link( $category_id );
			?>
			  
			  <span class="scategory"><a href="<?php echo $category_link ?>"><?php echo $key ?></a></span>
			  <?
			  foreach ($wynik as $key2 => $wynik2) {
			  if($count<=$maxwynik){
			  ?>
					      <a class="block" href="<?php echo get_permalink($key2) ?>">
							 <?php pro_post_thumbnail('id='.$key2.'&width=46&height=46&alt='.get_the_title().'&title='.get_the_title() );  ?>
					         <span class="searchheading"><? echo get_the_title($key2); ?></span>
					         <span><? echo strip_tags(string_limit_words($wynik2,15)); ?></span>
					      </a>
			  <?
			  $count++;
				
				}}
			}
		}

?>

<!-- more categories -->
		   <span class="seperator">
		      <a href="<? bloginfo('url') ?>/?s=<? echo $search; ?>"><? __('More results','proton_framework') ?></a>
		   </span>
		</p>
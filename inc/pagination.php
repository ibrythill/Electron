<?php
// File Security Check
if ( ! defined( 'PROTON_VERSION' ) ) exit;

if(!function_exists('proton_pagination')):
function proton_pagination($query = null, $range = 4) {
    global $paged, $wp_query;

    $q = $query == null ? $wp_query : $query;

    // How much pages do we have?
    if ( !isset($max_page) ) {
        $max_page = $q->max_num_pages;
    }

    // We need the pagination only if there is more than 1 page
    if ( $max_page > 1 ) {
        if ( !$paged ) $paged = 1;

        echo '<ul class="pagination">';

        // To the previous page
        if($paged > 1)
            echo '<li><a class="prev-page-link" href="' . get_pagenum_link($paged-1) . '">&laquo;</a></li>';

        if ( $max_page > $range + 1 ) :
            if ( $paged >= $range ) echo '<li><a href="' . get_pagenum_link(1) . '">1</a></li>';
            if ( $paged >= ($range + 1) ) echo '<li><span class="page-numbers">&hellip;</span></li>';
        endif;

        // We need the sliding effect only if there are more pages than is the sliding range
        if ( $max_page > $range ) {
            // When closer to the beginning
            if ( $paged < $range ) {
                for ( $i = 1; $i <= ($range + 1); $i++ ) {
                    echo ( $i != $paged ) ? '<li><a href="' . get_pagenum_link($i) .'">'.$i.'</a></li>' : '<li class="active"><span class="active">'.$i.'</span></li>';
                }
                // When closer to the end
            } elseif ( $paged >= ($max_page - ceil(($range/2))) ) {
                for ( $i = $max_page - $range; $i <= $max_page; $i++ ) {
                    echo ( $i != $paged ) ? '<li><a href="' . get_pagenum_link($i) .'">'.$i.'</a></li>' : '<li class="active"><span class="active">'.$i.'</span></li>';
                }
                // Somewhere in the middle
            } elseif ( $paged >= $range && $paged < ($max_page - ceil(($range/2))) ) {
                for ( $i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++ ) {
                    echo ($i != $paged) ? '<li><a href="' . get_pagenum_link($i) .'">'.$i.'</a></li>' : '<li class="active"><span class="active">'.$i.'</span></li>';
                }
            }
            // Less pages than the range, no sliding effect needed
        } else {
            for ( $i = 1; $i <= $max_page; $i++ ) {
                echo ($i != $paged) ? '<li><a href="' . get_pagenum_link($i) .'">'.$i.'</a></li>' : '<li class="active"><span class="active">'.$i.'</span></li>';
            }
        }
        if ( $max_page > $range + 1 ) :
            // On the last page, don't put the Last page link
            if ( $paged <= $max_page - ($range - 1) ) echo '<li><span class="page-numbers">&hellip;</span><a href="' . get_pagenum_link($max_page) . '">' . $max_page . '</a></li>';
        endif;

        // Next page
        if($paged < $max_page)
            echo '<li><a class="next-page-link" href="' . get_pagenum_link($paged+1) . '">&raquo;</a></li>';

        echo '</ul><!-- post-pagination -->';
    }
}
endif;
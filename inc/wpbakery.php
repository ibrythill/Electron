<?php


//Backend visual composer add-on code
/*
vc_map(array(
  'name' => 'Accordions',
  'base' => 'maxima_accordion',
  'category' => 'MedPoint',
  'params' => array(
    array(
      'type' => 'textfield',
      'name' => __('Title', 'rrf-maxima'),
      'holder' => 'div',
      'heading' => __('Title', 'rrf-maxima'),
      'param_name' => 'title',
    ),
    array(
      'type' => 'param_group',
      'param_name' => 'values',
      'params' => array(
        array(
          'type' => 'textfield',
          'name' => 'label',
          'heading' => __('Heading', 'rrf-maxima'),
          'param_name' => 'label',
        ),
        array(
          'type' => 'textarea',
          'name' => 'Content',
          'heading' => __('Content', 'rrf-maxima'),
          'param_name' => 'excerpt',
        )
      )

    ),
  ),

));


//shortcode



function maxima_accordion_shortcode($atts){
  extract(shortcode_atts(array(
    'title' => '',
    'values' => '',
  ), $atts));

  $list = '<h4>'.$title.'</h4>';


  $values = vc_param_group_parse_atts($atts['values']);

  $new_accordion_value = array();
  foreach($values as $data){
    $new_line = $data;
    $new_line['label'] = isset($new_line['label']) ? $new_line['label'] : '';
    $new_line['excerpt'] = isset($new_line['excerpt']) ? $new_line['excerpt'] : '';

    $new_accordion_value[] = $new_line;

  }

  $idd = 0;
  foreach($new_accordion_value as $accordion):
  $idd++;
    $list .=
    '<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$idd.'">
						'.$accordion['label'].'
						<span class="fa fa-plus"></span>
						</a>
					</h4>
				</div>
				<div id="collapse'.$idd.'" class="panel-collapse collapse">
					<div class="panel-body">
						<p>'.$accordion['excerpt'].'</p>
					</div>
				</div>
			</div>';

  endforeach;
  return $list;
  wp_reset_query();

}
add_shortcode('maxima_accordion', 'maxima_accordion_shortcode');
*/

//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => __("MedPoint", "electron"),
    "base" => "oferta_container",
	'category' => 'MedPoint',
    "as_parent" => array('only' => 'oferta_single, oferta_single2, staff_single, mp_price'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "electron"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "electron")
        )
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name" => __("Oferta Box", "electron"),
    "base" => "oferta_single",
	'category' => 'MedPoint',
    "content_element" => true,
    "as_child" => array('only' => 'oferta_container'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Tytuł", "electron"),
            "param_name" => "os_title",
            'holder' => 'div',
            "description" => __("Ustaw tytuł boxa", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Obrazek", "electron"),
            "param_name" => "os_img",
            "description" => __("Ustaw obrazek boxa", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Ikona obrazek", "electron"),
            "param_name" => "os_icon_img",
            "description" => __("Ustaw obrazek jako ikonę boxa", "electron")
        ),
        array(
            "type" => "vc_link",
            "heading" => __("Link", "electron"),
            "param_name" => "os_link",
            "description" => __("Ustaw link boxa", "electron")
        )
    )
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_oferta_container extends WPBakeryShortCodesContainer {
	    protected function content($atts, $content = null) {


			$output = '<div class="row top-xs mt30 medpoint-container">';
			$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_oferta_single extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			/*extract(shortcode_atts(array(
			'os_title' 		=> '',
			'os_img' 		=> '',
			'os_icon' 		=> '',
			'os_icon_img' 	=> '',
			'os_link' 		=> ''
			), $atts));*/
			$context = Timber::get_context();
			$context = array_merge($context, $atts);
			return Timber::compile( 'shortcode-oferta.twig', $context);

			//return $output;
		}
    }
}

vc_map( array(
    "name" => __("Oferta Box 2", "electron"),
    "base" => "oferta_single2",
    "show_settings_on_create" => true,
	'category' => 'MedPoint',
    "content_element" => true,
    "as_child" => array('only' => 'oferta_container'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            'holder' => 'div',
            "heading" => __("Tytuł", "electron"),
            "param_name" => "os_title",
            "description" => __("Ustaw tytuł boxa", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Obrazek", "electron"),
            "param_name" => "os_img",
            "description" => __("Ustaw obrazek boxa", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Ikona obrazek", "electron"),
            "param_name" => "os_icon_img",
            "description" => __("Ustaw obrazek jako ikonę boxa", "electron")
        ),
        array(
            "type" => "vc_link",
            "heading" => __("Link", "electron"),
            "param_name" => "os_link",
            "description" => __("Ustaw link boxa", "electron")
        ),

	    array(
	      'type' => 'param_group',
	      'param_name' => 'os_subs',
	      'params' => array(
	        array(
	            "type" => "textfield",
	            "heading" => __("Tytuł", "electron"),
	            "param_name" => "title",
	            "description" => __("Ustaw tytuł", "electron")
	        ),

	        array(
	            "type" => "vc_link",
	            "heading" => __("Link", "electron"),
	            "param_name" => "link",
	            "description" => __("Ustaw link", "electron")
	        )
	      )

	    ),

    )
) );
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_oferta_single2 extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			/*extract(shortcode_atts(array(
			'os_title' 		=> '',
			'os_img' 		=> '',
			'os_icon' 		=> '',
			'os_icon_img' 	=> '',
			'os_link' 		=> ''
			), $atts));*/

			$context = Timber::get_context();
			$context = array_merge($context, $atts);
			return Timber::compile( 'shortcode-oferta2.twig', $context);

			//return $output;
		}
    }
}

vc_map( array(
    "name" => __("Lekarz Box", "electron"),
    "base" => "staff_single",
	'category' => 'MedPoint',
    "content_element" => true,
    "as_child" => array('only' => 'oferta_container'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Tytuł", "electron"),
            "param_name" => "os_title",
            'holder' => 'div',
            "description" => __("Ustaw tytuł boxa", "electron")
        ),
        array(
            "type" => "textfield",
            "heading" => __("nazwisko", "electron"),
            "param_name" => "os_name",
            'holder' => 'div',
            "description" => __("Ustaw imię i nazwisko", "electron")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Stanowisko", "electron"),
            "param_name" => "os_position",
            'holder' => 'div',
            "description" => __("Ustaw stanowisko", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Obrazek", "electron"),
            "param_name" => "os_img",
            "description" => __("Ustaw obrazek boxa", "electron")
        ),
        array(
            "type" => "vc_link",
            "heading" => __("Link", "electron"),
            "param_name" => "os_link",
            "description" => __("Ustaw link boxa", "electron")
        )
    )
) );

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_staff_single extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			/*extract(shortcode_atts(array(
			'os_title' 		=> '',
			'os_img' 		=> '',
			'os_icon' 		=> '',
			'os_icon_img' 	=> '',
			'os_link' 		=> ''
			), $atts));*/

			return Timber::compile( 'shortcode-staff.twig', $atts);

			//return $output;
		}
    }
}

vc_map( array(
    "name" => __("Icon Box", "electron"),
    "base" => "ec_icon_box",
	'category' => 'Electron',
    "content_element" => true,
    //"as_child" => array('only' => 'oferta_container'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Tytuł", "electron"),
            "param_name" => "os_title",
            'holder' => 'div',
            "description" => __("Ustaw tytuł boxa", "electron")
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Ikona obrazek", "electron"),
            "param_name" => "os_icon_img",
            "description" => __("Ustaw obrazek jako ikonę boxa", "electron")
        ),
        array(
            "type" => "vc_link",
            "heading" => __("Link", "electron"),
            "param_name" => "os_link",
            "description" => __("Ustaw link boxa", "electron")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Rozmiar", "electron"),
            "param_name" => "os_size",
            "description" => __("Ustaw wielkosc ikonki", "electron"),
            "value" => array('15','20','25','30','35','45','52'),
            "default" => 25
        )
    )
) );
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ec_icon_box extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			return Timber::compile( 'shortcode-iconbox.twig', $atts);
		}
    }
}

vc_map( array(
    "name" => __("Cennik", "electron"),
    "base" => "mp_price",
	'category' => 'MedPoint',
    "content_element" => true,
    "as_child" => array('only' => 'oferta_container'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Nazwa", "electron"),
            "param_name" => "mp_nazwa",
            'holder' => 'div',
            "description" => __("Ustaw nazwę", "electron")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Cena", "electron"),
            "param_name" => "mp_cena",
            'holder' => 'div',
            "description" => __("Ustaw cenę", "electron")
        )
    )
) );
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_mp_price extends WPBakeryShortCode {
	    protected function content($atts, $content = null) {
			return Timber::compile( 'shortcode-price.twig', $atts);
		}
    }
}

?>
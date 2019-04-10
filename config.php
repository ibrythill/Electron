<?php

function add_firma_section($sections){
	global $shortname;

	//$sections = array();
	$sections[] = array(
		'title' => __('Główna', 'proton-framework'),
		'desc' => __('<p class="description">Tutaj możesz zmienić ustawienia Slidera.</p>', 'proton-framework'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'el-icon-home',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(


			array(
				'id' => "slider",
				'title' => 'Slider',
				'type' => 'select',
				'data' => 'post',
				'multi' => true,
				'sortable' => true,
				'width' => 90,
				'sub_desc' => 'Wybierz elementy slidera.',
				'desc' => 'Wybierz jakie posty mają się wyświetlać w sliderze.',
				//'validate' => 'no_html',
				'std' => '0',
				'args' => array('post_type' => array('post','newsy'))//uses get_posts
			),
			array(
				'id'=>'link_fb',
				'type' => 'text',
				'title' => __('Link do facebooka', 'redux-framework-demo'),
				'subtitle' => __('Podaj adres strony.', 'redux-framework-demo'),
				'desc' => __('Podaj link do strony na facebooku.', 'redux-framework-demo'),
				'validate' => 'url',
				'default' => ''
				),

			array(
				'id'=>'link_tw',
				'type' => 'text',
				'title' => __('Link do twittera', 'redux-framework-demo'),
				'subtitle' => __('Podaj adres strony.', 'redux-framework-demo'),
				'desc' => __('Podaj link do profilu na twitterze.', 'redux-framework-demo'),
				'validate' => 'url',
				'default' => ''
				),

			array(
				'id'=>'link_pin',
				'type' => 'text',
				'title' => __('Link do pinterest', 'redux-framework-demo'),
				'subtitle' => __('Podaj adres strony.', 'redux-framework-demo'),
				'desc' => __('Podaj link do strony pinterest.', 'redux-framework-demo'),
				'validate' => 'url',
				'default' => ''
				),

			array(
				'id'=>'link_gp',
				'type' => 'text',
				'title' => __('Link do google+', 'redux-framework-demo'),
				'subtitle' => __('Podaj adres strony.', 'redux-framework-demo'),
				'desc' => __('Podaj link do strony google+.', 'redux-framework-demo'),
				'validate' => 'url',
				'default' => ''
				),


		)
	);

	$sections[] = array(
		'title' => __('Aktualności', 'proton-framework'),
		'desc' => __('<p class="description">Tutaj możesz zmienić ustawienia strony aktualności.</p>', 'proton-framework'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'el-icon-graph',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(


			array(
				'id' => "blok1",
				'title' => 'Blok nr 1',
				'type' => 'select',
				'data' => 'post',
				'sub_desc' => 'Wybierz zawartosc bloczku nr 1 na stronie aktualności.',
				'desc' => 'Wybierz zawartosc bloczku nr 1 na stronie aktualności.',
				//'validate' => 'no_html',
				'std' => '0',
				'args' => array('post_type' => array('newsy'))//uses get_posts
			),
			array(
				'id' => "blok2",
				'title' => 'Blok nr 2',
				'type' => 'select',
				'data' => 'post',
				'sub_desc' => 'Wybierz zawartosc bloczku nr 2 na stronie aktualności.',
				'desc' => 'Wybierz zawartosc bloczku nr 2 na stronie aktualności.',
				//'validate' => 'no_html',
				'std' => '0',
				//'args' => array('post_type' => array('post','newsy'))//uses get_posts
			),
			array(
				'id' => "blok3",
				'title' => 'Blok nr 3',
				'type' => 'select',
				'data' => 'post',
				'sub_desc' => 'Wybierz zawartosc bloczku nr 3 na stronie aktualności.',
				'desc' => 'Wybierz zawartosc bloczku nr 3 na stronie aktualności.',
				//'validate' => 'no_html',
				'std' => '0',
				'args' => array('post_type' => array('newsy'))//uses get_posts
			)
		)
	);


	$sections[] = array(
		'title' => __('Obrazki', 'proton-framework'),
		'desc' => __('<p class="description">W tej czesci mozesz zmienic ustawienia zdjec.</p>', 'proton-framework'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'el-icon-picture',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => "Info2",
				'type' => 'info',
				'title' =>  "Ustawienia obrazkow na stronie glownej",
				'sub_desc' => "W tej czesci mozesz zmienic ustawienia zdjec.",
				//'desc' => "Tutaj zmienisz ustawienia bloczków",
				//'validate' => 'no_html',
				'std' => ''
			),
			array(
				'id' => "inimwidth", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Szerokosc",
				'sub_desc' => "Zmien szerokosc obrazka",
				'desc' => "Zmien szerokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '185', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),
			array(
				'id' => "inimheight", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Wysokosc",
				'sub_desc' => "Zmien wysokosc obrazka",
				'desc' => "Zmien wysokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '92', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),

			array(
				'id' => "Info3",
				'type' => 'info',
				'title' =>  "Ustawienia obrazkow na podstronach",
				'sub_desc' => "W tej czesci mozesz zmienic ustawienia zdjec.",
				//'desc' => "Tutaj zmienisz ustawienia bloczków",
				//'validate' => 'no_html',
				'std' => ''
			),
			array(
				'id' => "pstimwidth", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Szerokosc",
				'sub_desc' => "Zmien szerokosc obrazka",
				'desc' => "Zmien szerokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '270', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),
			array(
				'id' => "pstimheight", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Wysokosc",
				'sub_desc' => "Zmien wysokosc obrazka",
				'desc' => "Zmien wysokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '180', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),

			array(
				'id' => "Info4",
				'type' => 'info',
				'title' =>  "Ustawienia obrazkow w kategoriach",
				'sub_desc' => "W tej czesci mozesz zmienic ustawienia zdjec.",
				//'desc' => "Tutaj zmienisz ustawienia bloczków",
				//'validate' => 'no_html',
				'std' => ''
			),
			array(
				'id' => "catimwidth", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Szerokosc",
				'sub_desc' => "Zmien szerokosc obrazka",
				'desc' => "Zmien szerokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '100', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),
			array(
				'id' => "catimheight", //must be unique
				'type' => 'text', //builtin fields include:
				//text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
				'title' => "Wysokosc",
				'sub_desc' => "Zmien wysokosc obrazka",
				'desc' => "Zmien wysokosc obrazka",
				//'options' => $zm_categoriesa,//Must provide key => value pairs for select options
				//'validate' => '', //builtin validation includes: email|html|html_custom|no_html|js|numeric|url
				//'msg' => 'custom error message', //override the default validation error message for specific fields
				'std' => '90', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
				//'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
			),
		)
	);

	return $sections;

}//function






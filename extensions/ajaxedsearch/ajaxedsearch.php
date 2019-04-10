<?php

class Ajaxedsearch extends Proton{
	
	 public function __construct( $pntrs = array() ) {
		 
		 add_filter('pro-gzip-css', array( &$this,'enqueue_css'));
		 add_filter('pro-gzip-js', array( &$this,'enqueue_js'));
		 add_filter('pro-compress-js', array( &$this,'add_scripts'));
	 }
	
	public function enqueue_css($files){
		$files[]= EXTENSIONS_URL . 'ajaxedsearch/ajaxedsearch.css';
		return $files;
	}
	
	public function enqueue_js($files){
		$files[]= EXTENSIONS_URL . 'ajaxedsearch/jquery.ajaxedsearch.js';
		return $files;
	}
	
	public function add_scripts($output){
		$pointers = EXTENSIONS_URL;
   
        $output .= '
           $("#s").ajaxedsearch({
			  sourcefile: "'.$pointers.'/ajaxedsearch/ajaxedsearchresult.php"
			});
		';
		return $output;

	}
	
}

$Ajaxedsearch = new Ajaxedsearch();

?>
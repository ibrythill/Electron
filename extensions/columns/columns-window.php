<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Duotive Shortcodes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		//GET THE CURRENT WORDPRESS INSTALL LOCATION
        $url_with_file = $_SERVER['HTTP_REFERER'];
        $file_pos = strpos($url_with_file,"/wp-admin");
        $url = substr($url_with_file, 0,$file_pos);
    ?>    
    <!-- GET THE NECESARY JAVASCRIPT AND CSS -->
    <link rel="stylesheet" type="text/css" href="../../duotive_shortcode_style.css" />
	<script language="javascript" type="text/javascript" src="<?php echo $url; ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $url; ?>/wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript" src="../../js/jquery.jqtransform.js"></script>    
	<script language="javascript" type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery("#shorcode-manager").jqTransform();
	});	
	function insertShortcode() {
		var columns_layouts_value = document.getElementById('columns_layouts').value;
		var shortcode_content = '';
		var shortcode_content1 = '<div class="row">';
		
		if (columns_layouts_value == 1)	shortcode_content = ' <div class="col-md-6"> content in here </div> <div class="col-md-6"> content in here </div> ';
		if (columns_layouts_value == 2)	shortcode_content = ' <div class="col-md-4"> content in here </div> <div class="col-md-4"> content in here </div> <div class="col-md-4"> content in here </div> ';		
		if (columns_layouts_value == 3)	shortcode_content = ' <div class="col-md-3"> content in here </div> <div class="col-md-3"> content in here </div> <div class="col-md-3"> content in here </div> <div class="col-md-3"> content in here </div> ';				
		if (columns_layouts_value == 4)	shortcode_content = ' <div class="col-md-6"> content in here </div> <div class="col-md-3"> content in here </div> <div class="col-md-3"> content in here </div> ';						
		if (columns_layouts_value == 5)	shortcode_content = ' <div class="col-md-3"> content in here </div> <div class="col-md-3"> content in here </div> <div class="col-md-6"> content in here </div> ';								
		if (columns_layouts_value == 6)	shortcode_content = ' <div class="col-md-8"> content in here </div> <div class="col-md-4"> content in here </div> ';
		if (columns_layouts_value == 7)	shortcode_content = ' <div class="col-md-4"> content in here </div> <div class="col-md-8"> content in here </div> ';	
		if (columns_layouts_value == 8)	shortcode_content = ' <div class="col-md-9"> content in here </div> <div class="col-md-3"> content in here </div> ';		
		if (columns_layouts_value == 9)	shortcode_content = ' <div class="col-md-3"> content in here </div> <div class="col-md-9"> content in here </div> ';
		
		shortcode_content2 = '</div>';						
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcode_content1+shortcode_content+shortcode_content2);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
</head>
<body>
	<form action="#">
        <h3 class="page-title">Content columns</h3>
		<div id="shorcode-manager">
        	<div class="table-row table-row-beforelast">    
                <label>Columns layouts:</label>
                <select id="columns_layouts">
                    <option value="1">2 x One-half</option>
                    <option value="2">3 x One-third</option>
                    <option value="3">4 x One-forth</option>
                    <option value="4">1 x One-half + 2 x One-forth</option>
                    <option value="5">2 x One-forth + 1 x One-half</option>
                    <option value="6">1 x Two-thirds + 1 x One-third</option>
                    <option value="7">1 x One-third + 1 x Two-thirds</option> 
                    <option value="8">1 x Three-forths + 1 x One-forth</option> 
                    <option value="9">1 x One-forth + 1 x Three-forths</option>                                         
                </select>
            </div>
            <div class="table-row table-row-last">            
                <input class="cancel" type="button" value="Close" onclick="tinyMCEPopup.close();" />
                <input type="submit" value="Insert" onclick="insertShortcode();" />                 
            </div>             
        </div>   
	</form>
</body>
</html>
<?php

?>

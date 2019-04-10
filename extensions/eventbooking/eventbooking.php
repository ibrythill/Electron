<?php
class ProtonEventBooking{

	function __construct(){

		$this->createtables();	
		add_shortcode( 'eveBook', array( &$this, 'proevb_shortcode') );
		
		add_filter('the_posts', array( &$this, 'proevb_scripts_and_styles')); // the_posts gets triggered before wp_head
		
		

	}
	
	
	function createtables(){
		global $wpdb;
		//*************create a ap_appointments table*************************
		$table_name = $wpdb->prefix . "pro_appointments";
		$appointments = "CREATE TABLE IF NOT EXISTS $table_name (
			`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`date` DATE NOT NULL ,
			`hours` VARCHAR( 30 ) NOT NULL ,
			`name` VARCHAR( 30 ) NOT NULL ,
			`email` VARCHAR( 256 ) NOT NULL ,
			`phone` BIGINT( 21 ) NOT NULL ,
			`note` LONGTEXT NOT NULL ,
			`status` VARCHAR( 10 ) NOT NULL  
			)";
		$wpdb->query($appointments);
		
		$table_name2 = $wpdb->prefix . "pro_appointments_archive";
		$appointments2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
			`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`date` DATE NOT NULL ,
			`hours` VARCHAR( 30 ) NOT NULL ,
			`name` VARCHAR( 30 ) NOT NULL ,
			`email` VARCHAR( 256 ) NOT NULL ,
			`phone` BIGINT( 21 ) NOT NULL ,
			`note` LONGTEXT NOT NULL ,
			`status` VARCHAR( 10 ) NOT NULL  
			)";
		$wpdb->query($appointments2);

	}
	
	function proevb_shortcode( $atts, $content = null ) {
	   extract( shortcode_atts( array(
	      'class' => 'caption',
	      ), $atts ) );
	   
	   return '<form action="" method="post" class="proevb-form" id="eventForm">
			<div class="proevb-datepick">
				<input id="picker_simple" name="proevb-date" class="datepicker validate[required]" type="text" readonly=""><br>
				<div id="result"></div>
				<div id="captchabox"><input type="text" name="proevb-captcha" value="" class="proevb-text proevb-captcha validate[required]" size="40"><img style="width:50%;" src="'.EXTENSIONS_URL.'eventbooking/captcha.php" id="captcha" /><a href="#captcha" id="change-image">Not readable? Change text.</a></div>
			</div>
			<div class="proevb-rightside">
				<fieldset class="proevb-hourpick">
					<legend>
						'.__('Hours','proton_framework').'
					</legend>
					<div id="proevb-hourload">
						'.__('Pick date','proton_framework').'
					</div>
					<div class="clear"></div>
				
				</fieldset>
				
				
				<p>'.__('Name','proton_framework'). __('(required)','proton_framework').'<br>
				    <input type="text" name="proevb-name" value="" class="proevb-text validate[required]" size="40"> </p>
				<p>'.__('E-mail','proton_framework'). __('(required)','proton_framework').'<br>
				    <input type="text" name="proevb-email" value="" class="proevb-text validate[required,custom[email]]" size="40"> </p>
				<p>'.__('Phone','proton_framework'). __('(required)','proton_framework').'<br>
				    <input type="text" name="proevb-telefon" value="" class="proevb-text validate[required,custom[phone]]" size="40"> </p>
				<p>'.__('Message','proton_framework').'<br>
				    <textarea name="proevb-message" class="wpcf7-form-control" cols="40" rows="5"></textarea> </p>

			</div>
			<div class="clear"></div>
			<input type="submit" value="'.__('Send','proton_framework').'" class="wpcf7-form-control  wpcf7-submit">
		</form>';
	}
	
	// [eveBook]


//conditional add something
//
//
//
//
//
	function proevb_scripts_and_styles($posts){
		if (empty($posts)) return $posts;
	 
		$shortcode_found = false; // use this flag to see if styles and scripts need to be enqueued
		foreach ($posts as $post) {
			if (stripos($post->post_content, '[eveBook]') !== false) {
				$shortcode_found = true; // bingo!
				break;
			}
		}
	 
		if ($shortcode_found) {
			
			//add_action('wp_head', 'generate_calendar');
			$this->proevb_scripts();
			// enqueue here
			add_action('wp_head', array( &$this, 'proevb_generate_form'));
		}
	 
		return $posts;
	}




	


	function proevb_scripts() {
	    
	    	
		wp_enqueue_style( 'eventbookingCSS', EXTENSIONS_URL.'eventbooking/css/eventbooking.css', 1, '2.1.0' );
		
		wp_enqueue_style( 'validationengineCSS', EXTENSIONS_URL.'eventbooking/css/validationEngine.jquery.css', 2, '2.1.0' );
		
		wp_enqueue_style( 'pickadateCSS', EXTENSIONS_URL.'eventbooking/css/pickadate.04.inline-fixed.css', 3, '2.1.0' );
		
		
		//js
		wp_enqueue_script('pickadateJS', EXTENSIONS_URL.'eventbooking/js/pickadate.min.js', 1, '2.1.0');
		
		wp_enqueue_script('validationenginePlJS', EXTENSIONS_URL.'eventbooking/js/jquery.validationEngine-pl.js', 1, '2.1.0');
		
		wp_enqueue_script('validationengineJS', EXTENSIONS_URL.'eventbooking/js/jquery.validationEngine.js', 1, '2.1.0');
		           
	}    
 


	function proevb_generate_form(){
	
	global $wpdb;
$table_name = $wpdb->prefix . "pro_appointments";
$pyt1 = "SELECT date FROM ".$table_name."";
$results1 = $wpdb->get_col($pyt1);

$daty = array();
$godziny = array();
$commahours;

if ( $results1 ){
	foreach ($results1 as $result1) {
		if(!in_array($result1, $daty)){$daty[] = $result1;}
	}
}
foreach ($daty as $data) {
	$pyt2 = "SELECT hours FROM ".$table_name." WHERE date='".$data."'  ";
	$results2 = $wpdb->get_col($pyt2);
	if ( $results2 ){
		foreach ($results2 as $result2) {
			$godziny[$data] .= $result2.',';
		}
	}
}
foreach ($godziny as $key => $godzina) {
	if(count(explode( ',', $godzina )) >= 4){
		$wypust .= '['.str_replace('-', ',', $key).'],'."\n";
	}
}


		?>
		<script>
		
			$(document).ready(function() {
			
				
				$.extend( $.fn.pickadate.defaults, {
				    monthsFull: [ 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' ],
				    monthsShort: [ 'sty', 'lut', 'mar', 'kwi', 'maj', 'cze', 'lip', 'sie', 'wrz', 'paź', 'lis', 'gru' ],
				    weekdaysFull: [ 'niedziela', 'poniedziałek', 'wtorek', 'środa', 'czwartek', 'piąąek', 'sobota' ],
				    weekdaysShort: [ 'N', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So' ],
				    today: 'dzisiaj',
				    clear: 'usunąć',
				    firstDay: 1,
				    format: 'd mmmm yyyy',
				    formatSubmit: 'yyyy-mm-dd'
				})
				$( '.datepicker' ).pickadate({
				    firstDay: 1,
				    dateMin: true,
				    datesDisabled: [
				        6, 7,
				        <? echo $wypust; ?>
				        [ 2013, 3, 28 ]
				    ],
				    onSelect: function() {
				        //alert(this.getDate( 'yyyy-mm-dd' ));
				        var posting = $.post( '<? echo EXTENSIONS_URL ?>eventbooking/hours.php', { date: this.getDate( 'yyyy-mm-dd' ) } );
				        posting.done(function( data ) {
						    $( "#proevb-hourload" ).empty().html( data );
						  });
				    }
				});
				$("#eventForm").validationEngine();
				
				$("#change-image").click(function(e){
					e.preventDefault();
					$("#captcha").attr("src", "<? echo EXTENSIONS_URL ?>eventbooking/captcha.php?"+Math.random());
				});
				
				/* attach a submit handler to the form */
				$("#eventForm").submit(function(event) {
				 
				  /* stop form from submitting normally */
				  event.preventDefault();
					
				  /* get some values from elements on the page: */
				  var $form = $( this ),
				      prodate = $form.find( 'input[name="proevb-date_submit"]' ).val(),
				      proname = $form.find( 'input[name="proevb-name"]' ).val(),
				      proemail = $form.find( 'input[name="proevb-email"]' ).val(),
				      prophone = $form.find( 'input[name="proevb-telefon"]' ).val(),
				      promessage = $form.find( 'textarea[name="proevb-message"]' ).val(),
				      procaptcha = $form.find( 'input[name="proevb-captcha"]' ).val(),
				      url = $form.attr( 'action' );
				      var prohours ='';
				      $form.find( '.proevb-checkbox:checked' ).each(function () {
					      prohours += $( this ).val()+',';
				      });
				      
				 
				  /* Send the data using post */
					if($("#eventForm").validationEngine('validate')){
					  var posting = $.post( '<? echo EXTENSIONS_URL ?>eventbooking/results.php', { proevbdate: prodate, proevbname: proname, proevbemail: proemail, proevbtelefon: prophone, proevbmessage: promessage, proevbhours: prohours, proevbcaptcha: procaptcha} );
					  var posting2 = $.post( '<? echo EXTENSIONS_URL ?>eventbooking/hours.php', { date: prodate } );
					}
				  /* Put the results in a div */
				  posting.done(function( data ) {
				    $( "#result" ).empty().html( data );
				  });
				  posting2.done(function( data2 ) {
						    $( "#proevb-hourload" ).empty().html( data2 );
						  });
				});
				
			});
		
		</script>
		<?
	}
}
new ProtonEventBooking();

?>
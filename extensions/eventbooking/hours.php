<?
require_once (dirname(__FILE__) .'./../../proton.core.php');
new Proton();

global $wpdb;
$table_name = $wpdb->prefix . "pro_appointments";
$pyt4 = "SELECT hours FROM ".$table_name." WHERE date='".$_POST['date']."'  ";
$results = $wpdb->get_col($pyt4);

$godziny = array();
$commahours;

if ( $results ){
	foreach ($results as $result) {
		$commahours .= $result.',';
	}
}
$godziny = explode( ',', $commahours );
if(count($godziny) >= 4){
	echo __('Nothing available','proton_framework');
}else{

	//print_r($godziny);
	if(!empty($_POST['date'])){
		for ($i = 12; $i <=19; $i++) {
		?>
								<div class="proevb-checkbox_group">
									<input type="checkbox" <? if(in_array(($i.':00'), $godziny)){?>disabled="disabled"<? } ?>  class="proevb-checkbox validate[minCheckbox[1]]" value="<? echo $i; ?>:00" name="proevb-checkbox">
									<? if(in_array(($i.':00'), $godziny)){?><del><? } ?><span class="proevb-checkbox_desc" style="display:inline"><? echo $i; ?>:00</span><? if(in_array(($i.':00'), $godziny)){?></del><? } ?>
								</div>
		<?
		}
	}else{
		echo __('Pick date','proton_framework');
	}
}

?>
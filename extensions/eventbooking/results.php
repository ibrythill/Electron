<?
session_start();
require_once (dirname(__FILE__) .'./../../proton.core.php');
new Proton(); 

$hours  = rtrim( $_POST['proevbhours'], ",");
if (!empty($_POST['proevbcaptcha'])) {
    if (empty($_SESSION['captcha']) || trim(strtolower($_POST['proevbcaptcha'])) != $_SESSION['captcha']) {
        $captcha_message = __("Invalid captcha",'proton_framework');
    } else {
        $captcha_message = __("Valid captcha",'proton_framework');
        
        global $wpdb;
		$table_name = $wpdb->prefix . "pro_appointments";
		$wpdb->insert( 
			$table_name, 
			array( 
				'date' => $_POST['proevbdate'], 
				'name' => $_POST['proevbname'], 
				'email' => $_POST['proevbemail'], 
				'phone' => $_POST['proevbtelefon'], 
				'note' => $_POST['proevbmessage'], 
				'hours' => $hours 
			) 
		);
    }
}




?>
<?

?>
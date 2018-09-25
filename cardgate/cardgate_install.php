<?php
	// Load database settings

	// Set default timezone (required in PHP 5+)
	if (function_exists('date_default_timezone_set')) {
		date_default_timezone_set('Europe/Amsterdam');
	}

	// Load user configuration
	define('BOOTSTRAP', true);
	define('DIR_ROOT', dirname(__FILE__));
	require_once(dirname(__FILE__) . '/config.php');

	// Connect to database
	mysql_connect($config['db_host'], $config['db_user'], $config['db_password']) or die('ERROR: ' . mysql_error() . '<br><br>FILE: ' . __FILE__ . '<br><br>LINE: ' . __LINE__);
	mysql_select_db($config['db_name']) or die('ERROR: ' . mysql_error() . '<br><br>FILE: ' . __FILE__ . '<br><br>LINE: ' . __LINE__);

	$payments = array(
	    'Afterpay'=>'afterpay',
	    'Bancontact'=>'bancontact',
	    'DirectDebit' => 'directdebit',
	    'Banktransfer'=>'banktransfer',
	    'Billink'=>'billink',
	    'Bitcoin'=>'bitcoin',
	    'Creditcard'=>'creditcard',
	    'Giropay'=>'giropay',
	    'iDEAL'=>'ideal',
	    'iDEALQR'=>'idealqr',
	    'Klarna'=>'klarna',
	    'PayPal'=>'paypal',
	    'Paysafecard'=>'paysafecard',
	    'Przelewy24'=>'przelewy24',
	    'Sofortbanking'=>'sofortbanking',
	    'Generic' => 'generic',
	);
	
	foreach($payments as $naam => $paymentcode)
	{		
		if($paymentcode == 'ideal')
		{
			$template = 'cardgate_ideal.tpl';
		}
		else
		{
			$template = 'cc_outside.tpl';
		}
		upd($paymentcode, "`" . $config['table_prefix'] . "payment_processors` SET `processor` = 'Cardgate ".$naam."', `processor_script` = 'cardgate".$paymentcode.".php', `admin_template` = 'cardgate".$paymentcode.".tpl', `processor_template` = 'views/orders/components/payments/".$template."', `callback` = 'N', `type` = 'P'", $config['table_prefix']);
	}
	
	echo '
<h1>Cardgate Installatie</h1>
<p style="color: red;">Please remove this file after installation and clear your CS-Cart cache!</p>
<h3>Queries:</h3>
<code>' . ($query_html ? $query_html : 'No warnings found') . '</code>
';

	function upd($script, $query, $prefix) {
		$q = mysql_query("SELECT * FROM `" . $prefix . "payment_processors` WHERE `processor_script` = 'cardgate" . $script . ".php'");
		if (!$q || ($n = mysql_num_rows($q)) == 0) {
			$ex = mysql_query("INSERT INTO " . $query);
			return 'insert ' . $ex . '<br/>';
		}
		else {
			$r = mysql_fetch_assoc($q);
			$ex = mysql_query("UPDATE " . $query . " WHERE `processor_id` = '" . $r['processor_id'] . "'");
			return 'update ' . $ex . '<br/>';
		}
	}
?>
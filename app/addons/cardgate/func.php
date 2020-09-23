<?php

use Tygh\Settings;

if (!defined('BOOTSTRAP')) { die('Access denied'); }
function fn_cardgate_install_payment_processors(){
	$payments = array(
		'Afterpay' => 'afterpay',
		'Bancontact' => 'bancontact',
		'DirectDebit' => 'directdebit',
		'Banktransfer' => 'banktransfer',
		'Billink' => 'billink',
		'Bitcoin' => 'bitcoin',
		'Creditcard' => 'creditcard',
		'Giftcard' => 'giftcard',
		'Giropay' => 'giropay',
		'iDEAL' => 'ideal',
		'iDEALQR' => 'idealqr',
		'Klarna' => 'klarna',
		'PayPal' => 'paypal',
		'OnlineÜberweisen' => 'onlineueberweisen',
		'Paysafecard' => 'paysafecard',
		'Paysafecash' => 'paysafecash',
		'Przelewy24' => 'przelewy24',
		'Sofortbanking' => 'sofortbanking',
		'SofortPay' => 'sofortpay'
	);

	foreach ($payments as $naam => $paymentcode) {
		if ($paymentcode == 'ideal') {
			$template = 'cardgate_ideal.tpl';
		} else {
			$template = 'cc_outside.tpl';
		}
		$query = "?:payment_processors SET processor = 'Cardgate " . $naam . "', `processor_script` = 'cardgate" . $paymentcode . ".php', `admin_template` = 'cardgate" . $paymentcode . ".tpl', `processor_template` = 'views/orders/components/payments/" . $template . "', `callback` = 'N', `type` = 'P', `addon` = 'cardgate' ";

		$result = db_get_array("SELECT * FROM ?:payment_processors WHERE processor_script = 'cardgate" . $paymentcode . ".php'");
		if (! $result || count($result) == 0) {
			db_query("INSERT INTO " . $query);
		} else {
			db_query("UPDATE " . $query . " WHERE `processor_id` = '" . $result['processor_id'] . "'");
		}
	}
}

function fn_cardgate_delete_payment_processors()
{
	db_query("DELETE FROM ?:payment_descriptions WHERE payment_id IN (SELECT payment_id FROM ?:payments WHERE processor_id IN (SELECT processor_id FROM ?:payment_processors WHERE processor_script LIKE ('cardgate%')))");
	db_query("DELETE FROM ?:payments WHERE processor_id IN (SELECT processor_id FROM ?:payment_processors WHERE processor_script LIKE ('cardgate%'))");
	db_query("DELETE FROM ?:payment_processors WHERE processor_script LIKE ('cardgate%')");
}

function fn_update_cardgate_settings($settings)
{
	if (isset($settings['cg_statuses'])) {
		$settings['cg_statuses'] = serialize($settings['cg_statuses']);
	}

	foreach ($settings as $setting_name => $setting_value) {
		Settings::instance()->updateValue($setting_name, $setting_value);
	}
}

function fn_get_cardgate_settings()
{
	$cg_settings = Settings::instance()->getValues('cardgate', 'ADDON');
	if (!empty($cg_settings['general']['cg_statuses'])) {
		$cg_settings['general']['cg_statuses'] = unserialize($cg_settings['general']['cg_statuses']);
	}
	return $cg_settings['general'];
}

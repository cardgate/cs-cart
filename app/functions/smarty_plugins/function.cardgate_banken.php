<?php
use Tygh\Settings;
function smarty_function_cardgate_banken() {

    require_once (__DIR__.'/../../payments/cardgate/cardgate.php');
    $cg_settings = Settings::instance()->getValues('cardgate', 'ADDON');
    $cardgate = new Cardgate($cg_settings['general']['merchant_id'], $cg_settings['general']['api_key'], $cg_settings['general']['site_id']);
    $banken = '';
    $banken = $cardgate->getBankOptions();

    $keuze = '<select id="issuerid" name="payment_info[issuerid]">
		<option selected value="">Kies uw bank...</option>';

    foreach ( $banken as $k => $v ) {
        $keuze .= "<option value=\"" . $k . "\">" . $v . "</option>";
    }
    $keuze .= '</select>';
    return $keuze;
}

?>
<?php

function smarty_function_cardgate_banken( $params ) {

    require_once ($params['dir'] . 'cardgate/cardgate.php');
    $cardgate = new Cardgate(0,0,0 );
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
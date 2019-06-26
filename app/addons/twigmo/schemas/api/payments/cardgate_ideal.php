<?php
/***************************************************************************
*                                                                          *
*   (c) 2017 CardGate                                                      *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/


if ( !defined('AREA') ) { die('Access denied'); }


$schema = array (
	array (
		'option_id' => 1,
		'name' => 'issuerid',
		'description' => 'Kies uw bank:', //fn_get_lang_var('select_card'),
		'value' => '',
		'option_type' =>  'S',
		'position' => 10,
		'option_variants' => fn_banken()
	),
);

function fn_banken()
{
	require_once (DIR_PAYMENT_FILES.'/cardgate/cardgate.php');
	$cardgate = new Cardgate('', '');
	$banken = '';
		
	$cardgate->directoryRequest($banken, false);
	
	$keuze = array();
	
	$keuze[] = array('variant_id'=> '', 'variant_name' => '', 'description' => 'Kies uw bank...', 'position' => '1');

	$post = 1;
	foreach ($banken as $k => $v) {
		$pos++;
		$keuze[] = array('variant_id'=> $k, 'variant_name' => $k, 'description' => $v, 'position' => $pos);
	}
	
    return $keuze;
}

?>
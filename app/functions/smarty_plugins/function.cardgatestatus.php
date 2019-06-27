<?php
function smarty_function_cardgatestatus($params)
{
	
	$statuses = db_get_hash_array("SELECT ?:statuses.*, ?:status_descriptions.* FROM ?:statuses INNER JOIN ?:status_descriptions ON ?:statuses.status_id = ?:status_descriptions.status_id AND ?:status_descriptions.lang_code = ?s AND ?:statuses.type = ?s ORDER BY ?:status_descriptions.description", 'status', DESCR_SL, 'O');
	
	$keuze = '<select id="'.$params['state'].'" name="payment_data[processor_params]['.$params['state'].']">';
	
	foreach($statuses as $k =>$v)
	{
		$selected = '';
		
		if($k == $params['current'])
			$selected = 'selected';
		
		$keuze .= "<option value=\"" . $k . "\" ".$selected." >" . $v['description'] . "</option>";
	}
	
	$keuze .= '</select>';
	
	return $keuze;
}
?>
<?php

use Tygh\Settings;
/*
 * *************************************************************************
 * *
 * Copyright (c) 2015 Cardgate B.V. All rights reserved. *
 * *
 * **************************************************************************
 */

//
// $Id: base.php 2011-05-24
//
if (! defined('AREA')) {
    die('Access denied');
}
include 'cardgate.php';

if (defined('PAYMENT_NOTIFICATION')) {

    $order_id = $_REQUEST['order_id'];
    
    if ($mode == 'return') {
        if (fn_check_payment_script($filename . '.php', $order_id)) {
            fn_order_placement_routines('route', $order_id, false);
        }
    } elseif ($mode == 'notify') {
        
        $valid_id = db_get_field("SELECT order_id FROM ?:order_data WHERE order_id = ?i AND type = 'S'", $order_id);
        if (empty($valid_id)) {
            echo 'Order already Success';
            exit();
        }
	    $cg_settings = Settings::instance()->getValues('cardgate', 'ADDON');
        $pp_response = array();
        $payment_id = db_get_field("SELECT payment_id FROM ?:orders WHERE order_id = ?i", $order_id);
        $processor_data = fn_get_payment_method_data($payment_id);
        $order_info = fn_get_order_info($order_id);
        
        if (isset($generic_data['processor_params']['statussuccess']) && $generic_data['processor_params']['statussuccess'] != "") {
            $st = $generic_data['processor_params']['statussuccess'];
        } else {
            $st = 'P';
        }
        
        if ($order_info['status'] == $st) {
            echo 'Order already success';
            exit();
        }
        
        $cardgate = new Cardgate($cg_settings['general']['merchant_id'], $cg_settings['general']['api_key'], $cg_settings['general']['site_id']);
        $trxid = $_REQUEST['transaction'];
        $testMode = ($cg_settings['general']['mode'] == 'test' ? TRUE : FALSE);
        $hashKey = $cg_settings['general']['hash_key'];
        
        if (!$cardgate->hashCheck($_REQUEST, $cg_settings['general']['hash_key'], $testMode)) {
            exit('HashCheck failed.');
        }
        
        $code = $_REQUEST['code'];
        
        $pp_response['transaction_id'] = $trxid;
        
        if ($code >= 0 && $code <=100) {
            $sReturnStatus = 'Open';
            $st = $cg_settings['general']['statuspending'];
        }
        if ($code >= '200' && $code < '300') {
            $sReturnStatus = 'Completed';
            $st = $cg_settings['general']['statussuccess'];
        }
        if ($code >= '300' && $code < '400') {
            $sReturnStatus = 'Failure';
            $st = $cg_settings['general']['statusfailed'];
            
            if ($code == '309') {
                $sReturnStatus = 'Canceled';
                $st = $cg_settings['general']['statuscanceled'];
            }
        }
        if ($code >= '700' && $code < '800') {
            $sReturnStatus = 'Pending';
            $st = $cg_settings['general']['statuspending'];
        }
        
        $pp_response['order_status'] = $st;
        
        switch ($sReturnStatus) {
            case 'Open':
                $pp_response['reason_text'] = 'Transaction is Pending';
                fn_change_order_status($order_id, $pp_response['order_status'], '', false);
                break;
            case 'Completed':
                $pp_response['reason_text'] = 'Transaction is completed';
                fn_finish_payment($order_id, $pp_response, true);
                break;
            case 'Canceled':
                $pp_response['reason_text'] = 'Transaction is Canceled';
                fn_finish_payment($order_id, $pp_response, true);
            case 'Failure':
                $pp_response['reason_text'] = 'Transaction failed';
                fn_change_order_status($order_id, $pp_response['order_status'], '', false);
                break;
            case 'Pending':
                $pp_response['reason_text'] = 'Transaction is Pending';
                fn_change_order_status($order_id, $pp_response['order_status'], '', true);
                break;
        }
        
        echo $trxid . '.' . $code;
        exit();
    }
} else {

	$cg_settings = Settings::instance()->getValues('cardgate', 'ADDON');

    if (empty($cg_settings)) {
        echo 'There are no settings in the CardGate Add on. You need to set these first in order to process transactions.';
        exit();
    }

    $pp_response = array();

    echo '<div style="text-align: center;"><img src="images/cardgate/' . $filename . '.png" alt="payment logo" /> </div>';
    
    $arg = array();

    $currency = $cg_settings['general']['currency'];
    $amount = round(fn_format_price($order_info['total'], $currency) * 100);

    // wanneer ideal is geselecteerd
    // actie: controleren of er een bankkeuze is gemaakt
    // uitvoer: bij geen bankkeuze wordt er een foutmelding gegeven en een redirect geplaatst
    if ($paymentcode == 'ideal' && (! isset($order_info['payment_info']['issuerid']) || $order_info['payment_info']['issuerid'] == '')) {
        
        fn_set_notification('E', fn_get_lang_var('warning'), 'Kies een bank', false, 'no_bank');
        require_once (dirname(dirname(dirname(__FILE__))) . '/Tygh/Registry.php');
        $registry = new Tygh\Registry();
        fn_redirect($registry::get('config.current_location') . "/" . $index_script . "?dispatch=checkout.checkout&order_id=" . $order_id, true);
        exit();
    } else {
        
        // alle variabelen zetten voor de betaling
        $arg['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        
        $arg['billing_firstname'] = $order_info['b_firstname'];
        $arg['billing_lastname'] = $order_info['b_lastname'];
        $arg['billing_mail'] = $order_info['email'];
        $arg['billing_company'] = (isset($order_info['company'])) ? $order_info['company'] : '';
        $arg['billing_address1'] = $order_info['b_address'];
        $arg['billing_address2'] = $order_info['b_address_2'];
        $arg['billing_city'] = $order_info['b_city'];
        $arg['billing_zip'] = $order_info['b_zipcode'];
        $arg['billing_country'] = $order_info['b_country_descr'];
        $arg['billing_countrycode'] = $order_info['b_country'];
        if (isset($order_info['payment_info']['phone'])) {
            $arg['billing_phone'] = $order_info['payment_info']['phone'];
        } else {
            $arg['billing_phone'] = $order_info['b_phone'];
        }
        
        $arg['shipping_firstname'] = $order_info['s_firstname'];
        $arg['shipping_lastname'] = $order_info['s_lastname'];
        $arg['shipping_mail'] = $order_info['email'];
        $arg['shipping_company'] = (isset($order_info['company'])) ? $order_info['company'] : '';
        $arg['shipping_address1'] = $order_info['s_address'];
        $arg['shipping_address2'] = $order_info['s_address_2'];
        $arg['shipping_zip'] = $order_info['s_zipcode'];
        $arg['shipping_city'] = $order_info['s_city'];
        $arg['shipping_country'] = $order_info['s_country_descr'];
        $arg['shipping_countrycode'] = $order_info['s_country'];
        $arg['shipping_phone'] = $order_info['s_phone'];
        $arg['shipping'] = $order_info['shipping_cost'];
        
        // producten en taxes
        // kijken hoeveel btw aanwzig is
        $arg['tax'] = 0;
        foreach ($order_info['taxes'] as $tax) {
            $arg['tax'] += $tax['tax_subtotal'];
        }
        
        $arg['currency'] = $currency;
        
        if (isset($order_info['payment_method']['processor_params']['include']) && $order_info['payment_method']['processor_params']['include'] == 'on')
            $arg['including'] = 'true';
        
        if (isset($order_info['payment_method']['processor_params']['include']))
            $arg['inlcuding'] = $order_info['payment_method']['params']['days'];
            
            // producten
            // producten ophalen en prijzen berekenen
        $items = array();
        $nr = 0;
        
        foreach ($order_info['products'] as $product) {
            
            $nr ++;
            $items[$nr]['type'] = 'product';
            $items[$nr]['model'] = $product['product_code'];
            $items[$nr]['name'] = $product['product'];
            $items[$nr]['quantity'] = $product['amount'];
            
            $netprice = fn_format_price($product['price'], $currency);
            $taxrate = 0;
            
            $product_data = fn_get_product_data($product['product_id'], $_SESSION['auth'], $order_info['lang_code'], '');
            
            foreach ($order_info['taxes'] as $key => $tax) {
                if (in_array($key, $product_data['tax_ids']) && $tax['price_includes_tax'] == 'Y') {
                    if ($tax['rate_type'] == 'P') {
                        $netprice = ($netprice * 100.0) / (100.0 + $tax['rate_value']);
                    }
                }
            }
            
            $total = round($netprice * 100.0, 0);
            $netprice = $total;
            $taxrate = 0;
            
            foreach ($order_info['taxes'] as $key => $tax) {
                if (in_array($key, $product_data['tax_ids'])) {
                    if ($tax['rate_type'] == 'P') {
                        $total = $total * ((100.0 + $tax['rate_value']) / 100.0);
                        $taxrate += ($tax['rate_value']);
                    }
                }
            }
            $total = round($total, 0);
            
            $items[$nr]['price_wt'] = $total;
            $items[$nr]['vat'] = $taxrate;
            $items[$nr]['vat_amount'] = $total - $netprice;
        }
        
        // producten
        // verzendkosten toevoegen aan de producten
        if ($order_info['shipping_cost'] > 0) {
            
            $nr ++;
            foreach ($order_info['shipping'] as $shipping) {
                $items[$nr]['type'] = 'shipping';
                $items[$nr]['model'] = 'shipping_' . $nr;
                $items[$nr]['name'] = $shipping['shipping'];
                $items[$nr]['quantity'] = 1;
                
                $arg['product_description_' . $prodnr] = $shipping['shipping'];
                
                $arg['product_quantity_' . $prodnr] = '1';
                
                $netprice = fn_format_price($order_info['shipping_cost'], $currency);
                
                foreach ($order_info['taxes'] as $key => $tax) {
                    if ($tax['applies']['S'] > 0 && $tax['price_includes_tax'] == 'Y') {
                        if ($tax['rate_type'] == 'P') {
                            $netprice = $netprice / ((100.0 + $tax['rate_value']) / 100);
                        }
                    }
                }
                
                $taxamount = 0;
                $taxrate = 0;
                foreach ($order_info['taxes'] as $key => $tax) {
                    if ($tax['applies']['S'] > 0) {
                        if ($tax['rate_type'] == 'P') {
                            $taxamount += $netprice * ($tax['rate_value'] / 100);
                            $taxrate += $tax['rate_value'];
                        }
                    }
                }
                
                $productTaxrate = $taxrate;
                
                $items[$nr]['price_wt'] = round(($netprice + $taxamount) * 100.0, 0);
                $items[$nr]['vat'] = round($taxrate,2);
                $items[$nr]['vat_amount'] = round($taxamount * 100.0, 0);
            }
        }

        // producten
        // payment fee toevoegen aan de producten
        if (isset($order_info['payment_surcharge']) && $order_info['payment_surcharge'] > 0) {
            $nr ++;
            
            $items[$nr]['type'] = 'paymentfee';
            $items[$nr]['model'] = 'payment_fee_' . $nr;
            $items[$nr]['name'] = ($order_info['payment_method']['surcharge_title']== '' ? 'Betaal toeslag' : $order_info['payment_method']['surcharge_title']);
            $items[$nr]['quantity'] = 1;
            
            $netprice = fn_format_price($order_info['payment_surcharge'], $currency);
            
            foreach ($order_info['taxes'] as $key => $tax) {
                if (in_array($key, $order_info['payment_method']['tax_ids']) && $tax['price_includes_tax'] == 'Y') {
                    if ($tax['rate_type'] == 'P') {
                        $netprice = $netprice / ((100.0 + $tax['rate_value']) / 100);
                    }
                }
            }
            
            $taxamount = 0;
            $taxrate = 0;
            foreach ($order_info['taxes'] as $key => $tax) {
                if (in_array($key, $order_info['payment_method']['tax_ids'])) {
                    if ($tax['rate_type'] == 'P') {
                        $taxamount += $netprice * ($tax['rate_value'] / 100);
                        $taxrate += $tax['rate_value'];
                    }
                }
            }
            
            $items[$nr]['price_wt'] = round(($netprice + $taxamount) * 100.0, 0);
            $items[$nr]['vat'] = round($taxrate * 100.0, 0);
            $items[$nr]['vat_amount'] = round($taxamount * 100.0, 0);
        }
        
        // producten
        // eventuele korting toevoegen
        if (isset($order_info['subtotal_discount']) && $order_info['subtotal_discount'] > 0) {
            $nr ++;
            
            $items[$nr]['type'] = 'discount';
            $items[$nr]['model'] = 'discount' . $nr;
            $items[$nr]['name'] = 'Korting';
            $items[$nr]['quantity'] = 1;
            $items[$nr]['price_wt'] = round(fn_format_price($order_info['subtotal_discount'], $currency) * 100.0*-1, 0);
            $items[$nr]['vat'] = $productTaxrate;
            $items[$nr]['vat_amount'] = 0;
        }
        
        $arg['items'] = $items;
        
        // omschrijving inladen
        if (isset($processor_data['params']['description']) && $processor_data['params']['description'] != "") {
            $descr = str_replace("ORDER_ID", $order_id, $processor_data['params']['description']);
        } else {
            $descr = "Order " . $order_id;
        }
        // urls voor terugkoppeling inladen
        $notifyurl = fn_url("payment_notification.notify?payment=" . $filename . "&order_id=" . $order_id, AREA, 'current');
        $returnurl = fn_url("payment_notification.return?payment=" . $filename . "&order_id=" . $order_id, AREA, 'current');
        
        // kijken of de testmodes geactiveerd moet worden
        if ($cg_settings['general']['mode'] == 'test') {
            $arg['testmode'] = TRUE;
        } else {
            $arg['testmode'] = FALSE;
        }
        
        if (isset($order_info['payment_info']['cardgate_pclass'])) {
            $arg['pclass'] = $order_info['payment_info']['cardgate_pclass'];
        }

        // class cardgate inladen en ontbrekende attributen inladen
        $cardgate = new Cardgate($cg_settings['general']['merchant_id'], $cg_settings['general']['api_key'], $cg_settings['general']['site_id']);
        $cardgate->amount = $amount;
        $cardgate->payment = $paymentcode;
        $cardgate->purchaseId = $order_id;
        $cardgate->description = $descr;
        $cardgate->notifyUrl = $notifyurl;
        $cardgate->callbackUrl = $notifyurl;
        $cardgate->returnUrl = $returnurl;
        $cardgate->cancelUrl = $returnurl;
        
        if (isset($order_info['payment_info']['issuerid']))
            $cardgate->issuerId = $order_info['payment_info']['issuerid'];
            
            // transaction request starten
        if (($ex = $cardgate->transactionRequest($arg)) < 0) {
            $error = 'Betalen met ' . $order_info['payment_method']['payment'] . ' is nu niet mogelijk, betaal anders. (' . $cardgate->errorMessage . ')';
            $pp_response['reason_text'] = $error;
            $pp_response['order_status'] = (isset($processor_data['processor_params']['statusfailed']) && $processor_data['processor_params']['statusfailed'] != '') ? $processor_data['processor_params']['statusfailed'] : "F";
        } else {
            
            $url = $cardgate->issuerUrl;
            
            if ($redirect == false) {
                $pp_response['transaction_id'] = $trxid;
                
                if (($cardgate->StatusRequest()) < 0) {
                    $pp_response['reason_text'] = 'StatusRequest Failed';
                    $pp_response['order_status'] = 'O';
                } else {
                    if ($cardgate->status == Cardgate::statusSuccess || $cardgate->status == 'Reservation') {
                        if (isset($generic_data['params']['statussuccess']) && $generic_data['params']['statussuccess'] != "") {
                            $st = $generic_data['params']['statussuccess'];
                        } else {
                            $st = 'P';
                        }
                        
                        $pp_response['order_status'] = $st;
                        $pp_response['reason_text'] = 'Approved by Cardgate';
                    } else {
                        $pp_response['reason_text'] = ($cardgate->pendingKlarna == 'true') ? 'Transactie wordt gecontroleerd door Klarna.' : 'Wachten op betaling, betaalinstructies zijn per mail naar u toegestuurd.';
                        $pp_response['order_status'] = (isset($order_info['payment_method']['params']['statuspending'])) ? $order_info['payment_method']['params']['statuspending'] : 'O';
                    }
                }
                
                fn_change_order_status($order_id, $pp_response['order_status'], '', false);
                
                fn_redirect(fn_url("payment_notification.return?payment=" . $filename . "&order_id=" . $order_id, AREA, 'current'));
                exit();
            } else {
                fn_redirect($url, true, true);
                exit();
            }
        }
    }
}
?>
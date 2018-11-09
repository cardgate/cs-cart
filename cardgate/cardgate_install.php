<?php
// Load database settings

// Set default timezone (required in PHP 5+)
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Europe/Amsterdam');
}

// Load user configuration
define('BOOTSTRAP', true);
define('DIR_ROOT', dirname(__FILE__));

require_once (dirname(__FILE__) . '/config.local.php');

// Connect to database
$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']) or die('ERROR: ' . mysqli_connect_error() . '<br><br>FILE: ' . __FILE__ . '<br><br>LINE: ' . __LINE__);

$payments = array(
    'Afterpay' => 'afterpay',
    'Bancontact' => 'bancontact',
    'DirectDebit' => 'directdebit',
    'Banktransfer' => 'banktransfer',
    'Billink' => 'billink',
    'Bitcoin' => 'bitcoin',
    'Creditcard' => 'creditcard',
    'Giropay' => 'giropay',
    'iDEAL' => 'ideal',
    'iDEALQR' => 'idealqr',
    'Klarna' => 'klarna',
    'PayPal' => 'paypal',
    'Paysafecard' => 'paysafecard',
    'Przelewy24' => 'przelewy24',
    'Sofortbanking' => 'sofortbanking',
    'Generic' => 'generic'
);

$errors = array();
foreach ($payments as $naam => $paymentcode) {
    if ($paymentcode == 'ideal') {
        $template = 'cardgate_ideal.tpl';
    } else {
        $template = 'cc_outside.tpl';
    }
    $r = upd($mysqli, $paymentcode, "`" . $config['table_prefix'] . "payment_processors` SET `processor` = 'Cardgate " . $naam . "', `processor_script` = 'cardgate" . $paymentcode . ".php', `admin_template` = 'cardgate" . $paymentcode . ".tpl', `processor_template` = 'views/orders/components/payments/" . $template . "', `callback` = 'N', `type` = 'P'", $config['table_prefix']);
    if ($r !== true) {
        $errors[] = $r;
    }
}
$mysqli->close();

echo '
<h1>Cardgate Installatie</h1>
<p style="color: red;">Please remove this file after installation and clear your CS-Cart cache!</p>
<h3>Queries:</h3>
<code>';

if (count($errors) == 0) {
    echo 'No warnings found';
} else {
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
}
echo '</code>';

function upd($mysqli, $script, $query, $prefix) {
    $result = $mysqli->query("SELECT * FROM `" . $prefix . "payment_processors` WHERE `processor_script` = 'cardgate" . $script . ".php'");
    
    if (! $result || $result->fetch_array(MYSQLI_NUM) == 0) {
        if (! $mysqli->query("INSERT INTO " . $query)) {
            return 'insert error: ' . $mysqli->error;
        } else {
            return true;
        }
    } else {
        $r = $result->fetch_array(MYSQLI_ASSOC);
        if (! $mysqli->query("UPDATE " . $query . " WHERE `processor_id` = '" . $r['processor_id'] . "'")) {
            return 'update error: ' . $mysqli->error;
        } else {
            return true;
        }
    }
}
?>
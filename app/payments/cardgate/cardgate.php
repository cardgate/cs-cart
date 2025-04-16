<?php

require_once dirname( __FILE__ ) . '/cardgate-clientlib-php/src/Autoloader.php';
cardgate\api\Autoloader::register();

class Cardgate
{

    protected static $issuers;

    protected static $lastcheck;

    private $response;
    // Merchant data
    private $merchantId;

    private $merchantKey;

    private $siteId;
    // Transaction data
    public $payment;
    // ideal=iDEAL; sofort=DIRECTebanking; mistercash=MisterCash; ...
    public $issuerId;
    // mandatory; cardgate bank code
    public $purchaseId;
    // mandatory; max 16 alphanumeric
    public $entranceCode;
    // max 40 strict alphanumeric (letters and numbers only)
    public $description;
    // mandatory; max 32 alphanumeric
    public $amount;
    // mandatory; min 0.45
    public $notifyUrl;

    public $returnUrl;
    // mandatory
    public $cancelUrl;

    public $callbackUrl;
    // return code
    public $code;

    public $timeStamp;

    public $consumerAccount;

    public $consumerIban;

    public $consumerBic;

    public $consumerName;

    public $consumerCity;
    // Invoice data
    public $invoiceNo;

    public $documentId;
    // Klarna Factuur/Account
    public $pendingKlarna;

    public $monthly;

    public $pclass;

    public $intrestRate;

    public $invoiceFee;

    public $months;

    public $startFee;
    // Result/check data
    public $trxId;

    public $issuerUrl;
    // Error data
    public $errorCode;

    public $errorMessage;
    // endpoints
    public $cardgateEndpoint = 'https://api.cardgate.com';

    public $cardgateTestEndpoint = 'https://api-test.cardgate.com';
    
    // Status
    const statusSuccess = "Completed";

    const statusCancelled = "Cancelled";

    const statusExpired = "Expired";

    const statusFailure = "Failure";

    const statusOpen = "Open";

    const statusReservation = "Waiting";

    const statusPending = "Pending";
    
    // version
    const pluginName = 'cs_cart';

    const pluginVersion = '4.5.5';

    public function __construct($merchant_id, $api_key, $site_id)
    {
        $this->merchantId = $merchant_id;
        $this->merchantKey = $api_key;
        $this->siteId = $site_id;
    }

    private function error()
    {
        $this->errorCode = $this->response['error']['code'];
        $this->errorMessage = $this->response['error']['message'];
    }

    private function parse($search, $xml = false)
    {
        if ($xml === false) {
            $xml = $this->response;
        }
        if (($start = strpos($xml, "<" . $search . ">")) === false) {
            return false;
        }
        $start += strlen($search) + 2;
        if (($end = strpos($xml, "</" . $search . ">", $start)) === false) {
            return false;
        }
        return substr($xml, $start, $end - $start);
    }

    public function getEndpoint($test)
    {
        if ($test) {
            return $this->cardgateTestEndpoint;
        } else {
            return $this->cardgateEndpoint;
        }
    }
    
    // TransactionRequest
    public function transactionRequest($data = NULL)
    {
        $this->trxId = $this->issuerUrl = "";
        if (! $this->merchantId) {
            $this->errorMessage = "No merchantid";
            return - 1;
        }
        if (! $this->merchantKey) {
            $this->errorMessage = "No merchantkey";
            return - 2;
        }
        if (! $this->purchaseId) {
            $this->errorMessage = "No purchaseid";
            return - 3;
        }
        if ($this->amount < 0.45) {
            $this->errorMessage = "Amount < 0.45";
            return - 4;
        }
        if (! $this->description) {
            $this->errorMessage = "No description";
            return - 5;
        }
        if (! $this->returnUrl) {
            $this->errorMessage = "No returnurl";
            return - 6;
        }
        if (! $this->entranceCode)
            $this->entranceCode = $this->purchaseId;
        
        try {
            
            $oCardGate = new \cardgate\api\Client((int) $this->merchantId, $this->merchantKey, $data['testmode']);
            
            $oCardGate->setIp($_SERVER['REMOTE_ADDR']);
            $oCardGate->setLanguage(CART_LANGUAGE);
            $oCardGate->version()->setPlatformName(PRODUCT_NAME);
            $oCardGate->version()->setPlatformVersion(PRODUCT_VERSION);
            $oCardGate->version()->setPluginName(CARDGATE::pluginName);
            $oCardGate->version()->setPluginVersion(CARDGATE::pluginVersion);
            
            $iSiteId = (int) $this->siteId;
            $amount = (int) $this->amount;
            $currency = $data['currency'];
            
            $oTransaction = $oCardGate->transactions()->create($iSiteId, $amount, $currency);
            
            // Configure payment option.
            $oTransaction->setPaymentMethod($this->payment);
            
            // Configure customer.
            $oConsumer = $oTransaction->getConsumer();
            $oConsumer->setEmail($data['billing_mail']);
            $oConsumer->address()->setFirstName($data['billing_firstname']);
            $oConsumer->address()->setLastName($data['billing_lastname']);
            $oConsumer->address()->setAddress(trim($data['billing_address1'] . ' ' . $data['billing_address2']));
            $oConsumer->address()->setZipCode($data['billing_zip']);
            $oConsumer->address()->setCity($data['billing_city']);
            $oConsumer->address()->setCountry($data['billing_countrycode']);
            
            $oCart = $oTransaction->getCart();
            // Items
            
            foreach ($data['items'] as $item) {
                
                switch ($item['type']) {
                    case 'product':
                        $oItem = $oCart->addItem(\cardgate\api\Item::TYPE_PRODUCT, $item['model'], $item['name'], (int) $item['quantity'], (int) $item['price_wt']);
                        break;
                    case 'shipping':
                        $oItem = $oCart->addItem(\cardgate\api\Item::TYPE_SHIPPING, $item['model'], $item['name'], (int) $item['quantity'], (int) $item['price_wt']);
                        break;
                    case 'paymentfee':
                        $oItem = $oCart->addItem(\cardgate\api\Item::TYPE_HANDLING, $item['model'], $item['name'], (int) $item['quantity'], (int) $item['price_wt']);
                        break;
                    case 'discount':
                        $oItem = $oCart->addItem(\cardgate\api\Item::TYPE_DISCOUNT, $item['model'], $item['name'], (int) $item['quantity'], (int) $item['price_wt']);
                        break;
                }
                $oItem->setVat($item['vat']);
                $oItem->setVatAmount($item['vat_amount']);
                $oItem->setVatIncluded(1);
                $vat_total += round($item['vat_amount'] * $item['quantity'], 0);
                $cart_item_total += round($item['price_wt'] * $item['quantity'], 0);
            }
            
            $oTransaction->setCallbackUrl($this->notifyUrl);
            $oTransaction->setSuccessUrl($this->returnUrl);
            $oTransaction->setFailureUrl($this->cancelUrl);
            
            $oTransaction->setReference('O' . time() . $this->purchaseId);
            $oTransaction->setDescription($this->description);
            
            $oTransaction->register();
            
            $sActionUrl = $oTransaction->getActionUrl();
            
            if (NULL !== $sActionUrl) {
                $this->issuerUrl = trim($sActionUrl);
            } else {
                $this->errorMessage = htmlspecialchars($oException_->getMessage());
                return - 8;
            }
        } catch (cardgate\api\Exception $oException_) {
            $this->errorMessage = htmlspecialchars($oException_->getMessage());
            return - 9;
        }
        return 0;
    }

    public function hashCheck($data, $hashKey, $testMode)
    {
        try {
            
            $oCardGate = new \cardgate\api\Client((int) $this->merchantId, $this->merchantKey, $testMode);
            $oCardGate->setIp($_SERVER['REMOTE_ADDR']);
            
            if (FALSE == $oCardGate->transactions()->verifyCallback($data, $hashKey)) {
                return FALSE;
            } else {
                return TRUE;
            }
        } catch (cardgate\api\Exception $oException_) {
            return FALSE;
        }
    }
}
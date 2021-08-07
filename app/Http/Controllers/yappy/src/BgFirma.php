<?php

namespace Bg;

define('API_URL', 'https://pagosbg.bgeneral.com');
define('UPDATE_URL', 'https://bgx-digital-prod-ecommerce-plugins.s3.amazonaws.com/prestashop/updates/details.json');

final class BgFirma
{
    const HASH = 'sha256';
    const APIURL = 'https://apipagosbg.bgeneral.cloud';
    const URLSITE = 'https://pagosbg.bgeneral.com';
    const DOMAIN_REGEX = '/^(https:\/\/www\.|https:\/\/)?[a-zñ0-9]+([\-\.]{1}[a-zñ0-9]+)*\.[a-z]{2,10}(:[0-9]{1,5})?(\/.*)?$/';
    const DEFAULT_ORDER_ID = 'PEDIDO WEB';

    // MENSAJES DE ERROR
    const SSL_ERROR = "Para desactivar el modo de pruebas (sandbox), se requiere de un certificado SSL y una conexión segura por HTTPS.";
    const CAMPO_REQUERIDO_ERROR = "El campo de %s es un campo requerido para el uso del Botón de Pago Yappy.";
    const CAMPO_INVALIDO_ERROR = "El valor del campo %s es inválido.";

    // MENSAJES DE SUCCESS
    const FORMULARIO_CORRECTO = "Formulario correcto";

    private $total;
    private $merchantId;
    private $currency;
    private $subtotal;
    private $taxes;
    private $paymentDate;
    private $paymentMethod;
    private $transactionType;
    private $orderId;
    private $successUrl;
    private $failUrl;
    private $domain;
    private $secretToken;
    private $sandbox;
    private $ssl;
    private $jwtToken;
    private $tel;

    public function __construct($total, $merchantId, $currency, $subtotal, $taxes, $paymentDate, $paymentMethod, $transactionType, $orderId, $successUrl, $failUrl, $domain, $secretToken, $sandbox, $jwtToken, $tel)
    {
        $this->total = $total;
        $this->merchantId = $merchantId;
        $this->currency = $currency;
        $this->subtotal = $subtotal;
        $this->taxes = $taxes;
        $this->paymentDate = $paymentDate;
        $this->paymentMethod = $paymentMethod;
        $this->transactionType = $transactionType;
        $this->orderId = $orderId ? $orderId : self::DEFAULT_ORDER_ID;
        $this->successUrl = $successUrl ? mb_strtolower($successUrl) : '';
        $this->failUrl = $failUrl ? mb_strtolower($failUrl) : '';
        $this->domain = mb_strtolower($domain);
        $this->secretToken = $secretToken;
        $this->sandbox = $sandbox === true ? true : false;
        $this->ssl = $this->isSecure();
        $this->sandbox = !$this->ssl;
        $this->jwtToken = $jwtToken;
        $this->tel = $tel;
    }

    public function createHash()
    {
        $ok = $this->validateFields();
        if ($ok['success']) {
            $values = base64_decode($this->secretToken);
            $secrete = explode('.', $values);
            $signature =  hash_hmac(self::HASH, $this->concatElements(), $secrete[0]);
            $data = [
                'merchantId' => $this->merchantId,
                'total' => number_format($this->total, 2, '.', ''),
                'subtotal' => number_format($this->subtotal, 2, '.', ''),
                'taxes' => number_format($this->taxes, 2, '.', ''),
                'paymentDate' => $this->paymentDate,
                'paymentMethod' => $this->paymentMethod,
                'transactionType' => $this->transactionType,
                'orderId' => $this->orderId,
                'successUrl' => $this->successUrl,
                'failUrl' => $this->failUrl,
                'domain' => $this->domain,
                'jwtToken' => $this->jwtToken,
                'cancelUrl' => $this->failUrl,
                'platform' => 'desarrollopropiophp',
                'signature' => $signature,
                'sbx' => $this->sandbox === false ? 'no' : 'yes',
                'tel' => $this->validate_phone($this->tel)
            ];
            return [
                'success' => true,
                'url' => self::URLSITE . '?' . http_build_query($data, '', '&', PHP_QUERY_RFC3986)
            ];
        }
        return $ok;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of merchantId
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Set the value of merchantId
     *
     * @return  self
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of subtotal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set the value of subtotal
     *
     * @return  self
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get the value of taxes
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set the value of taxes
     *
     * @return  self
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Get the value of paymentDate
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set the value of paymentDate
     *
     * @return  self
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get the value of paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get the value of transactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set the value of transactionType
     *
     * @return  self
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get the value of orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @return  self
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get the value of successUrl
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * Set the value of successUrl
     *
     * @return  self
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * Get the value of failUrl
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * Set the value of failUrl
     *
     * @return  self
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;

        return $this;
    }

    /**
     * Get the value of domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set the value of domain
     *
     * @return  self
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function concatElements()
    {

        return number_format($this->total, 2, '.', '') . $this->merchantId . number_format($this->subtotal, 2, '.', '') . number_format($this->taxes, 2, '.', '')  . $this->paymentDate . $this->paymentMethod . $this->transactionType . $this->orderId . $this->successUrl . $this->failUrl . $this->domain;
    }

    /**
     * Get the value of secretToken
     */
    public function getSecretToken()
    {
        return $this->secretToken;
    }

    /**
     * Set the value of secretToken
     *
     * @return  self
     */
    public function setSecretToken($secretToken)
    {
        $this->secretToken = $secretToken;

        return $this;
    }

    private function isSecure()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
            || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https');
    }

    public function validateFields()
    {
        $resp = ["success" => false];
        if (!$this->ssl) {
            $resp["msg"] = self::SSL_ERROR;
            $resp["class"] = "alert";
            return $resp;
        }

        $totalValidation = $this->validateAmountField($this->total, 'Total');
        if ($totalValidation['error']) {
            $resp["msg"] = $totalValidation['msg'];
            $resp['class'] = $totalValidation['class'];
            return $resp;
        }

        $subTotalValidation = $this->validateAmountField($this->subtotal, 'Subtotal');
        if ($subTotalValidation['error']) {
            $resp["msg"] = $subTotalValidation['msg'];
            $resp['class'] = $subTotalValidation['class'];
            return $resp;
        }

        $taxesValidation = $this->validateAmountField($this->taxes, 'Impuestos');
        if ($taxesValidation['error']) {
            $resp["msg"] = $taxesValidation['msg'];
            $resp['class'] = $taxesValidation['class'];
            return $resp;
        }

        if ((floatval($this->taxes) + floatval($this->subtotal)) !== floatval($this->total)) {
            $resp["msg"] = sprintf(self::CAMPO_INVALIDO_ERROR, 'Total');
            $resp['class'] = 'invalid';
            return $resp;
        }

        if (!preg_match(self::DOMAIN_REGEX, $this->domain) || strlen($this->domain) > 64) {
            $resp["msg"] = sprintf(self::CAMPO_INVALIDO_ERROR, 'Dominio');
            $resp['class'] = 'invalid';
            return $resp;
        }

        $resp["success"] = true;
        $resp["msg"] = self::FORMULARIO_CORRECTO;

        return $resp;
    }


    public function showAlertError($response)
    {
        echo '<style>';
        include 'main.css';
        echo '</style>';
        $message = $response['msg'];
        $class = $response['class'];
        echo "<div class='$class'>$message</div>";
    }

    public static function checkCredentials($merchantId, $secretKey, $domain)
    {
        try {

            if (!preg_match(self::DOMAIN_REGEX, $domain) || strlen($domain) > 64) {
                return ['success' => false];
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::APIURL . '/validateapikeymerchand');
            curl_setopt($curl, CURLOPT_POST, 1);
            $values = base64_decode($secretKey);
            $secrete = explode('.', $values);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $secrete[1],
                'Content-Type: application/json',
                'version: ' . YAPPY_PLUGIN_VERSION
            ]);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
                'merchantId' => $merchantId,
                'urlDomain' => $domain
            ]));

            $result = curl_exec($curl);

            $response = json_decode($result, true);
            if (isset($response['unixTimestamp'])) {
                $response['unixTimestamp'] = $response['unixTimestamp'] * 1000;
            }

            curl_close($curl);
            return $response;
        } catch (\Throwable $th) {
            return ['success' => false];
        }
    }


    private function validateAmountField($amount, $field)
    {
        $resp = ['error' => true];

        if (empty($amount)) {
            $resp['msg'] = sprintf(self::CAMPO_REQUERIDO_ERROR, $field);
            $resp['class'] = 'invalid';
            return $resp;
        }

        if (!is_numeric($amount) || $amount < 0) {
            $resp['msg'] = sprintf(self::CAMPO_INVALIDO_ERROR, $field);
            $resp['class'] = 'invalid';
            return $resp;
        }

        $resp['error'] = false;
        return $resp;
    }

    private function validate_phone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) == 8 && $phone[0] == '6') {
            return $phone;
        }
        return '';
    }
}
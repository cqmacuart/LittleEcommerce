<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */


namespace Bg;

final class BgFirma
{
    const HASH = 'sha256';
    const DOMAIN_REGEX = '/^(https:\/\/www\.|https:\/\/)?[a-zñ0-9]+([\-\.]{1}[a-zñ0-9]+)*\.[a-z]{2,10}(:[0-9]{1,5})?(\/.*)?$/';
    const DEFAULT_ORDER_ID = 'PEDIDO WEB';

    // MENSAJES DE ERROR
    const SSL_ERROR = 'Para desactivar el modo de pruebas (sandbox), se requiere de un certificado SSL y una conexión segura por HTTPS.';
    const CAMPO_REQUERIDO_ERROR = 'El campo de %s es un campo requerido para el uso del Botón de Pago Yappy.';
    const CAMPO_INVALIDO_ERROR = 'El valor del campo %s es inválido.';

    // MENSAJES DE SUCCESS
    const FORMULARIO_CORRECTO = 'Formulario correcto';

    private $total;
    private $merchantId;
    private $currency;
    private $subtotal;
    private $taxes;
    private $shipping;
    private $discount;
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
    private $phone;

    public function __construct(array $paymentArray, $checkCredentialsResponse, $successUrl = '', $failUrl = '', $domain = '')
    {
        $this->total = $paymentArray['total'];
        $this->merchantId = $paymentArray['merchant'];
        $this->currency = 'US';
        $this->subtotal = $paymentArray['subtotal'];
        $this->taxes = $paymentArray['taxes'];
        $this->discount = $paymentArray['discount'] === '' ? '0.00' : $paymentArray['discount'];
        $this->shipping = $paymentArray['shipping'] === '' ? '0.00' : $paymentArray['shipping'];
        $this->paymentDate = $checkCredentialsResponse['unixTimestamp'];
        $this->paymentMethod = 'YAP';
        $this->transactionType = 'VEN';
        $this->orderId = $paymentArray['orderId'] ? $paymentArray['orderId'] : self::DEFAULT_ORDER_ID;
        $this->successUrl = $successUrl ? mb_strtolower($successUrl) : '';
        $this->failUrl = $failUrl ? mb_strtolower($failUrl) : '';
        $this->domain = mb_strtolower($domain);
        $this->secretToken = $paymentArray['secret'];
        $this->sandbox = $paymentArray['sandbox'];
        $this->ssl = $this->isSecure();
        $this->jwtToken = $checkCredentialsResponse['accessToken'];
        $this->tel = $paymentArray['phone'];
    }

    private function validateNumbers($number)
    {
        $decimal = explode('.', $number);
        if (isset($decimal[1])) {
            if (strlen($decimal[1]) > 2 || (float) $number < 0) {
                return false;
            }
        } elseif ((float) $number < 0) {
            return false;
        }

        return true;
    }

    public function generateCheckout()
    {

        $ok = $this->validateFields();
        if ($ok['success']) {
            $values = base64_decode($this->secretToken);
            $secrete = explode('.', $values);
            $signature = hash_hmac(self::HASH, $this->concatElements(), $secrete[0]);
            $data = [
                'merchantId' => $this->merchantId,
                'total' => number_format($this->total, 2, '.', ''),
                'subtotal' => number_format($this->subtotal, 2, '.', ''),
                'taxes' => number_format($this->taxes, 2, '.', ''),
                'discount' => number_format($this->discount, 2, '.', ''),
                'shipping' => number_format($this->shipping, 2, '.', ''),
                'paymentDate' => $this->paymentDate,
                'paymentMethod' => $this->paymentMethod,
                'transactionType' => $this->transactionType,
                'orderId' => $this->orderId,
                'successUrl' => $this->successUrl,
                'failUrl' => $this->failUrl,
                'domain' => $this->domain,
                'jwtToken' => $this->jwtToken,
                'cancelUrl' => $this->failUrl,
                'platform' => 'prestashop',
                'signature' => $signature,
                'sbx' => $this->sandbox === false ? 'no' : 'yes',
                'tel' => $this->validate_phone($this->tel),
            ];

            return [
                'success' => true,
                'url' => API_URL . '?' . http_build_query($data, '', '&', PHP_QUERY_RFC3986),
            ];
        }

        return $ok;
    }

    public function concatElements()
    {
        return number_format($this->total, 2, '.', '') . $this->merchantId . $this->paymentDate . $this->paymentMethod . $this->transactionType . $this->orderId . $this->successUrl . $this->failUrl . $this->domain;
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
        if (!preg_match(self::DOMAIN_REGEX, $this->domain) || strlen($this->domain) > 64) {
            $resp['success'] = false;
            $resp['msg'] = sprintf(self::CAMPO_INVALIDO_ERROR, 'Dominio');
            $resp['class'] = 'invalid';

            return $resp;
        }

        $resp['success'] = true;
        $resp['msg'] = self::FORMULARIO_CORRECTO;

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
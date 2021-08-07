<?php

namespace App\Http\Controllers;

define('API_URL', 'https://pagosbg.bgeneral.com');
define('UPDATE_URL', 'https://bgx-digital-prod-ecommerce-plugins.s3.amazonaws.com/prestashop/updates/details.json');
require 'BgFirma.php';

use Bg\BgFirma;

use Illuminate\Http\Request;
use App\Configuracion;


class YappyController extends Controller
{
    const DOMAIN_REGEX = '/^(https:\/\/www\.|https:\/\/)?[a-zñ0-9]+([\-\.]{1}[a-zñ0-9]+)*\.[a-z]{2,10}(:[0-9]{1,5})?(\/.*)?$/';
    private $bgFirma;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yappy_conf = Configuracion::where("core", "yappy")->orderBy("id", "ASC")->get();
        if (sizeof($yappy_conf)) {
            return response()->json($yappy_conf, 200);
        } else {
            return response()->json(NULL, 204);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada = $request->all();
        $fulldata = [
            ["core" => "yappy", "key" => "ID_DEL_COMERCIO", "value" => $entrada["param_1"]],
            ["core" => "yappy", "key" => "CLAVE_SECRETA", "value" => $entrada["param_2"]],
            ["core" => "yappy", "key" => "DOMINIO", "value" => $entrada["param_3"]],
            ["core" => "yappy", "key" => "MODO_DE_PRUEBAS", "value" => $entrada["param_4"]],
            ["core" => "yappy", "key" => "ENABLED", "value" => $entrada["param_5"]],
        ];
        //
        $exist = Configuracion::where("core", "yappy")->count();
        if ($exist == 0) {
            foreach ($fulldata as $value) {
                Configuracion::create($value);
            }
            return response()->json($value, 200);
        } else {
            foreach ($fulldata as $value) {
                $record = Configuracion::where("core", "yappy")->where("key", $value["key"])->get();
                $record[0]->update($value);
                // var_dump($record[0]);
            }
            return response()->json($value, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function verify(Request $request)
    {
        try {
            //code...

            $data = $request->all();
            // verificar credenciales
            $response = $this->checkCredentials($data["param_1"], $data["param_2"], "https://ebanumsystem.com/");
            if ($response && $response["success"]) {
                $this->yappyLog("Credenciales correctas.", 1);
                $paymentarray = [
                    'total' => $data["sumary"]['total_price'],
                    'subtotal' => $data["sumary"]['total_price_without_tax'],
                    'taxes' => $data["sumary"]['total_tax'],
                    'discount' => $data["sumary"]['total_discounts'],
                    'shipping' => $data["sumary"]['total_shipping'],
                    'orderId' => strtoupper(uniqid('ORDYP')),
                    'secret' => $data["param_2"],
                    'merchant' => $data["param_1"],
                    'phone' => $data["sumary"]['phone'],
                    'sandbox' => $data["param_4"] == 1 ? true : false,
                ];

                $this->bgFirma = new BgFirma($paymentarray, $response, $data["param_3"] . "/yappy/response/?orden=" . $paymentarray['orderId'],  $data["param_3"] . "/yappy/error/",  $data["param_3"]);
                $checkout = $this->bgFirma->generateCheckout();
                if ($checkout && $checkout["success"]) {
                    $this->yappyLog("Credenciales correctas.", 1);
                    return response()->json(["result" => $checkout["success"], "url" => $checkout["url"], "ref" => $paymentarray['orderId']], 200);
                } else {
                    $this->yappyLog("Ocurrio un error al tratar de redireccionar al cliente.", 3);
                    return response()->json(["result" => "Ocurrio un error al tratar de redireccionar al cliente."], 300);
                }
            } else {
                $this->yappyLog("Credenciales incorrectas.", 3);
                return response()->json(["result" => "Credenciales incorrectas"], 300);
            }
        } catch (\Throwable $th) {
            $this->yappyLog($th->getMessage(), 4);
            return response()->json(["result" => "Credenciales incorrectas"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function yappyLog($msg, $code)
    {
        $logfile = fopen("yappy.log", "a");
        fwrite($logfile, date("dmY:His") . "-- code:$code --" . PHP_EOL);
        fwrite($logfile, "$msg" . PHP_EOL);
        fwrite($logfile, "----------------------------------------\n" . PHP_EOL);
        fclose($logfile);
    }

    private function checkCredentials($merchantId, $secretKey, $domain)
    {
        try {
            if (!preg_match(self::DOMAIN_REGEX, $domain) || strlen($domain) > 64) {
                return ['success' => false];
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, API_URL . '/validateapikeymerchand');
            curl_setopt($curl, CURLOPT_POST, 1);
            $values = base64_decode($secretKey);
            $secrete = explode('.', $values);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $secrete[1],
                'Content-Type: application/json',
            ]);

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
                'merchantId' => $merchantId,
                'urlDomain' => $domain,
            ]));
            $result = curl_exec($curl);
            $response = json_decode($result, true);
            if (isset($response['unixTimestamp'])) {
                $response['unixTimestamp'] = $response['unixTimestamp'] * 1000;
            }

            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return ['success' => $th->getMessage()];
        }
    }
}
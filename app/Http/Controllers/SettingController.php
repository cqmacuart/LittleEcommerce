<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Setting;
use App\Configuracion;

class SettingController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware("EsAdmin");
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $settings = Setting::findOrFail(1);
        return response()->json($settings, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function saveFileImage(Request $request)
    {
        if ($archivo = $request->file("file")) {
            $nombre = $archivo->getClientOriginalName();
            $archivo->move('img/settings', $nombre);
        }
        return $nombre;
    }

    public function saveResponsive(Request $request)
    {
        if ($archivo = $request->file("file")) {
            $archivo->move('images/icons/', $request->text);
            return response()->json(200);
        } else {
            return response()->json(204);
        }
    }

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
        //
    }

    public function advancedSettings(Request $request)
    {
        $entrada = $request->all();
        $fulldata = [
            ["core" => "advanced", "key" => "CATALOGUE_MODE", "value" => $entrada["advanced_param_1"]],
        ];
        //
        $exist = Configuracion::where("core", "advanced")->count();
        if ($exist == 0) {
            foreach ($fulldata as $value) {
                Configuracion::create($value);
            }
            return response()->json($value, 200);
        } else {
            foreach ($fulldata as $value) {
                $record = Configuracion::where("core", "advanced")->where("key", $value["key"])->get();
                $record[0]->update($value);
                // var_dump($record[0]);
            }
            return response()->json($value, 200);
        }
    }
    public function getAdvancedSettings()
    {
        $exist = Configuracion::where("core", "advanced")->count();
        if ($exist > 0) {
            $value = Configuracion::where("core", "advanced")->get();
            return response()->json($value, 200);
        } else {
            return response()->json($value = [], 204);
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
        $setting = Setting::all();
        $setting = \App\Setting::findOrFail(1);
        return view('/admin/settings/edit', compact("setting", "setting"));
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
        $setting = Setting::findOrFail($id);
        $entrada = $request->all();
        $setting->update($entrada);
        $this->builtFBCSV();
        return response()->json($setting, 200);
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

    public function builtFBCSV()
    {
        $productos = \App\Product::where("estado_id", 1)->get();
        $ajustes = Setting::first();
        //Añadir primera fila de encabezados al arreglo
        $encabezados = ["id", "title", "description", "availability", "inventory", "condition", "price", "link", "image_link", "brand"];
        $csvProductsArray[] = $encabezados;
        if ($productos) {
            //crear arreglo de información que irá al csv
            foreach ($productos as $value) {
                $csvProductsArray[] = [$value->id, ucfirst(htmlentities($value->nombre)), ucfirst(htmlentities($value->short_des)), "in stock", 100, "new", $value->price . " " . $ajustes->currency, URL::to("/") . '/producto/' . $value->id . "/", URL::to("/") . "/img/products/" . rawurlencode($value->image), "no-brand"];
            }
            //ARCHIVO DELIMITADO POR PUNTO Y COMA (;)
            //variables básicas: Titulo del archivo para FB
            //crear directorio si no existe
            $docTitle = "files/fb_business/facebook_business_product_csv.csv";
            $ruta = $docTitle;
            $delimitador = ",";
            $encapsulador = '"';

            // Generar el archivo linea a linea
            $file_handle = fopen($ruta, "w");
            foreach ($csvProductsArray as $value) {
                fputcsv($file_handle, $value, $delimitador, $encapsulador);
            }
            rewind($file_handle);
            fclose($file_handle);
        }
    }
}

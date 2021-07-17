<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;

class EpaycoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $epayco_conf = Configuracion::where("core", "epayco")->orderBy("id", "ASC")->get();
        if (sizeof($epayco_conf)) {
            return response()->json($epayco_conf, 200);
        } else {
            return response()->json(NULL, 204);
        }
    }

    public function postReceive(Request $request)
    {
        return redirect('/epayco/response/?ref_payco=' . $request->ref_payco);
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
            ["core" => "epayco", "key" => "ENABLED", "value" => $entrada["epayco_param_5"]],
            ["core" => "epayco", "key" => "P_CUST_ID_CLIENTE", "value" => $entrada["epayco_param_1"]],
            ["core" => "epayco", "key" => "P_KEY", "value" => $entrada["epayco_param_2"]],
            ["core" => "epayco", "key" => "PUBLIC_KEY", "value" => $entrada["epayco_param_3"]],
            ["core" => "epayco", "key" => "PRIVATE_KEY", "value" => $entrada["epayco_param_4"]],
            ["core" => "epayco", "key" => "MODO", "value" => $entrada["epayco_param_6"]],
        ];
        //
        $exist = Configuracion::where("core", "epayco")->count();
        if ($exist == 0) {
            foreach ($fulldata as $value) {
                Configuracion::create($value);
            }
            return response()->json($value, 200);
        } else {
            foreach ($fulldata as $value) {
                $record = Configuracion::where("core", "epayco")->where("key", $value["key"])->get();
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
}

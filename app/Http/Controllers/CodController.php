<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;

class CodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cod_conf = Configuracion::where("core", "cod")->orderBy("id", "ASC")->get();
        if (sizeof($cod_conf)) {
            return response()->json($cod_conf, 200);
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
            ["core" => "cod", "key" => "ENABLED", "value" => $entrada["cod_param_1"]],
            ["core" => "cod", "key" => "ONLYCASH", "value" => $entrada["cod_param_2"]],
        ];
        //
        $exist = Configuracion::where("core", "cod")->count();
        if ($exist == 0) {
            foreach ($fulldata as $value) {
                Configuracion::create($value);
            }
            return response()->json($value, 200);
        } else {
            foreach ($fulldata as $value) {
                $record = Configuracion::where("core", "cod")->where("key", $value["key"])->get();
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

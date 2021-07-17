<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;

class PaguelofacilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paguelofacil_conf = Configuracion::where("core", "paguelofacil")->orderBy("id", "ASC")->get();
        if (sizeof($paguelofacil_conf)) {
            return response()->json($paguelofacil_conf, 200);
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
            ["core" => "paguelofacil", "key" => "ENABLED", "value" => $entrada["paguelofacil_param_3"]],
            ["core" => "paguelofacil", "key" => "CCWL", "value" => $entrada["paguelofacil_param_1"]],
            ["core" => "paguelofacil", "key" => "URL_RETURN", "value" => $entrada["paguelofacil_param_2"]],
        ];
        //
        $exist = Configuracion::where("core", "paguelofacil")->count();
        if ($exist == 0) {
            foreach ($fulldata as $value) {
                Configuracion::create($value);
            }
            return response()->json($value, 200);
        } else {
            foreach ($fulldata as $value) {
                $record = Configuracion::where("core", "paguelofacil")->where("key", $value["key"])->get();
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

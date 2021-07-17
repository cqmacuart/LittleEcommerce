<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Setting;

class SendMailController extends Controller
{
    public $correo;
    //
    public function nuevoPedido(Request $request)
    {
        $peticion = $request->all();
        $settings = Setting::first();
        if ($settings && $settings->email) {
            $this->correo = $settings->email;
            $info = [
                "pedido" => $peticion["pedido"],
                "enlace" => $peticion["enlace"],
            ];
            $datos = [
                "titulo" => "Se ha generado un nuevo pedido en su negocio.",
                "contenido" => $info
            ];
            Mail::send("emails.nuevo", $datos, function ($mensaje) {
                $mensaje->to($this->correo)->subject("NUEVO PEDIDO !!!");
            });
            return response()->json(200);
        } else {
            return response()->json(204);
        }
    }

    public function nuevoEstado(Request $request)
    {
        $peticion = $request->all();
        $settings = Setting::first();
        if ($settings && $settings->email) {
            $this->correo = $settings->email;
            $info = [
                "pedido" => $peticion["pedido"],
                "enlace" => $peticion["enlace"],
            ];
            $datos = [
                "titulo" => "Su pedido ha cambiado de estado.",
                "contenido" => $info
            ];
            Mail::send("emails.nuevo", $datos, function ($mensaje) {
                $mensaje->to($this->correo, "Destinatario")->subject("ESTADO DE SU PEDIDO !!!");
            });
            return response()->json(200);
        } else {
            return response()->json(204);
        }
    }

    public function remember(Request $request)
    {
        $this->correo = $request->correo;
        $info = [
            "mensaje" => "Se ha generado una nueva contraseña para que pueda ingresar al sistema. Se recomienda cambiarla luego de ingresar.",
            "pass" => $request->pass,
        ];
        $datos = [
            "titulo" => "Estimado usuario",
            "contenido" => $info
        ];
        Mail::send("emails.remember", $datos, function ($mensaje) {
            $mensaje->to($this->correo)->subject("NUEVA CONTRASEÑA !!!");
        });
    }
}

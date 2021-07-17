<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UsersController extends Controller
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
        $users = User::addSelect(['role' => Role::select('nombre')->whereColumn('role_id', 'roles.id')])->get();

        return response()->json($users, 200);
    }

    // verificar que correo existe para recuperación de contraseña
    public function remember(Request $request)
    {
        $usuario = User::where("email", $request->correo)->count();
        if ($usuario > 0) {
            $nuevopass = substr(md5(rand()), 0, 5);
            User::first()->where("email", $request->correo)->update(["password" => bcrypt($nuevopass)]);
            return response()->json($nuevopass, 200);
        } else {
            return response()->json([], 204);
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
        $roles = Role::all();
        $setting = \App\Setting::findOrFail(1);
        foreach ($roles as $rol) {
            $options[$rol->id] = $rol->nombre;
        }
        return view("admin.users.create", compact('options', 'setting'));
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
        $entrada = $request->all();
        $entrada['password'] = bcrypt($request->password);
        User::create($entrada);
        return redirect('/admin/users');
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
        $user = User::findOrFail($id);
        return response()->json($user, 200);
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
        $user = User::findOrFail($id);
        $entrada = $request->all();
        $entrada["password"] = bcrypt($request->password);
        $user->update($entrada);
        return response()->json($user, 200);
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/admin/users');
    }
}

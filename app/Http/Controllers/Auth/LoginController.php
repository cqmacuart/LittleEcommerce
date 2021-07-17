<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = $request->usuario;
        $pass = $request->password;
        $response = Auth::attempt(['email' => $user, 'password' => $pass]);

        if ($response) {
            return response()->json(["userAuth" => Auth::user(), "code" => 200]);
        } else {
            return response()->json(["code" => 401]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    }
}

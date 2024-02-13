<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\createUsersRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(AuthRequest $request)
    {
        //dd($request);
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            return redirect()->route('accueil.index');
        } else {
            return redirect()->back()->with('error_msg', 'Paramètre de connexion non reconnu');
        }
    }

   
}

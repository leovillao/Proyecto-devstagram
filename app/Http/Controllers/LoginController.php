<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required', // valida el campo de password y el password de confirmacion
        ]);

        if (!auth()->attempt($request->only('email','password'),$request->remember)) {
            return back()->with('mensaje',"Credenciales incorrectas");
        }

        return redirect()->route('posts.index',auth()->user()->username);
    }
}

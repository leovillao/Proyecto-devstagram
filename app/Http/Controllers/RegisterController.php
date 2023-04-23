<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
//      Se modifica el campo a validar desde el arreglo de datos modifcando la structura para que pueda ser validador
//      y mostrar ese mensaje en la consola de error del formulario
        $request->request->add(['username' => Str::slug(Str::slug($request->username))]);
//        validacion de datos del formulario enviado
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email|max:60',
            'username' => 'required|unique:users|min:8|max:15',
            'password' => 'required|confirmed|min:3', // valida el campo de password y el password de confirmacion
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

//        autenticar a usuario
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

//        otra forma de autenticar
        auth()->attempt($request->only('email','password'));

// redirecciona a la pagina despues del respectivo login
        return redirect()->route('posts.index',auth()->user()->username);

    }
}

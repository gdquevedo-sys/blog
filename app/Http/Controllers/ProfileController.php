<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Profile $profile)
    {
        //
    }

    public function edit(Profile $profile)
    {
        //Retorna la vista del formulario
        return view('subscriber.profiles.edit', compact('profile'));
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        //Creamos una variable
        $user = Auth::user();

        //Comprobamos si el usuario sube una foto
        if($request->hasFile('photo')){
            //Eliminar foto anterior
            File::delete(public_path('storage/' . $profile->photo));
            //Asignar nueva foto
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user->profile->photo;
        }

        //Asignar nombre y correo
        $user->name = $request->name;
        $user->email = $request->email;
        //Asignar foto
        $user->profile->photo = $photo;

        //Guardamos campos de usuario
        $user->save();
        //Guardamos campos de perfil
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }

    public function destroy(Profile $profile)
    {
        //
    }
}

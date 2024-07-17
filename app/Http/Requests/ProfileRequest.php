<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'photo' => 'nullable|mimes:jpeg, jpg, png',
            
            //Creamos las reglas de validación
            'profession' => 'nullable|max:60',
            'about' => 'nullable|max:255',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
        ];
    }
}

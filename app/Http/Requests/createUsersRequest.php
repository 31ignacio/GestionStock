<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de l\'administrateur est requis',
            'name.min' => 'Le nom doit contenir au moin trois (03) caractères',

            'email.required' => 'Le mail est requis',
            'email.email' => 'Le mail n\'est pas valide',
            'email.unique' => 'Cette adresse mail est déjà lié a un compte',
            'password.required' => 'Le mot de passe de l\'administrateur est requis',
            'password.min' => 'Le mot de passe doit excéder cinq (05) caractères',

           
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'telephone' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'ifu' => 'required',
            'societe' => 'required',
            'sexe' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'telephone.required' => 'Le téléphone est requis',
            'prenom.required' => 'Le prenom est requis',
            'nom.required' => 'Le nom est requis',
            'ifu.required' => 'L\'ifu est requis',
            'sexe.required' => 'La civilité est requis'

        ];
    }
}

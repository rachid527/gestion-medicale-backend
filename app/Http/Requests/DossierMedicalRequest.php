<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DossierMedicalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autoriser toutes les requêtes (adapter selon la logique métier)
    }

    public function rules(): array
    {
        return [
            'id_patient'    => 'required|exists:users,id|unique:dossier_medicals,id_patient,' . $this->route('id') . ',id_patient',
            'groupe_sanguin' => 'nullable|string|max:5',
            'allergies'     => 'nullable|string',
            'antecedents'   => 'nullable|string',
            'poids'         => 'nullable|numeric|min:0',
            'remarques'     => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'id_patient.required' => 'Le patient est obligatoire.',
            'id_patient.exists'   => 'Le patient spécifié n’existe pas.',
            'id_patient.unique'   => 'Ce patient possède déjà un dossier médical.',

            'groupe_sanguin.max' => 'Le groupe sanguin ne peut pas dépasser 5 caractères.',

            'poids.numeric' => 'Le poids doit être un nombre.',
            'poids.min'     => 'Le poids doit être supérieur ou égal à 0.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erreurs de validation',
            'errors'  => $validator->errors()
        ], 422));
    }
}

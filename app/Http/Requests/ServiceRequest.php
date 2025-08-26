<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'nom_service' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Messages personnalisés
     */
    public function messages(): array
    {
        return [
            'nom_service.required' => 'Le nom du service est obligatoire.',
            'nom_service.string'   => 'Le nom du service doit être une chaîne de caractères.',
            'nom_service.max'      => 'Le nom du service ne peut pas dépasser 255 caractères.',
            'description.string'   => 'La description doit être une chaîne de caractères.',
            'description.max'      => 'La description ne peut pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Réponse en cas d’échec de validation
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors'  => $validator->errors()
        ], 422));
    }
}

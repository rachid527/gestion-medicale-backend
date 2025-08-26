<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Specialite;

class CreateSpecialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_specialite' => 'required|string',
            'description' => 'nullable|string',
            'id_service' => 'required|exists:services,id_service',
        ];
    }

    public function messages()
    {
        return [
            'nom_specialite.required' => 'Le nom de la spécialité est obligatoire',
            'id_service.required' => 'Le service est obligatoire',
            'id_service.exists' => 'Le service sélectionné n’existe pas',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors'  => $validator->errors()
        ], 422));
    }
}

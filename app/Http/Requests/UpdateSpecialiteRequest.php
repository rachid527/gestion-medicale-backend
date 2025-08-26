<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Specialite;

class UpdateSpecialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_specialite' => 'sometimes|string',
            'description'    => 'nullable|string',
            'id_service'     => 'sometimes|exists:services,id_service',
        ];
    }

    public function messages()
    {
        return [
            'id_service.exists' => 'Le service sélectionné n’existe pas',
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

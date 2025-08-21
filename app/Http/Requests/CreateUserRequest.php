<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;

class CreateUserRequest extends FormRequest
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
        return User::$rules;
    }

    public function messages()
    {
        return [
            'prenom.required' => 'prenom is a required field',
            'nom.required' => 'nom is a required field',
            'email.required' => 'email is a required field',
            'email.required' => 'email field must be an email',
            'email.unique' => 'this email is already in use',
            'password.required' => 'password is a required field',
            'role.in' => 'role must be "admin" or "patient" or "medecin"',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }

}

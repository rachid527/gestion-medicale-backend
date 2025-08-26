<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DisponibiliteServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser toutes les requêtes (adapter si besoin)
    }

    public function rules(): array
    {
        // Règles par défaut (création)
        $rules = [
            'id_service'   => 'required|exists:services,id_service',
            'jour_semaine' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'heure_debut'  => 'required|date_format:H:i',
            'heure_fin'    => 'required|date_format:H:i|after:heure_debut',
            'estOuvert'    => 'boolean',
        ];

        // Si c'est une mise à jour (PUT / PATCH), certaines règles deviennent optionnelles
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['id_service']   = 'sometimes|exists:services,id_service';
            $rules['jour_semaine'] = 'sometimes|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche';
            $rules['heure_debut']  = 'sometimes|date_format:H:i';
            $rules['heure_fin']    = 'sometimes|date_format:H:i|after:heure_debut';
            $rules['estOuvert']    = 'sometimes|boolean';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'id_service.required'   => 'Le service est obligatoire.',
            'id_service.exists'     => 'Le service spécifié n’existe pas.',
            'jour_semaine.required' => 'Le jour de la semaine est obligatoire.',
            'jour_semaine.in'       => 'Le jour de la semaine doit être un jour valide (Lundi à Dimanche).',
            'heure_debut.required'  => 'L’heure de début est obligatoire.',
            'heure_debut.date_format' => 'L’heure de début doit être au format HH:mm.',
            'heure_fin.required'    => 'L’heure de fin est obligatoire.',
            'heure_fin.date_format' => 'L’heure de fin doit être au format HH:mm.',
            'heure_fin.after'       => 'L’heure de fin doit être postérieure à l’heure de début.',
            'estOuvert.boolean'     => 'Le champ estOuvert doit être vrai ou faux (boolean).',
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

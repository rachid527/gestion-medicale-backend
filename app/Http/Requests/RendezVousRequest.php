<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser toutes les requêtes (adapter si besoin)
    }

    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            // ✅ Création d’un rendez-vous
            return [
                'date_rdv'       => 'required|date',
                'heure_rdv'      => 'required|date_format:H:i',
                'motif'          => 'nullable|string',
                'id_patient'     => 'required|exists:users,id',
                'id_medecin'     => 'required|exists:users,id',
                'id_specialite'  => 'required|exists:specialites,id_specialite',
                // ⚠️ etat & type_action sont gérés dans le Controller (pas besoin de les envoyer côté front)
            ];
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // ✅ Mise à jour d’un RDV (annulation / reprogrammation / confirmation)
            return [
                'etat'             => 'sometimes|in:en_attente,confirme,annule,reprogramme',
                'motif'            => 'sometimes|nullable|string',
                'modifie_par'      => 'sometimes|in:patient,medecin',
                'type_action'      => 'sometimes|in:prise,confirmation,annulation,reprogrammation',
                'date_modification' => 'sometimes|nullable|date',
                'date_precedente'  => 'sometimes|nullable|date',
                'date_rdv'         => 'sometimes|date',
                'heure_rdv'        => 'sometimes|date_format:H:i',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'date_rdv.required'      => 'La date du rendez-vous est obligatoire.',
            'date_rdv.date'          => 'La date du rendez-vous doit être une date valide.',
            'heure_rdv.required'     => 'L’heure du rendez-vous est obligatoire.',
            'heure_rdv.date_format'  => 'L’heure du rendez-vous doit être au format HH:mm.',

            'id_patient.required'    => 'Le patient est obligatoire.',
            'id_patient.exists'      => 'Le patient spécifié n’existe pas.',

            'id_medecin.required'    => 'Le médecin est obligatoire.',
            'id_medecin.exists'      => 'Le médecin spécifié n’existe pas.',

            'id_specialite.required' => 'La spécialité est obligatoire.',
            'id_specialite.exists'   => 'La spécialité spécifiée n’existe pas.',

            'etat.in'                => 'L’état doit être : en_attente, confirme, annule ou reprogramme.',
            'modifie_par.in'         => 'Le champ modifie_par doit être patient ou medecin.',
            'type_action.in'         => 'L’action doit être : prise, confirmation, annulation ou reprogrammation.',
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

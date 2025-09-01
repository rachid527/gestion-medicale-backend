<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UtilisateurController;
use App\Http\Controllers\API\RendezVousController;
use App\Http\Controllers\API\DossierMedicalController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SpecialiteController;
use App\Http\Controllers\API\DisponibiliteServiceController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Toutes les routes de ton API Laravel
| Préfixées automatiquement par /api
|--------------------------------------------------------------------------
*/

// ----------------- AUTH -----------------
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

// ----------------- UTILISATEURS -----------------
Route::prefix('utilisateurs')->group(function () {
    Route::get('/', [UtilisateurController::class, 'index']);      // Liste tous les utilisateurs
    Route::post('/', [UtilisateurController::class, 'store']);     // Créer un utilisateur
    Route::get('/{id}', [UtilisateurController::class, 'show']);   // Voir un utilisateur
    Route::put('/{id}', [UtilisateurController::class, 'update']); // Modifier un utilisateur
    Route::delete('/{id}', [UtilisateurController::class, 'destroy']); // Supprimer un utilisateur

    // 🔹 Médecins par spécialité
    Route::get('/medecins/specialite/{id_specialite}', [UtilisateurController::class, 'getMedecinsBySpecialite']);
});

// ----------------- PATIENTS SUIVIS PAR UN MÉDECIN -----------------
Route::get('/utilisateurs/medecin/{id_medecin}/patients', [UtilisateurController::class, 'getPatientsByMedecin']);

// ----------------- STATISTIQUES MÉDECIN (patients & RDV) -----------------
Route::get('/medecin/{id}/stats', [UtilisateurController::class, 'getMedecinStats']);

// ----------------- RENDEZ-VOUS -----------------
Route::prefix('rendezvous')->group(function () {
    Route::get('/', [RendezVousController::class, 'index']);      // Liste RDV
    Route::post('/', [RendezVousController::class, 'store']);     // Créer RDV
    Route::get('/{id}', [RendezVousController::class, 'show']);   // Voir un RDV
    Route::put('/{id}', [RendezVousController::class, 'update']); // Modifier RDV
    Route::delete('/{id}', [RendezVousController::class, 'destroy']); // Supprimer RDV

    Route::get('/patient/{id}', [RendezVousController::class, 'getByPatient']);
    Route::get('/medecin/{id}', [RendezVousController::class, 'getByMedecin']);
});

// ----------------- DOSSIERS MEDICAUX -----------------
Route::prefix('dossiers')->group(function () {
    Route::get('/', [DossierMedicalController::class, 'index']);         // Liste dossiers
    Route::post('/', [DossierMedicalController::class, 'store']);        // Créer dossier
    Route::get('/patient/{id}', [DossierMedicalController::class, 'show']); // Voir dossier patient
    Route::put('/patient/{id}', [DossierMedicalController::class, 'update']); // Modifier dossier patient
    Route::delete('/patient/{id}', [DossierMedicalController::class, 'destroy']); // Supprimer dossier patient
});

// ----------------- SERVICES -----------------
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);      // Liste services
    Route::post('/', [ServiceController::class, 'store']);     // Créer service
    Route::get('/{id}', [ServiceController::class, 'show']);   // Voir service
    Route::put('/{id}', [ServiceController::class, 'update']); // Modifier service
    Route::delete('/{id}', [ServiceController::class, 'destroy']); // Supprimer service
});

// ----------------- SPECIALITES -----------------
Route::prefix('specialites')->group(function () {
    Route::get('/', [SpecialiteController::class, 'index']);      // Liste spécialités
    Route::post('/', [SpecialiteController::class, 'store']);     // Créer spécialité
    Route::get('/{id}', [SpecialiteController::class, 'show']);   // Voir spécialité
    Route::put('/{id}', [SpecialiteController::class, 'update']); // Modifier spécialité
    Route::delete('/{id}', [SpecialiteController::class, 'destroy']); // Supprimer spécialité

    // 🔹 Spécialités par service
    Route::get('/service/{id_service}', [SpecialiteController::class, 'getByService']);
});

// ----------------- DISPONIBILITES -----------------
Route::prefix('disponibilites')->group(function () {
    Route::get('/', [DisponibiliteServiceController::class, 'index']);      // Liste disponibilités
    Route::post('/', [DisponibiliteServiceController::class, 'store']);     // Créer disponibilité
    Route::get('/{id}', [DisponibiliteServiceController::class, 'show']);   // Voir disponibilité
    Route::put('/{id}', [DisponibiliteServiceController::class, 'update']); // Modifier disponibilité
    Route::delete('/{id}', [DisponibiliteServiceController::class, 'destroy']); // Supprimer disponibilité

    // 🔹 Disponibilités par service
    Route::get('/service/{id_service}', [DisponibiliteServiceController::class, 'getByService']);
});

// ----------------- NOTIFICATIONS -----------------
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::get('/{id}', [NotificationController::class, 'show']);
    Route::put('/{id}/marquer-lu', [NotificationController::class, 'markAsRead']);
});

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

// Auth routes (publiques)

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Utilisateurs
Route::prefix('utilisateurs')->group(function () {
    Route::get('/', [UtilisateurController::class, 'index']);
    Route::post('/', [UtilisateurController::class, 'store']);
    Route::get('/{id}', [UtilisateurController::class, 'show']);
    Route::put('/{id}', [UtilisateurController::class, 'update']);
    Route::delete('/{id}', [UtilisateurController::class, 'destroy']);
});

// Rendez-vous
Route::prefix('rendezvous')->group(function () {
    Route::get('/', [RendezVousController::class, 'index']);
    Route::post('/', [RendezVousController::class, 'store']);
    Route::get('/{id}', [RendezVousController::class, 'show']);
    Route::put('/{id}', [RendezVousController::class, 'update']);
    Route::delete('/{id}', [RendezVousController::class, 'destroy']);
});

// Dossiers médicaux
Route::prefix('dossiers')->group(function () {
    Route::get('/patient/{id}', [DossierMedicalController::class, 'show']);
    Route::put('/patient/{id}', [DossierMedicalController::class, 'update']);
});

// Services
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::put('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
});

// Spécialités
Route::prefix('specialites')->group(function () {
    Route::get('/', [SpecialiteController::class, 'index']);
    Route::post('/', [SpecialiteController::class, 'store']);
    Route::get('/{id}', [SpecialiteController::class, 'show']);
    Route::put('/{id}', [SpecialiteController::class, 'update']);
    Route::delete('/{id}', [SpecialiteController::class, 'destroy']);
});

// Disponibilités
Route::prefix('disponibilites')->group(function () {
    Route::get('/', [DisponibiliteServiceController::class, 'index']);
    Route::post('/', [DisponibiliteServiceController::class, 'store']);
    Route::get('/{id}', [DisponibiliteServiceController::class, 'show']);
    Route::put('/{id}', [DisponibiliteServiceController::class, 'update']);
    Route::delete('/{id}', [DisponibiliteServiceController::class, 'destroy']);
});

// // Notifications
// Route::prefix('notifications')->group(function () {
// Route::get('/', [NotificationController::class, 'index']);
// Route::get('/{id}', [NotificationController::class, 'show']);
// Route::put('/{id}/marquer-lu', [NotificationController::class, 'markAsRead']);
// });
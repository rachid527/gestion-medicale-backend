<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{
    /**
     * Liste tous les services
     */
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Créer un nouveau service
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service créé avec succès',
            'data'    => $service
        ], 201);
    }

    /**
     * Afficher un service spécifique
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    /**
     * Mettre à jour un service
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);

        $service->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service mis à jour avec succès',
            'data'    => $service
        ]);
    }

    /**
     * Supprimer un service
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service supprimé avec succès'
        ]);
    }
}

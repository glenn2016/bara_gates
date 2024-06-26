<?php

namespace App\Http\Controllers;

use App\Models\Contacte;
use Illuminate\Http\Request;

class ContacteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'Contactes' =>  Contacte::all(),
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des contacts',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){
        try {
            $validatedData = $request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'message' => ['required', 'string', 'max:255'],
            ]);
            return response()->json([
                'message' => 'Contact créé avec succès',
                'contacte' => Contacte::create($validatedData),
                'status'=>200
            ], );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création du contact',
                'error' => $e->getMessage(),
                'status'=>500
            ], );
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id){
        try {
        return response()->json([
            'contacte' => Contacte::find($id),
            'message' => 'contacte recuperer',
            'status' => 200
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Le contact demandé n\'a pas été trouvé',
                'error' => $e->getMessage(),
                'status' => 404
            ], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function softDelete($id)
    {
        try {
            $contacte = Contacte::findOrFail($id);
            $contacte->delete();
            return response()->json([
                'message' => 'Contact supprimé avec succès',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression du contact',
                'error' => $e->getMessage(),
                'status' => 500
            ], );
        }
    }
}
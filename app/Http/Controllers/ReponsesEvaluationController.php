<?php

namespace App\Http\Controllers;

use App\Models\ReponsesEvaluation;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReponsesEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'reponsesEvaluation' => ReponsesEvaluation::with(['questionsEvaluation.evaluation','evaluateur','evaluer'])->get(),
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des réponses d\'évaluation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function questionsAndReponsesByCategory($categorieId)
    {
        // Récupérer la catégorie
        $categorie = Categorie::findOrFail($categorieId);
        // Récupérer les questions liées à cette catégorie avec leurs réponses
        // Retourner les données au format JSON
        return response()->json($categorie->questions()->with('reponses')->get());
    }

    public function questionsAndReponsesByCategoryAndEvaluation($categorieId, $evaluationId)
    {
        // Récupérer la catégorie
        $categorie = Categorie::findOrFail($categorieId);

        // Récupérer les questions liées à cette catégorie via la table pivot
        $questions = $categorie->questionsEvaluations()
                               ->wherePivot('categorie_id', $categorieId) // Filtrer par catégorie sur la table pivot
                               ->where('evaluation_id', $evaluationId)    // Filtrer par évaluation sur la table questions
                               ->with('reponsesEvaluation')               // Charger les réponses associées
                               ->get();

        // Retourner les données au format JSON
        return response()->json($questions);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    /*
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'questions_evaluations_id' => ['required', 'numeric'], // Assurez-vous que evenement_id est numérique
            'nom' => ['required', 'string', 'max:255'],
            'evaluer_id' => ['required', 'numeric'],
        ]);

        $user = Auth::user(); // Utilisez la méthode statique auth() de la classe Auth pour récupérer l'utilisateur authentifié
        $validatedData = $validator->validated();
        $reponsesEvaluation = new ReponsesEvaluation();
        $reponsesEvaluation->nom = $validatedData['nom'];
        $reponsesEvaluation->evaluatuer_id= $user->id; // Assurez-vous d'accéder à l'attribut id de l'utilisateur
        $reponsesEvaluation->questions_evaluations_id = $validatedData['questions_evaluations_id'];
        $reponsesEvaluation->evaluer_id = $validatedData['evaluer_id'];
        $reponsesEvaluation->save();
        return response()->json([
            'message' => 'reponsesEvaluation créé avec succès',
            'reponsesEvaluation' => $reponsesEvaluation,
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reponsesEvaluation = ReponsesEvaluation::with(['questionsEvaluation.evaluation','evaluateur','evaluer'])->find($id);
        if (!$reponsesEvaluation) {
            return response()->json([
                'message' => 'reponsesEvaluation non trouvé',
                'status' => 404
            ], 404);
        }
        return response()->json([
            'reponsesEvaluation' => $reponsesEvaluation,
            'status' => 200
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    /*
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'questions_evaluations_id' => ['required', 'numeric'], // Assurez-vous que evenement_id est numérique
            'nom' => ['required', 'string', 'max:255'],
            'evaluer_id' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        $user = Auth::user(); // Utilisez la méthode statique auth() de la classe Auth pour récupérer l'utilisateur authentifié
        $validatedData = $validator->validated();
        $reponsesEvaluation = new ReponsesEvaluation();
        $reponsesEvaluation->nom = $validatedData['nom'];
        $reponsesEvaluation->evaluatuer_id= $user->id; // Assurez-vous d'accéder à l'attribut id de l'utilisateur
        $reponsesEvaluation->questions_evaluations_id = $validatedData['questions_evaluations_id'];
        $reponsesEvaluation->evaluer_id = $validatedData['evaluer_id'];
        $reponsesEvaluation->save();    
        return response()->json([
            'message' => 'reponsesEvaluation mis à jour avec succès',
            'reponsesEvaluation' => $reponsesEvaluation,
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function softDelete($id)
    {
        $reponsesEvaluation = ReponsesEvaluation::find($id);
        if ($reponsesEvaluation) {
            $reponsesEvaluation->delete(); // Utilise la suppression douce
            return response()->json([
                'message' => 'reponsesEvaluation soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'reponsesEvaluation not found',
                'status' => 404
            ], 404);
        }
    }
}
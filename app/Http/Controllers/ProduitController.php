<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveProduitRequest;
use Exception;
use App\Models\Produit;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Liste des produits
     */
    public function index()
    {
        $produits = Produit::orderBy('created_at', 'desc')->get();

        return view('Produits.index',compact('produits'));
    }

    /**
     * Enregistrer un produit
     */
    public function store(Produit $produit, Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'quantite' => 'required|numeric|min:0', // Accepte les décimaux
        ]);

       // Obtenir la date du jour
       $dateDuJour = Carbon::now();

       // Vérifier si le produit existe déjà
       $existingProduct = Produit::where('libelle', $request->libelle)->first();

        if ($existingProduct) {
            return back()->with('error_message', 'Ce produit existe déjà.');
        }

        try {
            $produit->ref = $request->ref;
            $produit->libelle = $request->libelle;
            $produit->quantite = $request->quantite;
            $produit->date = $dateDuJour;
            $produit->save();

            return redirect()->route('produit.index')->with('success_message', 'Produit enregistré avec succès.');
        } catch (Exception $e) {
            return back()->with('error_message', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    /**
     * Editer un produit
     */
    public function update(Produit $produit, Request $request)
    {
        try {
            // Valider uniquement les champs nécessaires
            $validatedData = $request->validate([
                'ref' => 'required|string|max:255',
                'libelle' => 'required|string|max:255',
            ]);
    
            // Mettre à jour uniquement les attributs spécifiés
            $produit->update($validatedData);
    
            return redirect()->route('produit.index')->with('success_message', 'Produit mis à jour avec succès.');
        } catch (\Throwable $e) {
            // Gérer les exceptions
            return back()->with('error_message', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
    

    /**
     * Supprimer un produit
     */
    public function delete(Produit $produit)
    {
        try {
            $produit->delete();

            return redirect()->route('produit.index')->with('success_message', 'Produit supprimé avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class StockController extends Controller
{
    /**
     * La page index
     */
    public function index()
    {

        return view('Stocks.index');
    }

    /**
     * Affiche la liste des entrés de stocks
     */
    public function entrer()
    {
        $stocks = Stock::orderby('date','desc')->get();
        $produits = Produit::all();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $stocks->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $stocks = new LengthAwarePaginator(
            $currentPageItems,
            $stocks->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('Stocks.entrer', compact('stocks','produits'));
    }

    /**
     * Afficher les sortie de stock des produits
     */
    public function sortie()
    {
        $factures = Facture::orderby('date','desc')->get();

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
            ->groupBy('date', 'produit')
            ->orderBy('date', 'asc')
            ->get();


        return view('Stocks.sortie', compact('factures'));
    }

    /**
     * Afficher le stock actuel des produits
     */
    public function actuel()
    {
        $produits = Produit::orderBy('created_at', 'desc')->get();
        $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
            ->groupBy('produit')
            ->get();

        // Créez un tableau associatif pour stocker la quantité de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;
            } else {
                // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                $produit->stock_actuel = $produit->quantite;
            }
        }

        return view('Stocks.actuel', compact('produits'));
    }


    /**
     * Entrer de stock
     */
    public function store(Request $request)
    {
        
        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');
        // Récupérer les données JSON envoyées depuis le formulaire
        $stock->libelle = $request->produit;

        $stock->quantite = $request->quantite;
        $stock->date = $dateDuJour;

        $stock->save();

        $produit = Produit::where('libelle', $request->produit)->first();

        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return back()->with('success_message', 'Stock entrés avec succès.');
    }

    /**
     * Supprimer une entrée
     */
    public function update(Request $request, $id)
    {

        // Valider les données du formulaire
        $request->validate([
            'libelle' => 'required',
            'quantite' => 'required|numeric',
        ]);
        $stock = Stock::find($id);
        $stock->delete();

        $ancienStock= $stock->quantite;
        
        $stock->libelle = $request->libelle;
        $stock->quantite = $request->quantite;

        $produit = Produit::where('libelle', $request->libelle)
        ->first();

        $nouvelleQuantite = ($produit->quantite - $ancienStock );
        $produit->update(['quantite' => $nouvelleQuantite]);
               
        return redirect()->route('stock.entrer')->with('success_message', 'Stock supprimé avec succès.');

    }


     /**
     * Recherche sur la liste des entrés de stock
    */
    public function rechercheDetail(Request $request)
    {
        // Initialiser les dates de début et de fin
        $dateDebut = $request->dateDebut ?? now()->startOfDay();
        $dateFin = $request->dateFin ?? now()->endOfDay();
    
        // Vérifier que la date de début n'est pas supérieure à la date de fin
        if ($dateDebut > $dateFin) {
            return back()->with('error_message', 'La date de début ne peut pas être supérieure à la date de fin');
        }
    
        // Initialiser la requête pour les stocks
        $query = Stock::query(); // Utiliser query() pour construire une requête fluide
    
        // Appliquer les filtres de date si fournis
        if ($request->filled('dateDebut')) {
            $query->where('date', '>=', $dateDebut);
        }
    
        if ($request->filled('dateFin')) {
            $query->where('date', '<=', $dateFin);
        }
    
        // Exécuter la requête en triant par date en ordre décroissant
        $stocks = $query->orderBy('date', 'desc')->get();
    
        // Date du jour
        $date = Carbon::now();
    
        return view('Stocks.recherche', compact('stocks', 'dateDebut', 'dateFin', 'date'));
    }


    /**
     * inventair detail superette
     */
    public function indexinventaire()
    {
        $today = Carbon::now();

        //Affiche tout les gros de la table grosProduit
        $produits = Produit::get();

        // Remplacer par ceci
        $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
        ->groupBy('produit')
        ->get();

        // Creez un tableau associatif pour stocker la quantite de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;
            } else {
                // Si la quantite de sortie n'est pas definie, le stock actuel est egal a la quantite totale
                $produit->stock_actuel = $produit->quantite;
            }
        }
        
        return view('Inventaires.index', compact('produits','today'));
    }
    
}

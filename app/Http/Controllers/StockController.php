<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Psr7\Query;

class StockController extends Controller
{
    //

    public function index()
    {

        return view('Stocks.index');
    }

    public function create()
    {
        $produits = Produit::all();


        return view('Stocks.create', compact('produits'));
    }

    public function entrer()
    {
        $stocks = Stock::all();

        return view('Stocks.entrer', compact('stocks'));
    }

    public function sortie()
    {
        $factures = Facture::all();

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
        ->groupBy('date', 'produit')
        ->orderBy('date', 'asc')
        ->get();


        return view('Stocks.sortie', compact('factures'));
    }

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

    public function store(Request $request)
    {
        //dd($request);
        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');
        // Récupérer les données JSON envoyées depuis le formulaire
        $stock->libelle = $request->produit;
        //$stock->ref = 001;

        $stock->quantite = $request->quantite;
        $stock->date = $dateDuJour;

        $stock->save();

        $produit = Produit::where('libelle', $request->produit)->first();

        //dd($produit);
        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return redirect()->route('stock.entrer')->with('success_message', 'Stock entrés avec succès.');
    }

   


}

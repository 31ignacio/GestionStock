<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccueilController extends Controller
{
    //

    public function index(){

        $clients = Client::all();
        $factures = Facture::all()->unique('code');
        $sommeTotalTTC = 0;
        $sommeMontantDu=0;
        foreach ($factures as $facture) {
            $sommeTotalTTC += $facture->totalTTC;
            $sommeMontantDu += $facture->montantDu;

        }
        
        //dd($sommeTotalTTC,$sommeMontantDu);
        $nombreClient=count($clients);


        $produits = Produit::paginate(10);
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
         

        return view('Accueil.index',compact('nombreClient','sommeTotalTTC','sommeMontantDu','produits'));
    }
}

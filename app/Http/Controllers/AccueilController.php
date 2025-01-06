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
        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->mode;
        });
        $sommeTotalTTC = 0;
        $sommeMontantDu=0;
        foreach ($factures as $facture) {
            $sommeTotalTTC += $facture->totalTTC;
            $sommeMontantDu += $facture->montantDu;

        }
        $nombreClient=count($clients);

        return view('Accueil.index',compact('nombreClient','sommeTotalTTC','sommeMontantDu'));
    }
}

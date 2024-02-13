<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\ModePaiement;
use App\Models\Produit;
use DateTime; // Importez la classe DateTime en haut de votre fichier
use Exception;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class FactureController extends Controller
{
    //

    public function index()
    {
        $factures = Facture::all();
        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->mode;
        });


        //$factures = Facture::orderBy('code')->get()->groupBy('code');
        //dd($codesFacturesUniques);
        return view('Factures.index', compact('factures', 'codesFacturesUniques'));
    }

    public function details($code, $date)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue

        $factures = Facture::all();
        //dd($factures);
        return view('Factures.details', compact('date', 'code', 'factures'));
    }

    
    public function annuler(Request $request)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue
        //dd($code);
       // $factures = Facture::where('code',$code)->get();
	   $code =$request->factureCode;
        $factures = Facture::select('produit', 'quantite')->where('code', $code)->get();

        foreach ($factures as $facture) {
            $produit = Produit::where('libelle', $facture->produit)->first();
            if ($produit) {
                $nouvelleQuantite = $produit->quantite + $facture->quantite - $facture->quantite; // Mettez à jour la nouvelle quantité
        
                // Assurez-vous de mettre à jour le produit avec la nouvelle quantité correcte
                $produit->quantite = $nouvelleQuantite;
                $produit->save();
            }
           // dd($produit);
        }
        //dd($produit);
        // Suppression de toutes les factures avec le code spécifié
        Facture::where('code', $code)->delete();

        //dd($fa);
        return back()->with('success_message', 'La facture a été annulée avec succès.');
    }


    public function create()
    {
        $modes = ModePaiement::all();
        $clients = Client::all();
        $produits = Produit::all();

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
        return view('Factures.create', compact('clients', 'modes','produits'));
    }

    public function store(Request $request)
    { // Récupérer les données JSON envoyées depuis le formulaire
        $donnees = json_decode($request->input('donnees'));
        $client = $request->client;
        $dateString = $request->date;
        $mode = $request->mode;
        $totalHT = $request->totalHT;
        $totalTVA = $request->totalTVA;
        $totalTTC = $request->totalTTC;
        $montant = $request->montant;
        $dette = $request->dette;

        //dd($montant);
        $prefix = 'Facture_';

        $nombreAleatoire = rand(0, 1000); // Utilisation de rand()


        // Formatage du nouveau matricule avec la partie numérique
        $code = $prefix . $nombreAleatoire;


        // Convertissez la date en un objet DateTime
        $date = new DateTime($dateString);
        try {
            // Parcourez chaque élément de $donnees et enregistrez-les dans la base de données
            foreach ($donnees as $donnee) {
                // Créez une nouvelle instance du modèle Facture pour chaque élément
                $facture = new Facture();

                // Remplissez les propriétés du modèle avec les données
                $facture->client_id = $client;
                $facture->date = $date;
                $facture->mode_id = $mode;
                $facture->totalHT = $totalHT;
                $facture->totalTVA = $totalTVA;
                $facture->totalTTC = $totalTTC;
                $facture->montantPaye =  $montant;
                $facture->dette =  $dette;

                // Vous pouvez accéder aux propriétés de chaque objet JSON
                $facture->quantite = $donnee->quantite;
                $facture->produit= $donnee->produit; // Assurez-vous d'utiliser la bonne clé ici
                $facture->prix = $donnee->prix;
                $facture->total = $donnee->total;
                $facture->code = $code;
                $facture->montantDu = ($totalTTC - $facture->montantPaye) + $dette;
                //dd($facture);
                // Sauvegardez la facture dans la base de données
                $facture->save();
            }
            return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }

        // Répondez avec une réponse de confirmation
        return response()->json(['message' => 'Données enregistrées avec succès']);
    }

    public function pdf($facture,Request $request)
    {
        $date = $request->input('date');
        $code = $request->input('code');
        //$id = $request->input('id');

        //dd($facture);
        try {
            //recuperer tout les information de l'entreprise
            $factures = Facture::all();
            //$name= $facture['date'];
          // Chargez la vue Laravel que vous souhaitez convertir en PDF
        $html = View::make('Factures.facture',compact('factures','date','code'))->render();


            // Créez une instance de Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendez le PDF
        $dompdf->render();

        // Téléchargez le PDF
        return $dompdf->stream('Entreprise .pdf', ['Attachment' => false]);

        } catch (Exception $e) {
            dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }

}

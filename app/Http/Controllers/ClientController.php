<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveClientRequest;
use Exception;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Rembourssement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;


class ClientController extends Controller
{

    /**
     * Liste des clients
     */
    public function index()
    {
        $clients = Client::latest()->get();

        return view('Clients.index', compact('clients'));
    }

    /**
     * Afficher les dettes des clients
     */
    public function dette()
    {
        $factures = Facture::all();

        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $dettes = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT;
        })->groupBy('client_id')->map(function ($group) {
            return [
                'client' => $group->first()->client, // Assurez-vous que vous avez une relation "client" définie dans votre modèle Facture
                'montantTotal' => $group->sum('montantDu'), // Changez "totalHT" par le nom correct de la colonne que vous souhaitez cumuler
            ];
        })->reject(function ($dette) {
            return $dette['montantTotal'] == 0;
        });

        return view('clients.dette', compact('dettes'));
    }

    
    /**
     * Afficher les details d'un client
     */
    public function detail($client)
    {
       
        $factures = Facture::where('client_id', $client)->get();

        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });

        $remboursements = Rembourssement::where('client_id', $client)->orderby('date','desc')->get();


        return view('Clients.detail', compact('codesFacturesUniques', 'client', 'remboursements'));
    }


    /**
     * Enregistrer un client
     */
    public function store(Client $client, saveClientRequest $request)
    {

            // Vérifier si le produit existe déjà
       $existingProduct = Client::where('telephone', $request->telephone)->first();

       if ($existingProduct) {
           return back()->with('error_message', 'Le numero de téléphone existe déjà.');
       }
        try {
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->societe = $request->societe;
            $client->zone = $request->zone;
            $client->sexe = $request->sexe;
            $client->telephone = $request->telephone;
            $client->ifu = $request->ifu;

            $client->save();

            return redirect()->route('client.index')->with('success_message', 'Client enregistré avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());
        }
    }

    /**
     * Enregistrer un rembourssement
     */
    public function rembourssement(Request $request)
    {
        // Récupérer toutes les factures pour le client spécifié
        $factures = Facture::where('client_id', $request->client)->get();

        // Créer une collection unique en fonction des colonnes code, date, client, totalHT et mode
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->mode;
        });

        // Calculer la somme des montantDu
        $montantDu = $codesFacturesUniques->sum('montantDu');

        // Vérifier si le remboursement est supérieur au montant dû
        if ($request->rembourssement > $montantDu) {
            return redirect()->back()->with('error_message', 'Le montant saisi est supérieur au montant dû.');
        }

        // Initialiser le montant à rembourser
        $montantARembourser = $request->rembourssement;

        // Parcourir les factures uniques pour mettre à jour les montants dus
        foreach ($codesFacturesUniques as $facture) {
            if ($montantARembourser <= 0) {
                break;
            }

            // Calculer le nouveau montant dû pour la facture
            $montantRestantFacture = $facture->montantDu;
            if ($montantARembourser >= $montantRestantFacture) {
                $facture->montantDu = 0;
                $montantARembourser -= $montantRestantFacture;
            } else {
                $facture->montantDu -= $montantARembourser;
                $montantARembourser = 0;
            }

            // Enregistrer les modifications de la facture
            $facture->save();
        }

        // Enregistrer le remboursement (optionnel)
        $remboursement = new Rembourssement();
        $remboursement->client_id = $request->client;
        $remboursement->montant = $request->rembourssement;
        $remboursement->facture_id = 1;

        $remboursement->date = Carbon::now();
        $remboursement->save();

        return redirect()->back()->with('success_message', 'Le remboursement a été effectué avec succès.');
    }
   
    /**
     * Editer un client
     */
    public function update(Client $client, saveClientRequest $request)
    {
        
        try {
            $client->societe = $request->societe;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->sexe = $request->sexe;
            $client->ifu = $request->ifu;
            $client->telephone = $request->telephone;
            $client->zone = $request->zone;

            $client->update();

            return redirect()->route('client.index')->with('success_message', 'Client mis à jour avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());

        }
    }

    /**
     * Supprimer un client
     */
    public function delete(Client $client)
    {
        //Enregistrer un nouveau département
        try {
            $client->delete();

            return redirect()->route('client.index')->with('success_message', 'Client supprimé avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());

        }
    }


    public function pdf($rembourssement, $code,$clientId, Request $request)
    {

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateJour = $dateDuJour->format('Y-m-d H:i:s');

        try {
           //Tout les Remboursement d'un client
            $remboursementss = Rembourssement::where('client_id', $clientId)->get();

            $factures = Facture::where('client_id', $clientId)->get();
           
            // Créez une collection unique en fonction des colonnes code, date, client et totalHT
            $codesFacturesUniques = $factures->unique(function ($facture) {
                return $facture->code . $facture->dette . $facture->client . $facture->totalHT . $facture->mode;
            });

            // Chargez la vue Laravel que vous souhaitez convertir en PDF
            $html = View::make('Clients.rembourssementFacture', compact('remboursementss','code', 'codesFacturesUniques', 'dateJour'))->render();

            // Créez une instance de Dompdf
            $dompdf = new Dompdf();
            // Chargez le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);
            // Rendez le PDF
            $dompdf->render();
            // Téléchargez le PDF
            return $dompdf->stream('EtatRembourssement .pdf', ['Attachment' => false]);
        } catch (Exception $e) {
            dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }
}

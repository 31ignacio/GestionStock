<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveClientRequest;
use Exception;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Rembourssement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    //

    public function index()
    {
        $clients = Client::all();

        return view('Clients.index', compact('clients'));
    }

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

    public function detailRembourssement(Request $request)
    {

        $code = $request->id2;
        $clientId = $request->ClientId;

       // dd($clientId,$code);
       //remboursement d'un client par rapport a une facture
        $remboursementss = Rembourssement::where('facture_id', $code)->get();
        //Tout les Remboursement d'un client
       // $remboursementsClient = Rembourssement::where('client_id', $clientId)->get();

        
        return view('Clients.voir', compact('remboursementss'));
    }

    public function detailRembourssements(Request $request)
    {

        //$code = $request->id2;
        $clientId = $request->ClientId;

        //Tout les Remboursement d'un client
        $remboursementss = Rembourssement::where('client_id', $clientId)->get();

        $factures = Facture::where('client_id', $clientId)->get();
        //dd($factures);
        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->dette . $facture->client . $facture->totalHT . $facture->mode;
        });

        //dd($codesFacturesUniques);


        
        return view('Clients.voir2', compact('remboursementss','codesFacturesUniques','clientId'));
    }

    public function detail($client)
    {

        $factures = Facture::where('client_id', $client)->get();
        //dd($factures);

        $rembourssements = Rembourssement::all();

        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });

        //dd($codesFacturesUniques,$rembourssements);

        return view('Clients.detail', compact('codesFacturesUniques', 'client', 'rembourssements'));
    }

    public function create()
    {
        return view('Clients.create');
    }

    public function store(Client $client, saveClientRequest $request)
    {
        //dd(1);
        //Enregistrer un nouveau client
        try {
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->societe = $request->societe;
            $client->zone = $request->zone;
            $client->sexe = $request->sexe;
            $client->telephone = $request->telephone;
            $client->ifu = $request->ifu;

            $client->save();

            // dd($client);

            return redirect()->route('client.index')->with('success_message', 'Client enregistré avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function rembourssement(Rembourssement $rembourssement, Request $request)
    {
        //dd($request);
        $dateDuJour = Carbon::now()->format('Y-m-d H:i:s');
        try {
            $rembourssement->date = $dateDuJour;
            $rembourssement->mode = "Remboursement";
            $rembourssement->montant = $request->rembourssement;
            $rembourssement->facture_id = $request->factureId;
            $rembourssement->client_id = $request->ClientId;

            $facture = Facture::find($request->factureId);
            // Si la facture est trouvée, vous pouvez accéder à la valeur de montantDu
            $montantDu = $facture->montantDu;
            //dd($montantDu);

            if ($request->rembourssement > $montantDu) {
                // Le montant saisi est supérieur au montant dû
                $message = "Le montant saisi est supérieur au montant dû.";
                return response()->json(['error' => $message], 401);
            }


               //dd($request->factureId);
            $rembourssement->save();


            //Après le remboursement je modifie le montant dû sur la table Facture
            $factures = Facture::where('id', $request->factureId)->first();
            $montantDu = $factures->montantDu;
            $resteAPayer = $montantDu - $request->rembourssement;
            Facture::where('id', $request->factureId)->update(['montantDu' => $resteAPayer]);

            $factures = Facture::where('id', $request->factureId)->first();

            return new Response(200);
            //$response = new stdClass();
           // $response->ClientId = $request->ClientId; // Assigne la valeur de $request->ClientId à la propriété clientId de l'objet response
            //return response()->json($response);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function edit(Client $client)
    {
        return view('Clients.edit', compact('client'));
    }

    public function update(Client $client, saveClientRequest $request)
    {
        //Enregistrer un nouveau département
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
            dd($e);
        }
    }

    public function delete(Client $client)
    {
        //Enregistrer un nouveau département
        try {
            $client->delete();

            return redirect()->route('client.index')->with('success_message', 'Client supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function pdf($rembourssement, $code,$clientId, Request $request)
    {

        //dd($clientId);
        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateJour = $dateDuJour->format('Y-m-d H:i:s');

        try {
           //Tout les Remboursement d'un client
            $remboursementss = Rembourssement::where('client_id', $clientId)->get();

            $factures = Facture::where('client_id', $clientId)->get();
            //dd($factures);
            // Créez une collection unique en fonction des colonnes code, date, client et totalHT
            $codesFacturesUniques = $factures->unique(function ($facture) {
                return $facture->code . $facture->dette . $facture->client . $facture->totalHT . $facture->mode;
            });

            // dd($remboursementss);
            //$name= $facture['date'];
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

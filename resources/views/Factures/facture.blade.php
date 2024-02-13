<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            font-size: 10px;
        }

        /* Ajoutez ces styles à votre CSS pour personnaliser la ligne "Montant dû" */
        .amount-due {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 10px;
        }


        .invoice {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            padding: 20px;
            font-size: 10px;

        }

        .invoice-header {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            font-size: 10px;

        }

        .invoice-header h1 {
            font-size: 28px;
            font-style: italic;
            margin: 0;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 10px;
        }

        .invoice-details .left {
            width: 50%;
        }

        .invoice-details .right {
            width: 50%;
            text-align: right;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-items th,
        .invoice-items td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        .invoice-items th {
            background-color: #f2f2f2;
        }

        .invoice-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .invoice-total .left {
            width: 50%;
            font-size: 10px;
        }

        .invoice-total .right {
            width: 50%;
            text-align: right;
            font-size: 15px;
        }

        .message {
            margin-top: 20px;
            font-style: italic;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Facture</h1>
        </div>
        <div style="position: absolute; top: 100px; right: 20px;">
            <p><b>Date:</b> {{ date('d/m/Y', strtotime($date)) }}</p>
            <p><b>Code facture: </b> {{ $code }}</p>
        </div>

        <div class="invoice-details">
            <div class="left">
                <p><b>De :</b> LEONI'S</p>
                <p><b>Adresse :</b> Godomey/Abomey-Calavi</p>
                <p><b>Cél : </b>(+229) 61-23-37-19 / 96-47-29-07</p>
                <p><b>IFU : </b> 012345678910</p>
            </div>

            @php
                $infosAffichees = false;
            @endphp

            @foreach ($factures as $facture)
                @if ($facture->date == $date && $facture->code == $code)
                    @if (!$infosAffichees)
                        <div class="right">
                            <p><b>À :</b> {{ $facture->client->nom }} {{ $facture->client->prenom }}</p>
                            <p><b>Téléphone :</b> {{ $facture->client->telephone }}</p>
                            <p><b>N° IFU :</b> {{ $facture->client->ifu }}</p>
                        </div>
                        @php
                            $infosAffichees = true; // Marquer que les informations ont été affichées
                        @endphp
                    @endif
                @endif
            @endforeach
        </div>
        <table class="invoice-items">
            <thead>
                <tr>
                    <th>Quantité</th>
                    <th>Produits</th>
                    <th>Prix</th>
                    <th>Totals</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($factures as $facture)
                    @if ($facture->date == $date && $facture->code == $code)
                        <tr>
                            <td>{{ $facture->quantite }}</td>
                            <td>{{ $facture->produit }}</td>
                            <td>{{ $facture->prix }}</td>
                            <td>{{ $facture->total }}</td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
        <div class="invoice-total">
            @php
                $infosAffichees = false;
            @endphp

            @foreach ($factures as $facture)
                @if ($facture->date == $date && $facture->code == $code)
                    @if (!$infosAffichees)
                        <div class="left">
                            <p>Total HT : {{ $facture->totalHT }} FCFA</p>
                            <p>TVA (20%) : {{ $facture->totalTVA }} FCFA</p>
                            <p>Total TTC : {{ $facture->totalTTC }} FCFA</p>
                            <p>Ancienne dette : {{ $facture->dette }} FCFA</p>

                        </div>
                        <div class="right">
                            <p>Montant dû : <span class="amount-due">{{ $facture->montantDu }} FCFA</span></p>
                        </div>
                        @php
                            $infosAffichees = true; // Marquer que les informations ont été affichées
                        @endphp
                    @endif
                @endif
            @endforeach
        </div>
        <p class="message">Nous vous remercions pour votre confiance. N'hésitez pas à nous contacter pour toute question
            ou préoccupation.</p>
    </div>
</body>

</html>

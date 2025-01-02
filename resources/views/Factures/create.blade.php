@extends('layouts.master2')

@section('content')
    <div class="container">
        <br>

        <div class="callout callout-info">
            <div id=="msg24"></div>
            <h5><i class="fas fa-info"></i> Note:</h5>
            <b>Cette page facilite l'enregistrement des achats et la création de factures, offrant une solution simple pour
                gérer vos transactions commerciales en toute efficacité.</b>
            <br>
            <hr><br>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date"><i class="fas fa-calendar-alt"></i> Date</label>
                        <input type="date" id="date" class="form-control" style="border-radius: 10px;"
                            onkeydown="return false">
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="client"><i class="fas fa-user"></i> Clients</label>
                        <select class="form-control select2" id="client" style="border-radius: 10px;" required>
                            <option></option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }} {{ $client->nom }}"
                                    @if ($client->nom == 'Client') selected @endif>
                                    {{ $client->nom }} {{ $client->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label for="mode"><i class="fas fa-wallet"></i> Mode de Paiement</label>

                        <select class="form-control" id="mode" style="width: 100%;border-radius:10px;">
                            <option></option>

                            @foreach ($modes as $mode)
                                <option value="{{ $mode->id }}">{{ $mode->modePaiement }}</option>
                            @endforeach
                        </select>
                    </div><!-- /input-group -->
                </div>

            </div>

        </div>

        <!-- Main content -->
        <div class="invoice p-3 mb-3">

            <form id="monFormulaire">
                <div id="msg25"></div>
                <div class="row">
                    
                    <div class="col-md-3" hidden>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn-sm btn-secondary">TVA(%)</button>
                            </div>
                            <input type="number" min=0 class="form-control" id='tva'>
                        </div><br>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-3">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn-sm btn-secondary">Produit</button>
                            </div>

                            <select class="form-control select2" id="produit">
                                <option></option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->libelle }}" data-stock="{{ $produit->stock_actuel }}">
                                        {{ $produit->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="message" style="color: red;"></div>

                    </div>
                    <div class="col-md-3">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn-sm btn-secondary">Quantité</button>
                            </div>
                            <input type="number" value="00" min=0 class="form-control" id='quantite'>
                        </div>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn-sm btn-secondary">Prix(FCFA)</button>
                            </div>
                            <input type="number" min=0 class="form-control" id='prix'>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="button" class="btn btn-primary" value="Ajouter" onclick="ajouterAuTableau()">
                        <input type="button" class="btn btn-danger" value="Annuler" onclick="supprimerDerniereLigne()">
                    </div>
                </div>

            </form>
            <!-- Table row -->
            <div class="row">
                {{-- <div class="col-md-2"></div> --}}
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="monTableau">
                        <thead>
                            <tr>
                                <th>Quantité</th>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody id="monTableauBody">
                            <!-- Les lignes de tableau seront ajoutées ici -->
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>


            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

                </div>
                <!-- /.col -->
                <div class="col-sm-12 col-md-6">
                    <div class="table-responsive">
                        <table class="table">

                            <tr>
                                <th style="width:50%">Total HT:</th>
                                <td id="totalHT">0</td>
                            </tr>
                            <tr>
                                <th>Total TVA</th>
                                <td id="totalTVA">0</td>
                            </tr>
                            <tr>
                                <th>Total TTC</th>
                                <td id="totalTTC" class="right badge-md badge-success">0</td>
                            </tr>
                            <tr>
                                <th>Montant payé</th>
                                <td><input type="text" class="form-control" id="montant"></td>
                            </tr>
                            <tr>
                                <th>Ancienne dette</th>
                                <td><input type="text" class="form-control" id="dette"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
           
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-success float-right valider" id="montantPaye"
                        style="margin-right: 5px;"onclick="enregistrerDonnees()">
                        <i class="fas fa-download"></i> Valider
                    </button>
                </div>
            </div>
        </div>
        <!-- /.invoice -->
        <div id="msg200"></div>

    </div>

    <!-- CSS pour un style plus propre et uniforme (pour l'entete) -->
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            border-radius: 8px !important;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
    </style>
    <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

    {{-- Ajouter produit dans le tableau --}}
    <script>
        function ajouterAuTableau() {
            // Récupérer les valeurs du formulaire
            var quantite = parseFloat(document.getElementById("quantite").value)
            var produit = document.getElementById("produit").value;
            var prix = document.getElementById("prix").value;

            if (quantite == "" || produit.trim() == "" || prix.trim() == "") {
                // Ajoutez ici le code pour afficher un message d'erreur ou faites une action appropriée
                $('#msg25').html(` <p  class="text-danger">
                        <strong>Veuillez remplir tous les champs (quantité, produit, prix).</strong>
                                    </p>`);
                // Masquer le message après 3 secondes
                setTimeout(function() {
                    $('#msg25').html('');
                }, 5000); // 3000 millisecondes équivalent à 3 secondes
            } else {

                // Calculer le total en multipliant la quantité par le prix
                var total = quantite * prix;

                // Sélectionner le tableau
                var tableauBody = document.getElementById("monTableauBody");

                // Créer une nouvelle ligne dans le tableau
                var newRow = tableauBody.insertRow(tableauBody.rows.length);

                // Insérer les cellules avec les valeurs du formulaire
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);
                var cell4 = newRow.insertCell(3);

                cell1.innerHTML = quantite;
                cell2.innerHTML = produit;
                cell3.innerHTML = prix;
                cell4.innerHTML = total.toFixed(); // Afficher le total avec deux décimales

                // Mettre à jour le total HT
                mettreAJourTotalHT();

                // Réinitialiser le formulaire
                //document.getElementById("monFormulaire").reset();

                // Vider les champs sauf TVA
                document.getElementById("quantite").value = "";
                // document.getElementById("produit").value = "";
                document.getElementById("prix").value = "";

                // Restaurer la valeur de TVA
                //document.getElementById("tva").value = tva;
            }
        }

        function mettreAJourTotalHT() {
            // Sélectionner le tableau
            var tva = document.getElementById("tva").value;
            var tableauBody = document.getElementById("monTableauBody");
            var totalHT = 0;

            for (var i = 0; i < tableauBody.rows.length; i++) {
                var cell = tableauBody.rows[i].cells[3]; // 4ème cellule contenant le total
                totalHT += parseFloat(cell.innerHTML);
            }
            totalTVA = (totalHT * tva) / 100
            totalTTC = (totalHT + totalTVA)
            // Afficher le total HT mis à jour dans la cellule correspondante
            document.getElementById("totalHT").innerHTML = totalHT.toFixed(); // Afficher le total avec deux décimales
            document.getElementById("totalTVA").innerHTML = totalTVA.toFixed(); // Afficher le total avec deux décimales
            document.getElementById("totalTTC").innerHTML = totalTTC.toFixed(); // Afficher le total avec deux décimales

        }


        function supprimerDerniereLigne() {
            // Sélectionner le tableau
            var tableauBody = document.getElementById("monTableauBody");

            // Vérifier s'il y a des lignes dans le tableau
            if (tableauBody.rows.length > 0) {
                // Supprimer la dernière ligne
                tableauBody.deleteRow(tableauBody.rows.length - 1);
                // Mettre à jour le total HT
                mettreAJourTotalHT();
            }
        }
    </script>

    {{-- Enregistrer une facture --}}
    <script>
        function enregistrerDonnees(donnees) {
            // Récupérer toutes les lignes du tableau
            var tableauBody = document.getElementById("monTableauBody");
            var date = document.getElementById("date").value;
            var client = document.getElementById("client").value.trim();
            var mode = document.getElementById("mode").value.trim();
            var totalHT = document.getElementById("totalHT").textContent.trim();
            var totalTVA = document.getElementById("totalTVA").textContent.trim();
            var totalTTC = document.getElementById("totalTTC").textContent.trim();
            var montant = document.getElementById("montant").value.trim();
            var dette = document.getElementById("dette").value.trim();

            // Vérification des champs obligatoires
            if (!client || !mode || !totalTTC) {
                Toastify({
                    text: "Veuillez remplir tous les champs obligatoires (Client, mode de paiement, Total TTC).",
                    duration: 5000,
                    close: true,
                    gravity: "top", // Position du toast
                    backgroundColor: "#dc3545", // Fond rouge (danger)
                    className: "your-custom-class", // Classe CSS personnalisée
                    stopOnFocus: true, // Arrêter le temps lorsque le toast est en focus
                }).showToast();
                return; // Arrêter l'exécution si les champs obligatoires ne sont pas remplis
            }

            // Vérification du montant payé si le mode de paiement est "2"
            if (mode === "2" && !montant) {
                Toastify({
                    text: "Le montant payé est vide. Veuillez saisir un montant.",
                    duration: 5000,
                    close: true,
                    gravity: "top", // Position du toast
                    backgroundColor: "#dc3545", // Fond rouge (danger)
                    className: "your-custom-class", // Classe CSS personnalisée
                    stopOnFocus: true, // Arrêter le temps lorsque le toast est en focus
                }).showToast();
                return; // Arrêter l'exécution si le montant est vide
            }


            var donnees = [];

            for (var i = 0; i < tableauBody.rows.length; i++) {
                var ligne = tableauBody.rows[i];
                var quantite = ligne.cells[0].textContent;
                var produit = ligne.cells[1].textContent;
                var prix = ligne.cells[2].textContent;
                var total = ligne.cells[3].textContent;
                //alert(totalHT)
                donnees.push({
                    quantite: quantite,
                    produit: produit,
                    prix: prix,
                    total: total
                });


            }

            $('.valider').hide();

            // Envoyer les données au serveur via une requête AJAX
            $.ajax({
                type: "POST",
                url: "{{ route('facture.store') }}", // L'URL de votre route Laravel
                data: {
                    _token: '{{ csrf_token() }}',
                    donnees: JSON.stringify(donnees),
                    client,
                    date,
                    mode,
                    totalTTC,
                    totalHT,
                    totalTVA,
                    montant,
                    dette
                },
                success: function(response) {
                    
                    Toastify({
                        text: "Félicitations, la facture a été enregistrée avec succès !",
                        duration: 5000,
                        close: true,
                        gravity: "top", // Position du toast
                        backgroundColor: "#4CAF50", // Fond vert
                        className: "your-custom-class", // Classe CSS personnalisée
                        stopOnFocus: true, // Arrêter le temps lorsque le toast est en focus
                        
                    }).showToast();

                    var url = "{{ route('facture.index') }}"
                    setTimeout(function() {
                        window.location = url
                    }, 5000)
                },
            });
        }
    </script>

    {{-- verifier le stock --}}
    <script>
        var quantiteInput = document.getElementById("quantite");
        var produitSelect = document.getElementById("produit");
        var message = document.getElementById("message");
        var previousValue = quantiteInput.value;
        var previousSelectedIndex = produitSelect.selectedIndex;

        quantiteInput.addEventListener("input", function() {
            validateQuantite();
        });

        produitSelect.addEventListener("change", function() {
            validateQuantite();
        });

        function validateQuantite() {
            var selectedOption = produitSelect.options[produitSelect.selectedIndex];
            var stock = parseFloat(selectedOption.getAttribute("data-stock"));
            var quantite = parseFloat(quantiteInput.value);

            if (isNaN(quantite) || isNaN(stock) || quantite <= stock) {
                message.textContent = "";
                quantiteInput.style.borderColor = "";
            } else {
                message.textContent = "Stock insuffisant!";
                quantiteInput.style.borderColor = "red";

                // Efface le champ de quantité après 3 secondes
                setTimeout(function() {
                    quantiteInput.value = "";
                }, 100);
            }

            // Vérifiez si l'utilisateur a changé de produit
            if (produitSelect.selectedIndex !== previousSelectedIndex) {
                quantiteInput.value = "";
                previousSelectedIndex = produitSelect.selectedIndex;
            }

            // Vérifiez si la quantité a été modifiée manuellement
            if (quantiteInput.value !== previousValue) {
                previousSelectedIndex = produitSelect.selectedIndex;
            }
        }


        // Vous pouvez appeler validateQuantite() au chargement de la page pour vérifier la quantité initiale
        validateQuantite();
    </script>

    {{-- Control sur la date --}}
    <script>
        // Récupérer la date d'aujourd'hui
        var dateActuelle = new Date();
        var annee = dateActuelle.getFullYear();
        var mois = ('0' + (dateActuelle.getMonth() + 1)).slice(-2);
        var jour = ('0' + dateActuelle.getDate()).slice(-2);

        // Formater la date pour l'attribut value de l'input
        var dateAujourdhui = annee + '-' + mois + '-' + jour;

        // Définir la valeur et la propriété max de l'input
        var inputDate = document.getElementById('date');
        inputDate.value = dateAujourdhui;
        inputDate.max = dateAujourdhui;
    </script>
@endsection

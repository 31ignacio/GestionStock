@extends('layouts.master2')

@section('content')

    <section class="content" >
        <div class="container">

            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2 mt-3">
                <button class="btn btn-danger" onclick="generatePDF()"><i class="fas fa-download"></i> Générer PDF</button>
                </div>
            </div>


            <div class="row">
                <div class="col-12 mt-4">

                    

                    <div class="card" id="my-table"><br>
                        <div class="row">
                            <div class="col-12 mt-5">
                                <h5>
                                    <i class="fas fa-globe mx-3"></i> <b>Léoni's Magasin</b> <br>
                                    <small class="float-right my-3"><b>Date:</b> {{ date('d/m/Y', strtotime($today)) }}</small><br><br>
                                    <small class="float-left mx-3"><b>IFU :</b> 01234567891011</small><br>
                                    <small class="float-left mx-3"><b>Téléphone :</b> (229) 0197472907 / 0161233719 </small>
                                </h5>
                            </div>
                            <!-- /.col -->
                        </div>

                        <div class="card-header">
                            <h5 class="text-center"><b> Écart d'inventaire Magasin du {{ date('d/m/Y', strtotime($today)) }}</b></h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="inventaireTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Stock Actuel</th>
                                        <th>Stock Physique</th>
                                        <th>Écart d'Inventaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produits as $produit)
                                        <tr>
                                            <td class="produit-nom">{{ $produit->libelle }}</td>
                                            <td>
                                                <span class="badge badge-info stock-actuel">
                                                    {{ $produit->stock_actuel }}
                                                </span>
                                            </td>
                                            <td>
                                                <input 
                                                    type="number" 
                                                    class="form-control stock-physique" 
                                                    data-stock-actuel="{{ $produit->stock_actuel }}" 
                                                    placeholder="Saisir le stock physique"
                                                >
                                            </td>
                                            <td class="ecart-inventaire text-center">
                                                <span class="badge badge-warning">0</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                            <!-- Bouton pour afficher les produits avec écart -->
                            <button id="afficherProduitsEcart" class="btn btn-primary mt-3">
                                Afficher les produits avec un écart
                            </button>
                        
                            <!-- Section pour afficher la liste -->
                            <div id="produitsAvecEcart" class="mt-3">
                                <!-- Les produits avec un écart s'afficheront ici -->
                            </div>
                        </div>
                        
                        
                    </div>

                <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
                <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- JavaScript -->


    <script>
    
        document.querySelectorAll('.stock-physique').forEach(input => {
            input.addEventListener('input', function() {
                const row = this.closest('tr');
                const stockActuel = parseFloat(this.dataset.stockActuel);
                const stockPhysique = parseFloat(this.value) || 0;
        
                // Calcul de l'écart d'inventaire
                const ecart = stockPhysique - stockActuel;
        
                // Mise à jour de l'écart dans le tableau
                const ecartElement = row.querySelector('.ecart-inventaire .badge');
                ecartElement.textContent = ecart;
        
                // Modifier la couleur en fonction de l'écart (rouge si négatif, vert si positif)
                if (ecart < 0) {
                    ecartElement.classList.remove('badge-warning', 'badge-success');
                    ecartElement.classList.add('badge-danger'); // Rouge pour les écarts négatifs
                } else if (ecart > 0) {
                    ecartElement.classList.remove('badge-warning', 'badge-danger');
                    ecartElement.classList.add('badge-success'); // Vert pour les écarts positifs
                } else {
                    ecartElement.classList.remove('badge-success', 'badge-danger');
                    ecartElement.classList.add('badge-warning'); // Orange pour zéro
                }
            });
        });
        
        // Fonction pour afficher les produits avec écart
        document.getElementById('afficherProduitsEcart').addEventListener('click', function() {
            const produitsAvecEcart = [];
            const rows = document.querySelectorAll('#inventaireTable tbody tr');
        
            rows.forEach(row => {
                const produitNom = row.querySelector('.produit-nom').textContent.trim();
                const ecartElement = row.querySelector('.ecart-inventaire .badge');
                const ecart = parseFloat(ecartElement.textContent) || 0;
        
                if (ecart !== 0) {
                    produitsAvecEcart.push({
                        produit: produitNom,
                        ecart: ecart
                    });
                }
            });
        
            // Afficher la liste des produits avec écart
            const resultDiv = document.getElementById('produitsAvecEcart');
            resultDiv.innerHTML = ''; // Réinitialiser le contenu
        
            if (produitsAvecEcart.length > 0) {
                let html = '<ul class="list-group">';
                produitsAvecEcart.forEach(item => {
                    html += `
                        <li class="list-group-item">
                            <strong>${item.produit}</strong> : Écart d'inventaire = ${item.ecart}
                        </li>
                    `;
                });
                html += '</ul>';
                resultDiv.innerHTML = html;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        Aucun produit avec un écart d'inventaire !
                    </div>
                `;
            }
        });

    </script>
    


    <script>
        // Définir la fonction generatePDF à l'extérieur de la fonction click
        function generatePDF() {
            // Récupérer le contenu du tableau HTML
            var element = document.getElementById('my-table');

            // Obtenez la date actuelle
            var today = new Date();

            // Formatez la date en yyyy-mm-dd sans padStart
            var day = ('0' + today.getDate()).slice(-2);
            var month = ('0' + (today.getMonth() + 1)).slice(-2); // Les mois commencent à 0
            var year = today.getFullYear();

            // Construisez la chaîne de date
            var formattedDate = year + '-' + month + '-' + day;

            // Créez le nom de fichier avec la date du jour
            var filename = 'Ecart_inventaire_détails_du_' + formattedDate + '.pdf';
    
            // Options pour la méthode html2pdf
            var opt = {
                margin: 0.5,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
            };
    
            // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection
  

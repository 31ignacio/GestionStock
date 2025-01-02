@extends('layouts.master2')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Entrés de stocks(Détail)</h1>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body">


                            <form method="GET" action="{{ route('stock.rechercheDetail') }}">
                                @csrf
                                @method('GET')

                                <div class="row mb-3">
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <label>Date Début :</label>
                                        <input type="date" class="form-control" name="dateDebut">
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <label>Date Fin :</label>
                                        <input type="date" class="form-control" name="dateFin">
                                    </div>


                                    <div class="col-md-4 col-lg-4 col-sm-4 mt-4">

                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-10"></div>



                                <div class="col-md-2 mt-3">
                                    <button class="btn btn-danger mb-3" onclick="generatePDF()"><i
                                            class="fas fa-download"></i> Générer PDF</button>

                                </div>
                            </div>

                            <div id="my-table">

                                <div class="row">
                                    <div class="col-12">
                                        <h5>
                                            <i class="fas fa-globe"></i> <b>Leoni's</b>.
                                            <small class="float-right">Date: {{ date('d/m/Y', strtotime($date)) }}
                                            </small>
                                        </h5>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <h4 class="mt-3"><b> Stock enregistré (Détails) du
                                        {{ date('d/m/Y', strtotime($dateDebut)) }} au
                                        {{ date('d/m/Y', strtotime($dateFin)) }}</b></h4>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Produits</th>
                                            <th>Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stocks as $stock)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($stock->date)) }}</td>
                                                <td>{{ $stock->libelle }}</td>
                                                <td>{{ $stock->quantite }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                              <td class="cell text-center" colspan="2">Aucun stock ajoutés</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
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
            var filename = 'Stock_enregistré à la date du' + formattedDate + '.pdf';

            // Options pour la méthode html2pdf
            var opt = {
                margin: 0.5,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection

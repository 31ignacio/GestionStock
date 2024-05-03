@extends('layouts.master2')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Note:</h5>
                        <b>Cette page fournit une vue détaillée de la facture du client, présentant les informations
                            essentielles telles que les produits/services achetés, les quantités, les tarifs unitaires, et
                            le montant total. Elle offre une vision claire et exhaustive des transactions effectuées par le
                            client.</b>
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3" id="my-table">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h3>
                                    <i class="fas fa-globe"></i> <b>Leoni's</b>.
                                    <small class="float-right">Date: {{ date('d/m/Y', strtotime($date)) }}
                                    </small>
                                </h3>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row --><br>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                @php
                                    $infosAffichees = false;
                                @endphp

                                @foreach ($factures as $facture)
                                    @if ($facture->date == $date && $facture->code == $code)
                                        @if (!$infosAffichees)
                                            <address>
                                                <strong>{{ $facture->client->societe }}</strong><br>

                                                Téléphone : {{ $facture->client->telephone }}<br>
                                                N° Ifu : {{ $facture->client->ifu }}<br>

                                            </address>

                                            @php
                                                $infosAffichees = true; // Marquer que les informations ont été affichées
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">

                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
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
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">

                            </div>
                            <!-- /.col -->
                            <div class="col-sm-12 col-md-6">

                                <div class="table-responsive">
                                    <table class="table">

                                        @php
                                            $infosAffichees = false;
                                        @endphp

                                        @foreach ($factures as $facture)
                                            @if ($facture->date == $date && $facture->code == $code)
                                                @if (!$infosAffichees)
                                                    <tr>
                                                        <th style="width:50%">Total HT:</th>
                                                        <td>{{ $facture->totalHT }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total TVA</th>
                                                        <td>{{ $facture->totalTVA }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total TTC</th>
                                                        <td>{{ $facture->totalTTC }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ancienne dette</th>
                                                        <td>{{ $facture->dette }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Montant dû </th>
                                                        <td>{{ $facture->montantDu }}</td>
                                                    </tr>
                                                    @php
                                                        $infosAffichees = true; // Marquer que les informations ont été affichées
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach

                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        

                    </div>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print mb-5">
                      <div class="col-12">
                          {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
                          {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                          </button> --}}

                          {{-- <a href="{{ route('facture.pdf',$factures['id']) }}" class="btn btn-success btn-sm">Telecharger <b>PDF</b></a> --}}
                          @php
                              $infosAffichees = false;
                          @endphp

                          @foreach ($factures as $facture)
                              @if ($facture->date == $date && $facture->code == $code)
                                  @if (!$infosAffichees)
                                      {{-- <a href="{{ route('facture.pdf', ['facture' => $facture->id, 'date' => $facture->date, 'code' => $facture->code]) }}" class="btn btn-danger float-right" style="margin-right: 5px;">
                                  <i class="fas fa-download"></i> Generate PDF
                              </a> --}}
                                      <button onclick="generatePDF()" class="btn btn-danger float-right"
                                         id="boutonPDF" style="margin-right: 5px;">
                                          <i class="fas fa-download"></i> Facture PDF
                                      </button>

                                      @php
                                          $infosAffichees = true; // Marquer que les informations ont été affichées
                                      @endphp
                                  @endif
                              @endif
                          @endforeach

                      </div>
                  </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>


  <script>
    // Définir la fonction generatePDF à l'extérieur de la fonction click
    function generatePDF() {
        // Récupérer le contenu du tableau HTML
        var element = document.getElementById('my-table');

        // Options pour la méthode html2pdf
        var timestamp = new Date().getTime(); // Obtenez un timestamp unique
        var filename = 'Facture_' + timestamp + '.pdf'; // Nom du fichier avec le timestamp

        var opt = {
            margin: 1,
            filename: filename, // Utilisez le nom de fichier dynamique
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
        html2pdf().from(element).set(opt).save();
    }

   
</script>

@endsection

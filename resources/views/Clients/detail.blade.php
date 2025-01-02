@extends('layouts.master2')

@section('content')
    <style>
        #achats {
        border-radius: 10px;
            background-color: #4CAF50; /* Couleur de fond vert plus pur */
            color: white; /* Couleur du texte en blanc */
        }

        #dettes{
            border-radius: 10px;
            background-color: red; /* Couleur de fond vert plus pur */
            color: white; /* Couleur du texte en blanc */
        }
    </style>
     <span id="client-id" hidden>{{$client}}</span> 

       {{-- REMBOURSSEMENT modal--}}
    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Rembourssement </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form action="{{ route('client.rembourssement') }}" method="post">

                        @csrf

                            <div class="modal-body">

                                <input id="client" hidden name="client" value="{{$client}}"  /> 
                                <label>Montant :</label>
                                <input type="number" min="100" class="form-control" id="rembourssement" autocomplete="off" name="rembourssement" required>                     

                                @error('rembourssement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="dettess" name="dette" />


                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-warning">Valider</button>
                            </div>
                    </form>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
     
    <section class="content">
        <div class="container-fluid">
           
            <div class="row">
                <div class="col-12">

                    <br><br>
                    <div id="msg200"></div>

                    {{-- Mes buttons du haut --}}
                    <div class="row">
                        <div class="col-md-3">
                            <label>Achats</label>
                            <input type="text" id="achats" class="form-control" style="border-radius:10px;" readonly />

                        </div>

                        <div class="col-md-3">
                            <label>Dettes</label>
                            <input type="text" id="dettes" class="form-control" style="border-radius:10px;" readonly/>

                        </div>
                       

                        <div class="col-md-3" style="margin-top: 35px;">
                            
                            <a href="" type="button" data-toggle="modal" data-target="#modal-sm" onclick="sendClientIdToModal()" data-client-id="{{ $client}}" data-key="{{ $client}}" class="btn btn-warning" style="border-radius:10px;">Rembourssement</a> 

                        </div>

                        <div class="col-md-3" style="margin-top: 35px;">
                            
                            <button type="button" class="btn btn-primary" style="border-radius:10px;" data-toggle="modal" data-target="#remboursementsModal">Voir les remboursements</button>

                        </div>

                    </div><br>

                    <!-- Modal pour voir les details de rembourssement -->
                    <div class="modal fade" id="remboursementsModal" tabindex="-1" aria-labelledby="remboursementsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="remboursementsModalLabel">Liste des remboursements</h5>
                            </div>
                            <div class="modal-body">
                            <!-- Table to display the list of remboursements -->
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Date</th>

                                    <th scope="col">Client</th>
                                    <th scope="col">Société</th>
                                    <th scope="col">Montant</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($remboursements as $remboursement)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($remboursement->date)) }}</td>

                                        <td>{{ $remboursement->client->prenom }} {{ $remboursement->client->nom }}</td>
                                        <td>{{ $remboursement->client->societe }}</td>

                                        <td>{{ $remboursement->montant }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                        </div>
                    </div>
  

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Facture clients</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>N°Facture</th>
                                        <th>Achat</th>
                                        <th>Montant dû</th>
                                        <th>Mode paiement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($codesFacturesUniques as $client)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($client->date)) }}</td>
                                            <td>{{ $client->code }}</td>
                                            <td class="montant">{{ $client->totalTTC +$client->dette }}</td>
                                            <td class="montant2">{{$client->montantDu }}</td>

                                            <td>
                                                @if ($client->mode->modePaiement == 'Espèce')
                                                <span class="badge badge-success">{{ $client->mode->modePaiement }}</span>
                                            @else
                                                @if($client->montantDu == 0)
                                                <span class="badge badge-danger">{{ $client->mode->modePaiement }}</span>
                                                <span class="badge badge-success">Soldé</span>
                                                @else
                                                <span class="badge badge-danger">{{ $client->mode->modePaiement }}</span>
                                                @endif
                                            @endif

                                            </td>
                                            
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="5">Aucune opération éffectuée</td>

                                        </tr>
                                    @endforelse


                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Pour faire la somme des achats --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalAchats = 0;
            let montants = document.querySelectorAll('#example1 tbody tr .montant');

            montants.forEach(function(montant) {
                totalAchats += parseFloat(montant.textContent.replace(/\s/g, '').replace(/,/g, '.'));
            });

            const formattedTotal = totalAchats.toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
            });

            document.getElementById('achats').value = formattedTotal;
        });
    </script>
        
    {{-- Pour faire la somme des dettes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalAchats = 0;
            let montants = document.querySelectorAll('#example1 tbody tr .montant2');

            montants.forEach(function(montant) {
                totalAchats += parseFloat(montant.textContent.replace(/\s/g, '').replace(/,/g, '.'));
            });

            const formattedTotal = totalAchats.toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
            });

            document.getElementById('dettes').value = formattedTotal;
        });
    </script>

    {{-- Voir les details de rembourssement d'un client --}}
    <script>
        function detailRembourssement(event) {

            const clientId = document.getElementById('client-id').textContent;
    
            // Afficher la valeur dans le modal
            document.getElementById('client-info2').textContent = `${clientId}`;
            
            
            $('#annonceModal').html('')
            //alert("Ouverture du formulaire d'inscription")
           
            var id2 = event.target.getAttribute('data-key');
            var ClientId = $("#client-info2").text();
            var url=" {{ route ("detailRembourssement")}} ";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var data = {
                _token: csrfToken,
                id2,ClientId
            };
                        
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response)
                { 
                
                    $('#annonceModal').html(response)
                                $('#modal-md').modal('show')
                }
            
            });            
        };
    </script>

@endsection

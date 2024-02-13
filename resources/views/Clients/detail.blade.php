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
     
    <section class="content">
        <div class="container-fluid">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                <b>Cette page offre une vision détaillée des transactions d'un client, incluant le total de ses achats, sa dette actuelle, ainsi que le détail des remboursements effectués. Explorez ces informations pour une gestion précise et transparente des transactions clients..</b>
              </div>
         
            <div class="row">
                <div class="col-12">

                    <br><br>
                    <div id="msg200"></div>

                    @if (Session::get('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                        <script>
                            setTimeout(() => {
                                document.getElementById('success-message').remove();
                            }, 3000);
                        </script>
                    @endif

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
                            
                        <button type="button" onclick="detailRembourssements(event)" class="btn-sm btn-primary voir" style="border-radius:10px;">Détails rembourssement</button> 

                        </div>
                        {{-- <div class="col-md-3" style="margin-top: 35px;">
                            <button type="button" onclick="detailRembourssements(event)" class="btn-sm btn-primary voir">Détails rembourssement</button> 
    
                        </div> --}}
                    </div><br><br>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Facture client</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>N°Facture</th>
                                        <th>Achat</th>
                                        <th>Montant dû</th>
                                        <th>Mode paiement</th>
                                        <th>Actions</th>

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
                                            <td>
                                                {{-- <button type="button" data-key="{{ $client->id }}" onclick="detailRembourssement(event)" class="btn-sm btn-primary voir">Détails rembourssement</button>  --}}
                                                @if ($client->montantDu != 0)
                                                    <a href="" type="button" class="btn-sm btn-warning"
                                                        data-toggle="modal" data-target="#modal-sm"
                                                        onclick="sendClientIdToModal()" data-client-id="{{ $client->id }}" data-key="{{ $client->id }}">
                                                        Remboursement
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="6">Aucune opération éffectuée</td>

                                        </tr>
                                    @endforelse


                                    </tfoot>
                            </table>
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

        {{-- REMBOURSSEMENT --}}
    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Montant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <input type="number" min="100" class="form-control" id="rembourssement" autocomplete="off" name="rembourssement">


                    <p id="client-info" name="factureId"hidden></p>
                    <p id="client-info2" name=clientId hidden></p> 


                    @error('rembourssement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning"  onclick="remboursse()">Valider</button>
                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i>Détails remboursement</i></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='annonceModal'>
                    <p id="client-info2" name=clientId></p> 


                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-md2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i>Détails remboursement</i></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='annonceModal2'>
                    <p id="client-info2" name=clientId></p> 


                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


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

                //alert(id2)
                //alert(ClientId)
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
    {{-- Envoyer l'id du client sur le modal rembourssement --}}
    <script>
        function sendClientIdToModal() {
            // Récupérer l'ID du client depuis la page
            // var clientId = document.getElementById('client-id').innerText;
            var clientId1 = event.target.getAttribute('data-client-id'); // Récupère l'ID du client depuis l'attribut personnalisé
            
            var factureId = parseInt(document.getElementById('client-info').innerText);

            document.getElementById('client-info').value = document.getElementById('client-info').innerText;

            // Placez l'ID du client dans votre modal
            var modalContent = document.getElementById('client-info');

            modalContent.innerHTML = clientId1;



            const clientId = document.getElementById('client-id').textContent;
    
            // Afficher la valeur dans le modal
            document.getElementById('client-info2').textContent = `${clientId}`;
            
            // Afficher le modal



        }
    </script>


    <script>
        function detailRembourssements(event) {

            const clientId = document.getElementById('client-id').textContent;

            // Afficher la valeur dans le modal
            document.getElementById('client-info2').textContent = `${clientId}`;
            
            
            $('#annonceModal2').html('')
            //alert("Ouverture du formulaire d'inscription")
        
        // var id2 = event.target.getAttribute('data-key');
            var ClientId = $("#client-info2").text();

                //alert(id2)
            // alert(ClientId)
            var url=" {{ route ("detailRembourssements")}} ";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var data = {
                _token: csrfToken,
                ClientId
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


    {{-- Le rembourssement pour un client --}}
    <script>
       function remboursse() {
    // Récupérer l'ID du client depuis la page
    var factureId = $("#client-info").text();
    var ClientId = $("#client-info2").text();
    var rembourssement = $("#rembourssement").val();
    // Récupérer le jeton CSRF depuis la balise meta
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
    $.ajax({
        type: 'POST',
        url: "{{ route('client.rembourssement') }}",
        data: {
            _token: csrfToken,
            factureId: factureId,
            rembourssement: rembourssement,
            ClientId: ClientId
        },
        success: function(response) {
            $('#modal-sm').modal('hide');

            if (parseInt(response) == 200 || parseInt(response) == 401) {
                parseInt(response) == 401 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                <strong>Une erreur s'est produite</strong> veuillez réessayer.
                </div>`))
                
                : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                <strong> Remboursement  </strong>
                </div>`));
            }

            var url = "{{ route('client.detail', ['client' => ':ClientId']) }}";
            url = url.replace(':ClientId', ClientId);

            if (response == 200) {
                setTimeout(function() {
                    window.location = url;
                }, 1000);
            } else {
                $("#msg200").html(response);
            }
        },

        error: function(response) {
        // Traitement en cas d'erreur
        if (response.responseJSON && response.responseJSON.error) {
            alert(response.responseJSON.error); // Affiche le message d'erreur
        }
    }
    });
}

    </script>

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




@endsection

@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success" id="success-message">{{ Session::get('success_message') }}</div>
    @endif

    <div id="msg200"></div>

    <div class="row">
        <div class="col-md-3"></div>

        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ajouter un profuit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
                            <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="societe">Réference</label>
                            <input type="text" class="form-control" id="ref" name="ref" value="{{ old('ref') }}" required style="border-radius:10px;">

                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('ref')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="societe">Produit</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('libelle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="quantite">Quantité</label>
                            <input type="number" class="form-control" id="quantite" name="quantite" value="{{ old('quantite') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-6">
                            <label for="prenom">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required style="border-radius:10px;">

                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning"  onclick="remboursse()">Valider</button>
                </div>


            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3"></div>

    </div>


    <script>
        function remboursse() {
            // $("#remboursementBtn").click(function() {
                // Récupérer l'ID du client depuis la page
                var ref = $("#ref").val();
                var libelle = $("#libelle").val();
                var quantite = $("#quantite").val();
                var date = $("#date").val();
                    //alert(ref)
                // Récupérer le jeton CSRF depuis la balise meta
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('produit.store') }}", // Remplacez "/votre-route" par la route pertinente de votre application
                    data: {
                        _token: csrfToken,

                        ref,libelle,quantite,date
                    },
                    success: function(response) {
                        // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                        if (parseInt(response) == 200 || parseInt(response) == 500) {

                            parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> Produit ajouté avec succès  </strong>

                            </div>`));
                        }

                        var url = "{{ route('produit.index') }}"
                        if (response == 200) {
                            setTimeout(function() {
                                window.location = url
                            }, 1000)
                        } else {
                            $("#msg200").html(response);

                        }
                    },

                });
            // });
        };
    </script>

    <script>
        // Recherche de l'élément de message de succès
        var successMessage = document.getElementById('success-message');

        // Masquer le message de succès après 3 secondes (3000 millisecondes)
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000);
        }
    </script>


@endsection

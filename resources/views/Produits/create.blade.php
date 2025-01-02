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

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="societe">Réference</label>
                            <input type="text" class="form-control" id="ref" name="ref"
                                value="{{ old('ref') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('ref')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="societe">Produit</label>
                            <input type="text" class="form-control" id="libelle" name="libelle"
                                value="{{ old('libelle') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('libelle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="quantite">Quantité</label>
                            <input type="number" class="form-control" id="quantite" name="quantite"
                                value="{{ old('quantite') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
               
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning">Valider</button>
                </div>


            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3"></div>

    </div>
   
@endsection

@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
        <script>
            setTimeout(() => {
                document.getElementById('success-message').remove();
            }, 3000);
        </script>
    @endif

    <form class="settings-form" method="POST" action="{{ route('client.update',$client->id) }}">
        @csrf
        @method('PUT')

    

    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editer un client</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="societe">Société</label>
                            <input type="text" class="form-control" id="societe" value="{{ $client->societe }}" name="societe" value="{{ old('societe') }}" required style="border-radius:10px;">
                        
                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('societe')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="ifu">IFU</label>
                            <input type="text" class="form-control" id="ifu" name="ifu" value="{{ $client->ifu }}" value="{{ old('ifu') }}" required style="border-radius:10px;">
                        
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('ifu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="ifu">Zone</label>
                            <input type="text" class="form-control" id="zone" name="zone" value="{{ $client->zone }}" value="{{ old('zone') }}" required style="border-radius:10px;">
                        
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('zone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $client->nom }}" required style="border-radius:10px;">
                       
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('nom')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $client->prenom }}" required style="border-radius:10px;">
                       
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('prenom')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                

                    <div class="row">
                        <div class="col-md-6">
                            <label for="sexe">Civilité</label>
                            <select name="sexe" id="sexe" class="form-control" value="{{ $client->sexe }}"  style="border-radius:10px;">
                                <option value=""></option>

                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>


                            </select>           
                            
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('sexe')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" value="{{ $client->telephone }}" name="telephone" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('telephone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        
                    </div>
                
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-warning" style="border-radius:10px;">Editer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-2"></div>

    </div>
</form>
@endsection
  
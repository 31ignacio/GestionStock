@extends('layouts.master2')

@section('content')
    <section class="content">
        <div class="container-fluid ">
            <br>

            <div class="row">
                <div class="col-12">

                    <a href="#" class="btn bg-gradient-primary" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-user-plus"></i> Ajouter
                    </a><br><br>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des clients</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Responsable</th>
                                        <th>Société</th>
                                        <th>IFU</th>
                                        <th>Civilité</th>
                                        <th>Téléphone</th>
                                        <th>zone</th>

                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clients as $client)
                                        <tr>
                                            <td>{{ $client->nom }} {{ $client->prenom }}</td>
                                            <td>{{ $client->societe }}</td>
                                            <td>{{ $client->ifu }}</td>
                                            <td> {{ $client->sexe }}</td>
                                            <td>{{ $client->telephone }}</td>
                                            <td>{{ $client->zone }}</td>

                                            <td>
                                                <a href="{{ route('client.detail', ['client' => $client->id]) }}"
                                                    class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                                <a href="#!" data-toggle="modal"
                                                    data-target="#editEntry{{ $loop->iteration }}"
                                                    class="btn-sm btn-warning mx-1"><i class="fas fa-edit"></i></a>

                                                @auth
                                                    @if (auth()->user()->role_id == 1)
                                                        <form action="{{ route('client.delete', ['client' => $client->id]) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-sm btn-danger"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth

                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="7">Aucun client ajoutés</td>

                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal pour enregistrer un client -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- En-tête du modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Ajouter un client</h5>
                </div>
                <!-- Corps du modal -->
                <div class="modal-body">
                    <form class="settings-form" method="POST" action="{{ route('client.store') }}">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="societe">Société</label>
                                    <input type="text" class="form-control" id="societe" name="societe"
                                        value="{{ old('societe') }}" required style="border-radius:10px;">

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('societe')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="societe">IFU</label>
                                    <input type="text" class="form-control" id="ifu" name="ifu"
                                        value="{{ old('ifu') }}" required style="border-radius:10px;">

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('ifu')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom"
                                        value="{{ old('nom') }}" required style="border-radius:10px;">

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('nom')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom"
                                        value="{{ old('prenom') }}" required style="border-radius:10px;">

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('prenom')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="sexe">Civilité</label>
                                    <select name="sexe" id="sexe" class="form-control" value="{{ old('sexe') }}"
                                        required style="border-radius:10px;">
                                        <option value=""></option>

                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('sexe')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone"
                                        value="{{ old('telephone') }}" name="telephone" required
                                        style="border-radius:10px;">

                                    {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                    @error('telephone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                  <label for="societe">Zone</label>
                                  <input type="text" class="form-control" id="zone" name="zone"
                                      value="{{ old('zone') }}" required style="border-radius:10px;">

                                  {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                  @error('zone')
                                      <div class="text-danger">{{ $message }}</div>
                                  @enderror
                              </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style="border-radius:10px;">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modifier produit --}}
    @foreach ($clients as $client)
        <div class="modal fade" id="editEntry{{ $loop->iteration }}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editer le client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('client.update', ['client'=>$client->id]) }}" method="POST">
                        @csrf
                        @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="societe">Société</label>
                                        <input type="text" class="form-control" id="societe"
                                            value="{{ $client->societe }}" name="societe" value="{{ old('societe') }}"
                                            required style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('societe')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="ifu">IFU</label>
                                        <input type="text" class="form-control" id="ifu" name="ifu"
                                            value="{{ $client->ifu }}" value="{{ old('ifu') }}" required
                                            style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('ifu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nom">Nom</label>
                                        <input type="text" class="form-control" id="nom" name="nom"
                                            value="{{ $client->nom }}" required style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('nom')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="prenom">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom"
                                            value="{{ $client->prenom }}" required style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('prenom')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="sexe">Civilité</label>
                                        <select name="sexe" id="sexe" class="form-control" style="border-radius:10px;">
                                         
                                            @if($client->sexe == "M")

                                            <option value="M" selected>Masculin</option>
                                            <option value="F">Féminin</option>
                                            
                                          @else
                                          <option value="M" >Masculin</option>
                                          <option value="F" selected>Féminin</option>
                                          @endif
                                        </select>

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('sexe')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="telephone">Téléphone</label>
                                        <input type="text" class="form-control" id="telephone"
                                            value="{{ $client->telephone }}" name="telephone" required
                                            style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('telephone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="ifu">Zone</label>
                                        <input type="text" class="form-control" id="zone" name="zone"
                                            value="{{ $client->zone }}" value="{{ old('zone') }}" required
                                            style="border-radius:10px;">

                                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                        @error('zone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius:10px;">Editer</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection

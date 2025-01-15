@extends('layouts.master2')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <br>
            <div class="row">

                <div class="col-12">

                    <a href="#" type="button" class="btn bg-gradient-primary" data-toggle="modal" data-target="#modal-xl">
                        Ajouter Produit
                    </a><br><br>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des produits</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Référence</th>
                                        <th>Produitt</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produits as $produit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $produit->ref }}</td>
                                            <td>{{ $produit->libelle }}</td>

                                            <td>
                                                <button data-toggle="modal"
                                                    data-target="#editEntry{{ $produit->id }}"
                                                    class="btn-sm btn-warning mx-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form action="{{ route('produit.delete', ['produit' => $produit->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-sm btn-danger"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="cell" colspan="3">Aucun produit ajoutés</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table><br>

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
    {{-- Modal pour enregistrer un produit --}}
    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau produit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('produit.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="societe">Réference</label>
                                <input type="text" class="form-control" id="ref" name="ref"
                                    value="{{ old('ref') }}" required style="border-radius:10px;">

                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('ref')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="societe">Produit</label>
                                <input type="text" class="form-control" id="libelle" name="libelle"
                                    value="{{ old('libelle') }}" required style="border-radius:10px;">

                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('libelle')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="quantite">Quantité</label>
                                <input type="text" class="form-control" id="quantite" name="quantite"
                                    value="{{ old('quantite') }}" required style="border-radius:10px;">

                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('quantite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <span data-dismiss="modal">.</span>
                            <button type="submite" class="btn btn-primary">Enregistrer</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    {{-- Modifier produit --}}
    @foreach ($produits as $produit)
        <div class="modal fade" id="editEntry{{ $produit->id }}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Éditer le produit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produit.update', ['produit' => $produit->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="ref">Référence</label>
                                    <input type="text" class="form-control" id="ref{{ $produit->id }}" 
                                        value="{{ $produit->ref }}" name="ref" required style="border-radius:10px;">

                                    @error('ref')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="libelle">Produit</label>
                                    <input type="text" class="form-control" id="libelle{{ $produit->id }}" 
                                        value="{{ $produit->libelle }}" name="libelle" required style="border-radius:10px;">

                                    @error('libelle')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-12 mb-3">
                                    <label for="libelle">Quantité</label>
                                    <input type="text" class="form-control" id="quantite{{ $produit->id }}" 
                                        value="{{ $produit->quantite }}" name="quantite" required style="border-radius:10px;">

                                    @error('quantitr')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

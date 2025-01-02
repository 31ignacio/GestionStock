@extends('layouts.master2')

@section('content')
<br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="row">
                        <div class="col-md-2 mt-3">

                          <a href="#" class="btn bg-gradient-primary" data-toggle="modal"
                              data-target="#stockEntryModal">Entrées de stock</a><br><br>
                               
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <!-- Utilisez une colonne de taille moyenne pour aligner les boutons à gauche -->
                            <a href="{{ route('stock.actuel') }}" class="btn bg-gradient-success mt-3"><i
                                    class="fas fa-archive"></i> Stocks actuels</a><br><br>
                        </div>
                        <div class="col-md-2">
                            <!-- Utilisez une colonne de taille moyenne pour aligner les boutons à gauche -->
                            <a href="{{ route('stock.sortie') }}" class="btn bg-gradient-warning mt-3"><i
                                    class="fas fa-sign-out-alt"></i> Sortie de stocks</a><br><br>
                        </div>
                    </div>

                      <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Entrés de stocks</h1>
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

                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Produits</th>
                              <th>Quantité</th>
                              @auth
                                  @if (auth()->user()->role_id == 1)
                                      <th>Supprimer</th>
                                  @endif
                              @endauth
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($stocks as $stock)
                              <tr>
                                <td>{{ date('d/m/Y', strtotime($stock->date)) }}</td>
                                <td>{{ $stock->libelle }}</td>
                                <td>{{ $stock->quantite }}</td>
                                @auth
                                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
                                        <td>
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#editModal{{ $stock->id }}"><i
                                                    class="fas fa-trash-alt"></i></button>

                                        </td>
                                    @endif
                                @endauth
                              </tr>

                              <!-- Modal -->
                              <div class="modal fade" id="editModal{{ $stock->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="editModalLabel">Supprimer le stock</h5>
                                          <button type="button" class="close" data-dismiss="modal"
                                              aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <!-- Inside the modal body -->
                                        <div class="modal-body">
                                          <!-- Your form inputs for editing vehicle information here -->
                                          <form action="{{ route('stock.update', $stock->id) }}"
                                            method="POST">
                                            @csrf
                                            
                                            <div class="form-group col-md-12">
                                                <label for="marque">Produit :</label>
                                                <input type="text" class="form-control" id="libelle"
                                                    name="libelle" value="{{ $stock->libelle }}" readonly>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="prix">Quantité :</label>
                                                <input type="text" class="form-control" id="quantite"
                                                    name="quantite" value="{{ $stock->quantite }}"
                                                    readonly>
                                            </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="submit"
                                                    class="btn btn-sm btn-danger">Supprimer</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                              </div>
                            @empty

                              <tr>
                                <td class="cell text-center" colspan="4">Aucun stock ajoutés</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>

                        <br>
                        {{-- LA PAGINATION --}}
                        <nav aria-label="Page navigation">
                          <ul class="pagination justify-content-center">
                              @if ($stocks->onFirstPage())
                                  <li class="page-item disabled">
                                      <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                                  </li>
                              @else
                                  <li class="page-item">
                                      <a class="page-link" href="{{ $stocks->previousPageUrl() }}" rel="prev"
                                          aria-label="Précédent">&laquo; Précédent</a>
                                  </li>
                              @endif

                              @if ($stocks->hasMorePages())
                                  <li class="page-item">
                                      <a class="page-link" href="{{ $stocks->nextPageUrl() }}" rel="next"
                                          aria-label="Suivant">Suivant &raquo;</a>
                                  </li>
                              @else
                                  <li class="page-item disabled">
                                      <span class="page-link" aria-hidden="true">Suivant &raquo;</span>
                                  </li>
                              @endif
                          </ul>
                        </nav>
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


      <!-- Modal pour les entrées de stock -->
      <div class="modal fade" id="stockEntryModal" tabindex="-1" aria-labelledby="stockEntryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- En-tête du modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="stockEntryModalLabel">Entrée de stock</h5>
                </div>
    
                <!-- Corps du modal -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('stock.store') }}">
                        @csrf
    
                        <!-- Produit avec Select2 -->
                        <div class="col-12 mb-3">
                            <label for="produit" class="form-label">Produit</label>
                            <select class="form-control select2" id="produit" name="produit" required>
                              <option value="">Sélectionnez un produit</option>
                              @foreach ($produits as $produit)
                                  <option value="{{ $produit->libelle }}">{{ $produit->libelle }}</option>
                              @endforeach
                          </select>
                          
                            @error('produit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Quantité -->
                        <div class="col-12 mb-3">
                            <label for="quantite" class="form-label">Quantité</label>
                            <input type="text" class="form-control" id="quantite" name="quantite" value="{{ old('quantite') }}" required>
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Boutons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- JS de Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery (nécessaire pour Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
      $(document).ready(function () {
          // Initialisation standard de Select2
          $('.select2').select2({
              placeholder: "Sélectionnez une option",
              allowClear: true,
          });

          // Réinitialiser Select2 lors de l'ouverture du modal
          $('#stockEntryModal').on('shown.bs.modal', function () {
              $('.select2').select2({
                  dropdownParent: $('#stockEntryModal'), // Permet de s'assurer que le menu apparaît dans le modal
              });
          });
      });
    </script>


@endsection

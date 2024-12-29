@extends('layouts.master2')

@section('content')



  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            <a href="{{ route ('stock.create')}}" class="btn  bg-gradient-primary">Entrés de stock</a><br><br>


            @if (Session::get('success_message'))
                <div class="alert alert-success" id="success-message">{{ Session::get('success_message') }}</div>
                
            @endif

          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Entrés de stocks</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Produits</th>
                  <th>Quantité</th>
                  <th>Modifier</th>


                </tr>
                </thead>
                <tbody>
                     @forelse ($stocks as $stock)

                <tr>
                  <td>{{ date('d/m/Y', strtotime($stock->date)) }}</td>
                  <td>{{$stock->libelle}}</td>
                  <td>{{$stock->quantite}}</td>
                  <td>
                    <button class="btn btn-warning" data-toggle="modal"
                    data-target="#editModal{{ $stock->id }}"><i class="fas fa-edit"></i></button>

                  </td>
                </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="editModal{{ $stock->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Modifier le stock</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form action="{{ route('stock.update', $stock->id) }}" method="POST">
                                    @csrf
                                    <!-- Input fields for vehicle information -->
                                    {{-- <div class="row"> --}}
                                        <div class="form-group col-md-12">
                                            <label for="marque">Produit :</label>
                                            <input type="text" class="form-control" id="libelle"
                                                name="libelle" value="{{ $stock->libelle }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="prix">Quantité :</label>
                                            <input type="text" class="form-control" id="quantite"
                                                name="quantite" value="{{ $stock->quantite }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                          <label for="date">Date :</label>
                                          <input type="date" class="form-control" id="date" name="date" value="{{ $stock->date }}">

                                        </div>
                                        

                                    {{-- </div> --}}

                                    
                                    </div>
                                    
                                    <div class="modal-footer">
                                        
                                        <button type="submit" class="btn btn-sm btn-warning">Enregistrer les
                                            modifications</button>
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


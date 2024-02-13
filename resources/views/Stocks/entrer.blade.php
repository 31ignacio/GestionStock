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


                </tr>
                </thead>
                <tbody>
                     @forelse ($stocks as $stock)

                <tr>
                  <td>{{ date('d/m/Y', strtotime($stock->date)) }}</td>
                  <td>{{$stock->libelle}}</td>
                  <td>{{$stock->quantite}}</td>

                </tr>
                 @empty

                <tr>
                    <td class="cell text-center" colspan="3">Aucun stock ajoutés</td>

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


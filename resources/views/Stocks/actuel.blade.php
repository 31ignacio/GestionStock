@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">




            {{-- <a href="{{ route ('stock.create')}}" class="btn  bg-gradient-primary">Entrés de stock</a><br><br> --}}


            @if (Session::get('success_message'))
                <div class="alert alert-success" id="success-message">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Stocks actuels</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
			


			
              <table id="example1" class=" table-row table table-bordered">
                <thead>
                <tr>
                  <th>Produits</th>
                  <th>Quantité</th>

                </tr>
                </thead>
                <tbody>
                 
<!-- Utilisez $produitLibelle et $produitQuantite comme vous le souhaitez dans cette vue -->

                  @foreach ($produits as $produit)
                  <tr>
                      <td>{{ $produit->libelle }}</td>
                      <td>
                          {{ $produit->stock_actuel }}
                          @if ($produit->stock_actuel <= 2)
                          {{-- <script src="https://unpkg.com/toastify-js"></script> --}}
                          <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

                              <script>
                                  setInterval(function() {
                                      Toastify({
                                          text: "Le stock de {{ $produit->libelle }} est faible.",
                                          duration: 5000,
                                          close: true,
                                          gravity: "top", // Position du toast
                                          backgroundColor: "#b30000",
                                      }).showToast();
                                  }, 10000); // 5000 millisecondes correspondent à 5 secondes

                              </script>
                          @endif
                      </td>
                  </tr>
              @endforeach
              

                </tfoot>
              </table>
			  
			  <br>
			  
				
			  
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


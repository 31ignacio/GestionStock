@extends('layouts.master2')

@section('content')

  <br>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Stocks actuels</h1>
            </div>
           
            <div class="card-body">
			
              <table id="example1" class=" table-row table table-bordered">
                <thead>
                <tr>
                  <th>Produits</th>
                  <th>Quantité</th>

                </tr>
                </thead>
                <tbody>
                 
                  @foreach ($produits as $produit)
                    <tr>
                        <td>{{ $produit->libelle }}</td>
                        <td> {{ $produit->stock_actuel }} </td>
                    </tr>
                  @endforeach
                </tbody>
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
  </section>

@endsection


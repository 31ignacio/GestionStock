@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-sm-12 col-md-8">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des dettes</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Clients</th>
                  <th>Montant Dû</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($dettes as $dette)

                <tr>
                    {{-- <li>{{ $dette['client']->nom }} {{ $dette['client']->prenom }} - Montant dû : {{ $dette['montantTotal'] }}</li> --}}
                
                  <td>{{ $dette['client']->nom }} {{ $dette['client']->prenom }}</td>
                  <td>{{ $dette['montantTotal'] }}</td>
                  
                </tr>
                @empty

                <tr>
                    <td class="cell text-center" colspan="2">Aucune dette</td>

                </tr>
                @endforelse


                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-2"></div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

  @endsection

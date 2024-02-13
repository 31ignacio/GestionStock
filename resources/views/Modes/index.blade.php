@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            <a href="{{ route ('mode.create')}}" class="btn  bg-gradient-primary">Ajouter mode paiement</a><br><br>


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des clients</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Mode paiement</th>

                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($modes as $mode)

                <tr>
                  <td>{{ $mode->id }}</td>
                  <td>{{ $mode->modePaiement }}</td>

                  <td>
                    <a class="btn-sm btn-danger" href="{{ route('mode.delete', $mode->id) }}">Supprimer</a>
                  </td>
                </tr>
                @empty

                <tr>
                    <td class="cell" colspan="3">Aucun mode de paiement ajoutés</td>

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

  @endsection

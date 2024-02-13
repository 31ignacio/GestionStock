@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">

      <div class="callout callout-info">
        <h5><i class="fas fa-info"></i> Note:</h5>
        <b>Cette page offre un aperçu complet de la liste des clients, fournissant des détails précis sur les transactions de chaque client. Explorez les informations transactionnelles de manière claire et organisée pour une gestion efficace de votre clientèle.</b>
      </div>
 
      <div class="row">
        <div class="col-12">

            {{-- <a href="{{ route ('client.create')}}" class="btn  bg-gradient-primary">Ajouter client</a><br><br> --}}

           
            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                <script>
                  setTimeout(() => {
                      document.getElementById('success-message').remove();
                  }, 3000);
              </script>
            @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des clients</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-responsive">
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
                    <a href="{{ route('client.detail', ['client' => $client->id]) }}" class="btn-sm btn-primary">Détail</a>
                    <a class="btn-sm btn-warning" href="{{ route('client.edit', $client->id) }}">Editer</a>
                    <a class="btn-sm btn-danger" href="{{ route('client.delete', $client->id) }}">Supprimer</a>
                  </td>
                </tr>
                @empty

                <tr>
                    <td class="cell text-center" colspan="7">Aucun client ajoutés</td>

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

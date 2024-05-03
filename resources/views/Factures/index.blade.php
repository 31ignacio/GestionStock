@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">

      <div class="callout callout-info">
        <h5><i class="fas fa-info"></i> Note:</h5>
        <b>Cette page présente la liste des factures des clients, triées par ordre alphabétique du nom du client et accompagnées d'un code de facture. Facile à parcourir, elle offre une vue organisée et détaillée de l'historique des transactions client.</b>
      </div>
      
      <div class="row">
        <div class="col-12">

            {{-- <a href="{{ route ('facture.create')}}" class="btn  bg-gradient-primary">Ajouter</a><br><br> --}}


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des factures</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        <th>Client</th>
                        <th>Code de Facture</th>
                        <th>Date</th>
                        <th>Total TTC</th>
                        <th>Mode de paiement</th>
                        <th>Actions</th>

                        <!-- Autres colonnes -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($codesFacturesUniques as $factureUnique)


                    <tr>
                      <td>{{ $factureUnique->client->societe }}</td>

                        <td><b>{{ $factureUnique->code}}</b></td>

                        <td>{{ date('d/m/Y', strtotime($factureUnique->date)) }}</td>
                        <td>{{ $factureUnique->totalTTC }}</td>
                        <td>
                            @if ($factureUnique->mode)
                                @if ($factureUnique->mode->modePaiement == 'Espèce')
                                    <span class="badge badge-success">{{ $factureUnique->mode->modePaiement }}</span>
                                @else
                                    @if($factureUnique->montantDu == 0)
                                    <span class="badge badge-danger">{{ $factureUnique->mode->modePaiement }}</span>
                                    <span class="badge badge-success">Soldé</span>
                                    @else
                                    <span class="badge badge-danger">{{ $factureUnique->mode->modePaiement }}</span>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('facture.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}" class="btn-sm btn-primary">Détail</a>

  <a href="#" class="btn-sm btn-danger"
                              data-toggle="modal" data-target="#confirmationModal" onclick="updateModal('{{ $factureUnique->code }}')">Annuler</a>
 
                        </td>
                    </tr>
                @endforeach
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


 <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="get" action="{{route('facture.annuler')}}">
                @csrf
                  <div class="modal-body">
                      Voulez-vous annuler cette facture ?
                  </div>
                  <input type="hidden" id="factureCode" name="factureCode">
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                      <button type="submit" class="btn btn-danger">Oui</button>
                  </div>
              </form>
          </div>
      </div>
  </div>    


  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
	function updateModal(code){
		document.getElementById('factureCode').value=code;
	}
</script>


  @endsection

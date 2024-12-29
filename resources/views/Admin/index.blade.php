@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mt-3">

             <a href="#" class="btn bg-gradient-primary" data-toggle="modal" data-target="#addUserModal">
              <i class="fas fa-user-plus"></i> Ajouter
          </a><br><br>

            <!-- Default box -->
            <div class="row">
              @forelse ($admins as $admin)
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                  <div class="card bg-light d-flex flex-fill">
                    <!-- Bouton Activer/Désactiver -->
                    <div class="card-header text-muted border-bottom-0 position-relative">
                      <h2 class="text-center">Léoni's</h2>
                      <form action="{{ route('admin.toggleStatus', ['admin' => $admin->id]) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                        @csrf
                        @method('PATCH')
                        @if ($admin->estActif)
                          <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 15px;">
                            <i class="fas fa-user-slash"></i> Désactiver
                          </button>
                        @else
                          <button type="submit" class="btn btn-sm btn-success" style="border-radius: 15px;">
                            <i class="fas fa-user-check"></i> Activer
                          </button>
                        @endif
                      </form>
                    </div>
            
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>{{ $admin->name }}</b></h2>
                          <p class="text-muted text-md">
                            @if ($admin->role_id == 1)
                              <span class="badge badge-success">ADMIN</span>
                            
                            @elseif ($admin->role_id == 2)
                              <span class="badge badge-primary">FACTURE</span>
                            @else
                            <span class="badge badge-warning">MAGASIN</span>
                            @endif
                          </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> {{ $admin->email }}</li><br>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img src="{{ asset('AD/dist/img/33 (2).png') }}" alt="user-avatar" class="img-circle img-fluid">
                        </div>
                      </div>
                    </div>
            
                    <!-- Boutons Supprimer et Éditer -->
                    <div class="card-footer">
                      <div class="text-right">
                        <form action="{{ route('admin.delete', ['admin' => $admin->id]) }}" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn-sm btn-danger" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" 
                            @if ($admin->estActif) disabled @endif>
                            <i class="fas fa-trash-alt"></i> Supprimer
                          </button>
                        </form>
                        <button class="btn-sm btn-warning" data-toggle="modal" data-target="#editEntry{{ $loop->iteration }}" 
                          @if ($admin->estActif) disabled @endif>
                          <i class="fas fa-edit"></i> Éditer
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <p>Aucun administrateur trouvé.</p>
              @endforelse
            </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>


  <!-- Modal pour enregistrer un utilisateur -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Ajouter un Utilisateur</h5>
            </div>
            <!-- Corps du modal -->
                <div class="modal-body">
                  <form id="addUserForm" action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <!-- Nom -->
                    <div class=" col-md-12 mb-3">
                      <label for="setting-input-1" class="form-label">Nom complet<span class="ms-2" data-container="body"
                        data-bs-toggle="popover" data-trigger="hover" data-placement="top"
                        data-content="This is a Bootstrap popover example. You can use popover to provide extra info."><svg
                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                            <circle cx="8" cy="4.5" r="1" />
                        </svg></span>
                      </label> 
                      <input type="text" class="form-control" id="setting-input-1" name="name" value="{{ old('name') }}" required>

                          @error('name')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
        
                    <!-- Email -->
                    <div class="col-md-12 mb-3">
                      <label for="setting-input-3" class="form-label">Email</label>
                      <input type="email" class="form-control" id="setting-input-3" name="email"
                          value="{{ old('email') }}">

                      @error('email')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    
                    <!-- Rôle -->
                    <div class="col-md-12 mb-3">
                      <label for="setting-input-3" class="form-label">Rôle</label>
                      <select  class="form-control" id="setting-input-3" name="role">
                          <option></option>
                          @foreach ($roles as $role )
                              <option value="{{$role->id}}">{{$role->role}}</option>
                          
                          @endforeach    
                      </select
                      
                      @error('role')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div
                    
                    <div class="row">
                      <div class=" col-md-12 mb-3">
                          <label for="setting-input-3" class="form-label">Mot de passe</label>
                          <input type="password" class="form-control" id="setting-input-3" name="password">
                          @error('password')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>   
                    </div>
                  </form>
                </div>
            <!-- Pied du modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" form="addUserForm" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
  </div>


   {{-- Modifier utilisateur --}}
   @foreach ($admins as $admin)
    <div class="modal fade" id="editEntry{{ $loop->iteration }}">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editer l'utilisateur</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
              <form action="{{ route('admin.update', ['admin'=>$admin->id]) }}" method="POST">
                @csrf
                @method('put')

                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Nom complet</label>
                    <input type="text" class="form-control" id="name" name="nom" value="{{ $admin->name }}" required>
                </div>

                <!-- Quantité -->
                <div class="mb-3 col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required>
                </div>

                <div class="col-md-12">

                  <label for="role">Rôle</label>

                  <select name="role" id="role" class="form-control">

                    @if($admin->role_id == 1)

                      <option value="1" selected>ADMIN</option>
                      <option value="2">FACTURE</option>
                      <option value="3">MAGASIN</option>
                      
                    @elseif($admin->role_id == 3)

                      <option value="1">ADMIN</option>

                      <option value="2" >FACTURE</option>

                      <option value="3" selected>MAGASIN</option>
                      
                    @else

                      <option value="1">ADMIN</option>

                      <option value="2" selected>FACTURE</option>

                      <option value="3">MAGASIN</option>
                      
                    @endif

                  </select>

                  @error('role')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
              </form>
            </div>
        
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  @endforeach

 
  @endsection

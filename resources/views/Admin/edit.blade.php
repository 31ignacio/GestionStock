@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
        <script>
            setTimeout(() => {
                document.getElementById('success-message').remove();
            }, 3000);
        </script>
    @endif

    <form class="settings-form" method="POST" action="{{ route('admin.update',$admin->id) }}">
        @csrf
        @method('PUT')

    

    <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editer un utilisateur</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="raisonSociale">Nom</label>
                            <input type="text" class="form-control" id="nom" value="{{ $admin->name }}" name="nom" required style="border-radius:10px;">
                        
                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('nom')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="nom">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required style="border-radius:10px;">
                       
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                

                    <div class="row">
                       
                        
                        <div class="col-md-12">
                            <label for="ville">Rôle</label>

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
                            
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        
                    </div>
                
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-warning" style="border-radius:10px;">Editer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-4"></div>

    </div>
</form>
 

@endsection
  
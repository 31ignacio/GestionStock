@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
    @endif




    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ajouter un client</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="settings-form" method="POST" action="{{ route('mode.store') }}">
                @csrf
                @method('POST')
                            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="mode">Mode de paiement</label>
                            <input type="text" class="form-control" id="mode" name="mode" value="{{ old('mode') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('mode')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>

                    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="border-radius:10px;">Envoyer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-2"></div>

    </div>

@endsection

@extends('layouts.master2')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    {{-- <a href="{{ route('admin.create') }}" class="btn  bg-gradient-primary">Ajouter un admin</a><br><br> --}}


                    @if (Session::get('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Utilisateurs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>
                                                @if ($admin->role_id == 1)
                                                    <span class="badge badge-success">ADMIN</span>
                                                @elseif($admin->role_id == 3)
                                                    <span class="badge badge-warning">MAGASIN</span>
                                                @else
                                                    <span class="badge badge-primary">FACTURE</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn-sm btn-warning"
                                                    href="{{ route('admin.edit', $admin->id) }}"><i
                                                        class="fas fa-edit"></i></a>

                                                <a class="btn-sm btn-danger"
                                                    href="{{ route('admin.delete', $admin->id) }}"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="4">Aucun utilisateurs ajoutés</td>

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

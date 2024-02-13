@extends('layouts.master2')

@section('content')
    @foreach ($produits as $produit)
        <tr>
            <td><span style="display:none;">{{ $produit->libelle }}</span></td>
            <td>
                <span style="display:none;">{{ $produit->stock_actuel }}</span>
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

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $nombreClient }}</h3>

                            <p>Mes clients</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('client.index') }}" class="small-box-footer">Plus d'information <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 style="font-size: 184%;">{{ $sommeTotalTTC }} FCFA</h3>

                            <p>Mes ventes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 style="font-size: 184%;">---</h3>

                            <p>Mon stock actuel</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('stock.actuel') }}" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 style="font-size: 184%;">{{ $sommeMontantDu }} FCFA</h3>

                            <p>Dettes clients</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('client.dette') }}" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->



            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="../../../../AD/dist/img/2.jpg" class="d-block w-100" alt="Image 1">
                        <div class="carousel-caption text-center">
                            {{-- <h3 style="margin-top: 5000px;color:black;">Mettre le developpement durable au coeur de nos actions</h3> --}}
                        </div>
                    </div>
                </div>


                <!-- Controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

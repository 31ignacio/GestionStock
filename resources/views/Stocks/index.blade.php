@extends('layouts.master2')

@section('content')
<div class="container">
<div class="row">
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

      <div class="info-box-content">
        <a href="{{route('stock.entrer')}}">
            <span class="info-box-text">Entrés de stocks</span>
            <span class="info-box-number">
            10
            <small>%</small>
            </span>
        </a>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

      <div class="info-box-content">
        <a href="{{route('stock.sortie')}}">

        <span class="info-box-text">Sorties de stocks</span>
        <span class="info-box-number">41,410</span>
        </a>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <a href="{{route('stock.actuel')}}">

        <span class="info-box-text">Stocks actuels</span>
        <span class="info-box-number">760</span>
        </a>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
</div>
</div>
@endsection

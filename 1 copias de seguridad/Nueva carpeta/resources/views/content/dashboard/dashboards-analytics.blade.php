@extends('layouts/contentNavbarLayout')

@section('title', 'RECOFI')

@section('content')
<div class="row">
  <div class="col-xxl-8 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary mb-3">Bienvenido a RECOFI 🎉</h5>
            <p class="mb-6">El software de control para instituciones educativas. Aquí podrás gestionar la administración, procesos y actividades educativas de manera eficiente.</p>

            <!-- Si deseas agregar un botón, puedes dejar esto -->
            <a href="javascript:;" class="btn btn-sm btn-outline-primary">Explorar Plataforma</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{asset('assets/img/illustrations/man-with-laptop.png')}}" height="175" class="scaleX-n1-rtl" alt="Bienvenido a RECOFI">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts/contentNavbarLayout')

@section('title', 'Crear Colegio')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Crear Colegio</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('schools.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Colegio</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email del Colegio</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subdomain" class="form-label">Subdominio</label>
                        <input type="text" name="subdomain" class="form-control" id="subdomain" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono (Opcional)</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección (Opcional)</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Colegio</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


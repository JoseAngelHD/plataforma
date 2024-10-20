@extends('layouts/contentNavbarLayout')

@section('title', 'Editar Colegio')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Editar Colegio</h5>
                <a href="{{ route('schools.index') }}" class="btn btn-secondary">Regresar</a>
            </div>
            <div class="card-body">
                <form action="{{ route('schools.update', $school->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Colegio</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $school->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email del Colegio</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $school->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="subdomain" class="form-label">Subdominio</label>
                        <input type="text" name="subdomain" class="form-control" id="subdomain" value="{{ $school->subdomain }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono (Opcional)</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ $school->phone }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección (Opcional)</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ $school->address }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Colegio</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- configure.blade.php -->
@extends('layouts/contentNavbarLayout')

@section('title', 'Configurar Colegio')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">Configurar Colegio: {{ $school->name }}</h5>
        <a href="{{ route('schools.index') }}" class="btn btn-secondary">Volver al Listado</a>
    </div>

    <div class="card-body">
        <!-- Pestañas llenas con íconos -->
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#db" aria-controls="db" aria-selected="true">
                    <i class="tf-icons bx bx-data bx-sm me-1_5 align-text-bottom"></i> Base de Datos
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#admin" aria-controls="admin" aria-selected="false">
                    <i class="tf-icons bx bx-user bx-sm me-1_5 align-text-bottom"></i> Asignar Administrador
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#additional" aria-controls="additional" aria-selected="false">
                    <i class="tf-icons bx bx-cog bx-sm me-1_5 align-text-bottom"></i> Configuraciones Adicionales
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Base de Datos -->
            <div class="tab-pane fade show active" id="db" role="tabpanel">
                <h6>Base de Datos</h6>
                <form action="{{ route('schools.createDatabase', $school->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Crear Base de Datos</button>
                </form>

                <form action="{{ route('schools.createTables', $school->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success">Crear Tablas</button>
                </form>
            </div>

                <!-- Formulario para Asignar Administrador -->
                <div class="tab-pane fade" id="admin" role="tabpanel">
                    <h6>Asignar Administrador</h6>
                    <form action="{{ route('schools.createAdmin', $school->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="admin_name">Nombre del Administrador</label>
                            <input type="text" name="admin_name" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="admin_email">Email del Administrador</label>
                            <input type="email" name="admin_email" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="admin_password">Contraseña</label>
                            <input type="password" name="admin_password" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="admin_password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="admin_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Asignar Administrador</button>
                    </form>
                </div>


            <!-- Configuraciones Adicionales -->
            <div class="tab-pane fade" id="additional" role="tabpanel">
                <h6>Configuraciones adicionales</h6>
                <p>Aquí se pueden agregar más configuraciones específicas del colegio, como el escudo, modelo de calificación, etc.</p>
            </div>
        </div>
    </div>
</div>
@endsection

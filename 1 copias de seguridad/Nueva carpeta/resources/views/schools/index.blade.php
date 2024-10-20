@extends('layouts/contentNavbarLayout')

@section('title', 'Listado de Colegios')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">Listado de Colegios</h5>
        <a href="{{ route('schools.create') }}" class="btn btn-primary">Crear Colegio</a>
    </div>

    <!-- Coloca las notificaciones justo debajo del título -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card-body">
        @if($schools->isEmpty())
            <p>No hay colegios registrados.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Subdominio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schools as $school)
                        <tr>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->email }}</td>
                            <td>{{ $school->subdomain }}</td>
                            <td>
                                <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="{{ route('schools.configure', $school->id) }}" class="btn btn-info btn-sm">Configurar</a> <!-- Botón de Configurar -->
                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este colegio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection


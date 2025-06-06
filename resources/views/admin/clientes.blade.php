@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-6 font-[Poppins]">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-violet-600 animate-pulse">
            👥 Gestión de Clientes
        </h1>
        <p class="text-gray-500 mt-2">Administra los clientes registrados de forma profesional</p>
    </div>

    {{-- Alerta de éxito --}}
    @if(session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-100 border border-emerald-400 text-emerald-800 rounded-lg shadow">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('admin.clientes') }}" class="mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="🔍 Buscar cliente..."
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:scale-105 hover:shadow-lg transition duration-300 ease-in-out">
                <i class="fas fa-search me-1"></i> Buscar
            </button>
        </div>
    </form>

    {{-- Tabla --}}
    @if($clientes->isEmpty())
        <div class="text-center text-gray-500 italic mt-10">
            <i class="fas fa-user-times fa-lg me-2"></i>No se encontraron clientes registrados.
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-2xl shadow-2xl ring-1 ring-black/10">
            <table class="min-w-full text-sm text-left text-gray-800">
                <thead class="bg-gradient-to-r from-blue-50 to-violet-50 uppercase text-xs font-semibold tracking-wider text-gray-700">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4">Correo</th>
                        <th class="px-6 py-4">Registrado</th>
                        <th class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $cliente->name }}</td>
                        <td class="px-6 py-4">{{ $cliente->email }}</td>
                        <td class="px-6 py-4">{{ $cliente->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.editarCliente', $cliente->id) }}"
                                    class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 hover:scale-105 transition">
                                    ✏️ Editar
                                </a>
                                <form method="POST" action="{{ route('admin.eliminarCliente', $cliente->id) }}"
                                    onsubmit="return confirm('¿Deseas eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 hover:scale-105 transition">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

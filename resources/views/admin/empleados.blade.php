@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 font-[Poppins] animate-fade-in-down">
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-700">
            🐾 Veterinaria Huellitas 🐾
        </h1>
        <p class="text-lg text-gray-500 mt-2">Gestión de equipo profesional</p>
    </div>

    <!-- Panel principal -->
    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden ring-1 ring-gray-200">
        <!-- Título -->
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">Lista de Empleados</h2>
        </div>

        <!-- Filtro de búsqueda -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('admin.empleados') }}" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="buscar" placeholder="🔍 Buscar por nombre o email"
                       value="{{ request('buscar') }}"
                       class="flex-grow px-4 py-3 rounded-xl border-2 border-cyan-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-300 transition duration-300">

                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-xl transition duration-300">
                        Buscar
                    </button>
                    <button type="reset"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition duration-300">
                        Limpiar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de empleados -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-cyan-50 text-cyan-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left font-medium">Nombre</th>
                        <th class="px-6 py-4 text-left font-medium">Email</th>
                        <th class="px-6 py-4 text-left font-medium">Registrado</th>
                        <th class="px-6 py-4 text-left font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($empleados as $empleado)
                        <tr class="hover:bg-cyan-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-900">{{ $empleado->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $empleado->email }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $empleado->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.editarEmpleado', $empleado->id) }}"
                                       class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                                        ✏️ Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.eliminarEmpleado', $empleado->id) }}"
                                          onsubmit="return confirm('¿Deseas eliminar este empleado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 transition flex items-center gap-1">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500 italic">No hay empleados registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="p-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
            <div>
                Mostrando {{ $empleados->firstItem() ?? 0 }} a {{ $empleados->lastItem() ?? 0 }} de {{ $empleados->total() }} empleados
            </div>
            <div class="mt-4 md:mt-0">
                {{ $empleados->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Animación --}}
<style>
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out;
}
</style>
@endsection


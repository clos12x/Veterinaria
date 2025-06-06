@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-16 mb-10 px-6 py-10 bg-white shadow-2xl rounded-3xl ring-1 ring-gray-200 font-[Poppins] animate-fade-in-down">
    <h2 class="text-3xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-600 mb-8">
        🩺 Editar Veterinario
    </h2>

    <form method="POST" action="{{ route('admin.actualizarEmpleado', $empleado->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Campo Nombre -->
        <div>
            <label for="name" class="block mb-2 text-lg font-semibold text-gray-700">Nombre</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $veterinario->name) }}"
                   required
                   class="w-full px-5 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:outline-none transition duration-300">
        </div>

        <!-- Campo Email -->
        <div>
            <label for="email" class="block mb-2 text-lg font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $veterinario->email) }}"
                   required
                   class="w-full px-5 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:outline-none transition duration-300">
        </div>

        <!-- Botón Guardar Cambios -->
        <div class="text-center pt-4">
            <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white text-lg font-semibold rounded-lg shadow hover:scale-105 transition duration-300">
                💾 Guardar Cambios
            </button>
        </div>
    </form>
</div>

{{-- Animación --}}
<style>
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down {
    animation: fade-in-down 0.6s ease-out;
}
</style>
@endsection


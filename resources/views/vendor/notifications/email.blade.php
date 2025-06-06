@component('mail::message')
{{-- Logo --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('img/logo.Veterinaria.webp') }}" alt="Logo Veterinaria" style="width: 120px;">
</div>

# {{ $greeting ?? 'Restablecer Contraseña' }}

Hola, recibiste este correo porque solicitaste restablecer tu contraseña.

Haz clic en el botón de abajo para continuar:

@component('mail::button', ['url' => $url])
{{ $actionText }}
@endcomponent

Este enlace expirará en {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutos.

Si no solicitaste un cambio de contraseña, puedes ignorar este mensaje.

Gracias,  
**{{ config('app.name') }}**
@endcomponent



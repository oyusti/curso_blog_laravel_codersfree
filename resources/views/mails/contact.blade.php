@component('mail::message')
# Hola! {{ $data['name'] }}
@component('mail::panel')
{{ $data['message'] }}   
@endcomponent
Correo de Contacto: {{ $data['email']}}
@endcomponent
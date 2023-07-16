@component('mail::message')
# Hola! {{$author->name}}
{{ $question->user->name }} te ha enviado un mensaje desde la web de Coders Free
@component('mail::panel')
{!! $question->body !!}   
@endcomponent
Correo de Contacto: {{ $question->user->email}}
@endcomponent
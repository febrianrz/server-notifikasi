@component('mail::message')
{!! $notification->body !!}

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
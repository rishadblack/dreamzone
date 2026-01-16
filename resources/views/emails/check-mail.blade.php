@component('mail::message')
Hello Admin,

This is testing mail

Sincerely,<br>
{{config('app.name')}} team<br>
{{config('app.url')}}
@endcomponent

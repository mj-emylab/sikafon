@component('mail::message')
<b>{{ $title }}</b>

{{ $dear }} {{ $user['first_name'] }},

<p>{{ $body }}</p>

{!! $thanks !!}

@endcomponent

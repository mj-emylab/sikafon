@component('mail::message')
Hi {{$user['first_name'] }},

Your default password is <b>{{$password}}</b>

Please you have to reset to your desired password for security purpose.

Thanks, Regards.<br>
@endcomponent

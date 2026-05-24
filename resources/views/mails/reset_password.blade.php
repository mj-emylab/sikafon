@component('mail::message')

Hi, {{$user['first_name'] }},

You've requested for password reset code? Incase this isn't from you please ignore this message.

Your reset password code is <b>{{$code}}</b>

Thanks.<br>

@endcomponent
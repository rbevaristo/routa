@component('mail::message')
# Verify Account

Hello {{ $name }}, <br>
To verify your account please click the button below.

@component('mail::button', ['url' => 'http://localhost/routa/public/verify/'.$token, 'color' => 'green'])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

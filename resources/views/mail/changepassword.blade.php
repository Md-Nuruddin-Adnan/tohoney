

@component('mail::message')
# Change Password Confirmation- {{ $user_name_for_mail }}


@component('mail::panel')
{{-- {{ $user_email_for_mail }}, This is your email Address. --}}
Password has been change!
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
@component('mail::message')

Hi, <b>{{ $inviteeName }}</b><br>
Your event for <u>{{ $eventTypeName }}</u> at {{ $startDate }} (UTC) was declined by owner!

Regards,<br>
Schedulia
@endcomponent

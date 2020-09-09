@component('mail::message')

Hi, {{ $user->name }} <br>
A new event was scheduled.

<b>Event Type:</b><br>
{{ $eventType->name }}

<b>Invitee:</b><br>
{{ $event->invitee_name }}

<b>Invitee Email:</b><br>
{{ $event->invitee_email }}

<b>Invitee TimeZone:</b><br>
{{ $event->timezone }}

<b>Event Date/Time(UTC):</b><br>
{{ $event->start_date }}

@if(count($customFieldValues))
<b>Questions:</b><br>
@foreach($customFieldValues as $customFieldValue)
<u>{{ $customFieldValue->customField->name }}</u><br>
{{ $customFieldValue->value }}<br>
@endforeach
@endif

@component('mail::button', ['url' => env('CLIENT_APP_URL'), 'color' => 'blue'])
Visit {{ env('APP_NAME') }}
@endcomponent

@endcomponent

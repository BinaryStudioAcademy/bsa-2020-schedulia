@component('mail::message')

Hi, {{ $inviteeName }} <br>
You have been invited to an Event!

<b>Event Type:</b><br>
{{ $eventType->name }}

<b>Organizator Name:</b><br>
{{ $owner->name }}

<b>Organizator Email:</b><br>
{{ $owner->email }}

<b>Invitee Name (You):</b><br>
{{ $inviteeName }}

<b>Invitee Email (You):</b><br>
{{ $inviteeEmail }}

@if($inviteeInformation)
<b>Invitee Information (You):</b><br>
{{ $inviteeInformation }}
@endif

<b>Event Date/Time (UTC):</b><br>
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

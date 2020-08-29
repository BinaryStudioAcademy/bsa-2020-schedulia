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

<b>Event Date/Time:</b><br>
{{ $event->start_date }}

@endcomponent

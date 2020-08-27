import {eventTypeMapper} from "../eventType/normalizer";

export const eventMapper = Event => ({
    id: Event.id,
    name: Event.invitee_name,
    email: Event.invitee_email,
    questions: Event.invitee_questions,
    startDate: Event.start_date,
    startTime: Event.start_time,
    timezone: Event.timezone,
    createdAt: Event.created_at,
    eventType: eventTypeMapper(Event.event_type),
});

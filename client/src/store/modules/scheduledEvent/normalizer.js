import { eventTypeMapper } from '../eventType/normalizer';

export const eventMapper = Event => ({
    id: Event.id,
    name: Event.invitee_name,
    email: Event.invitee_email,
    question: Event.invitee_question,
    status: Event.status,
    startDate: Event.start_date,
    location: Event.location,
    timezone: Event.timezone,
    createdAt: Event.created_at,
    eventType: eventTypeMapper(Event.event_type)
});

export const eventPaginationMapper = Pagination => ({
    currentPage: Pagination.current_page,
    lastPage: Pagination.last_page,
    perPage: Pagination.per_page,
    total: Pagination.total
});

export const eventEmailMapper = Email => ({
    name: Email.email
});

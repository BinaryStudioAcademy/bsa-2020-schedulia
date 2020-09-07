import moment from 'moment-timezone';
import { eventTypeMapper } from '../eventType/normalizer';

export const eventMapper = Event => ({
    id: Event.id,
    name: Event.invitee_name,
    email: Event.invitee_email,
    question: Event.invitee_question,
    status: Event.status,
    startDate: moment
        .utc(Event.start_date)
        .tz(Event.timezone)
        .format(),
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

export const eventApiMapper = Event => ({
    status: Event.status,
    start_date: moment(Event.startDate)
        .tz(Event.timezone)
        .utc()
        .format('YYYY-MM-DD HH:mm:ss'),
    location: Event.location,
    timezone: Event.timezone
});

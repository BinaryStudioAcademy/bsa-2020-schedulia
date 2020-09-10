import moment from 'moment-timezone';
import { eventTypeMapper } from '../eventType/normalizer';

export const eventMapper = Event => ({
    id: Event.id,
    name: Event.invitee_name,
    email: Event.invitee_email,
    inviteeInformation: Event.invitee_information,
    status: Event.status,
    startDate: moment
        .utc(Event.start_date)
        .tz(Event.timezone)
        .format(),
    timezone: Event.timezone,
    createdAt: Event.created_at,
    customFieldValues: customFieldValuesMapper(Event.custom_field_values),
    eventType: eventTypeMapper(Event.event_type)
});

export const customFieldValuesMapper = function(customFieldValues) {
    let result = {};

    result = {
        ...result,
        ...customFieldValues.reduce(
            (prev, customFieldValues) => ({
                ...prev,
                [customFieldValues.id]: customFieldValueMapper(
                    customFieldValues
                )
            }),
            {}
        )
    };

    return result;
};

export const customFieldValueMapper = customFieldValue => ({
    id: customFieldValue.id,
    custom_field_id: customFieldValue.custom_field_id,
    event_id: customFieldValue.event_id,
    value: customFieldValue.value
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
    id: Event.id,
    status: Event.status,
    invitee_name: Event.name,
    invitee_email: Event.email,
    invitee_question: Event.question,
    start_date: moment(Event.startDate)
        .tz(Event.timezone)
        .utc()
        .format('YYYY-MM-DD HH:mm:ss'),
    timezone: Event.timezone
});

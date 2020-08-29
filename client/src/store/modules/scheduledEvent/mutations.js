import * as mutations from './types/mutations';
import {
    eventMapper,
    eventPaginationMapper,
    eventEmailMapper
} from '@/store/modules/scheduledEvent/normalizer';

export default {
    [mutations.SET_SCHEDULED_EVENT_FILTER_VIEW]: (
        state,
        scheduledEventFilterView
    ) => {
        state.scheduledEventsFilterView = scheduledEventFilterView;
    },

    [mutations.SET_SCHEDULED_EVENTS]: (state, events) => {
        state.scheduledEvents = {
            ...state.scheduledEvents,
            ...events.reduce(
                (prev, event) => ({
                    ...prev,
                    [event.id]: eventMapper(event)
                }),
                {}
            )
        };
    },

    [mutations.SET_SCHEDULED_EVENTS_PAGINATION]: (state, pagination) => {
        state.eventsPagination = eventPaginationMapper(pagination);
    },

    [mutations.CLEAR_SCHEDULED_EVENTS]: state => {
        state.scheduledEvents = [];
    },

    [mutations.SET_EVENT_EMAILS_FILTER]: (state, eventEmails) => {
        state.eventEmails = {
            ...state.eventEmails,
            ...eventEmails.reduce(
                    (prev, eventEmail) => ({
                        ...prev,
                        [eventEmail.id]: eventEmailMapper(eventEmail)
                    }),
                    {}
            )
        };
    },
};

import * as types from './types/getters';

export default {
    [types.GET_SCHEDULED_EVENT_FILTER_VIEW]: state =>
        state.scheduledEventsFilterView,

    [types.GET_SCHEDULED_EVENTS]: state => state.scheduledEvents,

    [types.GET_SCHEDULED_EVENTS_PAGINATION]: state => state.eventsPagination,

    [types.GET_EVENT_EMAILS_FILTER]: state =>
            Object.values(state.eventEmails).sort((a, b) => {
                return a.name - b.name;
            }),
};

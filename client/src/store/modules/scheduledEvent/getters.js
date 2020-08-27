import * as types from './types/getters';

export default {
    [types.GET_SCHEDULED_EVENT_FILTER_VIEW]: state =>
        state.scheduledEventsFilterView,

    [types.GET_SCHEDULED_EVENTS]: state => state.scheduledEvents,

    [types.GET_SCHEDULED_EVENTS_PAGINATION]: state =>
        state.scheduledEvents.eventsPagination
};

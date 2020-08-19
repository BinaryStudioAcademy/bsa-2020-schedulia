import * as types from './types/getters';

export default {
    [types.GET_SCHEDULED_EVENT_FILTER_VIEW]: state =>
        state.scheduledEventsFilterView,

    [types.GET_SCHEDULED_EVENTS]: state => state.scheduledEvents.events,

    [types.GET_SCHEDULED_EVENTS_PAGINATION]: state =>
        state.scheduledEvents.eventsPagination,

    [types.GET_FILTER_SCHEDULED_EVENTS_TYPES]: state =>
            state.scheduledEventsTypes,
};

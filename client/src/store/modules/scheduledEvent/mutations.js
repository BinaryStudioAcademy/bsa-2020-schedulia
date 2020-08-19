import * as mutations from './types/mutations';

export default {
    [mutations.SET_SCHEDULED_EVENT_FILTER_VIEW]: (
        state,
        scheduledEventFilterView
    ) => {
        state.scheduledEventsFilterView = scheduledEventFilterView;
    },

    [mutations.SET_SCHEDULED_EVENTS]: (state, data) => {
        state.scheduledEvents = data;
    },

    [mutations.SET_FILTER_SCHEDULED_EVENTS_TYPES]: (state, data) => {
        state.scheduledEventsTypes = data;
    }
};

import * as mutations from './types/mutations';

export default {
    [mutations.SET_SCHEDULED_EVENT_FILTER_VIEW]: (state, scheduledEventFilterView) => {
        state.scheduledEventsFilterView = scheduledEventFilterView;
    },

    [mutations.SET_SCHEDULED_EVENTS]: (state, scheduledEvents) => {
        state.scheduledEvents = scheduledEvents;
    }
};

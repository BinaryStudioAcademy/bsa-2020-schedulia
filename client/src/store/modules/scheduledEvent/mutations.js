import * as mutations from './types/mutations';
import { eventMapper } from '@/store/modules/scheduledEvent/normalizer';

export default {
    [mutations.SET_SCHEDULED_EVENT_FILTER_VIEW]: (
        state,
        scheduledEventFilterView
    ) => {
        state.scheduledEventsFilterView = scheduledEventFilterView;
    },

    [mutations.SET_SCHEDULED_EVENTS]: (state, data) => {
        state.scheduledEvents = {
            ...state.scheduledEvents,
            ...data.reduce(
                (prev, event) => ({
                    ...prev,
                    [event.id]: eventMapper(event)
                }),
                {}
            )
        };
    },

    [mutations.CLEAR_SCHEDULED_EVENTS]: state => {
        state.scheduledEvents = [];
    }
};

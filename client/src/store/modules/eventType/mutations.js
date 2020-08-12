import * as mutations from './types/mutations';
import { eventTypeMapper } from '@/services/Normalizer';

export default {
    [mutations.SET_EVENT_TYPES]: (state, eventTypes) => {
        state.eventTypes = {
            ...state.eventTypes,
            ...eventTypes.reduce(
                (prev, eventType) => ({
                    ...prev,
                    [eventType.id]: eventTypeMapper(eventType)
                }),
                {}
            )
        };
    },
    [mutations.ADD_EVENT_TYPE]: (state, eventType) => {
        state.eventTypes = {
            ...state.eventTypes,
            [eventType.id]: eventTypeMapper(eventType)
        };
    },

    [mutations.SET_EVENT_TYPE]: (state, eventType) => {
        state.eventType = eventTypeMapper(eventType);
    },

    [mutations.DELETE_EVENT_TYPE]: (state, id) => {
        delete state.eventTypes[id];
    }
};

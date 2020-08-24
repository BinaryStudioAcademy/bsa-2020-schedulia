import * as mutations from './types/mutations';
import { eventTypeMapper } from '@/store/modules/eventType/normalizer';

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
    [mutations.DISABLE_EVENT_TYPE_BY_ID]: (state, data) => {
        const eventTypes = { ...state.eventTypes };
        eventTypes[data.id].disabled = data.disabled;
        state.eventTypes = eventTypes;
    },
    [mutations.DELETE_EVENT_TYPE_BY_ID]: (state, id) => {
        const eventTypes = { ...state.eventTypes };
        delete eventTypes[id];
        state.eventTypes = eventTypes;
    }
};

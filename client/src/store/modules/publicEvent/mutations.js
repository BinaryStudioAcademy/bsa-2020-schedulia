import * as mutations from './types/mutations';
import { eventTypeMapper } from './normalizer';

export default {
    [mutations.SET_EVENT_TYPE]: (state, eventType) => {
        state.eventType = {
            ...eventTypeMapper(eventType)
        };
    },
    [mutations.SET_PUBLIC_EVENT]: (state, publicEvent) => {
        state.publicEvent = { ...state.publicEvent, ...publicEvent };
    }
};

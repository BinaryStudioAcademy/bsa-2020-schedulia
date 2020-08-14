import * as mutations from './types/mutations';

export default {
    [mutations.SET_EVENT_TYPES]: (state, eventTypes) => {
        state.eventTypes = eventTypes;
    },
    [mutations.DISABLE_EVENT_TYPE_BY_ID]: (state, data) => {
        state.eventTypes.find(eventType => {
            return eventType.id === data.id;
        }).disabled = data.disabled;
    },
    [mutations.DELETE_EVENT_TYPE_BY_ID]: (state, id) => {
        state.eventTypes = state.eventTypes.filter(eventType => {
            return eventType.id !== id;
        });
    }
};

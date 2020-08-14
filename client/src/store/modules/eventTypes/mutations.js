import * as mutations from './types/mutations';

export default {
    [mutations.SET_EVENT_TYPES]: (state, eventTypes) => {
        state.eventTypes = eventTypes;
    },
    [mutations.DISABLE_EVENT_TYPE_BY_ID]: (state, data) => {
        const index = state.eventTypes.findIndex(eventType => {
            return eventType.id === data.id;
        });
        if (index !== -1) {
            state.eventTypes = [
                ...state.eventTypes.slice(0, index),
                { ...state.eventTypes[index], disabled: data.disabled },
                ...state.eventTypes.slice(index + 1)
            ];
        }
    },
    [mutations.DELETE_EVENT_TYPE_BY_ID]: (state, id) => {
        state.eventTypes = state.eventTypes.filter(eventType => {
            return eventType.id !== id;
        });
    }
};

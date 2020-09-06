import * as mutations from './types/mutations';
import { eventTypeMapper, eventTypeDefaultMapper } from '@/store/modules/eventType/normalizer';
import _ from 'lodash';

export default {
    [mutations.SET_EVENT_TYPES]: (state, eventTypes) => {
        const eventTypeById = {
            ...state.eventTypes.eventTypeById,
            ...eventTypes.reduce(
                (prev, eventType) => ({
                    ...prev,
                    [eventType.id]: eventTypeMapper(eventType)
                }),
                {}
            )
        };

        state.eventTypes = {
            eventTypeById: eventTypeById,
            eventTypes: Object.keys(eventTypeById)
        };
    },
    [mutations.ADD_EVENT_TYPE]: (state, eventType) => {
        state.eventTypes = {
            ...state.eventTypes,
            [eventType.id]: eventTypeMapper(eventType)
        };
    },

    [mutations.SET_EVENT_TYPE]: (state, eventType) => {
        _.assign(state.eventType, _.pick(eventType, _.keys(state.eventType)));
    },

    [mutations.CLEAR_SET_EVENT_TYPE]: (state) => {
        state.eventType = eventTypeDefaultMapper();
    },

    [mutations.DELETE_EVENT_TYPE]: (state, id) => {
        const eventTypes = { ...state.eventTypes };
        delete eventTypes[id];
        state.eventTypes = eventTypes;
    },

    [mutations.SET_PROPERTY]: (state, { property, value }) => {
        state[property] = value;
    }
};

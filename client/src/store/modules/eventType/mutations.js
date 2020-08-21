import * as mutations from './types/mutations';
import { eventTypeMapper } from '@/store/modules/eventType/normalizer';
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
        state.eventType = eventTypeMapper(eventType);
    },

    [mutations.DELETE_EVENT_TYPE]: (state, id) => {
        const eventTypes = { ...state.eventTypes };
        delete eventTypes[id];
        state.eventTypes = eventTypes;
    },

    [mutations.SET_EVENT_TYPE_FORM]: (state, data) => {
        _.assign(
            state.eventTypeForm,
            _.pick(data, _.keys(state.eventTypeForm))
        );
    },

    [mutations.SET_EVENT_TYPE_FORM_COLUMN_DISABLE]: (state, data) => {
        state.eventTypeForm.disabled = data;
    }
};

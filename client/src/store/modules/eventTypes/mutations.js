import * as mutations from './types/mutations';
import {
    eventTypeMapper,
    eventTypeTagMapper
} from '@/store/modules/eventType/normalizer';

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
    [mutations.CLEAR_EVENT_TYPES]: state => {
        state.eventTypes = [];
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
    },
    [mutations.SET_EVENT_TYPES_BY_NICKNAME]: (state, eventTypes) => {
        state.eventTypesByNickname = {
            ...state.eventTypesByNickname,
            ...eventTypes.reduce(
                (prev, eventType) => ({
                    ...prev,
                    [eventType.id]: eventTypeMapper(eventType)
                }),
                {}
            )
        };
    },
    [mutations.SET_CUSTOM_FIELDS]: (state, fields) => {
        state.customFields = {
            ...state.customFields,
            ...fields.reduce(
                (prev, field) => ({
                    ...prev,
                    [field.id]: {
                        type: field.type,
                        name: field.name
                    }
                }),
                {}
            )
        };
    },
    [mutations.SET_CUSTOM_FIELD]: (state, field) => {
        state.customFields = {
            ...state.customFields,
            [field.id]: {
                id: field.id,
                type: field.type,
                name: field.name
            }
        };
    },
    [mutations.EDIT_CUSTOM_FIELD]: (state, data) => {
        state.customFields = {
            ...state.customFields,
            [data.id]: {
                type: data.type,
                name: data.name
            }
        };
    },
    [mutations.DELETE_CUSTOM_FIELD]: (state, id) => {
        const customFields = { ...state.customFields };
        delete customFields[id];
        state.customFields = customFields;
    },
    [mutations.ADD_EVENT_TYPE]: (state, eventType) => {
        state.eventTypes = {
            ...state.eventTypes,
            [eventType.id]: eventTypeMapper(eventType)
        };
    },
    [mutations.UPDATE_INTERNAL_NOTE]: (state, data) => {
        const eventTypes = { ...state.eventTypes };
        eventTypes[data.id].internalNote = data.internalNote;
        state.eventTypes = eventTypes;
    },
    [mutations.CLEAR_EVENT_TYPES_TAGS]: state => {
        state.eventTypesTags = [];
    },
    [mutations.SET_EVENT_TYPES_TAGS]: (state, tags) => {
        state.eventTypesTags = {
            ...state.eventTypesTags,
            ...tags.reduce(
                (prev, tag) => ({
                    ...prev,
                    [tag.name]: eventTypeTagMapper(tag)
                }),
                {}
            )
        };
    },
    [mutations.CLEAR_CUSTOM_FIELDS]: state => {
        state.customFields = [];
    }
};

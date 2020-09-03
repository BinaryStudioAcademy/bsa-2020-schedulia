import * as getters from './types/getters';

export default {
    [getters.GET_ALL_EVENT_TYPES]: state =>
        Object.values(state.eventTypes).sort((a, b) => {
            return a.id - b.id;
        }),
    [getters.GET_EVENT_TYPES_BY_NICKNAME]: state => state.eventTypesByNickname,
    [getters.GET_CUSTOM_FIELDS]: state => state.customFields,
    [getters.GET_CUSTOM_FIELD_BY_ID]: state => id => state.customFields[id],
    [getters.GET_ALL_EVENT_TYPES_TAGS]: state =>
        Object.values(state.eventTypesTags).sort((a, b) => {
            return a.id - b.id;
        })
};

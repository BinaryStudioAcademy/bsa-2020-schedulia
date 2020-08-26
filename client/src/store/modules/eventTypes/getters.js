import * as getters from './types/getters';

export default {
    [getters.GET_ALL_EVENT_TYPES]: state =>
        Object.values(state.eventTypes).sort((a, b) => {
            return a.id - b.id;
        }),
    [getters.GET_EVENT_TYPES_BY_NICKNAME]: state => state.eventTypesByNickname
};

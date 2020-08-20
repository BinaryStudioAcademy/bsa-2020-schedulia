import * as types from './types/getters';

export default {
    [types.GET_EVENT_TYPE]: state => state.eventType,
    [types.GET_PUBLIC_EVENT]: state => state.publicEvent
};

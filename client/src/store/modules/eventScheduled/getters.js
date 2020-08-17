import * as types from './types/getters';

export default {
    [types.GET_EVENT_FILTER_VIEW]: state => state.eventFilterView,

    [types.GET_SCHEDULED_EVENTS]: state => state.events
};

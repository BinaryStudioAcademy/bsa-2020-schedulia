import * as types from './types/getters';

export default {
    [types.GET_EVENT_TYPES]: state => state.eventTypes,
    [types.GET_EVENT_TYPE]: state => state.eventType,
    [types.GET_DAY_AVAILABILITIES]: state => state.dayAvailabilities,
    [types.GET_VISIBLE_AVAILABILITY_DIALOG]: state =>
        state.visibleAvailabilityDialog,
    [types.GET_VISIBLE_TIME_ZONE_DIALOG]: state => state.visibleTimeZoneDialog,
    [types.GET_VISIBLE_DAY_AVAILABILITIES_DIALOG]: state =>
        state.visibleDayAvailabilitiesDialog,
    [types.GET_IS_SAVED]: state => state.isSaved
};

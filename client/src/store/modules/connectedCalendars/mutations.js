import * as mutations from './types/mutations';

export default {
    [mutations.SET_CALENDARS]: (state, calendars) => {
        state.calendars = {
            ...state.calendars,
            calendars
        };
    },
    [mutations.DELETE_CALENDAR_BY_PROVIDER]: (state, providerToDelete) => {
        const calendars = { ...state.calendars };

        const result = calendars.calendars.filter(({ provider }) => {
            return provider !== providerToDelete;
        });

        state.calendars.calendars = result;
    }
};

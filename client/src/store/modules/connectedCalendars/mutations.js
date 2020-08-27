import * as mutations from './types/mutations';

export default {
    [mutations.SET_CALENDARS]: (state, calendars) => {
        state.calendars = {
            ...state.calendars,
            calendars
        };
    }
};

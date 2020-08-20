import * as mutations from './types/mutations';
import { userMapper, availabilityMapper } from './normalizer';

export default {
    [mutations.SET_EVENT_TYPE]: (state, eventType) => {
        state.eventType = {
            ...eventType,
            owner: userMapper(eventType.owner),
            availabilities: availabilityMapper(eventType.availabilities)
        };
    },
    [mutations.SET_PUBLIC_EVENT]: (state, publicEvent) => {
        state.publicEvent = publicEvent;
    },
    [mutations.SET_INVITEE_NAME]: (state, name) => {
        state.publicEvent = {
            ...state.publicEvent,
            inviteeName: name
        };
    },
    [mutations.SET_INVITEE_EMAIL]: (state, email) => {
        state.publicEvent = {
            ...state.publicEvent,
            inviteeEmail: email
        };
    },
    [mutations.SET_START_DATE]: (state, startDate) => {
        state.publicEvent = {
            ...state.publicEvent,
            startDate
        };
    },
    [mutations.SET_TIMEZONE]: (state, timezone) => {
        state.publicEvent = {
            ...state.publicEvent,
            timezone
        };
    }
};

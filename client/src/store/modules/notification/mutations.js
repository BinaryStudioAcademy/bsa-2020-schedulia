import * as mutations from './types/mutations';

export default {
    [mutations.SET_NOTIFICATION]: (state, notification) => {
        state.notifications = {
            ...state.notifications,
            [notification.id]: notification
        };
    },

    [mutations.CLOSE_NOTIFICATION]: (state, id) => {
        state.notifications = {
            ...state.notifications,
            [id]: { ...state.notifications[id], showing: false }
        };
    },

    [mutations.REMOVE_NOTIFICATION]: (state, id) => {
        const notifications = { ...state.notifications };
        delete notifications[id];
        state.notifications = notifications;
    }
};

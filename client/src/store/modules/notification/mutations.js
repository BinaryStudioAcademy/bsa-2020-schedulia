import * as mutations from './types/mutations';

export default {
    [mutations.SET_NOTIFICATION]: (state, notification) => {
        state.notifications = {
            ...state.notifications,
            [notification.id]: notification
        };
    },

    [mutations.REMOVE_NOTIFICATION]: (state, id) => {
        delete state.notifications[id];
    }
};

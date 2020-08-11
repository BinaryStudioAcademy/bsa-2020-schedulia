import * as mutations from './types/mutations';

export default {
    [mutations.SET_NOTIFICATION]: (state, notification) => {
        state.notifications = state.notifications.concat(notification);
    },

    [mutations.REMOVE_NOTIFICATION]: (state, index) => {
        console.log('auto remove in mutation ' + index);
        state.notifications = state.notifications.splice(1, index);
    }
};

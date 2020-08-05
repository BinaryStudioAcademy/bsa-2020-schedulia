import * as mutations from './types/mutations';

export default {
    [mutations.USER_LOGOUT]: state => {
        state.user = null;
    },
    [mutations.SET_LOGGED_USER]: (state, userData) => {
        state.user = userData;
    }
};

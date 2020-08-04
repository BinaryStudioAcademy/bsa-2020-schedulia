import * as mutations from './types/mutations';

export default {
    [mutations.USER_LOGIN]: state => {
        state.isLoggedIn = true;
    },
    [mutations.USER_LOGOUT]: state => {
        state.isLoggedIn = false;
        state.user = {};
    },
    [mutations.SET_LOGGED_USER]: (state, userData) => {
        state.isLoggedIn = true;
        state.user = userData;
    }
};

import * as mutations from './types/mutations';

export default {
    [mutations.USER_LOGIN]: (state, loginData) => {
        localStorage.setItem('auth.accessToken', loginData.accessToken);
        localStorage.setItem('auth.tokenType', loginData.tokenType);
        state.token = loginData.accessToken;
        state.isLoggedIn = true;
    },
    [mutations.USER_LOGOUT]: state => {
        localStorage.removeItem('auth.accessToken');
        localStorage.removeItem('auth.tokenType');
        state.token = '';
        state.isLoggedIn = false;
        state.user = {};
    },
    [mutations.SET_LOGGED_USER]: (state, userData) => {
        state.isLoggedIn = true;
        state.user = userData;
    }
};

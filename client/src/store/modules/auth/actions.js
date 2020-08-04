import * as actions from './types/actions';
import * as mutations from './types/mutations';
import authService from '@/services/auth/authService';

export default {
    [actions.SIGN_IN]: async ({ commit }, loginData) => {
        await authService.signIn(loginData);
        commit(mutations.USER_LOGIN);
    },
    [actions.SIGN_UP]: async (context, registerData) => {
        await authService.signUp(registerData);
    },
    [actions.FETCH_LOGGED_USER]: async ({ commit }) => {
        const fetchUserResponse = await authService.fetchLoggedUser();
        commit(mutations.SET_LOGGED_USER, fetchUserResponse);
    },
    [actions.SIGN_OUT]: async ({ commit }) => {
        await authService.signOut();
        commit(mutations.USER_LOGOUT);
    }
};

import * as actions from './types/actions';
import * as mutations from './types/mutations';
import authService from '@/services/auth/authService';

export default {
    [actions.SIGN_IN]: async ({ commit }, loginData) => {
        try {
            const loginResponse = await authService.signIn(loginData);
            commit(mutations.USER_LOGIN, {
                accessToken: loginResponse.access_token,
                tokenType: loginResponse.token_type,
                expiresIn: loginResponse.expires_in
            });
        } catch (error) {
            return Promise.reject(error);
        }
    },
    [actions.SIGN_UP]: async (context, registerData) => {
        try {
            await authService.signUp(registerData);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    [actions.FETCH_LOGGED_USER]: async ({ commit }) => {
        try {
            const fetchUserResponse = await authService.fetchLoggedUser();
            commit(mutations.SET_LOGGED_USER, fetchUserResponse);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    [actions.SIGN_OUT]: async ({ commit }) => {
        try {
            await authService.signOut();
            commit(mutations.USER_LOGOUT);
        } catch (error) {
            return Promise.reject(error);
        }
    }
};

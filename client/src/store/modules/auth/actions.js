import * as actions from './types/actions';
import * as mutations from './types/mutations';
import authService from '@/services/auth/authService';
import router from '@/router';
import * as notifyActions from '@/store/modules/notification/types/actions';

export default {
    [actions.SIGN_IN]: async (context, loginData) => {
        await authService.signIn(loginData);
    },
    [actions.SIGN_UP]: async (context, registerData) => {
        await authService.signUp(registerData);
    },
    [actions.FETCH_LOGGED_USER]: async ({ commit, dispatch }) => {
        try {
            const fetchUserResponse = await authService.fetchLoggedUser();
            commit(mutations.SET_LOGGED_USER, fetchUserResponse);
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error);
        }
    },
    [actions.SIGN_OUT]: async ({ commit, dispatch }) => {
        try {
            await authService.signOut();
            commit(mutations.USER_LOGOUT);
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error);
        }
    },
    [actions.CHECK_IF_UNAUTHORIZED]: ({ dispatch }, error) => {
        if (error.response.status === 401) {
            authService.removeToken();
            router.push({ name: 'SignIn' });
            dispatch(
                'notification/' + notifyActions.SET_ERROR_NOTIFICATION,
                error?.response?.data?.error?.message,
                { root: true }
            );
        }
    }
};

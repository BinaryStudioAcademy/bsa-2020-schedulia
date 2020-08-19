import * as actions from './types/actions';
import * as mutations from './types/mutations';
import authService from '@/services/auth/authService';
import router from '@/router';
import * as notifyActions from '@/store/modules/notification/types/actions';
import enLang from '@/store/modules/i18n/en';

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
    },
    [actions.FORGOT_PASSWORD]: async context => {
        try {
            const dataForgot = {
                email: context.state.forgotPasswordData.email
            };
            await authService.forgotPassword(dataForgot);
            context.commit(mutations.SET_TYPE_RESULT_SUBMIT_FORGOT, 'success');
            context.commit(
                mutations.SET_RESULT_SUBMIT_FORGOT,
                enLang.LETTER_WITH_RESET_LINK_WAS_SENT
            );
            context.commit(
                mutations.SET_EXPLANATION_FORGOT,
                enLang.LETTER_EXPLANATION_EMAIL_EXIST
            );
            context.commit(mutations.SET_VISIBILITY_FORGOT, true);
        } catch (error) {
            context.commit(mutations.SET_TYPE_RESULT_SUBMIT_FORGOT, 'error');
            context.commit(
                mutations.SET_RESULT_SUBMIT_FORGOT,
                enLang.THE_USER_WITH_THE_SPECIFIED_EMAIL_DOES_NOT_EXIST
            );
            context.commit(
                mutations.SET_EXPLANATION_FORGOT,
                enLang.LETTER_EXPLANATION_EMAIL_DONOT_EXIST
            );
            context.commit(mutations.SET_VISIBILITY_FORGOT, true);
        }
    },
    [actions.RESET_PASSWORD]: async context => {
        try {
            const dataReset = {
                email: context.state.resetPasswordData.email,
                password: context.state.resetPasswordData.password,
                token: context.state.resetPasswordData.token
            };
            await authService.resetPassword(dataReset);
            context.commit(mutations.SET_STATUS_SUBMIT_RESET, 'success');
            context.commit(
                mutations.SET_SHORT_DESC_SUBMIT_RESET,
                enLang.OK_PASSWORD_RESET
            );
            context.commit(
                mutations.SET_EXPLANATION_RESET,
                enLang.EXPLANATION_PASSWORD_RESET
            );
            context.commit(mutations.SET_VISIBILITY_RESET, true);
        } catch (error) {
            context.commit(mutations.SET_STATUS_SUBMIT_RESET, 'error');
            context.commit(
                mutations.SET_SHORT_DESC_SUBMIT_RESET,
                enLang.ERROR_IN_PASSWORD_RESET
            );
            context.commit(
                mutations.SET_EXPLANATION_RESET,
                enLang.EXPLANATION_ERROR_PASSWORD_RESET
            );
            context.commit(mutations.SET_VISIBILITY_RESET, true);
        }
    }
};

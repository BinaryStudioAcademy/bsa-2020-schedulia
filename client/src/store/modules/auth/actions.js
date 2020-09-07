import * as actions from './types/actions';
import * as mutations from './types/mutations';
import authService from '@/services/auth/authService';
import router from '@/router';
import * as notifyActions from '@/store/modules/notification/types/actions';
import * as langGetters from '@/store/modules/i18n/types/getters';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import notificationConnectionService from '@/services/notification-connections/notificationConnectionService';
import profileService from '@/services/profile/profileService';

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
    [actions.CHECK_IF_UNAUTHORIZED]: (
        { dispatch, state, rootGetters },
        error
    ) => {
        if (error.response.status === 401) {
            authService.removeToken();
            state.user = null;
            router.push({ name: 'SignIn' });
            dispatch(
                'notification/' + notifyActions.SET_ERROR_NOTIFICATION,
                rootGetters['i18n/' + langGetters.GET_LANGUAGE_CONSTANTS]
                    .UNAUTHENTICATED_ERROR,
                { root: true }
            );
        }
    },
    [actions.VERIFY_EMAIL]: async (context, payload) => {
        await authService.verifyEmail(payload);
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
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].LETTER_WITH_RESET_LINK_WAS_SENT
            );
            context.commit(
                mutations.SET_EXPLANATION_FORGOT,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].LETTER_EXPLANATION_EMAIL_EXIST
            );
            context.commit(mutations.SET_VISIBILITY_FORGOT, true);
        } catch (error) {
            context.commit(mutations.SET_TYPE_RESULT_SUBMIT_FORGOT, 'error');
            context.commit(
                mutations.SET_RESULT_SUBMIT_FORGOT,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].THE_USER_WITH_THE_SPECIFIED_EMAIL_DOES_NOT_EXIST
            );
            context.commit(
                mutations.SET_EXPLANATION_FORGOT,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].LETTER_EXPLANATION_EMAIL_DONOT_EXIST
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
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].OK_PASSWORD_RESET
            );
            context.commit(
                mutations.SET_EXPLANATION_RESET,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].EXPLANATION_PASSWORD_RESET
            );
            context.commit(mutations.SET_VISIBILITY_RESET, true);
        } catch (error) {
            context.commit(mutations.SET_STATUS_SUBMIT_RESET, 'error');
            context.commit(
                mutations.SET_SHORT_DESC_SUBMIT_RESET,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].ERROR_IN_PASSWORD_RESET
            );
            context.commit(
                mutations.SET_EXPLANATION_RESET,
                context.rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].EXPLANATION_ERROR_PASSWORD_RESET
            );
            context.commit(mutations.SET_VISIBILITY_RESET, true);
        }
    },
    [actions.CONNECT_SLACK_NOTIFICATIONS]: async (
        { commit, dispatch },
        slackData
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await notificationConnectionService.connectSlack(slackData);
            commit(mutations.CONNECT_SLACK_NOTIFICATIONS, slackData);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.DELETE_SLACK_NOTIFICATIONS]: async ({ commit, dispatch }) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await notificationConnectionService.deleteSlack();
            commit(mutations.DELETE_SLACK_NOTIFICATIONS);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.CHANGE_CHATITO_NOTIFICATIONS_ACTIVITY]: async (
        { commit, dispatch },
        value
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await notificationConnectionService.changeActivityChatito(value);
            commit(
                mutations.CHANGE_CHATITO_NOTIFICATIONS_ACTIVITY,
                value.chatito_active
            );
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.UPDATE_PROFILE]: async ({ commit, dispatch }, userData) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await profileService.updateProfile(userData);
            commit(mutations.UPDATE_PROFILE, response?.data?.data);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch(actions.CHECK_IF_UNAUTHORIZED, error);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    }
};

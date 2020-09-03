import calendarService from '@/services/connectedCalendars/calendarService';
import socilaAccountService from '@/services/socialAccount/socialAccountService';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';

import { SET_CALENDARS, DELETE_CALENDAR_BY_PROVIDER } from './types/mutations';

export default {
    fetchCalendars: async ({ commit, dispatch }) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const calendars = await socilaAccountService.fetchAllCalendars();

            commit(SET_CALENDARS, calendars);

            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
            return calendars;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },

    async connect({ commit, dispatch }, calendar) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });

        try {
            const response = await calendarService.connect(calendar);

            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });

            return response?.data?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },

    async disconnect({ commit, dispatch }, provider) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });

        try {
            const response = await calendarService.disconnect(provider);
            commit(DELETE_CALENDAR_BY_PROVIDER, provider);

            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });

            return response?.data?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    }
};

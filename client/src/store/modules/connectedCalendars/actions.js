import calendarService from '@/services/connectedCalendars/calendarService';
import socilaAccountService from '@/services/socialAccount/socialAccountService';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';

import {
    SET_CALENDARS,
} from './types/mutations';

export default {

    fetchCalendars: async (
        { commit, dispatch }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const calendars = await socilaAccountService.fetchAllCalendars();

            console.log(calendars);

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

            return response?.data;
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

import calendarService from '@/services/connectedCalendars/calendarService';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';

export default {
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

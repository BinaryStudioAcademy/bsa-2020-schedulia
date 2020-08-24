import eventTypesService from '@/services/event-types/eventTypesService';
import * as actions from './types/actions';
import * as mutations from './types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';
import * as loaderMutations from '@/store/modules/loader/types/mutations';

export default {
    [actions.FETCH_EVENT_TYPES]: async (
        { commit, dispatch },
        data = { searchString: '' }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const eventTypes = await eventTypesService.fetchAllEventTypes(
                data.searchString,
                data.page
            );
            commit(mutations.SET_EVENT_TYPES, eventTypes);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
            return eventTypes;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.DISABLE_EVENT_TYPE_BY_ID]: async (
        { commit, dispatch },
        { id, disabled }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await eventTypesService.changeDisabledEventTypeById({
                id,
                disabled
            });
            commit(mutations.DISABLE_EVENT_TYPE_BY_ID, {
                id,
                disabled
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.DELETE_EVENT_TYPE_BY_ID]: async (
        { commit, dispatch },
        eventTypeId
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await eventTypesService.deleteEventTypeById(eventTypeId);
            commit(mutations.DELETE_EVENT_TYPE_BY_ID, eventTypeId);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
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

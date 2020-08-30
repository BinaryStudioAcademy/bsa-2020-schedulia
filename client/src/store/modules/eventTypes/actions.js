import eventTypesService from '@/services/event-types/eventTypesService';
import * as actions from './types/actions';
import * as mutations from './types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import * as notifyActions from '@/store/modules/notification/types/actions';

export default {
    [actions.FETCH_EVENT_TYPES]: async (
        { commit, dispatch },
        data = { searchString: '', all: false }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const eventTypes = await eventTypesService.fetchAllEventTypes(
                data.searchString,
                data.page,
                data.all
            );
            if (data.searchString || data.page === 1 || data.all) {
                commit(mutations.CLEAR_EVENT_TYPES);
            }
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
    },
    [actions.FETCH_EVENT_TYPES_BY_NICKNAME]: async (
        { commit, dispatch },
        nickName
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await eventTypesService.fetchEventTypesByNickname(
                nickName
            );
            commit(mutations.SET_EVENT_TYPES_BY_NICKNAME, response.eventTypes);
            commit(mutations.SET_OWNER_NAME_BY_NICKNAME, response.owner);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch(
                'notification/' + notifyActions.SET_ERROR_NOTIFICATION,
                error?.response?.data?.error?.message,
                { root: true }
            );
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    }
};

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
            const eventTypes = await eventTypesService.fetchEventTypesByNickname(
                nickName
            );
            commit(mutations.SET_EVENT_TYPES_BY_NICKNAME, eventTypes);
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
    },
    [actions.FETCH_CUSTOM_FIELDS_BY_EVENT_ID]: async ({ commit, dispatch }) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const customFields = await eventTypesService.fetchCustomFieldsByEventTypeId();
            commit(mutations.SET_CUSTOM_FIELDS, customFields);
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
    [actions.SET_CUSTOM_FIELD]: ({ commit }, field) => {
        commit(mutations.SET_CUSTOM_FIELD, field);
    },
    [actions.DELETE_CUSTOM_FIELD]: ({ commit }, id) => {
        commit(mutations.DELETE_CUSTOM_FIELD, id);
    },
    [actions.SAVE_CUSTOM_FIELDS]: async (
        { commit, dispatch },
        { id, custom_fields }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            await eventTypesService.saveCustomFieldsByEventTypeId(id, {
                custom_fields: Object.values(custom_fields)
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },
    [actions.EDIT_CUSTOM_FIELD]: ({ commit, dispatch }, data) => {
        try {
            commit(mutations.EDIT_CUSTOM_FIELD, data);
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    }
};

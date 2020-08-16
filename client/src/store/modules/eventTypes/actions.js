import eventTypesService from '@/services/event-types/eventTypesService';
import * as actions from './types/actions';
import * as mutations from './types/mutations';
import * as authAction from '@/store/modules/auth/types/actions';

export default {
    [actions.FETCH_ALL_EVENT_TYPES]: async ({ commit, dispatch }) => {
        try {
            const eventTypes = await eventTypesService.fetchAllEventTypes();
            commit(mutations.SET_EVENT_TYPES, eventTypes);
        } catch (error) {
            dispatch('auth/' + authAction.CHECK_IF_UNAUTHORIZED, error, { root: true });
        }
    },
    [actions.DISABLE_EVENT_TYPE_BY_ID]: async (
        { commit, dispatch },
        { id, disabled }
    ) => {
        try {
            await eventTypesService.changeDisabledEventTypeById({ id, disabled });
            commit(mutations.DISABLE_EVENT_TYPE_BY_ID, {
                id,
                disabled
            });
        } catch (error) {
            dispatch('auth/' + authAction.CHECK_IF_UNAUTHORIZED, error, { root: true });
        }
    },
    [actions.DELETE_EVENT_TYPE_BY_ID]: async ({ commit, dispatch }, eventTypeId) => {
        try {
            await eventTypesService.deleteEventTypeById(eventTypeId);
            commit(mutations.DELETE_EVENT_TYPE_BY_ID, eventTypeId);
        } catch (error) {
            dispatch('auth/' + authAction.CHECK_IF_UNAUTHORIZED, error, { root: true});
        }
    }
};

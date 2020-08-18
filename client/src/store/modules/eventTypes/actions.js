import eventTypesService from '@/services/event-types/eventTypesService';
import * as actions from './types/actions';
import * as mutations from './types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';

export default {
    [actions.FETCH_EVENT_TYPES]: async (
        { commit, dispatch },
        searchString = ''
    ) => {
        try {
            const eventTypes = await eventTypesService.fetchAllEventTypes(
                searchString
            );
            commit(mutations.SET_EVENT_TYPES, eventTypes);
            return eventTypes;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },
    [actions.DISABLE_EVENT_TYPE_BY_ID]: async (
        { commit, dispatch },
        { id, disabled }
    ) => {
        try {
            await eventTypesService.changeDisabledEventTypeById({
                id,
                disabled
            });
            commit(mutations.DISABLE_EVENT_TYPE_BY_ID, {
                id,
                disabled
            });
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },
    [actions.DELETE_EVENT_TYPE_BY_ID]: async (
        { commit, dispatch },
        eventTypeId
    ) => {
        try {
            await eventTypesService.deleteEventTypeById(eventTypeId);
            commit(mutations.DELETE_EVENT_TYPE_BY_ID, eventTypeId);
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    }
};

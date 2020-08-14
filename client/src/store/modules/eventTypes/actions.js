import eventTypesService from '@/services/event-types/eventTypesService';
import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.FETCH_ALL_EVENT_TYPES]: async ({ commit }) => {
        const eventTypes = await eventTypesService.fetchAllEventTypes();
        commit(mutations.SET_EVENT_TYPES, eventTypes);
    },
    [actions.DISABLE_EVENT_TYPE_BY_ID]: async (
        { commit },
        { id, disabled }
    ) => {
        await eventTypesService.changeDisabledEventTypeById({ id, disabled });
        commit(mutations.DISABLE_EVENT_TYPE_BY_ID, {
            id,
            disabled
        });
    },
    [actions.DELETE_EVENT_TYPE_BY_ID]: async ({ commit }, eventTypeId) => {
        await eventTypesService.deleteEventTypeById(eventTypeId);
        commit(mutations.DELETE_EVENT_TYPE_BY_ID, eventTypeId);
    }
};

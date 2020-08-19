import * as actions from './types/actions';
import * as mutations from './types/mutations';
import scheduledEventService from '@/services/scheduled-event/scheduledEventsService';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';

export default {
    [actions.SET_SCHEDULED_EVENT_FILTER_VIEW]: async (
        { commit },
        scheduledEventFilterView
    ) => {
        commit(
            mutations.SET_SCHEDULED_EVENT_FILTER_VIEW,
            scheduledEventFilterView
        );
    },

    [actions.SET_SCHEDULED_EVENTS]: async ({ commit }) => {
        try {
            const data = await scheduledEventService.getScheduledEvents();

            commit(mutations.SET_SCHEDULED_EVENTS, data);
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },

    [actions.SET_FILTER_SCHEDULED_EVENTS_TYPES]: async ({ commit }, eventTypesSearch = '') => {
        try {
            console.log(eventTypesSearch);
            const data = await scheduledEventService.getFilterScheduledEventsTypes(eventTypesSearch);

            commit(mutations.SET_FILTER_SCHEDULED_EVENTS_TYPES, data);
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    }
};

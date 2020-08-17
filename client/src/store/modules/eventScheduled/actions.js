import * as actions from './types/actions';
import * as mutations from './types/mutations';
import scheduledEventsService from '@/services/scheduled-events/scheduledEventsService';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';

export default {
    [actions.SET_EVENT_FILTER_VIEW]: async ({ commit }, eventFilterView) => {
        commit(mutations.SET_EVENT_FILTER_VIEW, eventFilterView);
    },

    [actions.SET_SCHEDULED_EVENTS]: async ({ commit }) => {
        try {
            const data = await scheduledEventsService.getScheduledEvents();

            commit(mutations.SET_SCHEDULED_EVENTS, data);
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    }
};

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

    [actions.SET_SCHEDULED_EVENTS]: async (
        { commit },
        {
            page = 1,
            sort = 'start_date',
            direction = 'desc',
            eventTypes = [],
            startDate = '',
            endDate = ''
        }
    ) => {
        try {
            const events = await scheduledEventService.getScheduledEvents(
                page,
                sort,
                direction,
                eventTypes,
                startDate,
                endDate
            );

            commit(mutations.CLEAR_SCHEDULED_EVENTS);
            commit(mutations.SET_SCHEDULED_EVENTS_PAGINATION, events.meta);
            commit(mutations.SET_SCHEDULED_EVENTS, events.data);
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    }
};

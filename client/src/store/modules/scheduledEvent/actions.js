import * as actions from './types/actions';
import * as mutations from './types/mutations';
import scheduledEventService from '@/services/scheduled-event/scheduledEventsService';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';
import * as loaderMutations from '@/store/modules/loader/types/mutations';

export default {
    [actions.SET_SCHEDULED_EVENT_FILTER_VIEW]: async (
        { commit },
        scheduledEventFilterView
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });

        try {
            commit(
                mutations.SET_SCHEDULED_EVENT_FILTER_VIEW,
                scheduledEventFilterView
            );

            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
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
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });

        try {
            const events = await scheduledEventService.getScheduledEvents(
                page,
                sort,
                direction,
                eventTypes,
                startDate,
                endDate
            );

            if (page === 1) {
                commit(mutations.CLEAR_SCHEDULED_EVENTS);
            }

            commit(mutations.SET_SCHEDULED_EVENTS_PAGINATION, events.meta);
            commit(mutations.SET_SCHEDULED_EVENTS, events.data);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    }
};

import * as actions from './types/actions';
import * as mutations from './types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';
import scheduledEventService from '@/services/scheduled-event/scheduledEventsService';
import * as loaderMutations from '@/store/modules/loader/types/mutations';

export default {
    [actions.SET_SCHEDULED_EVENT_FILTER_VIEW]: async (
        { commit, dispatch },
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
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },

    [actions.SET_SCHEDULED_EVENTS]: async (
        { commit, dispatch },
        {
            page = 1,
            sort = 'start_date',
            direction = 'desc',
            eventTypes = [],
            eventEmails = [],
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
                eventEmails,
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
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.FETCH_EVENT_EMAILS_FILTER]: async (
        { commit, dispatch },
        { startDate = '', endDate = '', searchString = '' }
    ) => {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });

        try {
            const eventEmails = await scheduledEventService.getEventEmailsFilter(
                startDate,
                endDate,
                searchString
            );

            if (searchString) {
                commit(mutations.CLEAR_EVENT_EMAILS_FILTER);
            }

            commit(mutations.SET_EVENT_EMAILS_FILTER, eventEmails);
            commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
            return eventEmails;
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

import * as actions from './types/actions';
import * as mutations from './types/mutations';
import publicEventService from '@/services/public-event/publicEventService';
import * as loaderMutations from '@/store/modules/loader/types/mutations';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';

export default {
    [actions.GET_EVENT_TYPE_BY_ID]: async (context, id) => {
        context.commit('loader/' + loaderMutations.SET_LOADING, true, {
            root: true
        });
        try {
            const eventType = await publicEventService.getEventTypeById(id);
            context.commit(mutations.SET_EVENT_TYPE, eventType);
            context.commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        } catch (error) {
            context.commit(SET_ERROR_NOTIFICATION, error.message);
            context.commit('loader/' + loaderMutations.SET_LOADING, false, {
                root: true
            });
        }
    },
    [actions.SET_PUBLIC_EVENT]: (context, data) => {
        try {
            context.commit(mutations.SET_PUBLIC_EVENT, data);
        } catch (error) {
            context.commit(SET_ERROR_NOTIFICATION, error.message);
        }
    },
    [actions.ADD_PUBLIC_EVENT]: async (context, data) => {
        try {
            context.commit(mutations.SET_PUBLIC_EVENT, {
                inviteeName: data.invitee_name,
                inviteeEmail: data.invitee_email,
                startDate: data.start_date,
                timezone: data.timezone
            });
            await publicEventService.addPublicEvent(data);
        } catch (error) {
            context.commit(SET_ERROR_NOTIFICATION, error.message);
        }
    }
};

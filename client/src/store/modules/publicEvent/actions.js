import * as actions from './types/actions';
import * as mutations from './types/mutations';
import publicEventService from '@/services/public-event/publicEventService';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';

export default {
    [actions.GET_EVENT_TYPE_BY_ID]: async (context, id) => {
        try {
            const eventType = await publicEventService.getEventTypeById(id);
            context.commit(mutations.SET_EVENT_TYPE, eventType);
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },
    [actions.ADD_PUBLIC_EVENT]: async (context, data) => {
        try {
            const publicEvent = await publicEventService.addPublicEvent(data);
            context.commit(mutations.SET_PUBLIC_EVENT, publicEvent);
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    }
};

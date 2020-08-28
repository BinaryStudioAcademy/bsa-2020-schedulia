import * as actions from './types/actions';
import * as mutations from './types/mutations';
import eventTypeService from '@/services/eventType/eventTypeService';
import { SET_ERROR_NOTIFICATION } from '@/store/modules/notification/types/actions';
import {
    eventTypeMapper,
    eventTypeFormMapper
} from '@/store/modules/eventType/normalizer';

export default {
    [actions.GET_EVENT_TYPE_BY_ID]: async (context, id) => {
        try {
            const eventType = await eventTypeService.getEventTypeById(id);
            context.commit(mutations.SET_EVENT_TYPE, eventTypeMapper(eventType));
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },
    [actions.GET_EVENT_TYPES]: async context => {
        try {
            const eventTypes = await eventTypeService.fetchEventTypes();
            context.commit(mutations.SET_EVENT_TYPES, eventTypes);

            return Promise.resolve(eventTypes.map(eventTypeMapper));
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },
    [actions.ADD_EVENT_TYPE]: async (context, data) => {
        try {
            const eventType = await eventTypeService.addEventType(
                eventTypeFormMapper(data)
            );
            context.commit(mutations.SET_EVENT_TYPES, eventType);

            return Promise.resolve(eventTypeMapper(eventType));
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },
    [actions.EDIT_EVENT_TYPE]: async (context, { id, data }) => {
        try {
            const eventType = await eventTypeService.editEventType(id, data);
            context.commit(mutations.SET_EVENT_TYPES, eventType);

            return Promise.resolve(eventTypeMapper(eventType));
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },
    [actions.DELETE_EVENT_TYPE]: async (context, id) => {
        try {
            await eventTypeService.deleteEventType(id);

            return Promise.resolve();
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },

    [actions.SET_EVENT_TYPE]: async (context, data) => {
        try {
            context.commit(mutations.SET_EVENT_TYPE, data);
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    },

    [actions.SET_PROPERTY]: async (context, data) => {
        try {
            context.commit(mutations.SET_PROPERTY, data);
        } catch (error) {
            context.commit(
                SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message
            );
        }
    }
};

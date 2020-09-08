import * as actions from './types/actions';
import * as mutations from './types/mutations';
import eventTypeService from '@/services/eventType/eventTypeService';
import {
    SET_ERROR_NOTIFICATION,
    SET_SUCCESS_NOTIFICATION
} from '@/store/modules/notification/types/actions';
import {
    eventTypeMapper,
    eventTypeFormMapper
} from '@/store/modules/eventType/normalizer';
import * as langGetters from '@/store/modules/i18n/types/getters';

export default {
    [actions.GET_EVENT_TYPE_BY_ID]: async (context, id) => {
        try {
            const eventType = await eventTypeService.getEventTypeById(id);
            context.commit(
                mutations.SET_EVENT_TYPE,
                eventTypeMapper(eventType)
            );
        } catch (error) {
            context.dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },
    [actions.GET_EVENT_TYPES]: async context => {
        try {
            const eventTypes = await eventTypeService.fetchEventTypes();
            context.commit(mutations.SET_EVENT_TYPES, eventTypes);

            return Promise.resolve(eventTypes.map(eventTypeMapper));
        } catch (error) {
            context.dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },
    [actions.CLEAR_SET_EVENT_TYPE]: async context => {
        context.commit(mutations.CLEAR_SET_EVENT_TYPE);
    },
    [actions.ADD_EVENT_TYPE]: async ({ dispatch, rootGetters }, data) => {
        try {
            const eventType = await eventTypeService.addEventType(
                eventTypeFormMapper(data)
            );
            dispatch(
                'notification/' + SET_SUCCESS_NOTIFICATION,
                rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].EVENT_TYPE_CREATED.replace('_', data.name),
                { root: true }
            );
            return Promise.resolve(eventTypeMapper(eventType));
        } catch (error) {
            dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },
    [actions.EDIT_EVENT_TYPE]: async ({ dispatch, rootGetters }, data) => {
        try {
            const eventType = await eventTypeService.editEventType(
                data.id,
                eventTypeFormMapper(data)
            );

            dispatch(
                'notification/' + SET_SUCCESS_NOTIFICATION,
                rootGetters[
                    'i18n/' + langGetters.GET_LANGUAGE_CONSTANTS
                ].EVENT_TYPE_UPDATED.replace('_', data.name),
                { root: true }
            );
            return Promise.resolve(eventTypeMapper(eventType));
        } catch (error) {
            dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },
    [actions.DELETE_EVENT_TYPE]: async (context, id) => {
        try {
            await eventTypeService.deleteEventType(id);

            return Promise.resolve();
        } catch (error) {
            context.dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },

    [actions.SET_EVENT_TYPE]: async (context, data) => {
        try {
            context.commit(mutations.SET_EVENT_TYPE, data);
        } catch (error) {
            context.dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    },

    [actions.SET_PROPERTY]: async (context, data) => {
        try {
            context.commit(mutations.SET_PROPERTY, data);
        } catch (error) {
            context.dispatch(
                'notification/' + SET_ERROR_NOTIFICATION,
                error?.response?.data?.message || error.message,
                { root: true }
            );
        }
    }
};

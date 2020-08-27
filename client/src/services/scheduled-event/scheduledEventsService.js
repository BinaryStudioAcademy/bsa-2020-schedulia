import responseFilterScheduledEventsTypes from './responseFilterScheduledEventsTypes.json';
import responseFilterScheduledEventsTypesSearch from './responseFilterScheduledEventsTypesSearch.json';
import requestService from '../requestService';

const scheduledEventService = {
    async getScheduledEvents(eventFilter) {
        console.log(eventFilter);
        const response = await requestService.get('/events');
        return response?.data?.data;
    },

    async getFilterScheduledEventsTypes(eventTypesSearch) {
        if (eventTypesSearch) {
            return responseFilterScheduledEventsTypesSearch;
        } else {
            return responseFilterScheduledEventsTypes;
        }
    }
};

export default scheduledEventService;

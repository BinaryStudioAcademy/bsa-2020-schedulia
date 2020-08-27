import responseFilterScheduledEventsTypes from './responseFilterScheduledEventsTypes.json';
import responseFilterScheduledEventsTypesSearch from './responseFilterScheduledEventsTypesSearch.json';
import requestService from '../requestService';

const scheduledEventService = {
    async getScheduledEvents(
                page,
                sort,
                direction,
                eventTypes,
                startDate,
                endDate,
    ) {
        const response = await requestService.get('/events', {
            page,
            sort,
            direction,
            eventTypes,
            startDate,
            endDate,
        });
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

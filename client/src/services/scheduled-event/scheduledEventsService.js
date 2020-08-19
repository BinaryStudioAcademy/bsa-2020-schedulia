import responseScheduledPastEventsFirstPage from './responseScheduledPastEventsFirstPage.json';
import responseScheduledPastEventsFirstPageFilter from './responseScheduledPastEventsFirstPageFilter.json';
import responseFilterScheduledEventsTypes from './responseFilterScheduledEventsTypes.json';
import responseFilterScheduledEventsTypesSearch from './responseFilterScheduledEventsTypesSearch.json';

const scheduledEventService = {
    async getScheduledEvents(eventFilter) {
        if (eventFilter.length) {
            const response = responseScheduledPastEventsFirstPageFilter;
            return response?.[0];
        } else {
            const response = responseScheduledPastEventsFirstPage;
            return response?.[0];
        }
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

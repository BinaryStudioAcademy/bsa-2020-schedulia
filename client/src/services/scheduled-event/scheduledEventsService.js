import responseScheduledPastEventsFirstPage from './responseScheduledPastEventsFirstPage.json';
import responseFilterScheduledEventsTypes from './responseFilterScheduledEventsTypes.json';
import responseFilterScheduledEventsTypesSearch from './responseFilterScheduledEventsTypesSearch.json';

const scheduledEventService = {
    async getScheduledEvents() {
        const response = responseScheduledPastEventsFirstPage;

        return response?.[0];
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

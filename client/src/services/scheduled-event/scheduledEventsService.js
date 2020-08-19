import responseScheduledPastEventsFirstPage from './responseScheduledPastEventsFirstPage.json';
import responseFilterScheduledEventsTypes from './responseFilterScheduledEventsTypes.json';

const scheduledEventService = {
    async getScheduledEvents() {
        const response = responseScheduledPastEventsFirstPage;

        return response?.[0];
    },

    async getFilterScheduledEventsTypes() {
        return responseFilterScheduledEventsTypes;
    }
};

export default scheduledEventService;

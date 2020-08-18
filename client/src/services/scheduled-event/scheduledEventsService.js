import responseScheduledPastEventsFirstPage from './responseScheduledPastEventsFirstPage.json';

const scheduledEventService = {
    async getScheduledEvents() {
        const response = responseScheduledPastEventsFirstPage;

        return response?.[0];
    }
};

export default scheduledEventService;

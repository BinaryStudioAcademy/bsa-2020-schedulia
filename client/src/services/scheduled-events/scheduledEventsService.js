import data from './scheduledEvents.json';

const scheduledEventsService = {
    async getScheduledEvents() {
        return data;
    }
};

export default scheduledEventsService;

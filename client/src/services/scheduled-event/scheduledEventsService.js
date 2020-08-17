import data from './scheduledEvents.json';

const scheduledEventService = {
    async getScheduledEvents() {
        return data;
    }
};

export default scheduledEventService;

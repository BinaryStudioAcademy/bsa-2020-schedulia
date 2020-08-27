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
    }
};

export default scheduledEventService;

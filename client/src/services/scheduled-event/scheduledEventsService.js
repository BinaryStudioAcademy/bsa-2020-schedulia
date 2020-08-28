import requestService from '../requestService';

const scheduledEventService = {
    async getScheduledEvents(
        page,
        sort,
        direction,
        eventTypes,
        start_date,
        end_date
    ) {
        const response = await requestService.get('/events', {
            page,
            sort,
            direction,
            eventTypes,
            start_date,
            end_date
        });
        return response?.data;
    }
};

export default scheduledEventService;

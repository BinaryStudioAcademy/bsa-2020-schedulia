import requestService from '../requestService';

const scheduledEventService = {
    async getScheduledEvents(
        page,
        sort,
        direction,
        event_types,
        start_date,
        end_date
    ) {
        const response = await requestService.get('/events', {
            page,
            sort,
            direction,
            event_types,
            start_date,
            end_date
        });
        return response?.data;
    }
};

export default scheduledEventService;

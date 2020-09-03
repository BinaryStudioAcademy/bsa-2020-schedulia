import requestService from '../requestService';

const apiEndpoint = '/events';

const scheduledEventService = {
    async getScheduledEvents(
        page,
        sort,
        direction,
        event_types,
        event_emails,
        event_status,
        tags,
        searchString,
        start_date,
        end_date
    ) {
        const response = await requestService.get(apiEndpoint, {
            page,
            sort,
            direction,
            event_types,
            event_emails,
            event_status,
            tags,
            searchString,
            start_date,
            end_date
        });
        return response?.data;
    },

    async getEventEmailsFilter(start_date, end_date, searchString) {
        const response = await requestService.get(apiEndpoint + '/emails', {
            start_date,
            end_date,
            searchString
        });
        return response?.data?.data;
    },

    async updateEvent(id, event) {
        const response = await requestService.put(`${apiEndpoint}/${id}`, {
            ...event
        });

        return response?.data?.data;
    }
};

export default scheduledEventService;

import requestService from '@/services/requestService';
const EVENT_TYPES_URL = '/event-types';
const EVENTS_URL = '/events';

const publicEventService = {
    async getEventTypeById(id) {
        const response = await requestService.get(`${EVENT_TYPES_URL}/${id}`);
        return response?.data?.data;
    },
    async addPublicEvent(data) {
        const response = await requestService.post(EVENTS_URL, data);
        return response?.data?.data;
    }
};

export default publicEventService;

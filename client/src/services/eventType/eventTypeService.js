import requestService from '@/services/requestService';
const EVENT_TYPES_URL = '/api/v1/event-types';

const eventTypeService = {
    async getEventTypeById(id) {
        const response = await requestService.get(`${EVENT_TYPES_URL}/${id}`);
        return response?.data?.data;
    },
    async fetchEventTypes() {
        const response = await requestService.get(EVENT_TYPES_URL);
        return response?.data?.data;
    },
    async addEventType(data) {
        const response = await requestService.post(EVENT_TYPES_URL, data);
        return response?.data?.data;
    },
    async editEventType(id, data) {
        const response = await requestService.put(
            `${EVENT_TYPES_URL}/${id}`,
            data
        );
        return response?.data?.data;
    },
    async deleteEventType(id) {
        const response = await requestService.delete(
            `${EVENT_TYPES_URL}/${id}`
        );
        return response?.data?.data;
    }
};

export default eventTypeService;

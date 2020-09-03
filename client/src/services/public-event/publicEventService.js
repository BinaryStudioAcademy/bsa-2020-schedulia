import requestService from '@/services/requestService';
const EVENTS_URL = '/events';

const publicEventService = {
    async getEventTypeByIdAndNickname(id, nickname) {
        const response = await requestService.get(
            `/public/users/${nickname}/event-types/${id}`
        );
        return response?.data?.data;
    },
    async getAvailabilitiesByMonth(id, date) {
        const response = await requestService.get(
            `/event-types/${id}/availabilities?month=${date}`
        );

        return response?.data?.data;
    },
    async addPublicEvent(data) {
        const response = await requestService.post(EVENTS_URL, data);
        return response?.data?.data;
    }
};

export default publicEventService;

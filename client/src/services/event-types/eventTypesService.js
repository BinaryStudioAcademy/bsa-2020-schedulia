import requestService from '@/services/requestService';

const eventTypesService = {
    async fetchAllEventTypes() {
        const response = await requestService.get('/event-types');
        return response?.data?.data;
    },
    async changeDisabledEventTypeById(updateData) {
        return await requestService.put(
            '/event-types/' + updateData.id + '/disabled',
            { disabled: updateData.disabled }
        );
    },
    async deleteEventTypeById(eventTypeId) {
        return await requestService.delete('/event-types/' + eventTypeId);
    },
    async createEventType(eventTypeData) {
        return await requestService.post('/event-types', eventTypeData);
    },
    async searchEventTypes(searchString) {
        const searchResponse = await requestService.get(
            '/event-types/search?searchString=' + searchString
        );
        return searchResponse?.data?.data;
    }
};

export default eventTypesService;

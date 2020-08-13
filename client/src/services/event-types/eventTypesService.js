import requestService from '@/services/requestService';

const eventTypesService = {
    async fetchAllEventTypes() {
        const response = await requestService.get('/eventTypes');
        return response?.data?.data;
    },
    async changeDisabledEventTypeById(updateData) {
        return await requestService.put(
            '/eventTypes/' + updateData.id + '/disabled',
            { disabled: updateData.disabled }
        );
    },
    async deleteEventTypeById(eventTypeId) {
        return await requestService.delete('/eventTypes/' + eventTypeId);
    },
    async createEventType(eventTypeData) {
        return await requestService.post('/eventTypes', eventTypeData);
    }
};

export default eventTypesService;

import requestService from '@/services/requestService';

const eventTypesService = {
    async fetchAllEventTypes() {
        return await requestService.get('/eventTypes');
    },
    async changeDisabledEventTypeById(updateData) {
        return await requestService.put(
            '/eventTypes/' + updateData.id + '/disabled',
            { disabled: updateData.disabled }
        );
    },
    async deleteEventTypeById(eventTypeId) {
        return await requestService.delete('/event-types/' + eventTypeId);
    }
};

export default eventTypesService;

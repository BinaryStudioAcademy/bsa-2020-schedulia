import requestService from '@/services/requestService';

const apiEndpoint = '/event-types';

const eventTypesService = {
    async fetchAllEventTypes(searchString) {
        const eventTypesApiUrl = searchString
            ? apiEndpoint + '?searchString=' + searchString
            : apiEndpoint;
        const response = await requestService.get(eventTypesApiUrl);
        return response?.data?.data;
    },
    async changeDisabledEventTypeById(updateData) {
        return await requestService.put(
            apiEndpoint + '/' + updateData.id + '/disabled',
            { disabled: updateData.disabled }
        );
    },
    async deleteEventTypeById(eventTypeId) {
        return await requestService.delete(apiEndpoint + '/' + eventTypeId);
    },
    async createEventType(eventTypeData) {
        return await requestService.post(apiEndpoint, eventTypeData);
    }
};

export default eventTypesService;

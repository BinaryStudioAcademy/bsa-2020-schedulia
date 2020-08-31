import requestService from '@/services/requestService';

const apiEndpoint = '/event-types';

const eventTypesService = {
    async fetchAllEventTypes(searchString, page, all) {
        const response = await requestService.get(apiEndpoint, {
            searchString,
            page,
            all
        });
        return response?.data;
    },
    async fetchEventTypesByNickname(nickName) {
        const response = await requestService.get(
            apiEndpoint + '/nickname/' + nickName
        );
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
    },
    async fetchCustomFieldsByEventTypeId(eventTypeId) {
        const response = await requestService.get(
            apiEndpoint + '/' + eventTypeId + '/custom-fields'
        );
        return response?.data?.data;
    },
    async saveCustomFieldsByEventTypeId(eventTypeId, customFields) {
        return await requestService.post(
            apiEndpoint + '/' + eventTypeId + '/custom-fields',
            customFields
        );
    },
    async cloneEventTypeById(eventTypeId) {
        const response = await requestService.post(
            apiEndpoint + '/' + eventTypeId + '/clone'
        );
        return response?.data?.data;
    }
};

export default eventTypesService;

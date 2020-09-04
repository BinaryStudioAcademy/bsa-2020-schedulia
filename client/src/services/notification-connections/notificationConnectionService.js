import requestService from '@/services/requestService';

const apiEndpointSlack = '/slack-notifications';

const notificationConnectionService = {
    async connectSlack(slackData) {
        return await requestService.post(apiEndpointSlack, slackData);
    },
    async deleteSlack() {
        return await requestService.delete(apiEndpointSlack);
    },
    async changeActivitySlack(activityData) {
        return await requestService.put(apiEndpointSlack, activityData);
    }
};

export default notificationConnectionService;

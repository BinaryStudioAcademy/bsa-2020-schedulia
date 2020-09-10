import requestService from '@/services/requestService';

const apiEndpointSlack = '/slack-notifications';
const apiEndpointChatito = '/chatito-notifications';
const apiEndpointZoom = '/zoom-status';
const apiEndpointWhale = '/whale-status';

const notificationConnectionService = {
    async connectSlack(slackData) {
        return await requestService.post(apiEndpointSlack, slackData);
    },
    async deleteSlack() {
        return await requestService.delete(apiEndpointSlack);
    },
    async changeActivitySlack(activityData) {
        return await requestService.put(apiEndpointSlack, activityData);
    },
    async changeActivityChatito(activityValue) {
        return await requestService.put(apiEndpointChatito, activityValue);
    },

    async changeZoomActivity(activityValue) {
        return await requestService.put(apiEndpointZoom, activityValue);
    },

    async changeWhaleActivity(activityValue) {
        return await requestService.put(apiEndpointWhale, activityValue);
    }
};

export default notificationConnectionService;

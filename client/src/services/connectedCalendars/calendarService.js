import requestService from '@/services/requestService';

export default {
    async connect(calendar) {
        return await requestService.get(`/social-accounts/${calendar}/oauth`);
    },

    async disconnect(provider) {
        return await requestService.delete(
            `/social-accounts/calendar/${provider}`
        );
    }
};

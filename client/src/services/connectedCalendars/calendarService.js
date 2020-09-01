import requestService from '@/services/requestService';

const SOCIAL_ACCOUNTS_ENDPOINT = '/social-accounts';

export default {
    async connect(calendar) {
        return await requestService.get(`${SOCIAL_ACCOUNTS_ENDPOINT}/${calendar}/oauth`);
    },

    async disconnect(provider) {
        return await requestService.delete(
            `${SOCIAL_ACCOUNTS_ENDPOINT}/calendar/${provider}`
        );
    }
};

import requestService from '@/services/requestService';

export default {
    async fetchAllCalendars() {
        const response = await requestService.get(`/social-accounts/calendars`);

        return response?.data?.data;
    }
};

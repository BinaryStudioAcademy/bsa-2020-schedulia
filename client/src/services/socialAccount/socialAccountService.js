import requestService from '@/services/requestService';

export default {
    async fetchAllCalendars() {
        return await requestService.get(`/social-accounts/calendars`);
    }
};

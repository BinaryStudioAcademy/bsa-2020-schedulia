import requestService from '@/services/requestService';

export default {
    async updatePassword(password, oldPassword) {
        return await requestService.put('/profiles/me/password', {
            password,
            oldPassword
        });
    },

    async saveBranding(url) {
        return await requestService.put('/profiles/me', { branding_logo: url });
    },

    async updateProfile(data) {
        return await requestService.put('/profiles/me', data);
    },

    async deleteProfile() {
        return await requestService.delete('/profiles/me');
    }
};

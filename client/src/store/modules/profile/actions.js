import uploadFileService from '@/services/upload/fileService';
import requestService from '@/services/requestService';
import { UPDATE_BRANDING_LOGO } from './types/mutations';

export default {
    async updatePassword(context, password, oldPassword) {
        try {
            const response = await requestService.patch('/profile/', {
                password: password,
                oldPassword: oldPassword
            });

            return Promise.resolve(response?.data?.data);
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async saveBranding({ commit }, logo) {
        try {
            const response = await uploadFileService.upload(logo);

            const url = response?.data?.data?.logo?.url;

            await requestService.patch('/profile/', { logo: url });

            commit(UPDATE_BRANDING_LOGO, url);

            return Promise.resolve(response?.data?.data);
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async uploadAvatar(context, avatar) {
        try {
            await uploadFileService.upload(avatar);

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async updateProfile() {
        try {
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    }
};

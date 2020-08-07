import uploadFileService from '@/services/upload/fileService';
import { UPDATE_BRANDING_LOGO } from './types/mutations';

export default {
    async checkUserPassword(context, password) {
        try {
            //TODO Send request to check user password
            console.log(password);
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async updatePassword(context, password) {
        try {

            console.log(password);
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async saveBranding({ commit }, logo) {
        try {
            const response = await uploadFileService.upload(logo);

            commit(UPDATE_BRANDING_LOGO, response.logo.url);

            return Promise.resolve(response);
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

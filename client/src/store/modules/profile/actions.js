import uploadFileService from '@/services/upload/fileService';
import profileService from '@/services/profile/profileService';
import { UPDATE_BRANDING_LOGO } from './types/mutations';

export default {
    async updatePassword(context, password, oldPassword) {
        const response = profileService.updatePassword(password, oldPassword);

        return response?.data?.data;
    },

    async saveBranding({ commit }, logo) {
        const response = await uploadFileService.upload(logo);

        const url = response?.data?.data?.logo?.url;

        profileService.saveBranding(url);

        commit(UPDATE_BRANDING_LOGO, url);

        return response?.data?.data;
    },

    async uploadAvatar(context, avatar) {
        const response = uploadFileService.upload(avatar);

        return response?.data?.data;
    },

    async updateProfile() {}
};

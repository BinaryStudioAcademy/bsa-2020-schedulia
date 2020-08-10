import uploadFileService from '@/services/upload/fileService';
import profileService from '@/services/profile/profileService';
import {
    UPDATE_BRANDING_LOGO,
    UPDATE_PROFILE,
    UPDATE_AVATAR
} from './types/mutations';

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

    async updateAvatar({ commit }, avatar) {
        const response = uploadFileService.upload(avatar);

        const url = response?.data?.data?.avatar?.url;

        commit(UPDATE_AVATAR, url);

        return response?.data?.data;
    },

    async updateProfile({ commit }, profile) {
        const response = profileService.updateProfile(profile);

        commit(UPDATE_PROFILE, profile);

        return response?.data?.data;
    }
};
